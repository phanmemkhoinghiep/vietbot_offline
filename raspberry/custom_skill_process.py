# !/usr/bin/python
# -*- coding: utf-8 -*-
#Processing
from lib_process import requests,process,json,time,global_constants,print_out

# Định nghĩa URL và headers
url = "https://api.dify.ai/v1/chat-messages"
headers = {
    "Authorization": "Bearer " + global_constants.dify_api_key,
    "Content-Type": "application/json"
}
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
        response = requests.post(global_constants.dify_url, headers=headers, json=request_json, stream=True)
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
        print(f"Lỗi xử lý API Dify: {str(e)}")
        return global_constants.dify_no_answer
# Hàm xử lý văn bản
def custom_skill_process(data):
    return dify_process(data)

# Chạy thử chương trình
if __name__ == "__main__":
    data = "Chế độ hỗ trợ lãi suất vay mua nhà ở cụ thể"
    result = custom_skill_process(data)
    print("Kết quả bot:", result)
