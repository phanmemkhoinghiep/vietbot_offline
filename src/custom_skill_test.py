 # !/usr/bin/python
# -*- coding: utf-8 -*-
#-*-coding:gb2312-*-
#Processing
import libs
libs.requests.packages.urllib3.disable_warnings(libs.requests.packages.urllib3.exceptions.InsecureRequestWarning)

#import requests
#import random
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
url = "https://caothang.edu.vn/Lich-cong-tac-tuan-thu-14-Tu-ngay-27112023-den-ngay-03122023.html"
#Import Object    
obj_work_calendar = [p['value'] for p in obj_data['work_calendar']] #Khai báo keyword dạng Object, đã định nghĩa trong object.json ở đây
obj_monday = [p['value'] for p in obj_data['monday']] #Khai báo keyword dạng Object, đã định nghĩa trong object.json ở đây
obj_tuesday = [p['value'] for p in obj_data['tuesday']] #Khai báo keyword dạng Object, đã định nghĩa trong object.json ở đây
obj_wednesday = [p['value'] for p in obj_data['wednesday']] #Khai báo keyword dạng Object, đã định nghĩa trong object.json ở đây
obj_thursday  = [p['value'] for p in obj_data['thursday']] #Khai báo keyword dạng Object, đã định nghĩa trong object.json ở đây
obj_friday  = [p['value'] for p in obj_data['friday']] #Khai báo keyword dạng Object, đã định nghĩa trong object.json ở đây
obj_saturday  = [p['value'] for p in obj_data['saturday']] #Khai báo keyword dạng Object, đã định nghĩa trong object.json ở đây
obj_sunday  = [p['value'] for p in obj_data['sunday']] #Khai báo keyword dạng Object, đã định nghĩa trong object.json ở đây

def custom_data_process(player2,led,volume):#Def này sẽ trả về kết quả để Vietbot đọc nội dung
    answer_text='Không có câu trả lời cho tình huống này' #Giá trị Default cho câu trả lời
    try:
        data = stt_process().lower()    
    except:
        libs.logging('left','Không nhận dạng được lệnh','red') 
        play_sound('FINISH') #Dong sound
        answer_text='Không nhận dạng được câu lệnh'
    if any(item in data for item in obj_work_calendar): #Nếu sử dụng keyword khác, cần khai báo trong obj.json và khai báo ở trên
        try:
            # Gửi yêu cầu GET đến trang web
            response = libs.requests.get(url, verify=False)
            # Kiểm tra xem yêu cầu có thành công không (status code 200 là thành công)
            if response.status_code == 200:
                # Sử dụng BeautifulSoup để phân tích cú pháp HTML
                soup = libs.BeautifulSoup(response.text, 'html.parser')
                # Tạo một biến để lưu trữ toàn bộ nội dung
                full_content = ""
                # Lấy Tiêu đề
                title = soup.title.text.strip()
                # Lấy Nội dung từ thẻ <td>
                td_tags = soup.find_all('td')
                for td_tag in td_tags:
                    p_tags = td_tag.find_all('p')
                    for p_tag in p_tags:
                        full_content += f"{p_tag.text.strip()}\n"   
                full_content=full_content.replace('TP', 'Thành phần:')                     
                if any(item in data for item in obj_monday):
                    thu_hai =libs.re.search(r'THỨ HAI(.*?)THỨ BA', full_content, re.DOTALL)
                    answer_text = thu_hai.group(1).strip()
                elif any(item in data for item in obj_tuesday):
                    thu_ba =libs.re.search(r'THỨ BA(.*?)THỨ TƯ', full_content, re.DOTALL)
                    answer_text = thu_ba.group(1).strip()
                elif any(item in data for item in obj_wednesday):
                    thu_tu =libs.re.search(r'THỨ TƯ(.*?)THỨ NĂM', full_content, re.DOTALL)
                    answer_text = thu_tu.group(1).strip()
                elif any(item in data for item in obj_thursday):
                    thu_nam =libs.re.search(r'THỨ NĂM(.*?)THỨ SÁU', full_content, re.DOTALL)
                    answer_text = thu_nam.group(1).strip()        
                elif any(item in data for item in obj_friday):
                    thu_sau =libs.re.search(r'THỨ SÁU(.*?)THỨ BẢY', full_content, re.DOTALL)
                    answer_text = thu_sau.group(1).strip()        
                elif any(item in data for item in obj_saturday):
                    thu_bay =libs.re.search(r'THỨ BẢY(.*?)CHỦ NHẬT', full_content, re.DOTALL)
                    answer_text = thu_bay.group(1).strip()        
                elif any(item in data for item in obj_sunday):
                    chu_nhat =libs.re.search(r'CHỦ NHẬT(.*?)$', full_content, re.DOTALL)
                    answer_text = chu_nhat.group(1).strip()        
                else:
                    # Lấy ngày hôm nay
                    ngay_hom_nay = libs.datetime.datetime.datetime.now()
                    # Lấy số thứ tự của ngày trong tuần (0 là thứ hai, 6 là chủ nhật)
                    so_thu_tu_ngay = ngay_hom_nay.weekday()
                    # Chuyển đổi số thứ tự sang tên của ngày trong tuần
                    ten_ngay = ['THỨ HAI', 'THỨ BA', 'THỨ TƯ', 'THỨ NĂM', 'THỨ SÁU', 'THỨ BẢY', 'CHỦ NHẬT']
                    ten_thu = ten_ngay[so_thu_tu_ngay]
                    if ten_thu =='THỨ HAI':
                        thu_hai =libs.re.search(r'THỨ HAI(.*?)THỨ BA', full_content, re.DOTALL)
                        answer_text = thu_hai.group(1).strip()
                    elif ten_thu =='THỨ BA':
                        thu_ba =libs.re.search(r'THỨ BA(.*?)THỨ TƯ', full_content, re.DOTALL)
                        answer_text = thu_ba.group(1).strip()
                    elif ten_thu =='THỨ TƯ':
                        thu_tu =libs.re.search(r'THỨ TƯ(.*?)THỨ NĂM', full_content, re.DOTALL)
                        answer_text = thu_tu.group(1).strip()
                    elif ten_thu =='THỨ NĂM':
                        thu_nam =libs.re.search(r'THỨ NĂM(.*?)THỨ SÁU', full_content, re.DOTALL)
                        answer_text = thu_nam.group(1).strip()        
                    elif ten_thu =='THỨ SÁU':
                        thu_sau =libs.re.search(r'THỨ SÁU(.*?)THỨ BẢY', full_content, re.DOTALL)
                        answer_text = thu_sau.group(1).strip()        
                    elif ten_thu =='THỨ BẨY':
                        thu_bay =libs.re.search(r'THỨ BẢY(.*?)CHỦ NHẬT', full_content, re.DOTALL)
                        answer_text = thu_bay.group(1).strip()        
                    elif ten_thu=='CHỦ NHẬT':
                        chu_nhat =libs.re.search(r'CHỦ NHẬT(.*?)$', full_content, re.DOTALL)
                        answer_text = chu_nhat.group(1).strip()                                            
        except:            
            answer_text = 'Lỗi xử lý thông tin'

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
