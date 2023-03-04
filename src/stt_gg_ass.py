# Copyright (C) 2017 Google Inc.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

"""Sample that implements a gRPC client for the Google Assistant API."""

import concurrent.futures
import json
import logging
import os
import os.path
import pathlib2 as pathlib
import sys
import uuid

import time
from termcolor import colored

import click
import grpc
import google.auth.transport.grpc
import google.auth.transport.requests
import google.oauth2.credentials

from google.assistant.embedded.v1alpha2 import (
    embedded_assistant_pb2,
    embedded_assistant_pb2_grpc
)
from tenacity import retry, stop_after_attempt, retry_if_exception

try:
    from . import (
        assistant_helpers,
        audio_helpers,
        device_helpers
    )
except (SystemError, ImportError):
    import assistant_helpers
    import audio_helpers
    import device_helpers


ASSISTANT_API_ENDPOINT = 'embeddedassistant.googleapis.com'
END_OF_UTTERANCE = embedded_assistant_pb2.AssistResponse.END_OF_UTTERANCE
DIALOG_FOLLOW_ON = embedded_assistant_pb2.DialogStateOut.DIALOG_FOLLOW_ON
CLOSE_MICROPHONE = embedded_assistant_pb2.DialogStateOut.CLOSE_MICROPHONE
DEFAULT_GRPC_DEADLINE = 10

STREAMING_LIMIT=None
with open('config.json') as config_json:
    config_data = json.load(config_json)
for p in config_data['local_stt']:
    if p['name'] == 'stt_gg_ass':
        STREAMING_LIMIT=p['time_out']
def get_current_time():
    return int(round(time.time() * 1000))

