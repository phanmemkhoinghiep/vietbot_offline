# !/usr/bin/python
# -*- coding: utf-8 -*-
#-*-coding:gb2312-*-
import libs
with open('config.json') as config_json:
    conf_data = libs.json.load(config_json)  
bot_mode=conf_data['smart_config']['bot_mode']
if bot_mode=='rapid':        
    import main_process_rapid
    main_process_rapid.main_process()
elif bot_mode=='full':
    import main_process_full
    main_process_full.main_process()
elif bot_mode=='custom':    
    try:
        import custom_process
        custom_process.main_process()
    except Exception as e1:
        libs.logging('left','Lỗi khi nạp chạy Custom Mode:' +str(e1),'red')    