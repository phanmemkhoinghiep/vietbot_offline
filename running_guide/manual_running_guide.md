
### Tùy chọn 1. Chạy Manual từ SSH trên PC (Mất kết nối sẽ ngừng Vietbot)

1.1. Truy nhập vào thư mục Bot
Sử dụng lệnh sau

```sh
cd vietbot_offline/src
```
1.2. Chạy vietbot

1.2.1. Chạy có hiện thông báo để biết lỗi xảy ra còn khắc phục
```sh
python3 start.py
```
1.2.2. Chạy không hiện thông báo khi đã không còn lỗi
```sh
python3 start.py  2>/dev/null
```


### Tùy chọn 2. Chạy Manual từ SSH trên PC (Mất kết nối sẽ không ngừng Vietbot)

2.1. Tạo 1 Session Tmux

```sh
tmux new -s vietbot
```
2.2. Cửa sổ Tmux mở, di chuyển tới thư mục vietbot, sử dụng lệnh sau

```sh
cd vietbot_offline/src
```
2.3. Chạy vietbot

2.3.1. Chạy có hiện thông báo để biết lỗi xảy ra còn khắc phục
```sh
python3 start.py
```
2.3.2. Chạy không hiện thông báo khi đã không còn lỗi
```sh
python3 start.py  2>/dev/null
```
2.4. Thoát khỏi SSH
Hiện tại có thể thoát khỏi SSH mà vietbot vẫn chạy bình thường

2.5. Nối lại kết nối

2.5.1. List các session

```sh
tmux ls
```

2.5.2. Gắn vào session vietbot đã có

```sh
tmux attach -t vietbot
```
2.5.3. Xóa Session vietbot

Xóa session đang chạy để chạy mới nếu cần

```sh
 tmux kill-session -t session-name
```
