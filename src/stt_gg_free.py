import time
import json
import speech_recognition as sr
from termcolor import colored
STREAMING_LIMIT=None
with open('config.json') as config_json:
    config_data = json.load(config_json)
for p in config_data['local_stt']:
    if p['name'] == 'stt_gg_free':
        STREAMING_LIMIT=p['time_out']
def get_current_time():
    return int(round(time.time() * 1000))


def main():
    start_time=get_current_time()        
    data=None
    while get_current_time() - start_time < STREAMING_LIMIT:    
        r = sr.Recognizer()
        with sr.Microphone() as source:
            try:
                r.adjust_for_ambient_noise(source, duration=1)
                audio = r.listen(source)
                data = r.recognize_google(audio, language = "vi-VN")
                if len(data) >0:
                    print(colored('[HUMAN]: '+data,'blue'))            
                    break
            except:
                pass
    return data

if __name__ == '__main__':
    main()

# [END speech_transcribe_streaming_mic]
