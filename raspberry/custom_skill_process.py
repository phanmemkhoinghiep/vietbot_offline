# !/usr/bin/python
# -*- coding: utf-8 -*-
#Processing
from lib_process import requests,process,json,time,global_constants,ChatClient,print_out


api_key = global_constants.dify_api_key


# Initialize ChatClient
chat_client = ChatClient(api_key)
# Create Chat Message using ChatClient


def dify_process(data):
    try:
        # Create Chat Message
        chat_response = chat_client.create_chat_message(
            inputs={}, query=data, user="user_id", response_mode="streaming"
        )
        chat_response.raise_for_status()
        result = []
        for line in chat_response.iter_lines(decode_unicode=True):
            line = line.split('data:', 1)[-1]  # Lấy nội dung JSON từ dòng
            if line.strip():
                line = json.loads(line.strip())  # Parse JSON
                answer = line.get('answer')
                if answer:  # Chỉ thêm các câu trả lời hợp lệ
                    result.append(answer)
                    # print(answer)  # In từng câu trả lời ra màn hình

        # Trả về toàn bộ kết quả nối thành chuỗi
        return " ".join(result)
    except Exception as e:
        print_out('left',f"Lỗi xử lý API Dify: {str(e)}",'red')
        return global_constants.dify_no_answer
def custom_skill_process(data):
    return dify_process(data)

# Chạy thử chương trình
if __name__ == "__main__":
    data = "trang bị phương tiện bảo vệ cá nhân để làm gì nhỉ?"
    result = custom_skill_process(data)
    print("Kết quả bot:", result)
