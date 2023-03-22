import json

config = {}
config['input_module'] =[]
config['input_module'].append({
    'type': 'text',
    'is_active': True            
})
config['input_module'].append({
    'type': 'api',
    'is_active': False            
})
config['input_module'].append({
    'type': 'mic',
    'is_active': True            
})
config['output_module'] =[]
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
    'type': 'default',
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
config['mic'] = []
config['mic'].append({
    'type': 'None Respeaker Mic',
    'led_off_mode': '',
    'led_off_color': '',
    'led_think_mode': '',    
    'led_thing_color': '',            
    'is_active': True            
})
config['mic'].append({
    'type': 'ReSpeaker 2-Mics Pi HAT',
    'led_off_mode': '',
    'led_off_color': '',
    'led_think_mode': '',    
    'led_thing_color': '',            
    'is_active': False        
})
config['mic'].append({
    'type': 'ReSpeaker 2-Mics Pi HAT with WS281x LED',
    'led_brightness': 100,
    'led_wakeup_color': 'bc6dca',  
    'is_active': False        
})
config['mic'].append({
    'type': 'ReSpeaker 4-Mics Pi HAT',
    'led_off_mode': '',
    'led_off_color': '',
    'led_think_mode': '',    
    'led_thing_color': '', 
    'led_pattern': 2,
    'is_active': False        
})
config['mic'].append({
    'type': 'ReSpeaker Mic Array v2.0',
    'led_off_mode': 2,
    'led_off_color': 'fffcff',
    'led_wakeup_mode': 2,
    'led_wakeup_color': '074a25',    
    'is_active': False        
})
config['volume'] = []
config['volume'].append({
    'value': 50 
})
config['hotword_engine'] = []
config['hotword_engine'].append({
    'name': 'snowboy',
    'is_active': False
})
config['hotword_engine'].append({
    'name': 'porcupine',
    'is_active': True,
    'porcupine_access_key': 'pJwvvm7JQ=='
})
config['hotword'] = []
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'vi-ci-ci_en_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': True    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'alexa_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': True    
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
    'is_active': True    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'bumblebee_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': True    
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
    'is_active': True    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'grasshopper_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': True    
})
config['hotword'].append({
    'type': 'porcupine',
    'file_name': 'hey barista_raspberry-pi.ppn',    
    'sensitive': 0.4,        
    'is_active': True    
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
    'is_active': True   
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
    'is_active': True    
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
    'is_active': True    
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
config['local_stt'] = []
config['local_stt'].append({
    'name': 'stt_gg_free',
    'time_out': 6000,
    'is_active': True    
})
config['local_stt'].append({
    'name': 'stt_gg_cloud',
    'token_file': 'google.json',    
    'time_out': 6000,
    'is_active': False    
})
config['local_stt'].append({
    'name': 'stt_gg_ass',
    'credentials_file': 'credentials.json',
    'device_config_file': 'device_config.json',    
    'time_out': 6000,
    'is_active': False    
})
config['local_stt'].append({
    'name': 'stt_viettel',
    'token': 'SythdWRNwYE8N',
    'time_out': 4000,
    'is_active': False    
})
config['local_stt'].append({
    'name': 'stt_fpt',
    'token': '',
    'token_file': '',    
    'time_out': '',
    'is_active': False    
})
config['local_tts'] = []
config['local_tts'].append({
    'token': '',
    'name': 'tts_gg_free',
    'voice_name': '',
    're_use': True,
    'is_active': True    
})
config['local_tts'].append({
    'token_file': 'google.json',    
    'name': 'tts_gg_cloud',    
    'voice_name': 'vi-VN-Wavenet-A',
    'profile': 'telephony-class-application',      
    'speed': 1.0,
    'pitch': 0,
    're_use': True,
    'is_active': False    
})
config['local_tts'].append({
    'token': 'dfgdfgdfgARWDFSc',
    'name': 'tts_gg_cloud_free',    
    'voice_name': 'vi-VN-Wavenet-B',
    'profile': 'telephony-class-application',      
    'speed': 1.0,
    'pitch': 0,
    're_use': True,
    'is_active': False   
})
config['local_tts'].append({
    'token': 'SythBsdfsdfsddfsdRNwYE8N',
    'name': 'tts_viettel',    
    'voice_name': 'hcm-diemmy2',
    'speed': 1.0,
    'pitch': '',
    're_use': True,
    'is_active': False    
})
config['local_tts'].append({
    'token': '8sJJsdfsdffRGU',
    'name': 'tts_zalo',
    'voice_name': '1',    
    'speed': 1.0,
    'pitch': '',
    're_use': True, 
    'is_active': False    
})    
config['local_tts'].append({
    'token': '9onFsfsdfqzjjDU',
    'name': 'tts_fpt',
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
with open('config.json', 'w') as outfile:
    json.dump(config, outfile)
