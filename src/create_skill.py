import json

skill = {}

skill['time_skill'] = []
skill['time_skill'].append({ 
    'pre_answer': 'Kết quả được thông báo ngay sau đây',
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
    'pre_answer': 'Kết quả được thông báo ngay sau đây',
    'error_answer': 'Lỗi tra cứu lịch âm',
    'is_active': True    
})
skill['anniversary_skill'] = []
skill['anniversary_skill'].append({ 
    'pre_answer': 'Kết quả được thông báo ngay sau đây',
    'error_answer': 'Lỗi tra cứu ngày kỉ niệm',
    'is_active': True    
})
skill['history_skill'] = []
skill['history_skill'].append({ 
    'pre_answer': 'Kết quả được thông báo ngay sau đây',
    'error_answer': 'Lỗi tra cứu ngày này năm xưa',
    'is_active': True    
})
skill['hass_skill'] = []
skill['hass_skill'].append({
    'hass_url':'http://abc.ddns.net',    
    'hass_token': 'eyJhbGcFZHTvxB7KxjnV0V26hPNfE8M',
    'pre_answer': 'Lệnh được thi hành ngay sau đây',
    'error_answer': 'Lỗi kết nối đến Hass',
    'is_active': True        
})
skill['gass_skill'] = []
skill['gass_skill'].append({
    'credentials_file': 'credentials.json',
    'device_config_file': 'device_config.json',    
    'pre_answer': 'Câu trả lời từ Google có ngay sau đây',
    'error_answer': 'Lỗi Google Assistant',
    'is_active': True    
})
skill['chatgpt_skill'] = []
skill['chatgpt_skill'].append({
    'token': 'sk-UR3WQN03a',
    'engine': 'text-davinci-003',
    'pre_answer': 'Câu trả lời từ chatGPT có ngay sau đây',
    'error_answer': 'Lỗi chatGPT',
    'is_active': True        
})
skill['tts_speaker_skill'] = []
skill['tts_speaker_skill'].append({
    'is_active': True
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
