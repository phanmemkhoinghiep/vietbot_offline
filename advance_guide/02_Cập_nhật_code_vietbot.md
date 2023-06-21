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
cd /home/pi/vietbot_offline/src
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
Updating b7da00f..e33167d
Fast-forward
 021_software_enviroment_installation_guide.md                       |   3 ++-
 022_software_enviroment_installation_guide.md                       |   6 ++---
 03_software_install_guide.md => 03_software_install_update_guide.md |  31 +++++++++++++++++++++++--
 07_updating_guide.md                                                |  63 ---------------------------------------------------
 README.md                                                           |  16 ++++++++++++-
 requirements.txt                                                    |   5 ----
 src/create_config.py                                                |   2 +-
 src/led_controll.so                                                 | Bin 1713052 -> 1713116 bytes
 src/local_controll.so                                               | Bin 693048 -> 827620 bytes
 src/main.so                                                         | Bin 5441808 -> 5405524 bytes
 src/requirements.txt                                                |   1 +
 src/schedule_controll.so                                            | Bin 271520 -> 0 bytes
 12 files changed, 51 insertions(+), 76 deletions(-)
 rename 03_software_install_guide.md => 03_software_install_update_guide.md (52%)
 delete mode 100644 07_updating_guide.md
 delete mode 100644 requirements.txt
 delete mode 100644 src/schedule_controll.so
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
