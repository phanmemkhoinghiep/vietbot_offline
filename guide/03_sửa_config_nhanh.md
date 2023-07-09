### ĐÂY LÀ HƯỚNG DẪN NHANH ĐỂ SỬA CONFIG, VỚI CÁC THỨ TỰ ƯU TIÊN

### STEP1. ID CỦA SOUNDCARD
  ```sh
            "amixer_id": 0
  ```
- Sử dụng để khai báo id của soundcard nhằm chỉnh âm lượng hệ thống
- Được xác định bằng lệnh
  ```sh
  amixer
  ```
- Sau đó tìm giá trị Master Volume và nhập thay thế giá trị 0 mặc định
- Với các Image đi kèm thì giá trị mặc định đã đúng

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

### STEP4. TỌA ĐỘ
  "location": {
      "lon": 105.804817,
      "lat": 21.028511
  }
Người dùng nhập tọa độ thay thế cho các giá trị mặc định, để có được kết quả dự báo thời tiết chính xác
đến tận khu vực nhập

