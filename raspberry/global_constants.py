# !/usr/bin/pythonf       
# -*- coding: utf-8 -*-
import json,os


CHANNELS=1
CHUNK = 512
PROCESS_TIMEOUT = 10  # Timeout for processing in seconds
DEFAULT_AUDIO_SAMPLE_RATE =16000

files = ['config.json', 'object.json','action.json', 'adverb.json']
data = {}
for file in files:
    with open(file) as json_file:
        data[file] = json.load(json_file)
config_data = data.get('config.json', {})
obj_data = data.get('object.json', {})
act_data = data.get('action.json', {})
adv_data = data.get('adverb.json', {})



long_press_time = 4.0  

startup_state_speaking=config_data['smart_answer']['startup_state_speaking']
#Mic
mic_id=config_data['smart_config']['mic']['id']

#Sound
BOT_WELCOME_TEXT=config_data['smart_answer']['sound']['welcome']['text']
BOT_WELCOME_MODE=config_data['smart_answer']['sound']['welcome']['mode']   
SOUND_START=config_data['smart_answer']['sound']['default']['start']
SOUND_FINISH=config_data['smart_answer']['sound']['default']['finish']    
SOUND_VOL_CHANGE=config_data['smart_answer']['sound']['default']['volume_change']    
SOUND_WELCOME_PATH=config_data['smart_answer']['sound']['welcome']['path']

pre_answer_timeout=config_data['smart_answer']['pre_answer_timeout']
obj_mic = [p['value'] for p in obj_data['mic']]
obj_volume = [p['value'] for p in obj_data['volume']]



obj_conversation = [p['value'] for p in obj_data['conversation']]
obj_wakeup_reply = [p['value'] for p in obj_data['wakeup_reply']]
pre_answer = [p['value'] for p in config_data['smart_answer']['pre_answer']]



# Khai báo cho API
web_port=config_data['smart_config']['web_interface']['port']
log_url = 'http://127.0.0.1:'+str(web_port)+'/log'  
logging_type=config_data['smart_config']['logging_type']
pre_answer = [p['value'] for p in config_data['smart_answer'].get('pre_answer', [])]
pre_answer_timeout=config_data['smart_answer']["pre_answer_timeout"]
soundcard_name=config_data['smart_config']['speaker']["system"]["name"]
led_type =config_data['smart_config']['led']['type']


#Color for sys.stdout
reset = "\033[0m"
red = "\033[0;31m"
green = "\033[0;32m"
yellow = "\033[0;33m"
blue = "\033[0;34m"
magenta = "\033[0;35m"
cyan = "\033[0;36m"
white = "\033[0;37m"



#Sound
#LED
# effect_mode=config_data['smart_config']['led']['effect_mode']    
# LED_COUNT =config_data['smart_config']['led']['number_led']                
LED_AIO_COUNT =12
LED_PIN = 10
LED_FREQ_HZ = 800000
LED_DMA = 10
LED_INVERT = False
LED_CHANNEL = 0
LED_BRIGHTNESS =config_data['smart_config']['led']['brightness']                
wakeup_color=config_data['smart_config']['led']['wakeup_color']                
muted_color=config_data['smart_config']['led']['muted_color']        
listen_effect=config_data['smart_config']['led']['listen_effect']
think_effect=config_data['smart_config']['led']['think_effect']
speak_effect=config_data['smart_config']['led']['speak_effect']

#STT
stt_mode=config_data['smart_request']['stt']['type']   

stt_timeout = config_data['smart_request']['stt']['time_out']
# stt_time_out = 4
project_id=config_data['smart_request']['stt']['ggcloud_project_id']
recognizer_id=config_data['smart_request']['stt']['recognizer_id']

            
#TTS
tts_mode=config_data['smart_answer']['tts']['type']               
tts_token=config_data['smart_answer']['tts']['token']
voice_name=config_data['smart_answer']['tts']['voice_name']
tts_speed=config_data['smart_answer']['tts']['speed'] 
tts_pitch = config_data['smart_answer']['tts']['pitch']         
tts_gg_cloud_url='https://cxl-services.appspot.com/proxy?url=https://texttospeech.googleapis.com/v1beta1/text:synthesize&token='+tts_token
tts_viettel_url = 'https://viettelgroup.ai/voice/api/tts/v1/rest/syn'
tts_zalo_url = 'https://api.zalo.ai/v1/tts/synthesize'
tts_fpt_url = 'https://api.fpt.ai/hmi/tts/v5'

