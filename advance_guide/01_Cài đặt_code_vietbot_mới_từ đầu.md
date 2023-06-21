### STEP1. Kết nối Console

1.1. Chờ Pi boot up xong, xác định IP của Pi từ Modem, Access Pint hoặc các phần mềm quét IP có hiển thị hostname

1.2.2. Sử dụng các phần mêm SSH như putty/Securec CRT truy cập ssh vào địa chỉ IP của Pi với 

```sh
username: pi
password: pi
```
### STEP2. Xóa thư mục code cũ, (Nếu có)

Trên console của Pi, sử dụng lệnh sau

```sh
sudo rm -rf /home/pi/vietbot_offline
```

### STEP3. Download Code mới

Trên console của Pi, sử dụng lệnh sau
Quay về thư mục gốc
```sh
cd ~
```
Sau đó
```sh
git clone -b beta --single-branch https://github.com/phanmemkhoinghiep/vietbot_offline.git
```
Chờ cho đến khi kết thúc


### STEP4. Cài đặt các gói Python do nâng cấp tính năng (Nếu cần)

4.1. Nâng cấp PIP

Chạy lần lượt các lệnh sau
```sh
python3 -m pip install --upgrade pip

```
4.2. Cài đặt các gói Python 

Truy cập vào thư mục vietbot_offline

```sh
cd /home/pi/vietbot_offline/src
```
Cài đặt các gói Python được list trong file requirements.txt để cài dặt các lib nếu cần
```sh
python3 -m pip install -r requirements.txt

```

