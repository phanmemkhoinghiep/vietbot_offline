### ĐÂY LÀ HƯỚNG DẪN NHANH ĐỂ SỬA CONFIG, VỚI CÁC THỨ TỰ ƯU TIÊN

Trước khi thực hiện đảm bảo đã thực hiện Guide 01 và Loa đã được cấp WiFi




### STEP1. KẾT NỐI VỚI UI

1.1. Cắm nguồn

1.2. Xác định Ip của Loa bằng 1 trong 2 cách

- Lắng nghe tiếng loa đọc IP nếu vietbot chạy lần đầu tiên
  
- Ấn giữ nút Playback trên loa

1.3. Cấp quyền cho UI bằng cách:

  ```sh
 sudo chmod -R 0777 /home/pi/vietbot_offline/html/ && sudo chmod -R 0777 /home/pi/vietbot_offline/src/

```
1.4. Truy cập vào Web UI, ví dụ:

  ```sh
http://192.168.1.10
```
và chuyển đến Tab Config

### STEP2. CÀI ĐẶT TRÊN UI

2.1. Thông tin cá nhân
Người dùng nhập vị trí thay thế cho các giá trị mặc định, để có được kết quả dự báo thời tiết chính xác
đến tận khu vực nhập
Thông tin này sẽ được lưu tại:
  ```sh
        "user_info": {
            "name": "Vũ Tuyển",
            "address": {
                "wards": "Xã Vĩnh Khúc",
                "district": "Huyện Văn Giang",
                "province": "Tỉnh Hưng Yên"
            }
        },
  ```
2.2. Nhập  Amixer ID
- Sử dụng để khai báo id của soundcard nhằm chỉnh âm lượng hệ thống
- Được xác định bằng lệnh
  ```sh
  amixer
  ```
- Sau đó tìm giá trị Master Volume và nhập thay thế giá trị 0 mặc định
- Tìm mục tương ứng trong Tab Config
Thông tin này sẽ được lưu tại:
 ```sh
            "amixer_id": 0
  ```

### STEP3. KEY CỦA WAKEUP

- Sử dụng để khai báo key cho cơ chế Wakeup
- Đăng ký và lấy key từ trang PICOVOICE.AI
- Nhập giá trị key thay thế giá trị mặc định 
Thông tin này được lưu tại:
  ```sh
        "hotword_engine": {
            "type": "porcupine",
            "key": "dsfsdfd"
        },
  ```
  ### STEP4. NGÔN NGỮ CỦA WAKEUP
  - Chọn ngôn ngữ tiếng Anh hoặc tiếng Việt
 
  Sau đó chọn lưu cấu hình và khởi động lại vietbot

