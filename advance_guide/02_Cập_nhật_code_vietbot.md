### STEP1. Kết nối Console

1.1. Chờ Pi boot up xong, xác định IP của Pi từ Modem, Access Pint hoặc các phần mềm quét IP có hiển thị hostname

1.2.2. Sử dụng các phần mêm SSH như putty/Securec CRT truy cập ssh vào địa chỉ IP của Pi với 

```sh
username: pi
password: vietbot
```
### STEP2. Kiểm tra nhánh

2.1. Truy cập vào thư mục vietbot_offline

```sh
cd /home/pi/vietbot_offline/
```
2.3. Kiểm tra chính xác xem có trong nhánh beta hay không

```sh
git branch -vv
```
2.2.1. Nếu câu trả lời là

```sh

* beta b7da00f [origin/beta] Update 03_software_install_guide.md
```
thì vietbot đã đúng nhánh beta, 

2.2.2. Nếu câu trả lời là 
```sh
* alpha ccd4057 [origin/alpha] Update config.json
```
Thì vietbot đang ở nhánh alpha, cần chuyển về nhánh beta bằng lệnh

```sh
git checkout -b beta
```
sau đó kiểm tra lại xem đã chuyển sang nhánh beta hay chưa
```sh
git branch -vv   
```
### STEP3. Kiểm tra code mới

