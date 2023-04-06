import json

config = {}
config['input_module'] =[]
config['input_module'].append({
    'type': 'text',
    'is_active': True            
})
config['input_module'].append({
    'type': 'api',
    'is_active': True            
})
config['input_module'].append({
    'type': 'mic',
    'is_active': True            
})
config['output_module'] =[]
config['output_module'].append({
    'type': 'api',
    'is_active': True            
})
config['output_module'].append({
    'type': 'text',
    'is_active': True            
})
config['output_module'].append({
    'type': 'speaker',
    'is_active': True            
})
config['speaker'] = []
config['speaker'].append({
    'type': None,
    'is_active': False
})
config['speaker'].append({
    'type': 'soundcard',
    'amixer_id': 0,    
    'is_active': True            
})
config['speaker'].append({
    'type': 'cast',
    'name': 'cast_speaker',
    'IP': '192.168.1.10',    
    'is_active': False            
})
config['speaker'].append({
    'type': 'bluetooth',
    'MAC': '',    
    'is_active': False            
})
config['led'] =[]
config['led'].append({
    'type': None,
    'is_active': True        
})
config['led'].append({
    'type': 'ReSpeaker 4-Mics Pi HAT',
    'effect_mode': 2,# 1- Google Home Pattern, 2- Alexa Pattern
    'is_active': False        
})
config['led'].append({
    'type': 'APA102',
    'number_led': 8, #Number of LED   
    'effect_mode': 1,# 1- Google Home Pattern, 2- Alexa Pattern
    'is_active': False                              
})
config['led'].append({
    'type': 'ReSpeaker Mic Array v2.0',
    'off_mode': 2,
    'off_color': 'fffcff',
    'wakeup_mode': 2,
    'wakeup_color': '074a25',    
    'is_active': False        
})
config['led'].append({
    'type': 'WS2812',
    'number_led': 16,#Number of LED
    'brightness':255, # Set to 0 for darkest and 255 for brightest
    'off_mode': 1, #1 - No Color, 2 - All LED off
    'off_color': '03254b',    # All LED with Hexa color
    'wakeup_mode': 1, #1 - theaterChase with wakeup_color, 2 - rainbow, 3 - rainbowCycle, 4 - theaterChaseRainbow
    'wakeup_color': '03254b',# Hexa color
    'listen_mode': 1, #1 - theaterChase with wakeup_color, 2 - rainbow, 3 - rainbowCycle, 4 - theaterChaseRainbow        
    'listen_color': '03254b',            
    'think_mode': 1, #1 - theaterChase with wakeup_color, 2 - rainbow, 3 - rainbowCycle, 4 - theaterChaseRainbow        
    'think_color': '074a25',            
    'speak_mode': 2, #1 - theaterChase with wakeup_color, 2 - rainbow, 3 - rainbowCycle, 4 - theaterChaseRainbow                   
    'speak_color': '074a25', # Hexa color
    'is_active': False        
 })
config['led'].append({
    'type': 'APA102',
    'number_led': 8, #Number of LED   
    'pattern': 2,        
    'is_active': False                              
})
config['volume'] = []
config['volume'].append({
    'value': [50,50] 
})
config['hotword_engine'] = []
config['hotword_engine'].append({
    'name': 'system',
    'is_active': True
})
config['hotword_engine'].append({
    'name': 'porcupine',
    'is_active': True,
    'porcupine_access_key': 'pJwv7qAbPrw9yXx2D3QeceV39+Rn+KW35JBTeyEal70VOOWoDvm7JQ=='
})
config['hotword'] = []
config['hotword'].append({
    'type': 'system',
    'value': 'em ơi',    
    'is_active': True    
})
config['hotword'].append({
    'type': 'system',
    'value': 'ê cu',    
    'is_active': True    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'vi-ci-ci_en_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': False    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'alexa_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': False    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'americano_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': True    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'blueberry_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': False    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'bumblebee_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': False    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'computer_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': True    
})

