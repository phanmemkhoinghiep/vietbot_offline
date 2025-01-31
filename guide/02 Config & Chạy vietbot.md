### CÀI ĐẶT VIETBOT TỪ ĐẦU TIÊN

### STEP1. Config vietbot

1.1. Lấy Mic id của microphone

Gõ  lệnh sau
```sh
source vietbot_env/bin/active
```

```sh
cd vietbot_offline/raspberry
```

```sh
python3 get_mic_id.py
```

Xem kết quả trả về, chọn lấy thiết bị Mic phù hợp
Ví dụ kết quả trả về
Danh sách các thiết bị âm thanh khả dụng:
```sh
ID: 0, Tên: bcm2835 Headphones: - (hw:0,0), Loại: 0 kênh đầu vào
ID: 1, Tên: USB Composite Device: Audio (hw:3,0), Loại: 1 kênh đầu vào
ID: 2, Tên: sysdefault, Loại: 0 kênh đầu vào
ID: 3, Tên: default, Loại: 0 kênh đầu vào
ID: 4, Tên: dmix, Loại: 0 kênh đầu vào
```
Thì mic_id sẽ là 1

Gõ  lệnh sau
```sh
source vietbot_env/bin/active
```

```sh
cd vietbot_offline/raspberry
```

```sh
sudo nano config.json
```
Ở dòng số 5 thay giá trị 12 bằng 1

```sh
"id": 1 
```
Ấn Ctrl + X sau đó bấm Y để lưu


1.2. Lấy giá trị amixer_id (Giá trị id của soundcard)

```sh
amixer
```
Nếu kết quả trả về:

```sh
Simple mixer control 'PCM',0
  Capabilities: pvolume pvolume-joined pswitch pswitch-joined
  Playback channels: Mono
  Limits: Playback -10239 - 400
  Mono: Playback -3856 [60%] [-38.56dB] [on]
```
Thì amixer có giá trị là 0

Gõ  lệnh sau
```sh
source vietbot_env/bin/active
```

```sh
cd vietbot_offline/raspberry
```

```sh
sudo nano config.json
```
Ở dòng số 9 thay giá trị 2 bằng 0

```sh
"amixer_id": 2
```
Ấn Ctrl + X sau đó bấm Y để lưu

1.3. Config picovoice (Nếu dùng Picovoice để Wakeup)

1.3.1. Cung cấp key Picovoice
Gõ  lệnh sau
```sh
source vietbot_env/bin/active
```

```sh
cd vietbot_offline/raspberry
```

```sh
sudo nano config.json
```

Thay key của Picovoice ở dòng thứ 57
```sh
"key": "nA2Kkj/oRFQ==",
```
thành giá trị đã đăng ký trên Picovoice console, giữa 2 dấu ""
Ấn Ctrl + X sau đó bấm Y để lưu

1.3.2. Kích hoạt Picovoice

Tương tự sử dụng các lệnh để nở file config.json ở dòng thứ 58
Sửa active từ false sang true, nếu true thì giữ nguyên
```sh
"active": true,
```
1.3.3. Sửa độ nhậy

Tương tự sử dụng các lệnh để nở file config.json ở dòng tương ứng với từng hotwod

Sửa giá trị 0.3 sang giá trị mong muốn (Càng lớn càng nhạy)
```sh
"sensitive": 0.3,
```

1.4. Config Openwakeword (Nếu dùng Openwakeword để Wakeup)

1.3.2. Download model của Openwakeword

Gõ  lệnh sau
```sh
source vietbot_env/bin/active
```

```sh
cd vietbot_offline
```

```sh
python3 get_openwakeword_model.py
```

1.3.2. Kích hoạt
Tương tự sử dụng các lệnh để nở file config.json ở dòng thứ 163
Sửa active từ false sang true, nếu true thì giữ nguyên
```sh
"active": true,
```
1.3.3. Sửa độ nhậy
Tương tự sử dụng các lệnh để nở file config.json ở dòng thứ 162
Sửa giá trị 0.3 sang giá trị mong muốn (Càng nhỏ càng nhậy)
```sh
"sensitive": 0.3,
```
1.5. Lưu file config.json

### STEP2. Chạy vietbot

2.1. Chạy Manual từ PC:

Gõ  lệnh sau
```sh
source vietbot_env/bin/active
```

```sh
cd vietbot_offline
```

```sh
python3 start.py
```

2.2. Chạy Manual từ PC có thể tắt PC:

Gõ các lệnh sau

```sh
tmux new-session -s vietbot_session
```

Cửa sổ tmux cho phiên vietbot_session mở ra, khi đó lặp lại các bước 2.1

Sau đó có thể tắt PC

Nếu muốn vào lại, kết nối SSH lại và gõ

```sh
tmux attach-session -t vietbot_session
```

2.3. Chạy tự động từ khi boot:

2.3.1 Soạn thảo file vietbot.service bằng lệnh sau:

```sh
sudo nano /etc/systemd/system/vietbot.service
```
Cửa sổ nano mở ra, paste các dòng sau

```sh
[Unit]
Description=Vietbot
After=network.target

[Service]
User=pi
WorkingDirectory=/home/pi/vietbot_offline/raspberry
ExecStart=/home/pi/vietbot_env/bin/python /home/pi/vietbot_offline/raspberry/start.py
Restart=always
Environment=PYTHONUNBUFFERED=1

[Install]
WantedBy=multi-user.target
```
Ấn Ctrl + X sau đó bấm Y để lưu

2.3.2. Gõ tiếp các lệnh sau:

```sh
sudo systemctl daemon-reload
```

```sh
sudo systemctl enable vietbot.service
```

```sh
sudo systemctl start vietbot.service
```
2.3.3. Xem trạng thái & Log 

Để xem trạng thái của service, dùng lệnh

```sh
sudo systemctl status vietbot.service
```
Để xem log của service, dùng lệnh

```sh
sudo journalctl -u vietbot.service -f
```