3.1. Check xem có file gì mới không
```sh
git checkout
```
```sh
M       html/Configuration.php
M       "html/H\306\260\341\273\233ng D\341\272\253n_OK.txt"
M       html/README.md
M       html/assets/colors/01.css
M       html/assets/colors/02.css
M       html/assets/colors/03.css
M       html/assets/colors/black.css
M       html/assets/colors/gg01.css
M       html/assets/colors/gg02.css
M       html/assets/colors/z.txt
M       html/assets/css/4.5.2_css_bootstrap.min.css
M       html/assets/css/Font_Muli_300,400,600,700.css
M       html/assets/css/Font_Poppins_400,500,600,700.css
M       html/assets/css/all.min.css
M       html/assets/css/animate.min.css
M       html/assets/css/bootstrap-icons.css
M       html/assets/css/bootstrap.css
M       html/assets/css/bootstrap.css.map
M       html/assets/css/bootstrap.min.css
M       html/assets/css/bootstrap_3.3.6.css
M       html/assets/css/deeee.html
M       html/assets/css/dropzone.min.css
M       html/assets/css/font-awesome.min.css
M       html/assets/css/jquery.mCustomScrollbar.css
M       html/assets/css/loginshell.css
M       html/assets/css/magnific-popup.css
M       html/assets/css/owl.carousel.min.css
M       html/assets/css/owl.video.play.html
M       html/assets/css/style.css
M       html/assets/css/vs.min.css
M       html/assets/css/z.txt
M       html/assets/fonts/FontAwesome.otf
M       html/assets/fonts/bootstrap-icons50ab.woff
M       html/assets/fonts/bootstrap-icons50ab.woff2
M       html/assets/fonts/fontawesome-webfont.eot
M       html/assets/fonts/fontawesome-webfont.svg
M       html/assets/fonts/fontawesome-webfont.ttf
M       html/assets/fonts/fontawesome-webfont.woff
M       html/assets/fonts/fontawesome-webfont.woff2
M       html/assets/fonts/z.txt
M       html/assets/img/AC.png
M       html/assets/img/Amin.jpg
M       html/assets/img/JShine.jpg
M       html/assets/img/Loading.gif
M       html/assets/img/VietBot.png
M       html/assets/img/VietBot128.png
M       html/assets/img/VietBotlogoWhite.png
M       html/assets/img/blackbg.jpg
M       html/assets/img/blog-header-img.html
M       html/assets/img/blog-img-03.jpg
M       html/assets/img/blog-img-04.jpg
M       html/assets/img/blog-img-05.jpg
M       html/assets/img/colorfull/bar-graph.png
M       html/assets/img/colorfull/checked.png
M       html/assets/img/colorfull/console.png
M       html/assets/img/colorfull/layer.png
M       html/assets/img/colorfull/location.svg
M       html/assets/img/colorfull/man.png
M       html/assets/img/colorfull/man1.png
M       html/assets/img/colorfull/message.svg
M       html/assets/img/colorfull/movie-frame.png
M       html/assets/img/colorfull/phone-call.svg
M       html/assets/img/colorfull/prototype.png
M       html/assets/img/colorfull/ui-design.png
M       html/assets/img/colorfull/woman.png
M       html/assets/img/favicon.png
M       html/assets/img/ff.jpg
M       html/assets/img/location-map.png
M       html/assets/img/man.png
M       html/assets/img/webdesigner/blog-item1.jpg
M       html/assets/img/webdesigner/blog-item2.jpg
M       html/assets/img/webdesigner/blog-item3.jpg
M       html/assets/img/webdesigner/blog-item4.jpg
M       html/assets/img/webdesigner/blog-single.jpg
M       html/assets/img/webdesigner/portfolio-item1.jpg
M       html/assets/img/webdesigner/portfolio-item2.jpg
M       html/assets/img/webdesigner/portfolio-item3.jpg
M       html/assets/img/webdesigner/portfolio-item4.jpg
M       html/assets/img/webdesigner/portfolio-item5.jpg
M       html/assets/img/webdesigner/portfolio-item6.jpg
M       html/assets/img/webdesigner/responsive.png
M       html/assets/img/z.txt
M       html/assets/js/1.16.0_umd_popper.min.js
M       html/assets/js/3.5.1_jquery.min.js
M       html/assets/js/ace.js
M       html/assets/js/ajax_jquery_3.6.0_jquery.min.js
M       html/assets/js/axios_0.21.1.min.js
M       html/assets/js/bootstrap.bundle.js.map
M       html/assets/js/bootstrap.bundle.min.js
M       html/assets/js/bootstrap.js
M       html/assets/js/bootstrap.min.js
M       html/assets/js/bootstrap_3_3_6_js_bootstrap.min.js
M       html/assets/js/datatables.min.js
M       html/assets/js/dropzone.min.js
M       html/assets/js/highlight.min.js
M       html/assets/js/isotope.pkgd.min.js
M       html/assets/js/jquery-3.4.1.min.js
M       html/assets/js/jquery-3.6.1.min.js
M       html/assets/js/jquery.countTo.js
M       html/assets/js/jquery.mCustomScrollbar.concat.min.js
M       html/assets/js/jquery.magnific-popup.min.js
M       html/assets/js/jquery.min.js
M       html/assets/js/jquery_1_12_4_min.js
M       html/assets/js/main.js
M       html/assets/js/owl.carousel.min.js
M       html/assets/js/popper.min.js
M       html/assets/js/speech_to_text_0_7_4_lib_index.js
M       html/assets/js/webshell.js
M       html/assets/js/z.txt
M       html/assets/json/Data_DiaGioiHanhChinhVN.json
M       html/assets/json/List_Lat_Lon_Huyen_VN.json
M       html/assets/json/translation.json
M       html/assets/json/z.txt
M       html/assets/readme.md
M       "html/config_M\341\272\253u.json"
M       html/guide.md
M       html/include_php/Backup_Config/backup_config_03-07-2023_20_21_47.json
M       html/include_php/Backup_Config/backup_config_03-07-2023_20_21_51.json
M       html/include_php/Backup_Config/backup_config_03-07-2023_20_21_56.json
M       html/include_php/Backup_Config/backup_config_03-07-2023_20_22_08.json
M       html/include_php/Backup_Config/backup_config_03-07-2023_20_23_46.json
M       html/include_php/Backup_Config/backup_config_03-07-2023_20_27_41.json
M       html/include_php/Backup_Config/backup_config_03-07-2023_20_28_05.json
M       html/include_php/Backup_Config/backup_config_03-07-2023_20_28_39.json
M       html/include_php/Backup_Config/backup_config_03-07-2023_20_35_12.json
M       html/include_php/Backup_Config/backup_config_03-07-2023_20_36_45.json
M       html/include_php/Backup_Config/backup_config_03-07-2023_20_38_40.json
M       html/include_php/Backup_Config/config_default.json
M       html/include_php/ChatBot.php
M       html/include_php/ConfigSetting.php
M       html/include_php/INFO_OS.php
M       html/include_php/LogServiceCMD.php
M       html/include_php/RestoreBackup.php
M       html/include_php/Shell.php
M       html/include_php/Skill.php
M       html/index.php
D       src/action.json
D       src/adverb.json
D       src/api_process.cpython-39-arm-linux-gnueabihf.so
D       src/assistant_helpers.py
D       src/browser_helpers.py
D       src/config.json
D       src/data_process.cpython-39-arm-linux-gnueabihf.so
D       src/device_helpers.py
D       src/embedded_assistant_pb2.py
D       src/embedded_assistant_pb2_grpc.py
D       src/gg_ass_data.cpython-39-arm-linux-gnueabihf.so
D       src/google_stt.json
D       src/google_tts.json
D       src/hass_process.cpython-39-arm-linux-gnueabihf.so
M       src/hotword/eng/alexa_raspberry-pi.ppn
M       src/hotword/eng/americano_raspberry-pi.ppn
M       src/hotword/eng/blueberry_raspberry-pi.ppn
M       src/hotword/eng/bumblebee_raspberry-pi.ppn
M       "src/hotword/eng/ch\303\240o-ch\341\273\213_raspberry-pi.ppn"
M       src/hotword/eng/computer_raspberry-pi.ppn
M       src/hotword/eng/grapefruit_raspberry-pi.ppn
M       src/hotword/eng/grasshopper_raspberry-pi.ppn
M       src/hotword/eng/hey barista_raspberry-pi.ppn
M       src/hotword/eng/hey google_raspberry-pi.ppn
M       src/hotword/eng/hey siri_raspberry-pi.ppn
M       src/hotword/eng/jarvis_raspberry-pi.ppn
M       src/hotword/eng/ok google_raspberry-pi.ppn
M       src/hotword/eng/pico clock_raspberry-pi.ppn
M       src/hotword/eng/picovoice_raspberry-pi.ppn
M       src/hotword/eng/porcupine_raspberry-pi.ppn
M       src/hotword/eng/readme.md
M       src/hotword/eng/terminator_raspberry-pi.ppn
M       src/hotword/readme.md
M       "src/hotword/vi/ch\303\240o-ch\341\273\213_raspberry-pi.ppn"
M       "src/hotword/vi/con-m\341\273\245-kia_raspberry-pi.ppn"
M       "src/hotword/vi/em-\306\241i_raspberry-pi.ppn"
M       "src/hotword/vi/h\303\240-n\341\273\231i-\306\241i_raspberry-pi.ppn"
M       "src/hotword/vi/ng\306\260\341\273\235i-\304\221\341\272\271p-\306\241i_raspberry-pi.ppn"
M       src/hotword/vi/readme.md
M       "src/hotword/vi/v\341\273\243-\304\221\303\242u-r\341\273\223i_raspberry-pi.ppn"
D       src/led_aio.cpython-39-arm-linux-gnueabihf.so
D       src/led_apa102.cpython-39-arm-linux-gnueabihf.so
D       src/led_process.cpython-39-arm-linux-gnueabihf.so
D       src/led_ring.cpython-39-arm-linux-gnueabihf.so
D       src/led_ws2812.cpython-39-arm-linux-gnueabihf.so
D       src/main.cpython-39-arm-linux-gnueabihf.so
D       src/mic_process.cpython-39-arm-linux-gnueabihf.so
M       src/mp3/readme.md
D       src/object.json
D       src/readme.md
D       src/skill.json
D       src/skill_process.cpython-39-arm-linux-gnueabihf.so
M       src/sound/default/ding.mp3
M       src/sound/default/dong.mp3
M       src/sound/default/tut_tut.mp3
M       src/sound/welcome/welcome.wav
D       src/speaker_process.cpython-39-arm-linux-gnueabihf.so
D       src/start.py
D       src/state.json
D       src/stt_process.cpython-39-arm-linux-gnueabihf.so
D       src/tts_process.cpython-39-arm-linux-gnueabihf.so
M       src/tts_saved/readme.md
D       src/volume_state.json
Your branch is behind 'origin/beta' by 16 commits, and can be fast-forwarded.
  (use "git pull" to update your local branch)
```
3.2. Download các File mới về