class SampleAssistant(object):
    """Sample Assistant that supports conversations and device actions.

    Args:
      device_model_id: identifier of the device model.
      device_id: identifier of the registered device instance.
      conversation_stream(ConversationStream): audio stream
        for recording query and playing back assistant answer.
      channel: authorized gRPC channel for connection to the
        Google Assistant API.
      deadline_sec: gRPC deadline in seconds for Google Assistant API call.
      device_handler: callback for device actions.
    """

    def __init__(self, language_code, device_model_id, device_id,
                 conversation_stream,
                 channel, deadline_sec):
        self.language_code = language_code
        self.device_model_id = device_model_id
        self.device_id = device_id
        self.conversation_stream = conversation_stream

        # Opaque blob provided in AssistResponse that,
        # when provided in a follow-up AssistRequest,
        # gives the Assistant a context marker within the current state
        # of the multi-Assist()-RPC "conversation".
        # This value, along with MicrophoneMode, supports a more natural
        # "conversation" with the Assistant.
        self.conversation_state = None

        # Create Google Assistant API gRPC client.
        self.assistant = embedded_assistant_pb2_grpc.EmbeddedAssistantStub(
            channel
        )
        self.deadline = deadline_sec


    def __enter__(self):
        return self

    def __exit__(self, etype, e, traceback):
        if e:
            return False
        self.conversation_stream.close()

    def is_grpc_error_unavailable(e):
        is_grpc_error = isinstance(e, grpc.RpcError)
        if is_grpc_error and (e.code() == grpc.StatusCode.UNAVAILABLE):
            # logging.error('grpc unavailable error: %s', e)
            return True
        return False

    @retry(reraise=True, stop=stop_after_attempt(3),
           retry=retry_if_exception(is_grpc_error_unavailable))
    def assist(self):
        text_result=''
        """Send a voice request to the Assistant and playback the response.

        Returns: True if conversation should continue.
        """
        continue_conversation = False
        device_actions_futures = []

        self.conversation_stream.start_recording()
        # logging.info('Recording audio request.')

        def iter_log_assist_requests():
            for c in self.gen_assist_requests():
                assistant_helpers.log_assist_request_without_audio(c)
                yield c
            # logging.debug('Reached end of AssistRequest iteration.')

        # This generator yields AssistResponse proto messages
        # received from the gRPC Google Assistant API.
        for resp in self.assistant.Assist(iter_log_assist_requests(),
                                          self.deadline):
            assistant_helpers.log_assist_response_without_audio(resp)
            if resp.event_type == END_OF_UTTERANCE:
                # logging.info('End of audio request detected.')
                # logging.info('Stopping recording.')
                self.conversation_stream.stop_recording()
                break
            if resp.speech_results:
                # logging.info('Transcript of user request: "%s".',
                             # ' '.join(r.transcript
                                      # for r in resp.speech_results))
                text_result= ' '.join(r.transcript
                                      for r in resp.speech_results)
            if len(resp.audio_out.audio_data) > 0:
                break
                # if not self.conversation_stream.playing:
                    # self.conversation_stream.start_playback()
                    # logging.info('Playing assistant response.')
                # self.conversation_stream.write(resp.audio_out.audio_data)
            if resp.dialog_state_out.conversation_state:
                break
                # conversation_state = resp.dialog_state_out.conversation_state
                # logging.debug('Updating conversation state.')
                # self.conversation_state = conversation_state
            if resp.dialog_state_out.volume_percentage != 0:
                volume_percentage = resp.dialog_state_out.volume_percentage
                # logging.info('Setting volume to %s%%', volume_percentage)
                self.conversation_stream.volume_percentage = volume_percentage
            if resp.dialog_state_out.microphone_mode == DIALOG_FOLLOW_ON:
                # continue_conversation = True
                # logging.info('Expecting follow-on query from user.')
                break
            elif resp.dialog_state_out.microphone_mode == CLOSE_MICROPHONE:
                # continue_conversation = False
                break
            # if resp.device_action.device_request_json:
                # device_request = json.loads(
                    # resp.device_action.device_request_json
                # )
                # fs = self.device_handler(device_request)
                # if fs:
                    # device_actions_futures.extend(fs)

        # if len(device_actions_futures):
            # logging.info('Waiting for device executions to complete.')
            # concurrent.futures.wait(device_actions_futures)

        # logging.info('Finished playing assistant response.')
        # self.conversation_stream.stop_playback()
        return text_result

    def gen_assist_requests(self):
        """Yields: AssistRequest messages to send to the API."""

        dialog_state_in = embedded_assistant_pb2.DialogStateIn(
                language_code=self.language_code,
                conversation_state=b''
            )
        if self.conversation_state:
            # logging.debug('Sending conversation state.')
            dialog_state_in.conversation_state = self.conversation_state
        config = embedded_assistant_pb2.AssistConfig(
            audio_in_config=embedded_assistant_pb2.AudioInConfig(
                encoding='LINEAR16',
                sample_rate_hertz=self.conversation_stream.sample_rate,
            ),
            audio_out_config=embedded_assistant_pb2.AudioOutConfig(
                encoding='LINEAR16',
                sample_rate_hertz=self.conversation_stream.sample_rate,
                volume_percentage=self.conversation_stream.volume_percentage,
            ),
            dialog_state_in=dialog_state_in,
            device_config=embedded_assistant_pb2.DeviceConfig(
                device_id=self.device_id,
                device_model_id=self.device_model_id,
            )
        )
        # The first AssistRequest must contain the AssistConfig
        # and no audio data.
        yield embedded_assistant_pb2.AssistRequest(config=config)
        for data in self.conversation_stream:
            # Subsequent requests need audio data, but not config.
            yield embedded_assistant_pb2.AssistRequest(audio_in=data)

              
# def stt_gg_ass(api_endpoint, credentials, project_id,
         # device_model_id, device_id, device_config, lang, verbose,
         # input_audio_file, output_audio_file,
         # audio_sample_rate, audio_sample_width,
         # audio_iter_size, audio_block_size, audio_flush_size,
         # grpc_deadline, once, *args, **kwargs):