act_on= act_data['on']['value']
act_off= act_data['off']['value']
act_open= act_data['open']['value']
act_close= act_data['close']['value']   
act_incrase= act_data['incrase']['value']
act_decrase= act_data['decrase']['value']
act_up= act_data['up']['value']    
act_down= act_data['down']['value'] 
act_enable= act_data['enable']['value']   
act_disable= act_data['disable']['value']   
act_continue= act_data['continue']['value']
act_adjust= act_data['adjust']['value']   
act_change= act_data['change']['value'] 
act_setup = act_data['setup']['value']
act_play = act_data['play']['value']
act_stop = [p['value'] for p in act_data['stop']]
act_pause = act_data['pause']['value']
act_sing= act_data['sing']['value']
act_execute = act_data['execute']['value']
act_notice = [p['value'] for p in act_data['notice']]
act_schedule = [p['value'] for p in act_data['schedule']]                                                 
act_check= act_data['check']['value'] 
act_read= act_data['read']['value'] 
act_display= act_data['display']['value']   
act_setup= act_data['setup']['value']        
act_adjust= act_data['adjust']['value']   
act_change= act_data['change']['value']

act_dict = {act_on,act_off,act_open,act_close,act_enable,act_disable,act_check,act_read,act_display,act_adjust,act_change,act_execute,act_setup}

#Import Object    
obj_end_of_request = [p['value'] for p in obj_data['end_of_request']]
obj_name_is = [p['value'] for p in obj_data['name_is']]
obj_yesterday = [p['value'] for p in obj_data['yesterday']]
obj_today = [p['value'] for p in obj_data['today']]
obj_tomorrow = [p['value'] for p in obj_data['tomorrow']]
obj_next_day = [p['value'] for p in obj_data['next_day']]
obj_next_week = [p['value'] for p in obj_data['next_week']]
obj_single = [p['value'] for p in obj_data['single']]
obj_all = [p['value'] for p in obj_data['all']]
obj_switch = [p['value'] for p in obj_data['switch']]
obj_light = [p['value'] for p in obj_data['light']]
obj_curtain = [p['value'] for p in obj_data['curtain']]
obj_door = [p['value'] for p in obj_data['door']]
obj_fan = [p['value'] for p in obj_data['fan']]
obj_socket = [p['value'] for p in obj_data['socket']]
obj_media_player = [p['value'] for p in obj_data['media_player']]
obj_confirm = [p['value'] for p in obj_data['confirm']]
obj_not_confirm = [p['value'] for p in obj_data['not_confirm']]
obj_what_time = [p['value'] for p in obj_data['what_time']]
obj_what_day = [p['value'] for p in obj_data['what_day']]
obj_what_day_name = [p['value'] for p in obj_data['what_day_name']]
obj_what_month = [p['value'] for p in obj_data['what_month']]
obj_what_year = [p['value'] for p in obj_data['what_year']]
obj_this_week = [p['value'] for p in obj_data['this_week']]
obj_next_week = [p['value'] for p in obj_data['next_week']]
obj_this_month = [p['value'] for p in obj_data['this_month']]
obj_next_month = [p['value'] for p in obj_data['next_month']]
obj_this_year = [p['value'] for p in obj_data['this_year']]
obj_lunar_day = [p['value'] for p in obj_data['lunar_day']]
obj_solar_day = [p['value'] for p in obj_data['solar_day']]


#Import Adverb
adv_at_moment=[p['value'] for p in adv_data['at_moment']]
adv_at_time=[p['value'] for p in adv_data['at_time']]
adv_from_now=[p['value'] for p in adv_data['from_now']]
adv_nearby=[p['value'] for p in adv_data['nearby']]


