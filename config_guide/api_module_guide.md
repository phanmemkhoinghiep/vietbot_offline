### HƯỚNG DẪN CÀI ĐẶT VÀ SỬ DỤNG
Vietbot hỗ trợ tính năng phát TTS trực tiếp, tức thời

### STEP1. Truyền text vào TTS để phát thông báo

1.1 Truyền trực tiếp
Truyền trực tiếp qua giao diện
 http://X.X.X.X:5000/
 
 Gõ Text, sau đó bấm Submit

1.2. Truyền qua API

1.2.1. Mô tả API

Địa chỉ: http://X.X.1.X:5000/api

Phương thức: POST

Định dạng bản tin: json

Cấu trúc bản tin: {"data":"Nội dung cần phát"} 

Phản hồi thành công: TTS sẽ trả về nội dung 'Playback OK'

Phản hồi không thành công: Trả về nội dung 'Playback not OK'

```sh
[BOT-TTS-GOOGLE-CLOUD]: Cộng hòa xã hội chủ nghĩa Việt Nam. Độc lập tự do hạnh phúc
Delayed: 5(s)
192.168.1.106 - - [27/Apr/2021 10:16:04] "POST HTTP/1.1" 200 -
```
1.2.2. Ví dụ với Home Assistant

Khai báo trong configuration.yaml
```sh
rest_command:
  vietbot_tts:
    url: http://192.168.1.109:5000/api
    method: POST
    payload: '{"data":"{{ data }}"}'
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

