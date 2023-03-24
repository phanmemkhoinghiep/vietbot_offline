### ĐÂY LÀ HƯỚNG DẪN CÀI ĐẶT PHẦN HỆ ĐIỀU HÀNH, THƯ VIỆN, DRIVER CHO PI ZERO WIRLESS, MODUN 2 MIC HAT, 4 MIC ARRAY HOẶC MIC USB TỪ IMAGE CÓ SẴN

### STEP1. Download bộ Image cho Raspberry Pi đã cài đặt sẵn

Download bộ Image cho Raspberry Pi đã cài đặt sẵn cho tất cả các loại Mic tại Link sau

[GOOGLE DRIVE FILE NÉN 1.4G](https://drive.google.com/file/d/1SZwM6F2k0eiubYJ0VcXg47Me68E9WReX/view?usp=sharing)

### STEP2. Ghi vào thẻ SD

2.1. Dùng Win32IMG để ghi vào thẻ nhớ SD

### STEP3. Khai báo WiFi
có thể tải file wpa_supplicant.conf mẫu chuẩn ở link này, rồi sửa lại ID wifi và pass wifi cho đúng. Hoặc làm file mới như hướng dẫn phía dưới
[GOOGLE DRIVE](https://drive.google.com/file/d/1D2iFC-sP2PUL-RijPmK9yKo3IsgEAvJ8/view?usp=sharing)

3.1. Sử dụng Notepad ++ để tạo file có tên là wpa_supplicant.conf trong thư mục boot của thẻ nhớ

3.2. Set định dạng File
Định dạng file Unix (Edit -> EOL converion -> UNIX/OSX Format là Unix (LF)), nội dung là các tham số tên SSID và mật khẩu tương ứng

3.3. Đặt nội dung
Chú ý, tham số country có thể đổi sang us hoặc vn tùy theo cài đặt tại bộ phát WiFi
```sh
country=vn
update_config=1
ctrl_interface=/var/run/wpa_supplicant
network={
    ssid="testing"
    psk="testingPassword"
}
```
3.4. Save lại nội dung File

3.5. Tạo một file rỗng có tên là SSH
có thể tải file SSH mẫu chuẩn ở link này
[GOOGLE DRIVE](https://drive.google.com/file/d/1QCAYZMTlXJ7Zx3ZW8iKjiXDVuGqZMqTc/view?usp=sharing)


### STEP4. Kết nối và điều chỉnh

4.1. Kết nối

4.1.1. Cắm thẻ nhớ vào Pi Zero 2 W/Pi 3B+/Pi4 và boot lên

4.1.2. Tìm địa chỉ IP của pi và sử dụng SSH để truy cập từ xa vào Console

4.1.3. Nhập Username và password đăng nhập (pi/vietbot)

4.2. Nâng dung lượng của OS cho Full thẻ

4.2.1. Chạy lệnh sau

```sh
sudo raspi-config
```
4.2.2. Chọn Advance

4.2.3. Chọn Expand File System

4.2.4. Chọn OK và chờ vài s

4.2.5. Chọn Yes để Reboot

### STEP5. Khai báo Mic 2Hat, Mic 4Hat Respeaker

5.1. Cài đặt âm lượng

Vào alxamixer bằng lệnh

```sh
alsamixer
```
bấm F6 để chọn sound card seed, sau đó bấm F5, dùng phím lên trên bàn phím để kéo hết các giá trị lên Max, phím trái, phải để chọn các giá trị Stereo tại các mục tương ứng

Gõ lệnh sau để lưu lại

```sh
sudo alsactl store
```

5.2. Test loa và mic sau khi cài

5.2.1. Test loa bằng lệnh sau
```sh
speaker-test -t wav -c 2
```
5.2.2. Test Mic bằng lệnh sau 
Ghi âm
```sh
arecord --format=S16_LE --duration=5 --rate=16000 --file-type=raw out.raw
```
Phát lại
```sh
aplay --format=S16_LE --rate=16000 out.raw
```
5.2.3. Test stream giữa Mic và Loa bằng lệnh sau
```sh
arecord --format=S16_LE --rate=16000 | aplay --format=S16_LE --rate=16000
```

Tiếp đó chuyển qua 
