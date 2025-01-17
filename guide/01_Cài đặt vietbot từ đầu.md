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
sudo apt-get update
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
```

```sh
sudo nano /etc/dphys-swapfile
```
Cửa sổ nano mở ra
Tại dòng 
```sh
CONF_SWAPSIZE=512
```
tăng giá trị 512 thành 2048, sau đó bấm Ctrl + Alt + X để save lại

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

### STEP3. Cài đặt các gói liên quan cơ bản
3.1. Cài các gói phục vụ cho Python

```sh
sudo apt-get install libopenblas-dev portaudio19-dev vlc flac -y
```
và
```sh
sudo apt-get install python3 python3-pip python3-venv python3-dev 
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
pip install python-vlc requests aiofiles aiohttp edge_tts sounddevice pyalsaaudio SpeechRecognition pathlib2 google-cloud gTTS fuzzywuzzy websocket-client Quart python-Levenshtein pvrecorder
```
và

```sh
pip install numpy==1.26.4
```

### STEP4. Cài đặt tùy chọn vietbot
4.1. Cài đặt các gói tùy chọn theo phần cứng:

4.1.1. Nếu dùng phím bấm cần cài đặt, nếu không dùng bỏ qua

```sh
sudo apt-get install python3-rpi.gpio 
```
```sh
pip install pigpio RPi.GPIO lgpio gpiozero
```
4.1.2. Nếu dùng Led cài đặt, nếu không dùng bỏ qua

```sh
pip install rpi_ws281x spidev
```
4.1.3. Nếu dùng Mic/Sound USB cài đặt, nếu không dùng bỏ qua

```sh
pip install pyusb
```
4.1.4. Nếu dùng Picovoice cài đặt, nếu không dùng bỏ qua

```sh
pip install pvporcupine
```
4.1.5. Nếu dùng Openwakeword cài đặt, nếu không dùng bỏ qua

```sh
pip install openwakeword
```
4.1.6. Nếu dùng Google Cloud Speech to Text cài đặt, nếu không dùng bỏ qua

```sh
pip install google-cloud-speech
```
4.1.7. Nếu dùng Google Cloud Text to Speech cài đặt, nếu không dùng bỏ qua

```sh
pip install google-cloud-texttospeech
```
4.1.8. Cài lib hỗ trợ Dify, nếu không dùng bỏ qua

```sh
pip install dify-client
```

4.2. Download code vietbot từ github

Mở 1 cửa sổ SSH khác, không vào Env và chạy lệnh

```sh
git clone --depth 1 https://github.com/phanmemkhoinghiep/vietbot_offline.git
```
Chờ cho đến khi kết thúc

