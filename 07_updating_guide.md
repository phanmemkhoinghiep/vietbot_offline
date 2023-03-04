
### STEP1. Theo dõi git

1.1. Theo dõi bằng git Desktop

Cài đặt Git Desktop trên PC và theo dõi git phanmemkhoinghiep/vietbot_source_code

Nếu có File cập nhật sẽ chuyển sang bước 2

Truy cập vào git phanmemkhoinghiep/vietbot_source_code 

Nếu phát hiện có file nào vừa cập nhật thì chuyển sang bước 2

### STEP2.  Lấy file vừa cập nhật về

2.1. Backup file

Backup các file google.json, config.yaml và thư mục tts_saved bằng lệnh

```sh
sudo cp /home/pi/vietbot/google.json /home/pi/google.json
```
và
```sh
sudo cp /home/pi/vietbot/config.yaml /home/pi/config.yaml
```
và
```sh
sudo cp /home/pi/vietbot/tts_saved /home/pi/tts_saved
```
2.2. Xóa thư mục vietbot bằng lệnh
```sh
sudo rm -rf /home/pi/vietbot
```
2.3. Download file update

2.3.1. Download bằng lệnh git
```sh
git clone https://github.com/phanmemkhoinghiep/vietbot_sourcecode.git
```
2.3.2. Đổi tên thư mục vietbot_sourcecode thành vietbot bằng lệnh
```sh
mv /home/pi/vietbot_sourcecode home/pi/vietbot
```
2.4. Restore file

Restore 2 file google.json và config.yaml và thư mục tts_saved bằng lệnh
```sh
sudo cp /home/pi/google.json /home/pi/vietbot/google.json
```
và
```sh
sudo cp /home/pi/config.yaml /home/pi/vietbot/config.yaml
```
và
```sh
sudo cp /home/pi/tts_saved /home/pi/vietbot/tts_saved
```
2.5. Chạy lại ứng dụng 

https://github.com/phanmemkhoinghiep/vietbot/blob/main/06_running_guide.md

Chờ bot chạy
