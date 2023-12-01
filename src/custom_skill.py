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
#Sound
from tts_process import tts_process
from stt_process import process as stt_process
from speaker_process import play_sound
#Import Action    
act_on= act_data['on']['value'] #Khai báo keyword dạng Action, đã định nghĩa trong action.json ở đây
act_open= act_data['open']['value']
act_play = [p['value'] for p in act_data['play']]
#Import Object    
obj_funny_story = [p['value'] for p in obj_data['funny_story']] #Khai báo keyword dạng Object, đã định nghĩa trong object.json ở đây
obj_music=[p['value'] for p in obj_data['music']]
#Import Adverb
adv_at_moment=[p['value'] for p in adv_data['at_moment']] #Khai báo toàn bộ keyword dạng Adverb, đã định nghĩa trong adverb.json ở đây
adv_at_time=[p['value'] for p in adv_data['at_time']]
adv_from_now=[p['value'] for p in adv_data['from_now']]
adv_nearby=[p['value'] for p in adv_data['nearby']]


def custom_data_process(player2,volume):#Def này sẽ trả về kết quả để Vietbot đọc nội dung
    answer_text='Không có câu trả lời cho tình huống này' #Giá trị Default cho câu trả lời
    answer_path=None #Giá trị Default cho link file âm thanh hoặc link stream

    try:
        data = stt_process().lower()    
    except:
        libs.logging('left','Không nhận dạng được lệnh','red') 
        play_sound('FINISH') #Dong sound
        answer_text='Không nhận dạng được lệnh'
    if any(item in data for item in obj_funny_story): #Nếu sử dụng keyword khác, cần khai báo trong obj.json và khai báo ở trên
        def get_story_content(url):
            headers = {
                "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"
            }
            response = requests.get(url, headers=headers)#lib requests này đã có trong libs, nên không cần phải import
            soup = libs.bs4.BeautifulSoup(response.content, 'html.parser') #lib BeautifulSoup này đã có trong libs, nên không cần phải import
            content = soup.select_one('article.fck_detail').text.strip() # Tùy vào cấu trúc của trang web, chúng ta cần xác định chính xác selector, # Đây chỉ là một ví dụ giả định, bạn có thể cần điều chỉnh cho phù hợp với cấu trúc thực sự của trang
            return content
        URL = "https://www.grimmstories.com/vi/grimm_truyen/titles"
        response = libs.requests.get(URL) 
        soup = libs.bs4.BeautifulSoup(response.content, "html.parser")
        
        # Lấy danh sách tên và url của truyện
        story_data = [(link.text, "https://www.grimmstories.com" + link.get('href'))
                     for link in soup.find_all("a", class_="title")]
        # Lấy tên truyện từ data hoặc chọn một cách ngẫu nhiên nếu không tìm thấy
        name_result, name_url = next((name, url) for name, url in story_data if name in data), None
        if not name_result:
            name_result, name_url = libs.random.choice(story_data)
        answer_text= get_story_content(name_url)
    player2.play_and_wait(tts_process('answer_text',False)) #False - Phát câu trả lời TTS ko cache lại nội dung, True - Có cache lại để cho lần sau


if __name__ == '__main__':  
    from speaker_process import Player, Volume
    from led_process import Led
    # from speaker_process import VOLUME
    # volume=VOLUME(0)
    led=Led(conf_data,True)
    player=Player()
    volume=Volume(0)
    data='bây giờ là mấy giờ'
    print(custom_data_process(player,led,volume,data))    
