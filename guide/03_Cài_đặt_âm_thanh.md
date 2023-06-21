### Chú ý. 

Chỉ sử dụng khi phần cứng Raspberry có nhiều hơn 1 Soundcard như Pi3B+, Pi4, khi đó mới cần phải điều chỉnh lại cho phù hợp

Với các phần cứng khác như Pi Zero W 1, Pi Zero W2 không cần

### STEP1. Xác định ID của Soundcard

Chạy lệnh sau

```sh
aplay -l
```
Kết quả sẽ tương tự như sau:

```sh
**** List of PLAYBACK Hardware Devices ****
card 0: wm8960soundcard [wm8960-soundcard], device 0: bcm2835-i2s-wm8960-hifi wm8960-hifi-0 [bcm2835-i2s-wm8960-hifi wm8960-hifi-0]
  Subdevices: 1/1
  Subdevice #0: subdevice #0
card 1: vc4hdmi [vc4-hdmi], device 0: MAI PCM i2s-hifi-0 [MAI PCM i2s-hifi-0]
  Subdevices: 1/1
  Subdevice #0: subdevice #0
```
Lấy <hardware_id>, <device_id> của Soundcard muốn xuất ra âm thanh, như ví dụ trên thì <hardware_id> là 0 (Ứng với card0) và <device_id> là 0 (Ứng với device0)

### STEP2. Thay đổi khai báo Default trong Pulse

2.1. Gọi lệnh sửa file Pulse

```sh
sudo nano /etc/pulse/default.pa
```
2.2. Sửa file Pulse
Tìm đến dòng
```sh
load-module module-alsa-sink
```
Nếu chưa bỏ ký tự # thì bỏ đi
Tìm đến dòng tiếp theo
```sh
load-module module-alsa-source device = hw: 1,0
```
Sửa lại thành <hardware_id>, <device_id> lấy ở Step 1

Ví dụ ở trên sẽ sửa lại thành

```sh
load-module module-alsa-source device = hw: 0,0
```
Sau đó bấm lần lượt Ctrl + Y rồi X để lưu lại file

### STEP3. Thay đổi khai báo Default trong Alsa

2.1. Gọi lệnh sửa file Pulse

```sh
sudo nano /usr/share/alsa/alsa.conf
```

2.2. Sửa file Pulse
Cửa sổ nano hiện lên, tìm tới 2 dòng sau
```sh
# defaults
defaults.ctl.card 0
defaults.pcm.card 0

```
Thay thế ký tự '0' bằng <card_id> đã lấy ở Step 1

tiếp tục tìm tới 2 dòng sau
```sh
# defaults
defaults.pcm.device 0
defaults.pcm.subdevice 0
```
Thay thế ký tự '0' bằng kết quả đã lưu cho <device_id> đã lấy ở Step 1


Ví dụ ở trên sẽ không phải thay, vì <hardware_id> đã là 0, <device_id> đã là0

Sau đó bấm lần lượt Ctrl + Y rồi X để lưu lại file

### STEP3. Thay đổi khai báo Default trong Raspi-config

3.1. Gọi lệnh Raspi config

```sh
sudo raspi-config
```
Vào System Option, sau đó chọn Advance, chọn Audio

Chọn đúng Sound Card cần sử dụng, Bấm OK, sau đó Finish

### STEP3. Test loa và mic sau khi thay đổi

3.3.1. Khởi động lại 
```sh
sudo reboot
```
Sau đó kết nối lại

3.3.2. Test loa bằng lệnh sau
```sh
speaker-test -t wav -c 2
```
3.3.3. Test Mic bằng lệnh sau 
Ghi âm
```sh
arecord --format=S16_LE --duration=5 --rate=16000 --file-type=raw out.raw
```
Sau đó phát lại để nghe
```sh
aplay --format=S16_LE --rate=16000 out.raw
```
3.3.4. Test stream giữa Mic và Loa bằng lệnh sau
```sh
arecord --format=S16_LE --rate=16000 | aplay --format=S16_LE --rate=16000
