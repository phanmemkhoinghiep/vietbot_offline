### STEP1. Kết nối Console

1.1. Chờ Pi boot up xong, xác định IP của Pi từ Modem, Access Pint hoặc các phần mềm quét IP có hiển thị hostname

1.2.2. Sử dụng các phần mêm SSH như putty/Securec CRT truy cập ssh vào địa chỉ IP của Pi với 

```sh
username: pi
password: vietbot
```
### STEP2. Cập nhật code mới

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
```sh
  alpha ccd4057 [origin/alpha] Update config.json
* beta  ccd4057 Update config.json
```
2.3. Check xem có file gì mới không

```sh
git fetch
```

Chú ý muốn giữ lại create_config.py, create_action.py, create_object.py, create_skill.py cần đổi tên nếu ko sẽ bị ghi đè

2.4. Download các File mới về

```sh
git pull
```

2.4.1. Nếu ra thông báo ví dụ như sau
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

2.4.2. Nếu ra thông báo sau
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

### STEP3. Cài đặt các gói Python do nâng cấp tính năng (Nếu cần)

3.1. Nâng cấp PIP

Chạy lần lượt các lệnh sau
```sh
python3 -m pip install --upgrade pip

```
3.2. Cài đặt các gói Python 

Truy cập vào thư mục vietbot_offline

```sh
cd /home/pi/vietbot_offline/src
```
Cài đặt các gói Python được list trong file requirements.txt để cài dặt các lib nếu cần
```sh
python3 -m pip install -r requirements.txt

```
