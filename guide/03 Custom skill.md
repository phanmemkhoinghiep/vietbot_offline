### STEP1. Hiểu luồng xử lý

1.1. Luồng xử lý thông thường:

```sh
Callback_process: stt_process() => Text => Kiểm tra điều kiện thỏa mãn để xử lý các lệnh cơ bản nhất => Nếu không thỏa mãn => Gọi text_process xử lý tiếp

Text_process: Kiểm tra điều kiện thỏa mãn để xử lý các skill cơ bản => Gọi skill_process với các def xử lý từng skill như(hỏi giờ, thời tiết theo khu vực trong config, lịch âm, hass, nghe nhạc offline) trả về text hoặc link, => Nếu không thỏa mãn gọi kết thúc
```
1.2. Luồng xử lý với custom skill:

```sh

Callback_process: stt_process() => Text => Kiểm tra điều kiện thỏa mãn để xử lý các lệnh cơ bản nhất => Nếu không thỏa mãn => Gọi text_process xử lý tiếp

Text_process: Kiểm tra điều kiện thỏa mãn để xử lý các skill cơ bản => Gọi skill_process với các def xử lý từng skill như(hỏi giờ, thời tiết theo khu vực trong config, lịch âm, hass, nghe nhạc offline) trả về text hoặc link, => Nếu không thỏa mãn gọi custom_skill_process

Custom_skill_process: Kiểm tra các điều kiện tùy chọn để gọi các def xử lý từng skill bổ sung trả về text hoặc link, => Nếu không thỏa mãn gọi kết thúc

```
Trong ví dụ này, sẽ tạo 2 custom skill, 1 là skill hỏi ngày kỉ niệm cá nhân và 1 skill sử dụng AI bot Dify, luồng xử lý sẽ như sau:

```sh

Custom_skill_process: Kiểm tra data thỏa mãn điều kiện để gọi skill kỉ niệm cá nhân, nếu không thỏa mãn thì gọi skill sử dụng AI bot Dify để trả lời, như vậy skill AI bot Dify sẽ trả lời toàn bộ các câu hỏi không thỏa mãn tại các skill mặc định và các skill custom

```sh
 
### STEP2. Khai báo trong json

2.1. Chuyển user về level 2 bằng cách cập nhật config.json tại dòng 275

```sh
        "level": 2
```

2.2. Tạo file json chứa config của các skill

2.2.1. Lưu các thông số cần config trong file json, nếu lưu luôn trong các file config.json

Ví dụ nếu khai các tham số config của skill Diffy trong config.json:
```sh
        "dify": {
            "api_key": "app-qVedgdfg7kO",
			      "url":"https://api.dify.ai/v1/chat-messages",			
			      "error":"Lỗi xử lý từ AI chatbot",	
			      "no_answer":"Không có trả lời từ AI chatbot"	
        }
```
2.2.2. Tạo mới file skill.json để lưu config của skill 
```sh
{
    "time": {
        "error_answer": "Không thực hiện được tra cứu thời gian, hãy kiểm tra lại",
        "active": true
    },
    "music": {
        "error_answer": "Không thực hiện được phát nhạc, hãy kiểm tra lại",
        "active": true
    },
    "lunar_calendar": {
        "error_answer": "Không thực hiện được tra cứu lịch âm, hãy kiểm tra lại",
        "active": true
    },
    "anniversary": {
        "error_answer": "Không thực hiện được tra cứu ngày kỉ niệm, hãy kiểm tra lại",
        "active": true
    },
    "anniversary_data": [{
            "name": "tết dương lịch",
            "day": "1",
            "month": "1",
            "is_lunar_calendar": false
        },
        {
            "name": "tết âm lịch",
            "day": "1",
            "month": "1",
            "is_lunar_calendar": true
        },
        {
            "name": "thành lập đảng cộng sản việt nam",
            "day": "3",
            "month": "2",
            "is_lunar_calendar": false
        },
        {
            "name": "lễ tình nhân",
            "day": "14",
            "month": "2",
            "is_lunar_calendar": false
        },
        {
            "name": "quốc tế phụ nữ",
            "day": "8",
            "month": "3",
            "is_lunar_calendar": false
        },
        {
            "name": "giỗ Tổ",
            "day": "10",
            "month": "3",
            "is_lunar_calendar": true
        },
        {
            "name": "test code",
            "day": "22",
            "month": "4",
            "is_lunar_calendar": false
        },
        {
            "name": "giải phóng miền Nam",
            "day": "30",
            "month": "4",
            "is_lunar_calendar": false
        },
        {
            "name": "quốc tế lao động",
            "day": "1",
            "month": "5",
            "is_lunar_calendar": false
        },
        {
            "name": "quốc khánh",
            "day": "2",
            "month": "9",
            "is_lunar_calendar": false
        },
        {
            "name": "phụ nữ Việt Nam",
            "day": "20",
            "month": "10",
            "is_lunar_calendar": false
        },
        {
            "name": "Giáng Sinh",
            "day": "24",
            "month": "12",
            "is_lunar_calendar": false
        }
    ]
}
```



2.2. Khai báo các biến dạng hằng số trong global_constants.py

Ví dụ, các biến của Skill diffy được khai báo tại đây

```sh
#Dify Skill
dify_api_key=config_data['smart_skill']['dify']['api_key']
dify_url=config_data['smart_skill']['dify']['url']
dify_error=config_data['smart_skill']['dify']['error']
dify_no_answer=config_data['smart_skill']['dify']['no_answer']
```

2.3. Khai báo các biến dạng biến toàn cục trong global_vars.py (Nếu cần)

Sử dụng biến toàn cục, nếu muốn đọc hoặc chỉnh sửa biến này từ nhiều script tạo thêm, hoặc qua đường API

### STEP3. Code def xử lý

Trong script custom_skill_process.py tạo các def xử lý data và trả về text hoặc text và link 

3.1. Code def xử lý
Ví dụ def dify_process
```sh
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
```
3.2. Lập trình để hàm def custom_skill_process gọi tiếp def xử lý data và trả về kết quả của hàm def xử lý data

Ví dụ gọi hàm dify_process
```sh
def custom_skill_process(data):
    return dify_process(data)
```

