### Hướng dẫn cài đặt để vietbot tự phát WiFi khi không kết nối được mạng WiFi

### STEP1. Chuẩn bị

1.1. Cấp quyền cho các File

```sh
cd /home/pi/vietbot_offline/src
```
Sau đó

```sh
chmod +x install-wifi-connect.sh
```
sau đó

```sh
chmod +x start-wifi-connect.sh

```
1.2. Tắt Apache2 Service

```sh
sudo systemctl disable apache2.service 
```

### STEP2.  Cài đặt 
2.1. Cài đặt Network Manager

```sh
sudo apt-get install -y -d network-manager
```
2.2. Cài đặt File chạy WiFi-Connect
```sh
sudo cp /home/pi/vietbot_offline/src/start-wifi-connect.sh /home/pi/
```
2.3. Cài đặt Service chạy WiFi-Connect khi khởi động

Copy file vào systemd
```sh
sudo cp /home/pi/vietbot_offline/src/wifi-connect.service /etc/systemd/system/wifi-connect.service
```
sau đó

```sh
sudo systemctl enable wifi-connect.service
```
Hệ thống sẽ hiện ra

```sh
Created symlink /etc/systemd/system/multi-user.target.wants/wifi-connect.service → /etc/systemd/system/wifi-connect.service.
```
Là thành công

2.4. Cài đặt WiFi-Connect

```sh
cd /home/pi/vietbot_offline/src
```
Sau đó

```sh
nohup bash ./install-wifi-connect.sh & tail -f nohup.out
```


```sh
[1] 10913
Setting up libqmi-glib5:armhf (1.26.10-0.1) ...
Setting up libqmi-proxy (1.26.10-0.1) ...
Setting up modemmanager (1.14.12-0.2) ...
Created symlink /etc/systemd/system/dbus-org.freedesktop.ModemManager1.service → /lib/systemd/system/ModemManager.service.
Created symlink /etc/systemd/system/multi-user.target.wants/ModemManager.service → /lib/systemd/system/ModemManager.service.
Processing triggers for libc-bin (2.31-13+rpt2+rpi1+deb11u5) ...
Processing triggers for man-db (2.9.4-2) ...
Processing triggers for dbus (1.12.24-0+deb11u1) ...
Processing triggers for hicolor-icon-theme (0.17-2) ...
nohup: ignoring input and appending output to 'nohup.out'
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
  0     0    0     0    0     0      0      0 --:--:-- --:--:-- --:--:--     0
  0     0    0     0    0     0      0      0 --:--:--  0:00:01 --:--:--     0
100  4626  100  4626    0     0   1489      0  0:00:03  0:00:03 --:--:--  6763
WiFi Connect Raspbian Installer: Retrieving latest release from https://api.github.com/repos/balena-os/wifi-connect/releases/45509064...
WiFi Connect Raspbian Installer: Downloading and extracting https://github.com/balena-os/wifi-connect/releases/download/v4.4.6/wifi-connect-v4.4.6-linux-rpi.tar.gz...
WiFi Connect Raspbian Installer: Successfully installed wifi-connect 4.4.6
WiFi Connect Raspbian Installer: NetworkManager is already installed
WiFi Connect Raspbian Installer: Deactivating and disabling dhcpcd...
```
Chờ đến khi nào mất kết nối WiFi với Pi là cài đặt xong

2.5. Rút điện để cho phần cứng khởi động lại

### STEP3.  Sử dụng

3.1. Tìm mạng WiFi vietbot

Trên điện thoại, tìm mạng WiFi có tên là vietbot, kết nối tới mạng này

3.3. Đăng nhập mạng WiFi theo danh sách 

Sau khi ra giao diện Web với địa chỉ 192.168.4.1, chọn danh sách WiFi cần có, nhập Pass và OK

3.4. Phần cứng sẽ tự kết nối tới mạng WiFi đã nhập

3.5. Gõ lệnh sau để chạy lại 

```sh
sudo systemctl restart wifi-connect
```
hoặc
```sh
sudo reboot
```
3.6. Gõ lệnh sau để xem log
```sh
 sudo journalctl -u wifi-connect.service -f
```
3.6.1. Gõ lệnh sau để stop chạy tự động khi khởi động

Gõ lệnh để stop tạm thời

```sh
sudo systemctl stop wifi-connect.service
```
WiFi-Connect sẽ tạm thời không chạy cho đến khi khởi động lại

Gõ lệnh để disable

```sh
sudo systemctl disable wifi-connect.service
```

Hệ thống sẽ hiện ra
```sh
Removed /etc/systemd/system/multi-user.target.wants/wifi-connectservice
```
Hệ thống đã stop wifi-connect không chạy tự động nữa

3.6.2. Phục hồi Apache2 Service

```sh
sudo systemctl enable apache2.service 
```
