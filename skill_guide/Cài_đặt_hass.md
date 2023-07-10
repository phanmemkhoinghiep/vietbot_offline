Vietbot hỗ trợ Home Assistant để điều khiển nhà thông minh bằng giọng nói Việt với hai tham số là Base URL & Long Lived Token

### STEP1. Lấy Base URL và Long Lived token

1.1. Base URL Internal

Có dạng: http://X.X.X.X:8123 với X.X.X.X là địa chỉ Private

1.2. Base URL External

Có dạng: http://abc.def:8123 (Có thể không có 8123) hoặc không với abc.def là Domain

1.3. Truy cập vào Web UI của Home Assistant để lấy Long Lived Token 

### STEP3.  Chỉnh sửa lại Config

3.1. Vào Web UI, chọn Tab Skill

3.3. Nhập Hass URL và Hass Long Token vào mục cần nhập

3.4. Chọn lưu cấu hình

3.5. Chọn Restart lại vietbot

### STEP4. Cách ra lệnh trên Hass

4.1. Lệnh tắt bật: Trong lệnh cần có đủ các phần sau, không cần thứ tự:

```sh
<action><friendly_name><end_of_request>
```
Ví dụ

```sh
<Tắt> <quạt phòng khách>
<Bật> <đèn trần phòng ngủ>  
```

Cấu trúc lệnh như sau:

4.1.1. <action> Lệnh tắt, bật

Một trong các từ được định nghĩa trong request_turn_on, request_off, check của file json, thêm vào bằng cách edit file craete_config, sau đó chạy python3 create_config.py 

4.1.2. <friendly_name>

Là tên friendly name của entity tương ứng với thiết bị, đã khai báo trên Hass
  
4.2. Lệnh kiểm tra trạng thái: Trong lệnh cần có đủ các phần sau, không cần thứ tự:

```sh
<action><friendly_name><end_of_request>
  
<Kiểm tra> <quạt> phòng khách>
<Kiểm tra> <đèn rọi hành lang>
<Hiển thị> <giá trị><nhiệt độ phòng khách>
<Thông báo> <trạng thái><cửa sân thượng>
```
4.1.1. <action> Lệnh kiểm tra

Một trong các từ được định nghĩa trong request_check của file json, thêm vào bằng cách edit file craete_config, sau đó chạy python3 create_config.py 

4.1.2. <friendly_name>

Là tên friendly name của entity tương ứng với thiết bị, đã khai báo trên Hass

4.3. Sau khi ra lệnh, có hai tình huống

4.3.1. Thành công

Phản hồi từ thiết bị với các thiết bị có phản hồi (Ví dụ đèn, quạt, rèm) và  thông báo về việc ra lệnh thành công

Thông báo kết quả với các thiết bị không có phản hồi (Ví dụ cảm biến)

4.3.2. Không thành công

- Nếu chưa kích hoạt Hass: Đưa ra thông báo chưa kích hoạt Hass
- Nếu không kết nối được Hass: Đưa ra thông báo không kết nối được
- Nếu ra lệnh không thành công: Đưa ra thông báo lý do 
