### Truyền câu lệnh vào Vietbot để trả lời

1.1. Mô tả API

Địa chỉ: http://X.X.1.X:5000/api

Phương thức: POST

Định dạng bản tin: json

Cấu trúc bản tin: {"data":"Nội dung cần phát","type":2} 

1.2 Phản hồi

1.2.1 Phản hồi thành công: 

TTS sẽ trả về bản tin json với payload:

```sh

'state':'Success','answer_text':text,'answer_link':link

```
Trong đó text, link là câu trả lời và link online của bài hát, kênh Radio (Nếu có)

1.3 Phản hồi không thành công

1.3.1. Giá trị type bị đưa sai

```sh
'state':'Failed','result':'type in request payload is invalid'

```

1.3.2. Tiến trình xử lý trên Vietbot đang bị lỗi 

```sh
'state':'Failed','result':'Vietbot process error'                        

```
1.3.3. Và cuối cùng là sai định dạng 

```sh
'state' : 'Failed','result':'Payload of request is invalid format' 

```
1.4. Ví dụ
1.4.1 Với Home Assistant

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

3.3 Phản hồi không thành công

3.3.1. Tiến trình xử lý trên Vietbot đang bị lỗi 

```sh
'state':'Failed','result':'Vietbot process error'                        

```
3.3.2. Và cuối cùng là sai định dạng 

```sh
'state' : 'Failed','result':'Payload of request is invalid format' 

```