 # !/usr/bin/python
# -*- coding: utf-8 -*-
#-*-coding:gb2312-*-
#Processing
import libs
files = ['config.json', 'object.json', 'skill.json', 'action.json', 'adverb.json']
data = {}
for file in files:
    with open(file) as json_file:
        data[file] = libs.json.load(json_file)
conf_data = data.get('config.json', {})
obj_data = data.get('object.json', {})
skill_data = data.get('skill.json', {})
act_data = data.get('action.json', {})
adv_data = data.get('adverb.json', {})
#Sound
from tts_process import tts_process
from stt_process import process as stt_process
from speaker_process import play_sound
#Import Action    
act_on= act_data['on']['value'] #Khai báo keyword dạng Action, đã định nghĩa trong action.json ở đây
act_open= act_data['open']['value']
act_play = [p['value'] for p in act_data['play']]
#Import Object    
obj_funny_story = [p['value'] for p in obj_data['funny_story']] #Khai báo keyword dạng Object, đã định nghĩa trong object.json ở đây
obj_music=[p['value'] for p in obj_data['music']]
#Import Adverb
adv_at_moment=[p['value'] for p in adv_data['at_moment']] #Khai báo toàn bộ keyword dạng Adverb, đã định nghĩa trong adverb.json ở đây
adv_at_time=[p['value'] for p in adv_data['at_time']]
adv_from_now=[p['value'] for p in adv_data['from_now']]
adv_nearby=[p['value'] for p in adv_data['nearby']]
#Hass
use_hass=skill_data['hass']['active']
if use_hass: #Hass skill    
    import hass_process

def custom_data_process(player2,volume):#Def này sẽ độc lập xử lý để Vietbot đọc nội dung
    answer='Lỗi Hass' #Giá trị Default cho câu trả lời
    try:
        data = 'thi hành '+ stt_process().lower()    
        answer=hass_process.hass_process(data)
        player2.play_and_wait(tts_process('answer',True)) #False - Phát câu trả lời TTS ko cache lại nội dung, True - Có cache lại để cho lần sau
    except:
        player2.play_and_wait(tts_process('Có lỗi',True))
        libs.logging('left','Có lỗi','red') 
        play_sound('FINISH') #Dong sound




if __name__ == '__main__':  
    from speaker_process import Player, Volume
    # from speaker_process import VOLUME
    # volume=VOLUME(0)
    player=Player()
    volume=Volume(0)
    data='bây giờ là mấy giờ'
    print(custom_data_process(player,volume,data))    
