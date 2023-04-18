### Lựa chọn 1.  Chạy bằng Systemd (Khi dùng STT Google Free, STT Google Cloud)

1.1. Gõ lệnh

```sh
sudo nano /etc/systemd/system/vietbot.service
```
1.2. Tại cửa sổ Nano, gõ dòng lệnh sau

1.2.1. Với Mic2Hat, 4MicHat

```sh
[Unit]
Description=vietbot

[Service]
ExecStart = /usr/bin/python3.9  /home/pi/vietbot_offline/src/start.py 2>/dev/null
WorkingDirectory=/home/pi/vietbot_offline/src
StandardOutput=inherit
StandardError=inherit
Restart=always
User=pi

[Install]
WantedBy=multi-user.target
```
1.2.2. Với các loại Mic USB

```sh
[Unit]
Description=vietbot
After=alsa-state.service

[Service]
ExecStart = /usr/bin/python3.9  /home/pi/vietbot_offline/src/start.py 2>/dev/null
WorkingDirectory=/home/pi/vietbot_offline/src
StandardOutput=inherit
StandardError=inherit
Restart=always

[Install]
WantedBy=multi-user.target
```
Bấm Ctrl + X, Y, Enter

1.4. Gõ lệnh sau

```sh
sudo systemctl enable vietbot.service
```
Hệ thống sẽ thông báo như sau và vietbot sẽ chạy tự động vào lần khởi động OS tới
```sh
Created symlink /etc/systemd/system/multi-user.target.wants/vietbot.service → /etc/systemd/system/vietbot.service.
```
Hệ thống đã sẵn sàng tự động chạy tu dong vietbot

1.5. Gõ lệnh sau để chạy vietbot ngay lập tức
```sh
sudo systemctl start vietbot
```
hoặc
```sh
sudo reboot
```
1.6. Gõ lệnh sau để xem log
```sh
 sudo journalctl -u vietbot.service -f
```
1.7. Gõ lệnh sau để stop chạy tự động 

```sh
sudo systemctl stop vietbot.service
```
vietbot sẽ stop không chạy cho đến khi khởi động lại

1.6. Gõ lệnh sau để disable

```sh
sudo systemctl disable vietbot.service
```
Hệ thống sẽ thông báo như sau và vietbot sẽ không chạy tự động vào lần khởi động OS tới
```sh
Removed /etc/systemd/system/multi-user.target.wants/vietbot.service
```

### Lựa chọn 2.  Chạy bằng Systemd User (Khi dùng STT GG Ass)

2.1. Gõ lệnh

```sh
mkdir -p  ~/.config/systemd/user/
```
và 
```sh
sudo nano  ~/.config/systemd/user/vietbot.service
```
2.2. Tại cửa sổ Nano, gõ dòng lệnh sau

2.2.1. Với Mic2Hat, 4MicHat

```sh
[Unit]
Description=vietbot

[Service]
ExecStart = /usr/bin/python3.9  /home/pi/vietbot_offline/src/start.py 2>/dev/null
WorkingDirectory=/home/pi/vietbot_offline/src
StandardOutput=inherit
StandardError=inherit
Restart=always

[Install]
WantedBy=default.target
```
2.2.1. Với các loại Mic USB

```sh
[Unit]
Description=vietbot
After=alsa-state.service

[Service]
ExecStart = /usr/bin/python3.9  /home/pi/vietbot_offline/src/start.py 2>/dev/null
WorkingDirectory=/home/pi/vietbot_offline/src
StandardOutput=inherit
StandardError=inherit
Restart=always
User=pi

[Install]
WantedBy=default.target
```

Bấm Ctrl + X, Y, Enter

2.3. Gõ lệnh sau

```sh
systemctl --user daemon-reload
```
```sh
systemctl --user enable vietbot.service
```
Hệ thống sẽ thông báo như sau và vietbot sẽ chạy tự động vào lần khởi động OS tới

```sh
Created symlink /home/pi/.config/systemd/user/default.target.wants/vietbot.service → /home/pi/.config/systemd/user/vietbot.service.
```

2.5. Gõ lệnh sau để chạy vietbot ngay lập tức
```sh
systemctl --user start vietbot.service
```
hoặc
```sh
sudo reboot
```
2.6. Gõ lệnh sau để xem log

```sh
 journalctl --user-unit vietbot.service 
```
2.7. Gõ lệnh sau để stop chạy tự động 

Gõ lệnh để stop tạm thời

```sh
systemctl --user stop vietbot.service
```
vietbot sẽ stop không chạy cho đến khi khởi động lại

Gõ lệnh sau để disable

```sh
systemctl --user disable vietbot.service
```
Hệ thống sẽ thông báo như sau và vietbot không chạy tự động nữa
```sh
Removed /home/pi/.config/systemd/user/default.target.wants/vietbot.service.
```
