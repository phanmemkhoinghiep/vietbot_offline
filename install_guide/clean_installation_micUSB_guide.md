### ĐÂY LÀ HƯỚNG DẪN CÀI ĐẶT TỪ ĐẦU CHO RASPBERRY

### STEP1. Cài đặt hệ điều hành Raspbian

1.1. Download Raspberry Pi OS
Tối ưu cho phần cứng Pi Zero 2 Wireless nên Vietbot chỉ cần bản OS Buster Lite tại trang chủ Pi

1.2. Flash vào thẻ nhớ
Sử dụng tool của Raspberry hoặc Etcher

1.3. Config để vào được SSH qua WiFi

1.3.1. Cắm lại thẻ nhớ vào máy

1.3.2. Sử dụng Notepad ++ để tạo file có tên là wpa_supplicant.conf trong thư mục boot của thẻ nhớ với  định dạng file Unix (Edit -> EOL converion -> UNIX/OSX Format là Unix (LF)), nội dung là các tham số tên SSID và mật khẩu tương ứng
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
1.3.3. Tạo file rỗng có tên là SSH trong thư mục boot 

1.4. Truy cập ssh vào Pi Zero Wirless

1.4.1. Cắm thẻ nhớ vào Pi Zero 2 Wireless, chờ Pi boot up xong, xác định IP của Pi từ Modem, Access Pint

1.4.2. Sử dụng putty truy cập ssh vào địa chỉ IP của Pi với username là pi, password là raspberry

### STEP2. Cài đặt các thư viện chung cho Vietbot và thư viện cho Python trên OS

2.1. Cài đặt các thư viện chung cho Vietbot

2.1.1.Chạy lần lượt các lệnh sau

```sh
sudo apt-get update -y
```
sau đó 
```sh
sudo apt-get upgrade -y
```
2.1.2. Cài đặt các gói thư viện

```sh
sudo apt-get install git flac python3-pip python3-pyaudio python-all-dev python3-all-dev libsdl2-mixer-2.0-0 libportaudio2  libportaudio-dev vlc pulseaudio -y

```
2.2. Khởi động lại

```sh
sudo reboot

```
### STEP3. Cài đặt các gói Python

3.1. Nâng cấp PIP

Chạy lần lượt các lệnh sau
```sh
python3 -m pip install --upgrade pip

```
3.2. Cài đặt các gói Python 

```sh
cd ~ 

```
sau đó

```sh
git clone -b beta --single-branch https://github.com/phanmemkhoinghiep/vietbot_offline.git
```
sau đó

```sh
cd /home/pi/vietbot_offline/src
```
sau đó

```sh
python3 -m pip install -r requirements.txt

```

3.3. Sửa fille liên quan tới Skill download và nghe nhạc trực tuyến

```sh
sudo nano /home/pi/.local/lib/python3.9/site-packages/pafy/backend_youtube_dl.py

```
Sau đó tìm đến các dòng sau và bổ sung ký tự # đằng trước

```sh
#        self._viewcount = self._ydl_info['view_count']
#        self._likes = self._ydl_info['like_count']
#        self._dislikes = self._ydl_info['dislike_count']

```
Bấm Ctrl + X, rồi Y để Save lại

Tiếp tục 

```sh

sudo nano /home/pi/.local/lib/python3.9/site-packages/youtube_dl/extractor/youtube.py

```
Sau đó tìm đến dòng thứ 1794 và bổ sung ký tự # đằng trước

```sh

# 'uploader_id': self._search_regex(r'/(?:channel|user)/([^/?&#]+)', owner_profile_url, 'uploader id') if owner_profile_url else None,

```
Bổ sung dòng sau thay thế dòng trên

```sh

'uploader_id': self._search_regex(r'/(?:channel/|user/|(?=@))([^/?&#]+)', owner_profile_url, 'uploader id', default=None),

```
Kết quả cuối là:

```sh

# 'uploader_id': self._search_regex(r'/(?:channel|user)/([^/?&#]+)', owner_profile_url, 'uploader id') if owner_profile_url else None,
'uploader_id': self._search_regex(r'/(?:channel/|user/|(?=@))([^/?&#]+)', owner_profile_url, 'uploader id', default=None),

```

Bấm Ctrl + X, rồi Y để Save lại


### STEP4. Cài đặt Mic USB

4.1. Thống kê ID của Mic USB và Loa 

Chạy lệnh sau để biết ID của Mic USB
```sh
arecord -l
```
sau đó chạy lệnh sau để biết ID của Loa

```sh
aplay -l
```
Lưu lại thông tin về card_id và device_id ở mỗi kết quả lệnh

Ví dụ card_id là 1, device_id là 0

4.2. Khai báo Default cho ALSA

Chạy lệnh sau 

```sh
sudo nano /usr/share/alsa/alsa.conf
```
Cửa sổ nano hiện lên, tìm tới 2 dòng sau
```sh
# defaults
defaults.ctl.card 0
defaults.pcm.card 0

```
Thay thế ký tự '0' bằng kết quả đã lưu cho <card_id>, ví dụ nếu card_id là 1

