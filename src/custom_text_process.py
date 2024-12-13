# !/usr/bin/python
# -*- coding: utf-8 -*-
# Processing
from libs import re,random,constant,global_vars
import skill_process
import hass_process


def handle_pause(data):
    """Xử lý hành động pause"""
    if str(global_vars.player1.get_state()) == 'State.Playing':
        global_vars.player1.pause()
        return 'Đã tạm dừng phát nhạc'
    return 'Không thể tạm dừng khi không có nhạc đang phát'

def handle_continue(data):
    """Xử lý hành động continue"""
    if str(global_vars.player1.get_state()) == 'State.Paused':
        global_vars.player1.play()
        return 'Đã tiếp tục phát nhạc'
    return 'Không thể tiếp tục khi nhạc chưa được tạm dừng'

def handle_stop(data):
    """Xử lý hành động stop"""
    if str(global_vars.player1.get_state()) in ['State.Playing', 'State.Paused']:
        global_vars.player1.stop()
        return 'Đã dừng phát nhạc'
    return 'Không có nhạc nào để dừng'

def handle_volume(data):
    answer=None
    """Xử lý thay đổi âm lượng."""
    if constant.act_incrase in data:
        global_vars.player2.vol_adjust('UP', False)
        answer="Đã tăng âm lượng"
    elif constant.act_decrase in data:
        global_vars.player2.vol_adjust('DOWN', False)
        answer="Đã giảm âm lượng"
    elif any(act in data for act in [constant.act_setup, constant.act_adjust, constant.act_change]):
        try:
            new_volume = int(re.findall(r'\d+', data)[0])
            global_vars.player2.vol_adjust(new_volume, False)
            answer='Đã thiết lập âm lượng lên mức: '+str(new_volume)
        except ValueError:
            answer="Không nhận diện được thông tin cài đặt"
    else:
        answer="Thay đổi âm lượng cần có tăng, giảm, hoặc cài đặt"
    return answer    
def handle_conversation(data):
    answer=None
    """Xử lý chế độ hội thoại."""
    if any(act in data for act in [constant.act_on, constant.act_open, constant.act_enable]):
        global_vars.conversation = True
        answer="Đã bật chế độ hội thoại"
    elif any(act in data for act in [constant.act_off, constant.act_close, constant.act_disable]):
        global_vars.conversation = False
        answer="Đã tắt chế độ hội thoại"
    return answer
    
def handle_mic(data):
    answer=None
    """Xử lý trạng thái mic."""
    if any(act in data for act in [constant.act_off, constant.act_close, constant.act_disable]):
        global_vars.mic_block = True
        global_vars.conversation = True
        answer='Đã tắt Mic'
    else:
        global_vars.mic_block = True
        answer='Đã bật Mic'
    return answer


def check_single_action(data):
    """Kiểm tra nếu chỉ có 1 action duy nhất xuất hiện trong dữ liệu."""
    count = sum(1 for key in constant.act_dict if key in data)
    return count == 1

def process_action(data, action):
    """Hàm xử lý hành động cụ thể."""
    # Định nghĩa từ điển ánh xạ hành động với các hàm xử lý
    action_map = {
        constant.act_on: hass_process.on,
        constant.act_off: hass_process._off,
        constant.act_open: hass_process._open,
        constant.act_close: hass_process.close,
        constant.act_enable: hass_process.enable,
        constant.act_disable: hass_process.disable,
        constant.act_execute: hass_process.execute,
        constant.act_setup: hass_process.setup,
        constant.act_adjust: hass_process.setup,
        constant.act_change: hass_process.setup,
        constant.act_check: hass_process.check,
        constant.act_read: hass_process.check,
        constant.act_display: hass_process.check,
        constant.act_pause: handle_pause,
        constant.act_continue: handle_continue,
        constant.act_stop: handle_stop,
    }

    # Nếu action tồn tại trong action_map, gọi hàm tương ứng
    action_function = action_map.get(action)
    if action_function:
        return action_function(data.replace(action,''))
    
    return 'Không có câu trả lời từ các skill của vietbot trong tình huống này'
    
