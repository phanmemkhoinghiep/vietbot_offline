import json
import pyaudio


def list_audio_input_devices():
    p = pyaudio.PyAudio()
    num_devices = p.get_device_count()
    input_devices = []

    for idx in range(num_devices):
        device_info = p.get_device_info_by_index(idx)
        if device_info["maxInputChannels"] > 0:
            input_devices.append({
                "mic_id": idx,
                "mic_type_name": device_info["name"],
                "hostApi": device_info["hostApi"],
                "hostApiId": p.get_host_api_info_by_index(device_info["hostApi"])["index"],
                "maxInputChannels": device_info["maxInputChannels"],
                "maxOutputChannels": device_info["maxOutputChannels"],
                "defaultLowInputLatency": device_info["defaultLowInputLatency"],
                "defaultLowOutputLatency": device_info["defaultLowOutputLatency"],
                "defaultHighInputLatency": device_info["defaultHighInputLatency"],
                "defaultHighOutputLatency": device_info["defaultHighOutputLatency"],
                "defaultSampleRate": device_info["defaultSampleRate"],
                "structVersion": device_info["structVersion"],
                "hostApiName": p.get_host_api_info_by_index(device_info["hostApi"])["name"],
                "deviceCount": p.get_device_count(),
                #"deviceInfo": p.get_device_info_by_index(idx)
            })

    p.terminate()
    return input_devices

if __name__ == "__main__":
    devices = list_audio_input_devices()
    print(json.dumps(devices, indent=4))
