Các file sử dụng cho STT-GG-ASS, Google Assistant Skill là 2 file: credentials.json và device_config.json, lấy từ Google Assistant Project
2 File này đã có sẵn trên git, tuy nhiên nếu sử dụng đồng thời sẽ bị báo lỗi sau

```sh
grpc._channel._MultiThreadedRendezvous: <_MultiThreadedRendezvous of RPC that terminated with:
        status = StatusCode.RESOURCE_EXHAUSTED
        details = "Quota exceeded for quota metric 'embedded-assistant-prod/converse_requests' and limit 'ConverseRequestsPerDayPerProject' of service 'embeddedassistant.googleapis.com' for consumer 'project_number:361910366281'."
        debug_error_string = "{"created":"@1678842654.480373082","description":"Error received from peer ipv4:172.217.31.10:443","file":"src/core/lib/surface/call.cc","file_line":903,"grpc_message":"Quota exceeded for quota metric 'embedded-assistant-prod/converse_requests' and limit 'ConverseRequestsPerDayPerProject' of service 'embeddedassistant.googleapis.com' for consumer 'project_number:361910366281'.","grpc_status":8}"
```
Do đó nên khởi tạo Google Assistant Project để tránh bị trùng theo các bước sau


### STEP1.  Cách 1: Đăng ký thiết bị sử dụng Web Google

1.1. Mở trang https://console.actions.google.com/u/0/project/project_id/deviceregistration/ với project_id là project_id vừa lưu ở 2.1.1.

và điền lần lượt từng mục

![ĐĂNG KÝ THIẾT BỊ](https://developers.google.com/assistant/sdk/images/console/device-models-aog.png)

![ĐĂNG KÝ THIẾT BỊ](https://user-images.githubusercontent.com/64348125/109378336-3f136d80-7904-11eb-808e-37bf5c726bf3.png)

1.1.1. Product Name: Gõ tùy ý

1.1.2. Manufacturer name: Gõ  tùy ý

1.1.3. Device Type: Chọn Speaker

1.1.4. Device Model ID: Để mặc định hoặc tùy chọn. Nhớ lưu lại thông tin để dùng sau

1.1.5. Bấm Register Model

1.2. Download file về máy

1.3. Cửa sổ mới mở ra, chọn Download OAuth 2.0 credentials

![ĐĂNG KÝ THIẾT BỊ](https://user-images.githubusercontent.com/64348125/109378347-56525b00-7904-11eb-9764-c2af673d9ac4.png)


1.4. File .json được lưu về máy, giữ nguyên File không đổi tên 

1.5. Copy file json vừa download được sang thư mục của loa thông minh tại đường dẫn
```sh
 /home/pi
```
1.6. Có thể lấy lại file json bằng cách vào lại bước 2.1, chọn Download OAuth 2.0 credentials

![LẤY LẠI FILE](https://developers.google.com/assistant/sdk/images/console/edit-model.png)

### STEP2.  Cách 2: Đăng ký thiết bị sử dụng Tool

https://developers.google.com/assistant/sdk/reference/device-registration/device-tool

### STEP3. Kích hoạt Google Assistant

3.1. Truy nhập SSH của Raspberry Pi

3.1.1 Gõ lệnh sau

```sh
google-oauthlib-tool --scope https://www.googleapis.com/auth/assistant-sdk-prototype \
      --scope https://www.googleapis.com/auth/gcm \
      --save --headless --client-secrets /home/pi/client_secret_client-id.json

```
với client_secret_client-id.json là tên file json vừa lưu ở /home/pi theo bước 2.2.3.

3.1.2. Kết quả dòng lệnh sẽ trả về có dạng

```sh
Please visit this URL to authorize this application: https://...
```
3.2. Lấy mã từ Google

3.2.1. Copy toàn bộ đường link bắt đầu từ https:// sau đó dán vào trình duyệt trên máy PC, 

3.2.2. Cửa sổ đăng nhập hiện ra, đăng nhập vào tài khoản Google (Là tài khoản duy nhất từ Step 1) sau đó bấm Allow(Cho phép) và Tiếp tục(Continue) để cho phép quyền truy cập vào tài khoản từ App Google Action

3.2.3. Sau khi chấp thuận, một mã sẽ hiện ra có dạng

```sh
4/XXXX
```
3.2.4. Copy mã trên vào cửa sổ dòng lệnh còn đang chạy trên Raspberry Pi tại mục:

```sh
Enter the authorization code:

```
3.2.5. 

theo thông báo trên console

```sh
credentials saved: /path/to/.config/google-oauthlib-tool/credentials.json

```
Hệ thống sẽ gen ra một file có tên là credentials.json, nằm trong thư mục ẩn .config tại đường dẫn /home/pi/.config/google-oauthlib-tool/
Chú ý, không được xóa, đổi tên file này trong quá trình sử dụng Google Assistant

3.3. Trong trường hợp muốn dùng Account Google khác

3.3.1. Thay Acc khác

Xóa thư mục trên bằng lệnh

```sh
sudo rm -rf/home/pi/.config/google-oauthlib-tool/credentials.json

```
Chạy lại toàn bộ các bước từ 3.1. đến 3.2 để tạo được file credentials.json mới

3.3.2. Dùng nhiều Acc

Đổi tên file .json hiện tại bằng lệnh

```sh
sudo cp /home/pi/.config/google-oauthlib-tool/credentials.json /home/pi/.config/google-oauthlib-tool/credentials_1.json

```
Chạy lại toàn bộ các bước từ 3.1. đến 3.2 để tạo được file credentials.json mới

Lặp lại bước 3.3.2 để tạo ra file credentials_x.json

Muốn dùng Acc nào thì tạo file credentials.json từ file đó

```sh
sudo cp /home/pi/.config/google-oauthlib-tool/credentials_x.json /home/pi/.config/google-oauthlib-tool/credentials.json

```
3.4. Trong trường hợp báo lỗi InvalidGrantError, là do mã copy vào theo bước 3.1.5. bị sai, cần phải lặp lại từ 3.1. Chú ý mã copy không có khoảng trắng, khi select bằng chuột có thể có khoảng trắng

### STEP4. Kích hoạt thiết bị để chạy được Google Assistant

4.1. Chạy ứng dụng gốc để kích hoạt thiết bị như sau:
```sh
cd /home/pi/vietbot_offline/src/
```
sau đó
```sh
python3 register_device.py --project-id <ten_project> --device-model-id <ten_device_id>
```
với project_id và device_model_id là giá trị đã lưu lại khi khởi tạo project

Chương trình sẽ hiển thị như sau
```sh
pygame 1.9.4.post1
Hello from the pygame community. https://www.pygame.org/contribute.html
INFO:root:Connecting to embeddedassistant.googleapis.com
WARNING:root:Device config not found: [Errno 2] No such file or directory: '/home/pi/.config/googlesamples-assistant/device_config.json'
INFO:root:Registering device
INFO:root:Device registered: xxxxxxx-xxxxxxx-xxxxxxx-xxxxxxx-xxxxxxx

```
Bấm Ctrl + C để thoát ứng dụng kiểm tra
4.2. Kiểm tra kết quả
Sau khi khởi chạy, hệ thống sẽ tạo một thư mục có file là device_config.json nằm trong thư mục googlesamples-assistant
```sh
/home/pi/.config/googlesamples-assistant/device_config.json
```
### STEP4. Kết thúc

