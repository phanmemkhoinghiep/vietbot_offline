### ĐÂY LÀ HƯỚNG DẪN NHANH ĐỂ SỬA CONFIG, VỚI CÁC THỨ TỰ ƯU TIÊN

### STEP1. KẾT NỐI VỚI UI

1.1. Bật nguồn
1.2. Lắng 



### STEP1. CẤP QUYỀN CHO UI

  ```sh
 sudo chmod -R 0777 /home/pi/vietbot_offline/html/ && sudo chmod -R 0777 /home/pi/vietbot_offline/src/

```
### STEP2. ID CỦA SOUNDCARD
   
- Sử dụng để khai báo id của soundcard nhằm chỉnh âm lượng hệ thống
- Được xác định bằng lệnh
  ```sh
  amixer
  ```
- Sau đó tìm giá trị Master Volume và nhập thay thế giá trị 0 mặc định
- Tìm mục tương ứng trong Tab Config

- ```sh
            "amixer_id": 0
  ```

### STEP3. KEY CỦA WAKEUP
  ```sh
        "hotword_engine": {
            "type": "porcupine",
            "key": "dsfsdfd"
        },
  ```
- Sử dụng để khai báo key cho cơ chế Wakeup
- Đăng ký và lấy key từ trang PICOVOICE.AI
- Nhập giá trị key thay thế giá trị mặc định 

### STEP4. THÔNG TIN CÁ NHÂN
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
Người dùng nhập vị trí thay thế cho các giá trị mặc định, để có được kết quả dự báo thời tiết chính xác
đến tận khu vực nhập