config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'grapefruit_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': False    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'grasshopper_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': False    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'hey barista_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': False    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'hey google_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': False   
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'hey siri_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': True   
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'jarvis_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': False   
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'ok google_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': False    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'pico clock_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': False    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'picovoice_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': True    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'porcupine_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': False    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'terminator_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': True    
})
config['continuous_asking'] = []
config['continuous_asking'].append({
    'content': 'hỏi liên tục',
    'is_active': False
})
config['stt'] = []
config['stt'].append({
    'type': 'stt_gg_free',
    'time_out': 6000,
    'is_active': False    
})
config['stt'].append({
    'type': 'stt_gg_cloud',
    'token_file': 'google.json',    
    'time_out': 6000,
    'is_active': True    
})
config['stt'].append({
    'type': 'stt_gg_ass',
    'credentials_file': 'credentials.json',
    'device_config_file': 'device_config.json',    
    'time_out': 6000,
    'is_active': False    
})
config['stt'].append({
    'type': 'stt_viettel',
    'token': 'SythBY7fsdfXxzdsfsYE8N',
    'time_out': 4000,
    'is_active': False    
})
config['stt'].append({
    'type': 'stt_fpt',
    'token': '',
    'token_file': '',    
    'time_out': '',
    'is_active': False    
})
config['tts'] = []
config['tts'].append({
    'type': 'tts_gg_free',
    'token': '8sJJ39ssfsfBXC2fRGU',    
    'voice_name': '',    
    'speed': '',
    'pitch': '',
    're_use': True,
    'is_active': False    
})
config['tts'].append({
    'token': 'AIzaSyDsdfsdf_k16b3c',
    'token_file': 'google.json',    
    'type': 'tts_gg_cloud',    
    'voice_name': 'vi-VN-Wavenet-A',
    'profile': 'telephony-class-application',      
    'speed': 1.0,
    'pitch': 0,
    're_use': True,
    'is_active': True    
})
config['tts'].append({
    'token': 'dfgdfgdfgARWDFSc',
    'type': 'tts_gg_cloud_free',    
    'voice_name': 'vi-VN-Wavenet-A',
    'profile': 'telephony-class-application',      
    'speed': 1.0,
    'pitch': 0,
    're_use': True,
    'is_active': False   
})
config['tts'].append({
    'token': 'SythBYsfsdfs',
    'token_file': '',    
    'type': 'tts_viettel',    
    'voice_name': 'hcm-diemmy2',
    'speed': 1.0,
    'pitch': '',
    're_use': True,
    'is_active': False    
})
config['tts'].append({
    'token': '8sJJsdfsdffRGU',
    'token_file': '',    
    'type': 'tts_zalo',
    'voice_name': '1',    
    'speed': 1.0,
    'pitch': '',
    're_use': True, 
    'is_active': False    
})    
config['tts'].append({
    'token': '9onFsfsdfqzjjDU',
    'type': 'tts_fpt',
    'voice_name': 'ngoclam',
    'speed': 1.0,
    'pitch': '',    
    're_use': True,
    'is_active': False   
})
config['playback_time'] = []
config['playback_time'].append({
    'playback_time': 30,    
})
config['internet_timeout'] = []
config['internet_timeout'].append({
    'internet_timeout': 5,    
})
config['check_url'] = []
config['check_url'].append({
    'check_url': 'http://www.google.com',
})
config['button_data'] = []
config['button_data'].append({
    'gpio_address': 6,
    'type': 'touch',
    'pulse': True,    
    'function': 'volume_down',
    'is_active': False    
})
config['button_data'].append({
    'gpio_address': 5,
    'type': 'touch',
    'pulse': True,    
    'function': 'volume_up',
    'is_active': False    
})
config['button_data'].append({
    'gpio_address': 25,
    'type': 'touch',    
    'pulse': True,    
    'function': 'toggle_mic',
    'is_active': False    
})
config['button_data'].append({
    'gpio_address': 26,
    'type': 'touch',    
    'pulse': True,    
    'function': 'direct_command',
    'is_active': False    
})
config['location'] = []
config['location'].append({
    'lon': 105.804817,
    'lat': 21.028511
})
config['web_interface'] = []
config['web_interface'].append({
    'port': 5000,
})
config['sound_event'] = []                             
config['sound_event'].append({
    'name': 'system_start',
    'path': 'sound/ding.mp3'        
})
config['sound_event'].append({
    'name': 'system_finish',
    'path': 'sound/dong.mp3'        
})
config['sound_event'].append({
    'name': 'bot_start',
    'path': 'sound/ding.mp3'        
})
config['sound_event'].append({
    'name': 'bot_welcome',
    'path': 'sound/ding.mp3',        
    'text': 'Xin chào mời đọc khẩu lệnh để ra lệnh',        
    'mode': 'text'            
})
config['sound_event'].append({
    'name': 'bot_volume',
    'is_active': True   
})
with open('config.json', 'w') as outfile:
    json.dump(config, outfile)

