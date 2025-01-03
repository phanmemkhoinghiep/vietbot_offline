### CÀI ĐẶT VIETBOT TỪ ĐẦU TIÊN

### STEP1. Kết nối Console

1.1. Chờ Pi boot up xong, xác định IP của Pi từ Modem, Access Pint hoặc các phần mềm quét IP có hiển thị hostname

1.2. Sử dụng các phần mêm SSH như putty/Securec CRT truy cập ssh vào địa chỉ IP của Pi với 

```sh
username: pi
password: vietbot
```
### STEP2. Cài đặt môi trường

2.1. Nâng cấp gói
Trên console của Pi, sử dụng lần lượt các lệnh sau

```sh
sudo apt-get update -y
```
Sau khi chạy xong, chạy tiếp
```sh
sudo apt-get upgrade -y
```
2.2. Cài gói cơ bản
```sh
sudo apt-get install nano git -y
```
2.3. Cài đặt Swap 2G

```sh
sudo dphys-swapfile swapoff
sudo dphys-swapfile swapoff
sudo nano /etc/dphys-swapfile
```
Cửa sổ nano mở ra
Tại dòng 
```sh
CONF_SWAPSIZE=1000
```
tăng giá trị 500 thành 2000, sau đó bấm Ctrl + Alt + X để save lại

2.4. Cài đặt Soundcard cho Mic2Hat, mạch AIO (Nếu sử dụng)
```sh
git clone https://github.com/waveshareteam/WM8960-Audio-HAT.git
```
Sau khi git xong
```sh
cd WM8960-Audio-HAT
sudo ./install.sh 
```
Sau khi cài xong
```sh
sudo reboot
```
2.5. Mở SPI cho led ws_2812 (Nếu sử dụng)
```sh
sudo raspi-config
```
Tìm đến mục Interface và kích hoạt mở SPI

### STEP3. Cài đặt các gói liên quan
3.1. Cài các gói phục vụ cho Python

```sh
sudo apt-get install libopenblas-dev vlc -y
```
và
```sh
sudo apt-get install python3 python3-pip python3-venv python3-dev python3-rpi.gpio python3-pyaudio
```

3.2. Tạo env
```sh
python3 -m venv vietbot_env
```
3.3. Chạy Env
```sh
source vietbot_env/bin/activate
```
Nếu ra dấu nhắc lệnh như sau:
```sh
(vietbot_env) pi@vietbot32:~ 
```
là thành công

3.4. Cài đặt gói Python
Trong môi trường evn, gõ
```sh
pip install pvporcupine python-vlc requests aiofiles aiohttp pyusb edge_tts sounddevice pyalsaaudio spidev SpeechRecognition pathlib2 gpiozero google-cloud google-cloud-speech google-cloud-texttospeech rpi_ws281x gTTS fuzzywuzzy websocket-client Quart python-Levenshtein pigpio RPi.GPIO lgpio numpy PyAudio
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