#User
user_level=config_data['smart_user']['level']
user_place_province=config_data['smart_user']['address']['province']
user_place_district=config_data['smart_user']['address']['district']
user_place=user_place_district+', '+user_place_province
user_place_covert=user_place.lower().replace('huyện','').replace('Huyện','').replace('Quận','').replace('quận','').replace('Thành phố','').replace('thành phố','')


#Weather Skill
#Lunar Day Skill
#Anniversary skill
#History Skill
#Network Skill 
#Funny Story Skill
#Fairy_tale
#News Skill

#Wikipedia Skill



#Music Skill
song_path_list =os.listdir('mp3/')    
local_music_compare=config_data['smart_skill']['music']['music_compare_percent']
obj_music=[p['value'] for p in obj_data['music']]
music_error=config_data['smart_skill']['music']["error_answer"]




#Hass    
# use_hass=skill_data['hass']['active']    
hass_token=config_data['smart_skill']['hass']['token']
hass_url=config_data['smart_skill']['hass']['url']
display_full_state=config_data['smart_skill']['hass']['display_full_state']
hvac_mode=[]
hvac_mode_eng=[]
hvac_fan=[]
hvac_fan_eng=[]
hvac_swing=[]
hvac_swing_eng=[]
hvac_temperature=[]        
fan_oscillate_on=[]
fan_oscillate_off=[]        
fan_increase_speed=[]        
fan_decrease_speed=[]
fan_percent=[]
fan_preset_mode=[]
fan_preset_mode_eng=[]
light_brightness=[]
light_temperature=[]
light_color_name=[]
light_color_R=[]
light_color_G=[]
light_color_B=[]
unit_code=[]
unit_name=[]

for p in obj_data['hvac_mode']:    
    hvac_mode.append(p['value'])                                            
    hvac_mode_eng.append(p['value_eng'])                                         
for p in obj_data['hvac_fan']:    
    hvac_fan.append(p['value'])                                            
    hvac_fan_eng.append(p['value_eng'])                                            
for p in obj_data['hvac_swing']:    
    hvac_swing.append(p['value'])                                            
    hvac_swing_eng.append(p['value_eng'])                                              
for p in obj_data['hvac_temperature']:    
    hvac_temperature.append(p['value'])                                            
for p in obj_data['fan_oscillate_on']:    
    fan_oscillate_on.append(p['value'])                                            
for p in obj_data['fan_oscillate_off']:    
    fan_oscillate_off.append(p['value'])                                            
for p in obj_data['fan_incrase_speed']:    
    fan_increase_speed.append(p['value'])                                            
for p in obj_data['fan_decrase_speed']:    
    fan_decrease_speed.append(p['value'])                                            
for p in obj_data['fan_percent']:    
    fan_percent.append(p['value'])                                            
for p in obj_data['fan_preset_mode']:    
    fan_preset_mode.append(p['value'])                                            
    fan_preset_mode_eng.append(p['value_eng'])                                            
for p in obj_data['light_brightness']:    
    light_brightness.append(p['value'])                                            
for p in obj_data['light_temperature']:    
    light_temperature.append(p['value'])                                            
for p in obj_data['light_color_data']:    
    light_color_name.append(p['name'])                                                
    light_color_R.append(p['R'])                                                
    light_color_G.append(p['G'])                                                
    light_color_B.append(p['B'])                                                
for p in obj_data['unit']:
    unit_code.append(p['code'])
    unit_name.append(p['name'])
    



#Weather Skill
weather_key=config_data['smart_skill']['weather']['openweathermap_key']
weather_error=config_data['smart_skill']['weather']["error_answer"]
obj_weather = [p['value'] for p in obj_data['weather']]
TEMP_DELTA = -273.15
cache_compare_result=config_data['smart_skill']['cache_compare_result']

#Today History Skill
obj_history = [p['value'] for p in obj_data['history']]
today_history_url=config_data['smart_skill']['today_history']['url']

#Dify Skill
dify_api_key=config_data['smart_skill']['dify']['api_key']
dify_url=config_data['smart_skill']['dify']['url']
dify_error=config_data['smart_skill']['dify']['error']
dify_no_answer=config_data['smart_skill']['dify']['no_answer']
