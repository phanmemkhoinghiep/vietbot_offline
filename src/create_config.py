import json

data = {}
data['mic'] = []
data['mic'].append({
    'type': 'None Respeaker Mic',
    'led_off_mode': '',
    'led_off_color': '',
    'led_think_mode': '',    
    'led_thing_color': '',            
    'is_active': True           
})
data['mic'].append({
    'type': 'ReSpeaker 2-Mics Pi HAT',
    'led_off_mode': '',
    'led_off_color': '',
    'led_think_mode': '',    
    'led_thing_color': '',            
    'is_active': False        
})
data['mic'].append({
    'type': 'ReSpeaker 2-Mics Pi HAT with WS281x LED',
    'led_off_mode': 2,
    'led_off_color': 'FFFF99',
    'led_wakeup_mode': 2,
    'led_wakeup_color': '33FFFF',        
    'is_active': False        
})                                                      
data['mic'].append({                    
    'type': 'ReSpeaker 4-Mics Pi HAT',
    'led_off_mode': '',
    'led_off_color': '',
    'led_think_mode': '',    
    'led_thing_color': '',            
    'is_active': False        
})
data['mic'].append({
    'type': 'ReSpeaker Mic Array v2.0',
    'led_off_mode': 2,
    'led_off_color': 'FFFF99',
    'led_wakeup_mode': 2,
    'led_wakeup_color': '33FFFF',    
    'is_active': False        
})
data['mic'].append({
    'type': 'ReSpeaker Core v2.0',
    'led_off_mode': '',
    'led_off_color': '',
    'led_think_mode': '',    
    'led_thing_color': '',            
    'is_active': False        
})
data['volume'] = []
data['volume'].append({
    'value': 75,
    'type': 'event'    
})
data['volume'].append({
    'value': 75,
    'type': 'speak'    
})
data['volume'].append({
    'value': 75,
    'type': 'playback'    
})
data['hotword_engine'] = []
data['hotword_engine'].append({
    'name': 'snowboy',
    'is_active': False
})
data['hotword_engine'].append({
    'name': 'porcupine',
    'is_active': True,
    'porcupine_access_key': 'EhpBuTJẻwrwerwer4IwUtAONg=='
})
data['hotword'] = []
data['hotword'].append({
    'type': 'snowboy',
    'file_name': 'snowboy.umdl',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'snowboy',
    'file_name': 'subex.umdl',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'vi-oh-vi_en_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'vi-o-vi_en_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'alexa_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'americano_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'blueberry_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'bumblebee_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'computer_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'grapefruit_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'grasshopper_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'hey barista_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'hey google_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True   
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'hey siri_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True   
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'jarvis_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True   
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'ok google_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'pico clock_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'picovoice_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'porcupine_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['hotword'].append({
    'type': 'porcupine',
    'file_name': 'terminator_raspberry-pi.ppn',    
    'sensitive': 0.6,        
    'is_active': True    
})
data['continuous_asking'] = []
data['continuous_asking'].append({
    'content': 'hỏi liên tục',
    'is_active': False
})
data['local_stt'] = []
data['local_stt'].append({
    'name': 'stt_gg_free',
    'time_out': 6000,
    'is_active': False    
})
data['local_stt'].append({
    'name': 'stt_gg_cloud',
    'token_file': 'google.json',    
    'time_out': 6000,
    'is_active': True    
})
data['local_stt'].append({
    'name': 'stt_gg_ass',
    'token': '',
    'token_file': '',    
    'time_out': 6000,
    'is_active': False    
})
data['local_stt'].append({
    'name': 'stt_viettel',
    'token': 'SythBY7N8AUsdfsdfdsfpxlyXxzdWRNwYE8N',
    'time_out': 4000,
    'is_active': False    
})
data['local_stt'].append({
    'name': 'stt_fpt',
    'token': '',
    'token_file': '',    
    'time_out': '',
    'is_active': False    
})
data['local_tts'] = []
data['local_tts'].append({
    'name': 'tts_gg_free',
    'token': '8sJJsdfsdfsdfBXC2fRGU',    
    'voice_name': '',    
    'speed': '',
    'pitch': '',
    'is_active': False    
})
data['local_tts'].append({
    'token': 'AIzaSysdfsdfsdfk16b3c',
    'token_file': 'google.json',    
    'name': 'tts_gg_cloud',    
    'voice_name': 'vi-VN-Wavenet-A',
    'profile': 'telephony-class-application',      
    'speed': 1.0,
    'pitch': 0,
    'is_active': False    
})
data['local_tts'].append({
    'token': 'SythBY7NsfsdfsdfdWRNwYE8N',
    'token_file': '',    
    'name': 'tts_viettel',    
    'voice_name': 'hcm-diemmy2',
    'speed': 1.0,
    'pitch': '',
    'is_active': False    
})
data['local_tts'].append({
    'token': '8sJJ3sfsdfsdXC2fRGU',
    'token_file': '',    
    'name': 'tts_zalo',
    'voice_name': '1',    
    'speed': 1.0,
    'pitch': '',
    'is_active': False    
})    
data['local_tts'].append({
    'token': '9onFCsfsdfjjDU',
    'name': 'tts_fpt',
    'voice_name': 'ngoclam',
    'speed': 1.0,
    'pitch': '',    
    'is_active': False    
})

data['playback_time'] = []
data['playback_time'].append({
    'playback_time': 60,    
})

data['internet_timeout'] = []
data['internet_timeout'].append({
    'internet_timeout': 5,    
})

data['check_url'] = []
data['check_url'].append({
    'check_url': 'http://www.google.com/'     
})
data['server'] = []
data['server'].append({
    'server_url': 'http://vietbot.xyz:5000/api',
    'api_type': 'REST',
    'is_active': True        
})
data['server'].append({
    'server_url': 'ws://vietbot.xyz:7000',
    'api_type': 'WS',
    'is_active': False        
})
data['server'].append({
    'server_url': 'grpc://vietbot.xyz:9000',
    'api_type': 'gRPC',
    'is_active': False        
})

data['button_data'] = []
data['button_data'].append({
    'gpio_address': 24,
    'type': 'touch',
    'pulse': True,    
    'function': 'volume_down',
    'is_active': False    
})
data['button_data'].append({
    'gpio_address': 25,
    'type': 'touch',
    'pulse': True,    
    'function': 'volume_up',
    'is_active': False    
})
data['button_data'].append({
    'gpio_address': 22,
    'type': 'touch',    
    'pulse': True,    
    'function': 'toggle_mic',
    'is_active': False    
})
data['button_data'].append({
    'gpio_address': 26,
    'type': 'touch',    
    'pulse': True,    
    'function': 'direct_command',
    'is_active': False    
})
data['smh_skill'] = []
data['smh_skill'].append({
    'smh_name': 'hass',
    'smh_url':'https://abc.duckdns.org:8123',
    'smh_token1': 'sdfsdfdsf',                                                                                                                                                                                                        
    'smh_token2':'',
    'smh_token3':'',
    'is_active': True        
})
data['smh_skill'].append({
    'smh_name': 'vcchome',
    'smh_url':'',
    'smh_token1': '8ed3ac0sdfsdfsdbc5a0e',
    'smh_token2': 'F27F4F2FA8sfdD5EF1EC8',
    'smh_token3': 'eyJhbGsfsdLWtRsfsdfbWfvMFTf28g',
    'is_active': False        
})
data['incrase_volume'] = []
data['incrase_volume'].append({
    'content': 'to lên',
    'is_active': True
})
data['incrase_volume'].append({
    'content': 'to thêm',
    'is_active': True
})
data['incrase_volume'].append({
    'content': 'tăng âm lượng',
    'is_active': True
})
data['decrase_volume'] = []
data['decrase_volume'].append({
    'content': 'bé xuống',
    'is_active': True
})
data['decrase_volume'].append({
    'content': 'bé đi',
    'is_active': True
})
data['decrase_volume'].append({
    'content': 'giảm âm lượng',
    'is_active': True
})
data['pause'] = []
data['pause'].append({
    'content': 'tạm dừng',
    'is_active': True
})
data['continue'] = []
data['continue'].append({
    'content': 'tiếp tục',
    'is_active': True
})
data['reply'] = []
data['reply'].append({
    'content': 'phát lại',
    'is_active': True
})
data['reply'].append({
    'content': 'bật lại',
    'is_active': True
})
data['next'] = []
data['reply'].append({
    'content': 'kế tiếp',
    'is_active': True
})
data['reply'].append({
    'content': 'tiếp theo',
    'is_active': True
})
data['exit'] = []
data['exit'].append({
    'content': 'exit',
    'is_active': True
})
data['exit'].append({
    'content': 'thoát',
    'is_active': True
})
data['exit'].append({
    'content': 'stop',
    'is_active': True
})
data['schedule_alarm'] = []
data['schedule_alarm'].append({
    'content': 'đặt lịch'
})
data['schedule_alarm'].append({
    'content': 'hẹn giờ'
})
data['compare_percent'] = []
data['compare_percent'].append({
    'type':'music_compare',                
    'value': 80
})
data['music_source'] = []
data['music_source'].append({
    'content': 'tìm thấy nhạc',    
})
data['music_source'].append({
    'content': 'phát hiện nhạc',    
})
data['no_music_source'] = []
data['no_music_source'].append({
    'content': 'không có nhạc',    
})
data['no_music_source'].append({
    'content': 'không phát hiện nhạc',    
})

data['no_music_source'].append({
    'content': 'không tìm thấy nhạc',    
})
data['no_music_source'].append({
    'content': 'không có nhạc',    
})
data['music_online'] = []
data['music_online'].append({
    'content': 'sử dụng nhạc trực tuyến',    
})
data['music_online'].append({
    'content': 'dùng nhạc trực tuyến',    
})
data['music_offline'] = []
data['music_offline'].append({
    'content': 'sử dụng thẻ nhớ',    
})
data['music_offline'].append({
    'content': 'dùng thẻ nhớ',    
})
data['play_music'] = []
data['play_music'].append({
    'content': 'phát bài'
})
data['play_music'].append({
    'content': 'phát bài hát'
})
data['play_music'].append({
    'content': 'phát nhạc'
})
data['play_music'].append({
    'content': 'phát bài nhạc'
})
data['play_music'].append({
    'content': 'phát bản nhạc'
})
data['play_music'].append({
    'content': 'play bài'
})
data['play_music'].append({
    'content': 'play bài hát'
})
data['play_music'].append({
    'content': 'play nhạc'
})
data['play_music'].append({
    'content': 'play bài nhạc'
})
data['play_music'].append({
    'content': 'play bản nhạc'
})
data['play_music'].append({
    'content': 'chơi bài'
})
data['play_music'].append({
    'content': 'chơi bài hát'
})
data['play_music'].append({
    'content': 'chơi nhạc'
})
data['play_music'].append({
    'content': 'chơi bài nhạc'
})
data['play_music'].append({
    'content': 'chơi bản nhạc'
})
data['play_music'].append({
    'content': 'bật bài'
})
data['play_music'].append({
    'content': 'bật bài hát'
})
data['play_music'].append({
    'content': 'bật nhạc'
})
data['play_music'].append({
    'content': 'bật bài nhạc'
})
data['play_music'].append({
    'content': 'bật bản nhạc'
})
data['play_music'].append({
    'content': 'hát bài'
})
data['play_music'].append({
    'content': 'hát bài hát'
})
data['play_music'].append({
    'content': 'hát nhạc'
})
data['play_music'].append({
    'content': 'hát bài nhạc'
})
data['play_music'].append({
    'content': 'hát bản nhạc'
})
data['download_music'] = []
data['download_music'].append({
    'content': 'download bài'
})
data['download_music'].append({
    'content': 'download nhạc'
})
data['download_music'].append({
    'content': 'download bài hát'
})
data['download_music'].append({
    'content': 'download bài nhạc'
})
data['download_music'].append({
    'content': 'download bản nhạc'
})
data['download_music'].append({
    'content': 'tải bài'
})
data['download_music'].append({
    'content': 'tải nhạc'
})
data['download_music'].append({
    'content': 'tải bài hát'
})
data['download_music'].append({
    'content': 'tải bài nhạc'
})
data['download_music'].append({
    'content': 'tải bản nhạc'
})
data['download_music'].append({
    'content': 'tải xuống bài'
})
data['download_music'].append({
    'content': 'tải xuống nhạc'
})
data['download_music'].append({
    'content': 'tải xuống bài hát'
})
data['download_music'].append({
    'content': 'tải xuống bài nhạc'
})
data['download_music'].append({
    'content': 'tải xuống bản nhạc'
})
data['all'] = []
data['all'].append({
    'content': 'tất cả'
})
data['all'].append({
    'content': 'hết cả'
})
data['all'].append({
    'content': 'toàn bộ'
})
data['all'].append({
    'content': 'toàn bộ'
})
data['all'].append({
    'content': 'đầy đủ'
})
data['single'] = []
data['single'].append({
    'content': 'duy nhất'
})
data['single'].append({
    'content': 'chỉ một'
})
data['single'].append({
    'content': 'riêng mỗi'
})
data['single'].append({
    'content': 'duy mỗi'
})
data['single'].append({
    'content': 'mỗi một'
})
data['single'].append({
    'content': 'duy nhất'
})
data['action_on'] = []
data['action_on'].append({
    'content': 'bật'
})
data['action_on'].append({
    'content': 'lên'
})
data['action_off'] = []
data['action_off'].append({
    'content': 'tắt'
})
data['action_off'].append({
    'content': 'ngắt'
})
data['action_open'] = []
data['action_open'].append({
    'content': 'mở'
})
data['action_close'] = []
data['action_close'].append({
    'content': 'đóng'
})
data['action_check'] = []
data['action_check'].append({
    'content': 'kiểm tra'
})
data['action_check'].append({
    'content': 'hiển thị'
})
data['action_check'].append({
    'content': 'trạng thái'
})
data['action_check'].append({
    'content': 'thông số'
})
data['request_enable'] = []
data['request_enable'].append({
    'content': 'kích hoạt'
})
data['request_enable'].append({
    'content': 'thực hiện'
})
data['request_enable'].append({
    'content': 'thi hành'
})
data['request_disable'] = []
data['request_disable'].append({
    'content': 'vô hiệu'
})
data['request_disable'].append({
    'content': 'hủy bỏ'
})
data['unit'] = []
data['unit'].append({
    'code': 'clients',    
    'name': 'kết nối'    
})
data['unit'].append({
    'code': '%',    
    'name': 'phần trăm'    
})
data['unit'].append({
    'code': 'MiB',    
    'name': 'mê bai'    
})
data['unit'].append({
    'code': '°C',    
    'name': 'độ xê'    
})
data['unit'].append({
    'code': 'min',    
    'name': 'phút'    
})
data['unit'].append({
    'code': 's',    
    'name': 'giây'    
})
data['unit'].append({
    'code': 'km/h',    
    'name': 'ki lô mét trên giờ'    
})
data['unit'].append({
    'code': 'Hz',    
    'name': 'héc'    
})
data['unit'].append({
    'code': 'V',    
    'name': 'vôn'    
})
data['unit'].append({
    'code': 'A',    
    'name': 'am pe'    
})
data['unit'].append({
    'code': 'kW',    
    'name': 'ki lô oát'    
})
data['unit'].append({
    'code': 'Wh',    
    'name': 'oát giờ'    
})
data['unit'].append({
    'code': 'kWh',    
    'name': 'kilo oát giờ'    
})
data['unit'].append({
    'code': 'L',    
    'name': 'lít'    
})
data['at_now'] = []
data['at_now'].append({
    'content': 'bây giờ'
})
data['at_now'].append({
    'content': 'lập tức'
})
data['at_now'].append({
    'content': 'lúc này'
})
data['time_now'] = []
data['time_now'].append({
    'content': 'mấy giờ'
})
data['light'] = []
data['light'].append({
    'content': 'đèn'
})
data['light'].append({
    'content': 'bóng điện'
})
data['light'].append({
    'content': 'đèn điện'
})
data['switch'] = []
data['switch'].append({
    'content': 'công tắc'
})
data['socket'] = []
data['socket'].append({
    'content': 'ổ cắm'
})
data['socket'].append({
    'content': 'ổ điện'
})
data['fan'] = []
data['fan'].append({
    'content': 'quạt'
})
data['door'] = []
data['door'].append({
    'content': 'cửa'
})    
data['door'].append({
    'content': 'cổng'
})
data['occupancy'] = []
data['occupancy'].append({
    'content': 'pir'
})
data['occupancy'].append({
    'content': 'chuyển động'
})
data['curtain'] = []
data['curtain'].append({
    'content': 'rèm'
})
data['curtain'].append({
    'content': 'mành'
})
data['curtain'].append({
    'content': 'màn'
})
data['cover'] = []
data['cover'].append({
    'content': 'cửa cuốn'    
})
data['gate'] = []
data['gate'].append({
    'content': 'cổng'    
})
data['request_temperature'] = []
data['request_temperature'].append({
    'content': 'nhiệt độ'    
})
data['request_humidity'] = []
data['request_humidity'].append({
    'content': 'độ ẩm'    
})
data['request_script'] = []
data['request_script'].append({
    'content': 'kịch bản'    
})
data['request_automation'] = []
data['request_automation'].append({
    'content': 'tự động'    
})
with open('config.json', 'w') as outfile:
    json.dump(data, outfile)