```sh
git pull
```
3.2.1. Nếu ra thông báo ví dụ như sau
```sh
hint: Pulling without specifying how to reconcile divergent branches is
hint: discouraged. You can squelch this message by running one of the following
hint: commands sometime before your next pull:
hint: 
hint:   git config pull.rebase false  # merge (the default strategy)
hint:   git config pull.rebase true   # rebase
hint:   git config pull.ff only       # fast-forward only
hint: 
hint: You can replace "git config" with "git config --global" to set a default
hint: preference for all repositories. You can also pass --rebase, --no-rebase,
hint: or --ff-only on the command line to override the configured default per
hint: invocation.
error: Your local changes to the following files would be overwritten by merge:
        src/main.so
Please commit your changes or stash them before you merge.
Aborting
```
Là do đã copy file main.so từ bên ngoài chứ ko phải từ lần git trước cần phải xóa hoặc đổi tên file này, sau đó chạy lại lệnh

3.2.2. Nếu ra thông báo sau
```sh
hint: Pulling without specifying how to reconcile divergent branches is
hint: discouraged. You can squelch this message by running one of the following
hint: commands sometime before your next pull:
hint: 
hint:   git config pull.rebase false  # merge (the default strategy)
hint:   git config pull.rebase true   # rebase
hint:   git config pull.ff only       # fast-forward only
hint: 
hint: You can replace "git config" with "git config --global" to set a default
hint: preference for all repositories. You can also pass --rebase, --no-rebase,
hint: or --ff-only on the command line to override the configured default per
hint: invocation.
Updating fb04f3a..f7bd158
Updating files: 100% (14/14), done.
Fast-forward
 "guide/01_Danh_s\303\241ch_image_vietbot.md"                                                                                  |   16 +
 "guide/02_C\303\240i_\304\221\341\272\267t_t\341\273\253_image.md" => guide/02_Flash_image.md                                 |    0
 "guide/03_C\303\240i_\304\221\341\272\267t_nhanh.md"                                                                          |   74 +++
 .../03_C\303\240i_\304\221\341\272\267t_\303\242m_thanh.md" => "guide/04_C\303\240i_\304\221\341\272\267t_\303\242m_thanh.md" |    0
 "guide/04_s\341\273\255a_config_nhanh.md"                                                                                     |   33 --
 skill_guide/homeassistant.md => "skill_guide/C\303\240i_\304\221\341\272\267t_hass.md"                                        |   23 +-
 src/data_process.cpython-39-arm-linux-gnueabihf.so                                                                            |  Bin 5296764 -> 5631832 bytes
 src/mic_process.cpython-39-arm-linux-gnueabihf.so                                                                             |  Bin 2574440 -> 2593148 bytes
 src/object.json                                                                                                               | 1576 ++++++++++++++++++++++++++++++++--------------------------------
 src/skill_process.cpython-39-arm-linux-gnueabihf.so                                                                           |  Bin 3374692 -> 3400648 bytes
 src/speaker_process.cpython-39-arm-linux-gnueabihf.so                                                                         |  Bin 558828 -> 559392 bytes
 11 files changed, 885 insertions(+), 837 deletions(-)
 rename "guide/02_C\303\240i_\304\221\341\272\267t_t\341\273\253_image.md" => guide/02_Flash_image.md (100%)
 create mode 100644 "guide/03_C\303\240i_\304\221\341\272\267t_nhanh.md"
 rename "guide/03_C\303\240i_\304\221\341\272\267t_\303\242m_thanh.md" => "guide/04_C\303\240i_\304\221\341\272\267t_\303\242m_thanh.md" (100%)
 delete mode 100644 "guide/04_s\341\273\255a_config_nhanh.md"
 rename skill_guide/homeassistant.md => "skill_guide/C\303\240i_\304\221\341\272\267t_hass.md" (75%)
```
là đã thành công

