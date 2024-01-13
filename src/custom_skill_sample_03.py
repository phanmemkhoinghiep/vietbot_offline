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
#Get Hass info
session = libs.requests.Session()
token=skill_data['hass']['token']
hass_url=skill_data['hass']['url']
headers = {'Authorization': 'Bearer '+ token,'content-type': 'application/json'}
script_name='Đi ngủ' #Lấy đúng giá trị friendly của script name tương ứng
def get_entity():
    entity_result=''
    response = session.get(hass_url + '/api/states', headers=headers, verify=False)
    if response.status_code == 200:
        entities = response.json()
        for entity in entities:
            attributes = entity.get('attributes', {})
            if attributes.get('friendly_name', '').strip().lower() ==script_name:
              entity_result=entity:
              break
    return entity_result

def custom_data_process(player2,volume):#Def này sẽ độc lập xử lý để Vietbot đọc nội dung
    answer='Lỗi Hass' #Giá trị Default cho câu trả lời
    payload = {'entity_id': get_entity()}
    try:
         r = session.post(url+'/api/services/script/turn_on', data=libs.json.dumps(payload), headers=headers, verify=False)
         if r.status_code == 200:
             answer= 'Đã thi hành '+script_name+' thành công' 
         else:
             answer= 'Thi hành '+script_name+' không thành công'
        player2.play_media(tts_process(answer,True),True) #False - Phát câu trả lời TTS ko cache lại nội dung, True - Có cache lại để cho lần sau
    except:
        player2.play_media(tts_process('Có lỗi',True),True)
        libs.logging('left','Có lỗi','red') 
        play_sound('FINISH') #Dong sound

if __name__ == '__main__':  
    from speaker_process import Player, Volume
    # from speaker_process import VOLUME
    # volume=VOLUME(0)
    player=Player()
    volume=Volume(0)
    print(custom_data_process(player,volume))    
