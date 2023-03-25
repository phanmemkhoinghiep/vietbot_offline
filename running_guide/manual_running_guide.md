
### STEP1. Chạy Manual từ SSH trên PC

1.1. Truy nhập vào thư mục Bot
Sử dụng lệnh sau

```sh
cd vietbot_offline/src
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


