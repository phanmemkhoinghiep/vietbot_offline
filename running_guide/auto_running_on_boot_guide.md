### Lựa chọn 1.  Chạy bằng Systemd (Khi dùng STT Google Free, STT Google Cloud)

1.1. Gõ lệnh

```sh
sudo nano /etc/systemd/system/vietbot.service
```
Tại cửa sổ Nano, gõ dòng lệnh sau

1.2. Với Mic2Hat, 4MicHat

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
1.3. Với các loại Mic USB

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
WantedBy=multi-user.target
```
Bấm Ctrl + X, Y, Enter

1.4. Gõ lệnh sau

```sh
sudo systemctl enable vietbot.service
Created symlink /etc/systemd/system/multi-user.target.wants/vietbot.service → /etc/systemd/system/vietbot.service.
```
Hệ thống đã sẵn sàng tự động chạy tu dong vietbot

1.5. Gõ lệnh sau để chạy tự động vietbot
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

Gõ lệnh để stop tạm thời

```sh
sudo systemctl stop vietbot.service
```
vietbot sẽ stop không chạy cho đến khi khởi động lại

Gõ lệnh sau để disable

```sh
sudo systemctl disable vietbot.service
Removed /etc/systemd/system/multi-user.target.wants/vietbot.service
```
Hệ thống đã stop vietbot không chạy tự động nữa

### Lựa chọn 2.  Chạy bằng Systemd User (Khi dùng STT GG Ass)

2.1. Gõ lệnh

```sh
mkdir -p  ~/.config/systemd/user/
sudo nano  ~/.config/systemd/user/vietbot.service
```
Tại cửa sổ Nano, gõ dòng lệnh sau

2.2. Với Mic2Hat, 4MicHat

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
WantedBy=default.target
```
1.1.3. Với các loại Mic USB

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
WantedBy==default.target
```

Bấm Ctrl + X, Y, Enter

1.1.4. Gõ lệnh sau

```sh
systemctl --user daemon-reload
systemctl --user enable vietbot.service
Created symlink /home/pi/.config/systemd/user/default.target.wants/vietbot.service → /home/pi/.config/systemd/user/vietbot.service.
```

Hệ thống đã sẵn sàng tự động chạy tu dong vietbot

1.1.5. Gõ lệnh sau để chạy tự động vietbot
```sh
systemctl --user start vietbot.service
```
hoặc
```sh
sudo reboot
```
1.1.6. Gõ lệnh sau để xem log
```sh
systemctl --user status vietbot.service
```
1.1.7. Gõ lệnh sau để stop chạy tự động 

Gõ lệnh để stop tạm thời

```sh
systemctl --user stop vietbot.service
```
vietbot sẽ stop không chạy cho đến khi khởi động lại

Gõ lệnh sau để disable

```sh
systemctl --user disable vietbot.service
Removed /home/pi/.config/systemd/user/default.target.wants/vietbot.service.
```

Hệ thống đã stop vietbot không chạy tự động nữa
