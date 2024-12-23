### ĐÂY LÀ HƯỚNG DẪN ĐỂ CÀI ĐẶT VIETBOT
### STEP1. Cài đặt Mic ID (Nếu dùng Pi3b+/Pi4/Pi5 hoặc Mic USB)
1.1. Xác định Mic ID của thiết bị
Chạy file check_mic_id.py
```sh
cd /home/pi/vietbot
```
sau đó

```sh
python3 check_mic_id.py
```
Xác định thiết bị Mic ID sử dụng tương ứng với con số mic_id bên cạnh

1.1. Mở file config.json ở dòng thứ 5
```sh
                "mic_id": 12
```
Thay giá trị 12 bằng giá trị phù hợp

### STEP2. Xác định Sound card (Nếu dùng Pi3b+/Pi4/Pi5 hoặc Soud card USB)
2.1. Xác định Mic ID của thiết bị
Chạy file check_mic_id.py
```sh
amixer
```
sau đó

Xác định thiết bị Soundcard sử dụng tương ứng với con số id bên cạnh

2.1. Mở file config.json ở dòng thứ 9
```sh
                "amixer_id": 2
```
Thay giá trị 2 bằng giá trị phù hợp