def text_process(data):
    # answer='Không có câu trả lời từ các skill của vietbot trong tình huống này'
    answer=None
    music_path=None
    if any(item in data for item in constant.obj_mic):
        answer = handle_mic(data)
    elif any(item in data for item in constant.obj_conversation):
        answer = handle_conversation(data)
    elif any(item in data for item in constant.obj_volume):
        answer = handle_volume(data)   
    elif any(item in data for item in constant.obj_what_time):
        answer=skill_process.what_time('TIME')
    elif any(item in data for item in constant.obj_what_month):
        answer=skill_process.what_time('MONTH')
    elif any(item in data for item in constant.obj_what_year):
        answer=skill_process.what_time('YEAR')
    elif any(item in data for item in constant.obj_lunar_day):        
        if any(item in data for item in constant.obj_yesterday):
            answer=skill_process.lunar_day('YESTERDAY')
        elif any(item in data for item in constant.obj_today):                         
            answer=skill_process.lunar_day('TODAY')
        elif any(item in data for item in constant.obj_tomorrow):                         
            answer=skill_process.lunar_day('TOMORROW')
        elif any(item in data for item in constant.obj_next_day):                         
            answer=skill_process.lunar_day('NEXT_DAY')
        elif any(item in data for item in constant.obj_what_month):                         
            answer=skill_process.lunar_day('THIS_MONTH')
        else:
            answer= 'Yêu cầu tra cứu lịch âm cần ngày cụ thể là một trong các ngày '+ random.choice(constant.obj_yesterday)+ ' '+random.choice(constant.obj_today)+ ' '+random.choice(constant.obj_tomorrow)+ ' '+random.choice(constant.obj_next_day)+ ' hoặc '+random.choice(constant.obj_what_month)   
    elif any(item in data for item in constant.obj_weather):   
        try:
            if any(item in data for item in constant.obj_yesterday): 
                answer=skill_process.weather_process('YESTERDAY')
            elif any(item in data for item in constant.obj_today):   
                answer=skill_process.weather_process('TODAY')
            elif any(item in data for item in constant.obj_tomorrow):             
                answer=skill_process.weather_process('TOMORROW')
            elif any(item in data for item in constant.obj_next_day):             
                answer=skill_process.weather_process('NEXT_DAY')
            elif any(item in data for item in constant.obj_next_week):             
                answer=skill_process.weather_process('NEXT_WEEK')            
            else:
                answer= 'Yêu cầu tra cứu thời tiết cần ngày cụ thể là một trong các ngày '+ random.choice(constant.obj_yesterday)+ ' '+random.choice(constant.obj_today)+ ' '+random.choice(constant.obj_tomorrow)+ ' '+random.choice(constant.obj_next_day)+ ' hoặc '+random.choice(constant.obj_what_month)               
        except:
            answer=constant.weather_error
    elif any(item in data for item in constant.obj_music):               
        try:
            result=skill_process.local_music(data)
            answer=result[0]                
            music_path=result[1]                            
        except:
            answer=constant.music_error            
    else:
        if any(item in data for item in constant.obj_all):
            action = constant.act_on if constant.act_on in data else constant.act_off
            target = None
            
            if any(item in data for item in constant.obj_light):
                target = 'light'
            elif any(item in data for item in constant.obj_switch):
                target = 'switch'
            elif any(item in data for item in constant.obj_socket):
                target = 'socket'
            elif any(item in data for item in constant.obj_door):
                action = constant.act_open if constant.act_on in data else constant.act_off
                target = 'cover'
            elif any(item in data for item in constant.obj_curtain):
                action = constant.act_open if constant.act_on in data else constant.act.off
                target = 'curtain'
            
            if target:
                if hass_process._all(target, action) == 'không thành công':
                    answer = f'{action} tất cả {target} {hass_process._all(target, action)}'
                else:
                    answer = f'{action} tất cả {target} {hass_process._all(target, action)}'
            else:
                answer = 'Không có câu trả lời từ các skill của vietbot trong tình huống này'
        else:
            action = next((key for key in constant.act_dict if key in data), None)
            if action:
                answer = process_action(data, action)
            else:
                if any(item in data for item in [constant.act_execute, constant.act_enable]):
                    action = next((key for key in [constant.act_execute, constant.act_enable] if key in data), None)
                    if action:
                        answer = process_action(data, action)
                else:
                    answer = 'Không có câu trả lời từ các skill của vietbot trong tình huống này'

    return answer, music_path

if __name__ == '__main__': 
    data='thời tiết hôm nay thế nào'    
    print(text_process(data))
