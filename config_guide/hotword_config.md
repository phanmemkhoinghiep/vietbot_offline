
Vietbot hỗ trợ các hotword của Porcupine cho Raspberry

### STEP1. Download hotword file

1.1. Download Hotword Picovoice

1.1.1. Truy cập trang Web https://github.com/Picovoice/porcupine/tree/master/resources/keyword_files/raspberry-pi 

1.1.2. Ấn vào link file bất kỳ: Ví dụ  alexa_raspberry-pi.ppn

1.1.3. Ấn vào mục Download ở bên phải, trình duyệt sẽ tự Download xuống

1.1.4. Truy nhập trang Web Picovoice https://console.picovoice.ai/

1.1.5. Đăng ký tài khoản

1.1.6. Lấy Access Token và lưu lại

### STEP2. Copy file

2.1. Copy các file .ppn từ PC sang Pi Zero Wireless bằng WinSCP vào đúng thư mục vietbot_offline/src/hotword

### STEP3. Khai báo cho hotword mới

3.1. Truy cập vào thư mục vietbot_offline trên M Pi Zero Wireless

```sh

cd /home/pi/vietbot_offline/src

```

3.2. Mở file create_config.py bằng WinSCP và Notepad ++


```sh

    "smart_wakeup": {
        "hotword_engine": {
            "type": "porcupine",
            "key": "riHsfsdfbcKcisA=="
        },
        "wakeup_reply": [{
                "value": "có em"
            },
            {
                "value": "em đây"
            },
            {
                "value": "đây anh"
            },
            {
                "value": "gì anh"
            },
            {
                "value": "yes anh"
            },
            {
                "value": "anh à"
            },
            {
                "value": "vâng anh"
            }
        ],
        "hotword": [{
                "type": "porcupine",
                "value": null,
                "file_name": "hey siri_raspberry-pi.ppn",
                "lang": "eng",
                "sensitive": 0.4,
                "say_reply": false,
                "command": null,
                "active": false
            },
            {
                "type": "porcupine",
                "value": null,
                "lang": "vi",
                "file_name": "chào-chị_raspberry-pi.ppn",
                "sensitive": 0.1,
                "say_reply": false,
                "command": null,
                "active": true
            },
            {
                "type": "porcupine",
                "value": null,
                "lang": "vi",
                "file_name": "em-ơi_raspberry-pi.ppn",
                "sensitive": 0.1,
                "say_reply": false,
                "command": null,
                "active": true
            },
            {
                "type": "porcupine",
                "value": null,
                "lang": "vi",
                "file_name": "người-đẹp-ơi_raspberry-pi.ppn",
                "sensitive": 0.1,
                "say_reply": false,
                "command": null,
                "active": true
            },
            {
                "type": "porcupine",
                "value": null,
                "lang": "vi",
                "file_name": "hà-nội-ơi_raspberry-pi.ppn",
                "sensitive": 0.1,
                "say_reply": false,
                "command": null,
                "active": true
            },
            {
                "type": "porcupine",
                "value": null,
                "lang": "vi",
                "file_name": "vợ-đâu-rồi_raspberry-pi.ppn",
                "sensitive": 0.1,
                "say_reply": false,
                "command": null,
                "active": true
            },
            {
                "type": "porcupine",
                "value": null,
                "lang": "vi",
                "file_name": "con-mụ-kia_raspberry-pi.ppn",
                "sensitive": 0.1,
                "say_reply": false,
                "command": null,
                "active": true
            }
        ]
    },

```

3.3. Save lại file create_config.py

### STEP4. Kết thúc

4.1. Lặp lại các Step 1,2,3 cho các Hotword khác

4.2. Sau khi khai báo xong hotword cuối cùng, save lại file create_config.py và chạy lại lệnh để tạo config

```sh
python3 create_config.py

```
Bước tiếp theo:

[CÁCH CHẠY](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/06_running_guide.md) 
