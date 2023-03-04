### ĐÂY LÀ THƯ MỤC BETA VỚI CÁC TÍNH NĂNG MỚI DÀNH CHO CÁC TESTER

### STEP1. Cài đặt

1.1. Cài đặt theo hướng dẫn

https://github.com/phanmemkhoinghiep/vietbot_offline/blob/main/03_software_install_guide.md

2.1. Cài đặt thư viện
Di chuyển đến thư mục
```sh
cd /home/pi/vietbot_offline/src_beta

```
Sau đó

```sh
python3 -m pip install -r requirements.txt
```
### STEP2. Cấu hình

2.1. Tạo file config

Di chuyển đến thư mục
```sh
cd /home/pi/vietbot_offline/src_beta
```
Sau đó

Chỉnh sửa các File config và tạo File config

```sh
python3 -m create_config.py
```
### STEP3. Chạy

Chạy theo hướng dẫn

https://github.com/phanmemkhoinghiep/vietbot_offline/blob/main/06_running_guide.md

Di chuyển đến thư mục
```sh
cd /home/pi/vietbot_offline/src_beta
```
Sau đó

```sh
python3 start.py
```


