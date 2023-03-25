### STEP1.  Chạy tự động khi khởi động Pi

1.1. Chạy bằng Systemd

1.1.1. Gõ lệnh

```sh
sudo nano /etc/systemd/system/vietbot.service
```
Tại cửa sổ Nano, gõ dòng lệnh sau

1.1.2. Với Mic2Hat, 4MicHat

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
WantedBy=multi-user.target
```


Bấm Ctrl + X, Y, Enter

1.1.4. Gõ lệnh sau

```sh
sudo systemctl enable vietbot.service
```
Hệ thống sẽ hiện ra
```sh
Created symlink /etc/systemd/system/multi-user.target.wants/vietbot.service → /etc/systemd/system/vietbot.service.
```
Hệ thống đã sẵn sàng tự động chạy tu dong vietbot

1.1.5. Gõ lệnh sau để chạy tự động vietbot
```sh
sudo systemctl start vietbot
```
hoặc
```sh
sudo reboot
```
1.1.6. Gõ lệnh sau để xem log
```sh
 sudo journalctl -u vietbot.service -f
```
1.1.7. Gõ lệnh sau để stop chạy tự động 

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

Đến mục tiếp theo: ![WIFI-CONNECT](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/08_auto_wifi-connect.md)
