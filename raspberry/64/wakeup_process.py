#!/usr/bin/env python
# -*- coding: utf-8 -*-
#-*-coding:gb2312-*-
from lib_process import pvporcupine,struct,pyaudio,print_out,global_constants


class WakeupManager:
    def __init__(self):
        # Tải thông tin cấu hình từ global_constants 
        hotword_config = global_constants.config_data['smart_wakeup']
        self.hotword_key = hotword_config['hotword_engine']['key']
        # Tạo danh sách keyword_paths từ các từ khóa mặc định
        try:
            self.sensitivities = [
                p['sensitive']
                for p in hotword_config['hotword']
                if p['active'] and p['type'] == 'porcupine'
            ]
            self.keywords = ["alexa", "americano","blueberry","bumblebee","computer","grasshopper","jarvis","picovoice","terminator"]  # Danh sách các từ khóa mặc định
            # Khởi tạo Porcupine với các từ khóa mặc định
            if len(self.keywords) != len(self.sensitivities):
                raise ValueError("Số lượng keyword và sensitivities không khớp!")
        except Exception as e:
            print_out('left',f"Lỗi khởi tạo pvporcupine: {e}",'red')
        self.porcupine = None # Khởi tạo tài nguyên Porcupine và PyAudio một lần
        self.pa = None
        self.audio_stream = None
        # self.keyword_paths=['hotword/vi/chào chị_raspberry-pi.ppn']
        # self.sensitivities = [0.3]


    def initialize(self):
        try:
            self.porcupine = pvporcupine.create(access_key=self.hotword_key,
                                                keywords=self.keywords,
                                                sensitivities=self.sensitivities)
            self.pa = pyaudio.PyAudio()
            self.audio_stream = self.pa.open(rate=self.porcupine.sample_rate,
                                             channels=global_constants.CHANNELS,
                                             format=pyaudio.paInt16,
                                             input=True,
                                             input_device_index=global_constants.mic_id,
                                             output_device_index=None,
                                             frames_per_buffer=512)
            return True
        except Exception as e:
            print_out('left',f"Porcupine bắt đầu lỗi: {e}",'red')
            self.close_resources()
            return False
  


    def close_resources(self):
        # if not self.audio_stream:
            # self.initialize()
        if self.audio_stream:
            self.audio_stream.close()
        if self.porcupine:
            self.porcupine.delete()
        if self.pa:
            self.pa.terminate()

    def detect(self): 
        try:
            if self.audio_stream:
                pcm = self.audio_stream.read(512, exception_on_overflow=False)
                pcm = struct.unpack_from("h" * 512, pcm)
                result=self.porcupine.process(pcm)
                if result>=0:
                    return self.keywords[result]
            return None
        except Exception as e:
            print_out('left',f"Error processing audio: {e}",'red')
            return None
          

if __name__ == '__main__':
    wakewordDetector = WakeupManager()    
    if wakewordDetector.initialize() is False:
        print_out('left','Lỗi key Pico','red')                 
    print_out('left','CHỜ KÍCH HOẠT', 'green')                            
    while True:
        wakeup_detect = wakewordDetector.detect()
        if wakeup_detect:            
            print_out('left','Phát hiện keyword: '+wakeup_detect,'white')        
            # # print('Phát hiện keyword: ')        
            # break
