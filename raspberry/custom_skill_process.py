# !/usr/bin/python
# -*- coding: utf-8 -*-
#Processing
from lib_process import requests,process,json,time,global_constants,print_out
import bs4

# Định nghĩa URL và headers Dify
dify_headers = {
    "Authorization": "Bearer " + global_constants.dify_api_key,
    "Content-Type": "application/json"
}
today_hisotry_headers = {'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'}
def today_history_process(opt):
    try:

        # Using a dictionary to map the options to their corresponding functions
        date_map = {
            'YESTERDAY': get_current_date()[0],
            'TODAY': get_current_date()[1],
            'TOMORROW': get_current_date()[2],
            'NEXT_DAY': get_current_date()[3],
            'NEXT_WEEK': get_current_date()[4]  # adding an option for the 5th date
        }
        selected_date = date_map.get(opt)
        if not selected_date:
            return None
        payload = {
            'ngayxem': f"{selected_date.day:02d}-{selected_date.month:02d}-{selected_date.year}"
        }
        response = requests.post(global_constants.today_history_url, headers=today_hisotry_headers, data=payload)
        soup = bs4.BeautifulSoup(response.text, 'html.parser')
        return clean_content(soup.get_text())
    except Exception as e:
        print_out('left',f"Lỗi xử lý Today_history Skill: {str(e)}",'red')
        return 'Không có câu trả lời từ skill của vietbot trong tình huống này'
def dify_process(data):
    request_json = {
        "inputs": {},
        "query": data,
        "response_mode": "streaming",
        "conversation_id": "",
        "user": "abc-123",
        "files": []
    }
    try:
        response = requests.post(global_constants.dify_url, headers=dify_headers, json=request_json, stream=True)
        if response.status_code != 200:
            raise ValueError(f"HTTP Error: {response.status_code} - {response.text}")
        
        for line in response.iter_lines(decode_unicode=True):
            if line.strip():  # Kiểm tra dòng không rỗng
                if line.startswith("data: "):
                    line = line[6:]  # Loại bỏ tiền tố "data: "
                try:
                    response_data = json.loads(line)  # Parse JSON
                    data_section = response_data.get("data", global_constants.dify_no_answer)
                    if not data_section:
                        continue                    
                    inputs_section = data_section.get("inputs", global_constants.dify_no_answer)
                    if not inputs_section:
                        continue                    
                    context_value = inputs_section.get("#context#", global_constants.dify_no_answer)
                    if context_value:
                        # Chỉ lấy dòng đầu tiên
                        first_line = context_value.split("\n")[0].strip()
                        return first_line
                except json.JSONDecodeError:
                    # Bỏ qua lỗi JSON cho các dòng không hợp lệ
                    continue
        # Nếu không tìm thấy giá trị
        return global_constants.dify_no_answer
    except Exception as e:
        print_out('left',f"Lỗi xử lý Dify Skill: {str(e)}",'red')
        return global_constants.dify_no_answer
# Hàm xử lý văn bản
def custom_skill_process(data):
    answer='Không có câu trả lời từ skill của vietbot trong tình huống này'
    if any(item in data for item in global_constant.obj_history):
        if any(item in data for item in global_constant.obj_yesterday):
            answer=today_history_process('YESTERDAY')
        elif any(item in data for item in global_constant.obj_today):
            answer=today_history_process('TODAY')            
        elif any(item in data for item in global_constant.obj_tomorrow):
            answer=today_history_process('TOMORROW')     
        elif any(item in data for item in global_constant.obj_next_day):
            answer=today_history_process('NEXT_DAY')                 
        elif any(item in data for item in global_constant.obj_next_week):
            answer=today_history_process('NEXT_WEEK')    
    else:
        answer=dify_process(data)    
    return answer
# Chạy thử chương trình
if __name__ == "__main__":
    data = "Ngày này năm xưa có gì"
    result = custom_skill_process(data)
    print("Kết quả bot:", result)
