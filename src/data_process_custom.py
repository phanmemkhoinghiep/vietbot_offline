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

#Import Action    
act_on= act_data['on']['value']
act_off= act_data['off']['value']
act_open= act_data['open']['value']
act_close= act_data['close']['value']
act_enable= act_data['enable']['value']
act_disable= act_data['disable']['value']
act_play = [p['value'] for p in act_data['play']]
act_execute = act_data['execute']['value']
act_notice = [p['value'] for p in act_data['notice']]
act_schedule = [p['value'] for p in act_data['schedule']]                                                 
act_check= act_data['check']['value'] 
act_read= act_data['read']['value'] 
act_display= act_data['display']['value']   
act_setup= act_data['setup']['value']        
act_adjust= act_data['adjust']['value']   
act_change= act_data['change']['value']
#Import Object    
obj_end_of_request = [p['value'] for p in obj_data['end_of_request']]
obj_name_is = [p['value'] for p in obj_data['name_is']]
obj_yesterday = [p['value'] for p in obj_data['yesterday']]
obj_today = [p['value'] for p in obj_data['today']]
obj_tomorrow = [p['value'] for p in obj_data['tomorrow']]
obj_next_day = [p['value'] for p in obj_data['next_day']]
obj_next_week = [p['value'] for p in obj_data['next_week']]
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
obj_anniversary = [p['value'] for p in obj_data['anniversary']]
# obj_distance = [p['value'] for p in obj_data['distance']]
# obj_route = [p['value'] for p in obj_data['route']]
obj_telegram = [p['value'] for p in obj_data['telegram']]
obj_telegram_chat_id = [p['chat_id'] for p in skill_data['telegram_data']]
anniversary_data = skill_data.get('anniversary_data', [])
obj_anniversary_name = [p['name'] for p in anniversary_data]
obj_anniversary_day = [p['day'] for p in anniversary_data]
obj_anniversary_month = [p['month'] for p in anniversary_data]
obj_anniversary_type = [p['is_lunar_calendar'] for p in anniversary_data]
obj_telegram_name = [p['name'].lower() for p in skill_data['telegram_data']]
#Import Adverb
adv_at_moment=[p['value'] for p in adv_data['at_moment']]
adv_at_time=[p['value'] for p in adv_data['at_time']]
adv_from_now=[p['value'] for p in adv_data['from_now']]
adv_nearby=[p['value'] for p in adv_data['nearby']]

    
def data_process(player,data):
    answer='12345'
    music_path=None
    return answer,music_path

# if __name__ == '__main__':  
    # print('test')