def main():
    api_endpoint = ASSISTANT_API_ENDPOINT
    lang = None
    display = None
    credentials='/home/pi/.config/google-oauthlib-tool/credentials.json'
    device_config ='/home/pi/.config/googlesamples-assistant/device_config.json'
    audio_sample_rate=audio_helpers.DEFAULT_AUDIO_SAMPLE_RATE
    audio_sample_width=audio_helpers.DEFAULT_AUDIO_SAMPLE_WIDTH
    audio_iter_size=audio_helpers.DEFAULT_AUDIO_ITER_SIZE
    audio_block_size=audio_helpers.DEFAULT_AUDIO_DEVICE_BLOCK_SIZE
    audio_flush_size=audio_helpers.DEFAULT_AUDIO_DEVICE_FLUSH_SIZE
    grpc_deadline = DEFAULT_GRPC_DEADLINE

    """Samples for the Google Assistant API.

    Examples:
      Run the sample with microphone input and speaker output:

        $ python -m googlesamples.assistant

      Run the sample with file input and speaker output:

        $ python -m googlesamples.assistant -i <input file>

      Run the sample with file input and output:

        $ python -m googlesamples.assistant -i <input file> -o <output file>
    """
    # Setup logging.
    # logging.basicConfig(level=logging.DEBUG if verbose else logging.INFO)

    # Load OAuth 2.0 credentials.
    try:
        with open(credentials, 'r') as f:
            credentials = google.oauth2.credentials.Credentials(token=None,
                                                                **json.load(f))
            http_request = google.auth.transport.requests.Request()
            credentials.refresh(http_request)
    except Exception as e:
        # logging.error('Error loading credentials: %s', e)
        # logging.error('Run google-oauthlib-tool to initialize '
                      # 'new OAuth 2.0 credentials.')
        sys.exit(-1)

    # if not device_id or not device_model_id:
    try:
        with open(device_config) as f:
            device = json.load(f)
            device_id = device['id']
            device_model_id = device['model_id']
            # logging.info("Using device model %s and device id %s",
                         # device_model_id,
                         # device_id)
    except Exception as e:
        # logging.warning('Device config not found: %s' % e)
        sys.exit(-1)
    # Create an authorized gRPC channel.
    grpc_channel = google.auth.transport.grpc.secure_authorized_channel(
        credentials, http_request, api_endpoint)
    # logging.info('Connecting to %s', api_endpoint)

    # Configure audio source and sink.
    audio_source = audio_helpers.SoundDeviceStream(
            sample_rate=audio_sample_rate,
            sample_width=audio_sample_width,
            block_size=audio_block_size,
            flush_size=audio_flush_size,
            direction=0
    )

    audio_sink = audio_helpers.SoundDeviceStream(
            sample_rate=audio_sample_rate,
            sample_width=audio_sample_width,
            block_size=audio_block_size,
            flush_size=audio_flush_size,
            direction=1
    )
    # Create conversation stream with the given audio source and sink.
    conversation_stream = audio_helpers.ConversationStream(
        source=audio_source,
        sink=audio_sink,
        iter_size=audio_iter_size,
        sample_width=audio_sample_width,
    )

    try:
        with open(device_config) as f:
            device = json.load(f)
            device_id = device['id']
            device_model_id = device['model_id']
            # logging.info("Using device model %s and device id %s",
                         # device_model_id,
                         # device_id)
    except Exception as e:
        # logging.warning('Device config not found: %s' % e)
        # logging.info('Registering device')
        # if not device_model_id:
            # logging.error('Option --device-model-id required '
                          # 'when registering a device instance.')
        sys.exit(-1)
        # if not project_id:
            # logging.error('Option --project-id required '
                          # 'when registering a device instance.')
            # sys.exit(-1)
        # device_base_url = (
            # 'https://%s/v1alpha2/projects/%s/devices' % (api_endpoint,
                                                         # project_id)
        # )
        # device_id = str(uuid.uuid1())
        # payload = {
            # 'id': device_id,
            # 'model_id': device_model_id,
            # 'client_type': 'SDK_SERVICE'
        # }
        # session = google.auth.transport.requests.AuthorizedSession(
            # credentials
        # )
        # r = session.post(device_base_url, data=json.dumps(payload))
        # if r.status_code != 200:
            # logging.error('Failed to register device: %s', r.text)
            # sys.exit(-1)
        # logging.info('Device registered: %s', device_id)
        # pathlib.Path(os.path.dirname(device_config)).mkdir(exist_ok=True)
        # with open(device_config, 'w') as f:
            # json.dump(payload, f)


        # if on:
            # logging.info('Turning device on')
        # else:
            # logging.info('Turning device off')

    start_time=get_current_time()        
    final_result=None
    while get_current_time() - start_time < STREAMING_LIMIT:    
        assistant= SampleAssistant(lang, device_model_id, device_id,
                                 conversation_stream,
                                 grpc_channel, grpc_deadline)
        final_result=str(assistant.assist())
        if len(final_result) >0:
            print(colored('[HUMAN]: '+final_result,'yellow'))            
        break

    return final_result


    
if __name__ == '__main__':
    main()
