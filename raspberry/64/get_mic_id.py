import pyaudio

def list_audio_devices():
    p = pyaudio.PyAudio()
    print("Danh sách các thiết bị âm thanh khả dụng:\n")
    for i in range(p.get_device_count()):
        device_info = p.get_device_info_by_index(i)
        print(f"ID: {i}, Tên: {device_info['name']}, Loại: {device_info['maxInputChannels']} kênh đầu vào")
    p.terminate()

list_audio_devices()
