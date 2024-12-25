### ĐÂY LÀ HƯỚNG DẪN CÀI ĐẶT TỪ IMAGE CÓ SẴN

### STEP1. Download bộ Image cho Raspberry Pi đã cài đặt sẵn

Download bộ Image cho Raspberry Pi tại Link sau:

### STEP2. Ghi vào thẻ SD

2.1. Dùng Win32IMG để ghi vào thẻ nhớ SD

### STEP2. Kết nối Console

2.1. Chờ Pi boot up xong, xác định IP của Pi từ Modem, Access Pint hoặc các phần mềm quét IP có hiển thị hostname

2.2. Sử dụng các phần mêm SSH như putty/Securec CRT truy cập ssh vào địa chỉ IP của Pi với 

```sh
username: pi
password: vietbot
```


### STEP4. Cài đặt & Chạy vietbot

4.1. Download code vietbot từ github
```sh
git clone --depth 1 https://github.com/phanmemkhoinghiep/vietbot_offline.git
```
Chờ cho đến khi kết thúc

4.2. Config vietbot
Mở file config.json they key của Picovoice ở dòng thứ 58
```sh
"key": "nA2Kkj/oRFQ=="
```
thành giá trị đã đăng ký trên Picovoice console

4.3. Chạy vietbot
Gõ các lệnh sau
```sh
cd /home/pi/vietbot_offline/raspberry/32/start.py
```
hoặc
```sh
cd /home/pi/vietbot_offline/raspberry/64/start.py
```
Tùy phiên bản OS
