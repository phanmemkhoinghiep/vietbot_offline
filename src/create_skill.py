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
    'openweathermap_key': 'ffddba0dfgdfg26ffdgdf070b',
    'pre_answer': None,
    'error_answer': 'Lỗi tra cứu thời tiết khu vực',     
    'is_active': True    
})
skill['hass_skill'] = []
skill['hass_skill'].append({
    'hass_url': 'https://leluong76.co',    
    'hass_token': 'eyJhbGciOiJIUzIdfgdfgFhNDFmMyIsImlhdCI6MTY2NuxQY-C_lbnIZwTAZu5wI74jsG2c',
    'pre_answer': None,
    'error_answer': 'Lỗi kết nối đến Hass',
    'display_full_state': False,
    'is_active': True
})
skill['funny_story_skill'] = []
skill['funny_story_skill'].append({
    'pre_answer': 'Tìm câu trả lời từ Skill truyện cười',
    'error_answer': 'Lỗi Skill truyện cười',
    'is_active': True    
})
skill['wikipedia_skill'] = []
skill['wikipedia_skill'].append({
    'pre_answer': 'Tìm câu trả lời từ Wikipedia',
    'error_answer': 'Lỗi Skill Wikipedia',
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
skill['hanet_skill'] = []
skill['hanet_skill'].append({
    'agent_annoucement': 'Phát hiện người nhà hoặc nhân viên tên là',    
    'partner_annoucement': 'Phát hiện khách hoặc nhân viên tên là',    
    'stranger_annoucement': 'Phát hiện người lạ hoặc không nhận diện đủ gương mặt',    
    'is_active': False
})
skill['telegram_skill'] = []
skill['telegram_skill'].append({
    'token': '6068674110:AAEsdfQUx4E_UzNMsfdAeU',    
    'pre_answer': 'Đang gửi Telegram tới đich',
    'error_answer': 'Lỗi Telegram',
    'is_active': False        
})
skill['countdown_skill'] = []
skill['countdown_skill'].append({
    'pre_answer': 'Đang tạo tác vụ đếm ngược',
    'error_answer': 'Lỗi tạo tác vụ đếm ngược',
    'is_active': False        
})
skill['schedule_skill'] = []
skill['schedule_skill'].append({
    'pre_answer': 'Đang tạo tác vụ lập lịch',
    'error_answer': 'Lỗi tạo tác vụ lập lịch',
    'is_active': False        
})
with open('skill.json', 'w') as outfile:
    json.dump(skill, outfile)
