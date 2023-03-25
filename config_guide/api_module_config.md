### HƯỚNG DẪN CÀI ĐẶT VÀ SỬ DỤNG
Vietbot hỗ trợ tính năng xử lý API thông qua nhận RestFull và phản hồi lại 

### STEP1. Enable Module API trong Config
1.1. Sửa File config như sau:
```sh

config['input_module'].append({
    'type': 'api',
    'is_active': True            
})
config['output_module'] =[]
config['output_module'].append({
    'type': 'api',
    'is_active': True            
})

```
sau đó Save lại

1.2. Gen file config.json như sau
Sau đó 

```sh

python3 /home/pi/vietbot_offline/src/create_config.py  

```

### STEP2. Truyền text vào Vietbot để phát thành âm thanh

2.1. Mô tả API

Địa chỉ: http://X.X.1.X:5000/api

Phương thức: POST

Định dạng bản tin: json

Cấu trúc bản tin: {"data":"Nội dung cần phát","type":1} 

2.2 Phản hồi

2.2.1 Phản hồi thành công: 

TTS sẽ trả về bản tin json với payload:

```sh

'state':'OK','result':'Speak TTS OK'

```
2.3 Phản hồi không thành công

2.3.1. Do không kích hoạt Module Speaker Ouput trong config Vietbot
```sh

'state':'Failed','result':'Ouput Speaker in Vietbot config not enable'

```
2.3.2. Giá trị type bị đưa sai

```sh
'state':'Failed','result':'type in request payload is invalid'

```

2.3.4. Tiến trình xử lý trên Vietbot đang bị lỗi 

```sh
'state':'Failed','result':'Vietbot process error'                        

```
2.3.5. Và cuối cùng là sai định dạng 

```sh
'state' : 'Failed','result':'Payload of request is invalid format' 

```
2.4. Ví dụ
2.4.1 Với Home Assistant

Khai báo trong configuration.yaml
```sh
rest_command:
  vietbot_tts:
    url: http://192.168.1.109:5000/api
    method: POST
    payload: '{"data":"{{ data }}","type":1}'
    content_type: 'application/json; charset=utf-8'
automation:
  alias: test
  description: ''
  trigger:
    - platform: device
      type: turned_off
      device_id: cc94e4e74c8e7bcf0a9f2649637d3734
      entity_id: switch.0x588e81fffede3767_switch_l2
      domain: switch
  condition: []
  action:
    - service: rest_command.vietbot_tts
      data:
        data: Đã tắt đèn rồi nhé anh 
  mode: single
```
### STEP3. Truyền câu lệnh vào Vietbot để trả lời

3.1. Mô tả API

Địa chỉ: http://X.X.1.X:5000/api

Phương thức: POST

Định dạng bản tin: json

Cấu trúc bản tin: {"data":"Nội dung cần phát","type":2} 

3.2 Phản hồi

3.2.1 Phản hồi thành công: 

TTS sẽ trả về bản tin json với payload:

```sh

'state':'Success','answer_text':text,'answer_link':link

```
Trong đó text, link là câu trả lời và link online của bài hát, kênh Radio (Nếu có)

2.3 Phản hồi không thành công

2.3.1. Giá trị type bị đưa sai

```sh
'state':'Failed','result':'type in request payload is invalid'

```

2.3.2. Tiến trình xử lý trên Vietbot đang bị lỗi 

```sh
'state':'Failed','result':'Vietbot process error'                        

```
2.3.3. Và cuối cùng là sai định dạng 

```sh
'state' : 'Failed','result':'Payload of request is invalid format' 

```

2.4. Ví dụ
2.4.1 Với Home Assistant

Khai báo trong configuration.yaml
```sh
rest_command:
  vietbot_tts:
    url: http://192.168.1.109:5000/api
    method: POST
    payload: '{"data":"{{ data }}","type":2}'
    content_type: 'application/json; charset=utf-8'
automation:
  alias: test
  description: ''
  trigger:
    - platform: device
      type: turned_off
      device_id: cc94e4e74c8e7bcf0a9f2649637d3734
      entity_id: switch.0x588e81fffede3767_switch_l2
      domain: switch
  condition: []
  action:
    - service: rest_command.vietbot_tts
      data:
        data: Tắt Tivi phòng khách 
  mode: single
```
### STEP4. Nhận cảnh báo tù Cam Hanet và đọc ra loa

4.1. Mô tả API

Địa chỉ: http://X.X.1.X:5000/api

Phương thức: POST

Định dạng bản tin: json

Cấu trúc bản tin: Theo quy định của Hanet

4.2 Phản hồi

4.2.1 Phản hồi thành công: 

TTS sẽ trả về bản tin json với payload:

```sh

'state' : 'Success','Result' : 'Get Hanet event and speak face information OK'

```
4.3 Phản hồi không thành công

4.3.1. Do không kích hoạt Module Speaker Ouput trong config Vietbot

```sh
state':'Failed','result':'Ouput Speaker in Vietbot config not enable'                        

```

4.3.2. Tiến trình xử lý trên Vietbot đang bị lỗi 

```sh
'state':'Failed','result':'Vietbot process error'                        

```
4.3.3. Và cuối cùng là sai định dạng 

```sh
'state' : 'Failed','result':'Payload of request is invalid format' 

```
