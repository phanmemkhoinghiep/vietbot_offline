
### STEP1. Chạy Manual

1.1. Truy nhập vào thư mục Bot
Sử dụng lệnh sau

```sh
cd vietbot_online/src
```
1.2. Edit config bằng lệnh 

```sh
sudo nano create_config.py
```
1.3. Tạo file config sau khi Edit xong bằng lệnh 

```sh
python3 create_config.py
```
1.4. Chạy boot

1.4.1. Chạy có hiện thông báo để biết lỗi xảy ra còn khắc phục
```sh
python3 start.py
```
1.4.1. Chạy không hiện thông báo khi đã không còn lỗi
```sh
python3 start.py  2>/dev/null
```

1.5. Ra lệnh bằng từ khóa

Sau khi có kết quả thành công, ra lệnh bằng từ khóa đã có trong file confg.json sẽ có tiếng Ting và bắt đầu chờ để ra lệnh


### STEP2.  Chạy tự động khi khởi động Pi

2.1. Chạy bằng Systemd

2.1.1. Gõ lệnh

```sh
sudo nano /etc/systemd/system/vietbot.service
```
Tại cửa sổ Nano, gõ dòng lệnh sau

2.1.2. Với Mic2Hat, 4MicHat

```sh
[Unit]
Description=vietbot

[Service]
ExecStart = /usr/bin/python3.9  /home/pi/vietbot_online/src/start.py 2>/dev/null
WorkingDirectory=/home/pi/vietbot_online/src
StandardOutput=inherit
StandardError=inherit
Restart=always
User=pi

[Install]
WantedBy=multi-user.target
```
2.1.3. Với các loại Mic USB

```sh
[Unit]
Description=vietbot
After=alsa-state.service

[Service]
ExecStart = /usr/bin/python3.9  /home/pi/vietbot_online/src/start.py 2>/dev/null
WorkingDirectory=/home/pi/vietbot_online/src
StandardOutput=inherit
StandardError=inherit
Restart=always
User=pi

[Install]
WantedBy=multi-user.target
```


Bấm Ctrl + X, Y, Enter

2.1.4. Gõ lệnh sau

```sh
sudo systemctl enable vietbot.service
```
Hệ thống sẽ hiện ra
```sh
Created symlink /etc/systemd/system/multi-user.target.wants/vietbot.service → /etc/systemd/system/vietbot.service.
```
Hệ thống đã sẵn sàng tự động chạy tu dong vietbot

2.1.5. Gõ lệnh sau để chạy tự động vietbot
```sh
sudo systemctl start vietbot
```
hoặc
```sh
sudo reboot
```
2.1.6. Gõ lệnh sau để xem log
```sh
 sudo journalctl -u vietbot.service -f
```
2.1.7. Gõ lệnh sau để stop chạy tự động 

Gõ lệnh để stop tạm thời

```sh
sudo systemctl stop vietbot.service
```
vietbot sẽ stop không chạy cho đến khi khởi động lại

Gõ lệnh sau để disable

```sh
sudo systemctl disable vietbot.service
```

Hệ thống sẽ hiện ra
```sh
Removed /etc/systemd/system/multi-user.target.wants/vietbot.service
```
Hệ thống đã stop vietbot không chạy tự động nữa
