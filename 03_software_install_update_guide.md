### STEP1. Download code về Pi khi chưa có Code
Download Code về phần cứng raspberry theo cách sau:
1.1. Truy cập vào Git
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

### STEP2.  Download code về khi đã có Code, cần cập nhật lại

2.1. Truy cập vào thư mục vietbot_online

```sh
cd /home/pi/vietbot_offline/src
```
Sau đó kiểm tra chính xác xem có trong nhánh beta hay không

```sh
git branch -vv
```
Nếu câu trả lời là

```sh

* beta b7da00f [origin/beta] Update 03_software_install_guide.md
```
thì vietbot đã đúng nhánh beta, khi đó có thể check xem có file gì mới không

```sh
git fetch
```
Chú ý muốn giữ lại create_config.py cần đổi tên sang create_config.py.old nếu ko sẽ bị ghi đè

Download các File mới về

```sh
git pull
```

Nếu ra thông báo sau
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

Nếu ra thông báo sau
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

### STEP3. Cài đặt các gói Python do nâng cấp tính năng

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
