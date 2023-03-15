import json

skill = {}

skill['time_skill'] = []
skill['time_skill'].append({ 
    'pre_answer': None,
    'error_answer': 'Lỗi tra cứu thời gian',
    'is_active': True    
})
skill['network_skill'] = []
skill['network_skill'].append({ 
    'pre_answer': 'Kết quả được thông báo ngay sau đây',
    'error_answer': 'Lỗi kiểm tra mạng',
    'is_active': True    
})
skill['news_skill'] = []
skill['news_skill'].append({ 
    'pre_answer': 'Tin tức được phát ngay sau đây',
    'error_answer': 'Lỗi đọc tin tức',
    'is_active': True    
})
skill['radio_skill'] = []
skill['radio_skill'].append({ 
    'pre_answer': 'Radio được phát ngay sau đây',
    'error_answer': 'Lỗi đọc Radio',
    'is_active': True    
})
skill['music_skill'] = []
skill['music_skill'].append({ 
    'pre_answer': 'Nhạc được phát ngay sau đây',
    'error_answer': 'Lỗi phát nhạc',
    'is_active': True    
})
skill['lunar_calendar_skill'] = []
skill['lunar_calendar_skill'].append({ 
    'pre_answer': None,
    'error_answer': 'Lỗi tra cứu lịch âm',
    'is_active': True    
})
skill['anniversary_skill'] = []
skill['anniversary_skill'].append({ 
    'pre_answer': None,
    'error_answer': 'Lỗi tra cứu ngày kỉ niệm',
    'is_active': True    
})
skill['history_skill'] = []
skill['history_skill'].append({ 
    'pre_answer': 'Kết quả được thông báo ngay sau đây',
    'error_answer': 'Lỗi tra cứu ngày này năm xưa',
    'is_active': True    
})
skill['currency_rate_skill'] = []
skill['currency_rate_skill'].append({ 
    'pre_answer': 'Kết quả được thông báo ngay sau đây',
    'error_answer': 'Lỗi tra cứu tỉ giá ngoại tệ',
    'is_active': True    
})
skill['gold_rate_skill'] = []
skill['gold_rate_skill'].append({ 
    'pre_answer': 'Kết quả được thông báo ngay sau đây',
    'error_answer': 'Lỗi tra cứu giá vàng',
    'is_active': True    
})
skill['lottery_skill'] = []
skill['lottery_skill'].append({ 
    'pre_answer': 'Kết quả được thông báo ngay sau đây',
    'error_answer': 'Lỗi tra cứu kết quả sổ xố',
    'is_active': True    
})
skill['weather_skill'] = []
skill['weather_skill'].append({ 
    'openweathermap_key': 'ffddba060ff1a735f04ff426f85f070b',
    'pre_answer': None,
    'error_answer': 'Lỗi tra cứu thời tiết khu vực',     
    'is_active': True    
})
skill['hass_skill'] = []
skill['hass_skill'].append({
    'hass_url': 'http://myname.ddns.net',    
    'hass_token': 'eysfdsfM',
    'pre_answer': None,
    'error_answer': 'Lỗi kết nối đến Hass',
    'is_active': False        
})
skill['funny_story_skill'] = []
skill['funny_story_skill'].append({
    'pre_answer': 'Tìm câu trả lời từ Skill truyện cười',
    'error_answer': 'Lỗi Skill truyện cười',
    'is_active': True    
})
skill['simsim_skill'] = []
skill['simsim_skill'].append({
    'pre_answer': None,
    'error_answer': 'Lỗi Skill Sim sim',
    'is_active': False    
})
skill['gass_skill'] = []
skill['gass_skill'].append({
    'credentials_file': 'credentials.json',
    'device_config_file': 'device_config.json',    
    'pre_answer': None,
    'error_answer': 'Lỗi Google Assistant',
    'is_active': True    
})
skill['chatgpt_skill'] = []
skill['chatgpt_skill'].append({
    'token': 'sk-UR3fdsfsdsfsdfN03a',
    'engine': 'text-davinci-003',
    'pre_answer': 'Câu trả lời từ chatGPT có ngay sau đây',
    'error_answer': 'Lỗi chatGPT',
    'is_active': False        
})
skill['tts_speaker_skill'] = []
skill['tts_speaker_skill'].append({
    'is_active': False
})
skill['hanet_skill'] = []
skill['hanet_skill'].append({
    'agent_annoucement': 'Phát hiện người nhà hoặc nhân viên tên là',    
    'partner_annoucement': 'Phát hiện khách hoặc nhân viên tên là',    
    'stranger_annoucement': 'Phát hiện người lạ hoặc không nhận diện đủ gương mặt',    
    'is_active': False
})
with open('skill.json', 'w') as outfile:
    json.dump(skill, outfile)
