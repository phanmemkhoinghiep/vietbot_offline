### Hướng dẫn cài đặt để vietbot tự phát WiFi khi không kết nối được mạng WiFi

### STEP1. Cấp quyền cho các File

```sh
cd /home/pi/vietbot_online/src
```
Sau đó

```sh
chmod +x install-wifi-connect.sh
```
sau đó

```sh
chmod +x start-wifi-connect.sh

```

### STEP2.  Cài đặt 
2.1. Cài đặt Network Manager

```sh
sudo apt-get install -y -d network-manager
```
2.2. Cài đặt File chạy WiFi-Connect
```sh
sudo cp /home/pi/vietbot_online/src/start-wifi-connect.sh /home/pi/
```
2.3. Cài đặt Service chạy WiFi-Connect khi khởi động

Copy file vào systemd
```sh
sudo cp /home/pi/vietbot_online/src/wifi-connect.service /etc/systemd/system/wifi-connect.service
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
cd /home/pi/vietbot_online/src
```
Sau đó

```sh
nohup bash ./install-wifi-connect.sh & tail -f nohup.out
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
2.1.5. Gõ lệnh sau để stop chạy tự động khi khởi động

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
