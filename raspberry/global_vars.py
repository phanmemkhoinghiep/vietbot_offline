# !/usr/bin/pythonf       
# -*- coding: utf-8 -*-

#Các biến sẽ trả về API

bot_state='CHỜ KÍCH HOẠT'
conversation=False
wakeup_reply=False
last_hotword_use=''
last_request=''
last_answer=''
mic_block=False
player1=None
player2=None
led=None
use_aio_board=False
bypass_skill=False
use_button=True
use_wakeup=True
sys_volume=0
bot_info=None

#Các biến không trả về API
btn_down_active = False
btn_down = None
btn_up_active = False
btn_up = None
btn_wakeup_active = False
btn_wakeup = None
btn_mic_active = False
btn_mic = None


bot_startup=''
wakewordDetector=None
picovoice_state=True
stt_ws=None    

wakeup_short_press=False
wakeup_long_press=False
mic_short_press=False
mic_long_press=False
up_short_press=False
up_long_press=False
down_short_press=False
down_long_press=False


# Biến toàn cục để lưu kết quả
hass_devices_info = None
time_taken =None
#Music Skill           
#Bắt đầu phần API Process
wakewordDetector=None

micRecorder=None

STT=None

