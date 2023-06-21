### Kiểm tra chạy hay không:

Gõ lệnh sau để kiểm tra vietbot có chạy hay không
```sh
systemctl --user status vietbot.service
```
### Dừng lệnh:

Gõ lệnh sau để dừng chạy vietbot ngay lập tức

```sh
systemctl --user stop vietbot.service
```
hoặc
```sh
sudo reboot
```
### Chạy lại:

Gõ lệnh sau để chạy lại vietbot ngay lập tức

```sh
systemctl --user start vietbot.service
```
hoặc
```sh
systemctl --user restart vietbot.service
```
### Tạm dừng chạy 

Gõ lệnh để stop tạm thời

```sh
systemctl --user stop vietbot.service
```
vietbot sẽ stop không chạy cho đến khi khởi động lại

### Hủy bỏ chạy tự động

Gõ lệnh sau để hủy bỏ chạy tự động sau khi khởi động 

```sh
systemctl --user disable vietbot.service
```
Hệ thống sẽ thông báo như sau và vietbot không chạy tự động nữa
```sh
Removed /home/pi/.config/systemd/user/default.target.wants/vietbot.service.
```
### Kích hoạt chạy tự động

Gõ lệnh sau để kích hoạt chạy tự động sau khi khởi động 

```sh
systemctl --user enable vietbot.service
```
Hệ thống sẽ thông báo như sau và vietbot sẽ chạy tự động vào lần khởi động tới

```sh
Created symlink /home/pi/.config/systemd/user/default.target.wants/vietbot.service → /home/pi/.config/systemd/user/vietbot.service.
```

###  Xem log

Gõ lệnh sau để xem log (Chú ý phải chuyển đến trang cuối)

```sh
 journalctl --user-unit vietbot.service 
```

