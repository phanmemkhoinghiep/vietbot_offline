# Copyright 2024 Google LLC
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#    https://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

"""Google Cloud Speech V2 API sample application using the streaming API.

NOTE: This module requires the dependencies `pyaudio` and `termcolor`.
To install using pip:

    pip install pyaudio
    pip install termcolor

Example usage:
    python transcribe_streaming_infinite_v2.py gcp_project_id
"""

# [START speech_transcribe_infinite_streaming_v2]

from google.cloud.speech_v2 import SpeechClient
from google.cloud.speech_v2.types import cloud_speech as cloud_speech_types
from lib_process import queue, re, sys, time, pyaudio,os,global_constants,print_out,asyncio


# Thiết lập thông tin xác thực Google Cloud
os.environ["GOOGLE_APPLICATION_CREDENTIALS"] = 'google_stt.json'

def get_current_time() -> int:
    """Return Current Time in MS.

    Returns:
        int: Current Time in MS.
    """

    return int(round(time.time() * 1000))


class MicrophoneStream:
    """Opens a recording stream as a generator yielding the audio chunks."""

    def __init__(
        self: object,
    ) -> None:
        self._buff = queue.Queue()
        self.closed = True
        self.stream_limit=global_constants.stt_timeout
        self.start_time = time.time()
    def __enter__(self: object) -> object:
        self._audio_interface = pyaudio.PyAudio()
        self._audio_stream = self._audio_interface.open(
            format=global_constants.FORMAT,
            channels=global_constants.CHANNELS,
            rate=global_constants.DEFAULT_AUDIO_SAMPLE_RATE,
            input=True,
            input_device_index=global_constants.mic_id,
            # output_device_index=None,            
            frames_per_buffer=global_constants.CHUNK,
            stream_callback=self._fill_buffer,
        )
        self.closed = False
        return self

    def __exit__(
        self: object,
        type: object,
        value: object,
        traceback: object,
    ) -> object:
        self._audio_stream.stop_stream()
        self._audio_stream.close()
        self.closed = True
        # Signal the generator to terminate so that the client's
        # streaming_recognize method will not block the process termination.
        self._buff.put(None)
        self._audio_interface.terminate()

    def _fill_buffer(
        self: object,
        in_data: object,
        *args: object,
        **kwargs: object,
    ) -> object:
        self._buff.put(in_data)
        return None, pyaudio.paContinue

    def generator(self: object) -> object:
        while not self.closed:
            if time.time() - self.start_time > self.stream_limit / 1000:
                break        
            data = []    
            chunk = self._buff.get()
            if chunk is None:
                return
            data.append(chunk)
            while True:
                try:
                    chunk = self._buff.get(block=False)
                    if chunk is None:
                        return
                    data.append(chunk)
                except queue.Empty:
                    break
            yield b''.join(data)  


def listen_print_loop(responses: object) -> None:
    data1 = ''
    for response in responses:
        if response.results:
            result = response.results[0]
            if result.alternatives:
                transcript = result.alternatives[0].transcript
                # if not result.is_final:
                    # libs.logging('right','(HUMAN-STT-GG-CLOUD)' + transcript + '\r', 'dark_grey')
                if result.is_final:
                    data1 = transcript
                    break
    return data1

client = SpeechClient()

recognition_config = cloud_speech_types.RecognitionConfig(
    explicit_decoding_config=cloud_speech_types.ExplicitDecodingConfig(
        sample_rate_hertz=global_constants.DEFAULT_AUDIO_SAMPLE_RATE,
        encoding=cloud_speech_types.ExplicitDecodingConfig.AudioEncoding.LINEAR16,
        audio_channel_count=global_constants.CHANNELS
    ),
    language_codes=["vi-VN"],
    model="short",
)
streaming_config = cloud_speech_types.StreamingRecognitionConfig(
    config=recognition_config,
    streaming_features=cloud_speech_types.StreamingRecognitionFeatures(
        interim_results=True
    )
)
config_request = cloud_speech_types.StreamingRecognizeRequest(
    recognizer = 'projects/'+global_constants.project_id+'/locations/global/recognizers/'+global_constants.recognizer_id,    
    streaming_config=streaming_config,
)

def requests(config: cloud_speech_types.RecognitionConfig, audio: list) -> list:
    """Helper function to generate the requests list for the streaming API.

    Args:
        config: The speech recognition configuration.
        audio: The audio data.
    Returns:
        The list of requests for the streaming API.
    """
    yield config
    for chunk in audio:
        yield cloud_speech_types.StreamingRecognizeRequest(audio=chunk)

async def stt_process() -> None:
    """start bidirectional streaming from microphone input to speech API"""
    # print_out('left','Bắt đầu chạy','white')
    with MicrophoneStream() as stream:
        stream.audio_input = []
        audio_generator = stream.generator()
        # Transcribes the audio into text
        responses_iterator = client.streaming_recognize(
            requests=requests(config_request, audio_generator))
        data = listen_print_loop(responses_iterator)
    return data

async def main():
    print('Bắt đầu thu âm')
    data = await stt_process()
    print(data)

if __name__ == '__main__': 

    asyncio.run(main())