```sh
# defaults
defaults.ctl.card 1
defaults.pcm.card 1
```

tiếp tục tìm tới 2 dòng sau
```sh
# defaults
defaults.pcm.device 0
defaults.pcm.subdevice 0

Thay thế ký tự '0' bằng kết quả đã lưu cho <device_id>, ví dụ device_id là 0, thì không phải thay

4.3. Chọn đúng Speaker (Trong trường hợp dùng các dòng Pi có cổng 3.5)

4.3.1. Chạy lệnh

```sh
sudo raspi-config
```

4.3.2. Vào các mục mục System Option, Audio, chọn USB Audio rồi Enter, chọn OK rồi Finish

4.3.3 Chọn Reboot hoặc bỏ qua Reboot, sau đó reboot bằng lệnh:

```sh
sudo reboot
```

4.4. Đưa Account đang dùng (Ví dụ pi) vào group root

Chạy lệnh sau
```sh
sudo usermod -aG root pi
```
4.5. fix lỗi bot không hoạt động sau 1 thời gian.

Chạy lệnh sau
```sh
sudo usermod -aG audio root
```
4.6. Reboot lại Pi
Chạy lệnh sau
```sh
sudo reboot
```
4.7. Test loa và mic sau khi cài

4.7.1. Test loa bằng lệnh sau
```sh
speaker-test -t wav -c 2
```
4.7.2. Test Mic bằng lệnh sau 
Ghi âm
```sh
arecord --format=S16_LE --duration=5 --rate=16000 --file-type=raw out.raw
```
Phát lại
```sh
aplay --format=S16_LE --rate=16000 out.raw
```
4.7.3. Test stream giữa Mic và Loa bằng lệnh sau
```sh
arecord --format=S16_LE --rate=16000 | aplay --format=S16_LE --rate=16000
```


### STEP5. Tối ưu cho Pi

5.1. Chạy config
Chạy lệnh sau
```sh
sudo raspi-config
```
5.2. Cài đặt thời gian với múi giờ VN

Chọn mục số 5 Localisation Options, Select rồi Enter

Chọn L2 Time Zone

Chọn Asia

Chọn Ho Chi Minh City, OK rồi Enter

5.3. Cài đặt Pi khởi động với Command line để tiết kiệm bộ nhớ

Chọn mục System Options, Select rồi Enter

Chọn S5 Boot/ Auto Login, Select rồi Enter

Chọn B2, OK

5.4. Giảm bộ nhớ RAM dùng cho đồ họa

Chọn mục Performance Options, Select rồi Enter

Chọn P2 GPU Memory, Select rồi Enter

Chọn 4, OK

5.5. Khởi động lại Pi

Khi thoát khỏi Raspi Config, chọn Yes để khởi động lại

5.6. Tăng bộ nhớ của Raspbian lên 1G

Gõ lệnh:
```sh
free -hm
```
Hệ thống sẽ trả về bộ nhớ Swap có dung lượng xấp xỉ 1G

```sh
               total        used        free      shared  buff/cache   available
Mem:           459Mi        57Mi       278Mi       1.0Mi       123Mi       351Mi
Swap:          100M          0B       100M
```
Tăng lên 1GB bằng cách gõ lệnh:

```sh
sudo dphys-swapfile swapoff
```
Tiếp đó gõ lệnh:
```sh
sudo nano /etc/dphys-swapfile
```
Tìm đến dòng sau và sửa lại 100 thành 1024
```sh
CONF_SWAPSIZE=1024
```
Lần lượt bấm đồng thời Ctrl + X sau đó bấm Y rồi bấm Enter

Sau đó gõ
```sh
sudo dphys-swapfile setup
```
Hệ thống sẽ báo lại
```sh
want /var/swap=1024MByte, checking existing: deleting wrong size file (104857600), generating swapfile ... ```

```
Chờ 1 lát cho đến khi hiện
```sh
want /var/swap=1024MByte, checking existing: deleting wrong size file (104857600), generating swapfile of 1024MBytes ```

```
và quay về dấu nhắc lệnh thì gõ
```sh
sudo dphys-swapfile swapon
```
Sau đó reboot lại hệ thống
```sh
sudo reboot
```
Sau khi reboot thành công, dùng lại lệnh

```sh
free -hm
```
Hệ thống sẽ trả về bộ nhớ Swap có dung lượng xấp xỉ 1G

```sh
               total        used        free      shared  buff/cache   available
Mem:           459Mi        57Mi       278Mi       1.0Mi       123Mi       351Mi
Swap:          1.0Gi          0B       1.0Gi
```
Đi đến mục tiếp theo

![CÀI ĐẶT, CẬP NHẬT PHẦN MỀM](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/03_software_install_update_guide.md)


### STEP6. Cài đặt Code
Download Code về phần cứng raspberry theo cách sau:
6.1. Truy cập vào Git
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

Đi đến mục tiếp theo
![TỐI ƯU CHO RASPBIAN](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/023_software_enviroment_installation_optimize.md)

