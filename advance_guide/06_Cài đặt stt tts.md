Vietbot sử dụng STT (Speed to Text) Online để nhận diện câu lệnh và TTS (Text to Speech) Online để phát câu phản hồi, Vietbot hỗ trợ các
STT và TTS sau:

### STT & TTS Google (FREE)

Không cần khai báo, chỉ cần kích hoạt sử dụng

### STT GOOGLE ASSISTANT (FREE)
Nếu chọn Mode default, không cần khai báo, chỉ cần kích hoạt sử dụng

### STT & TTS Google CLOUD (MẤT PHÍ)

Cần thực hiện các bước sau, sau đó kích hoạt sử dụng
1.1. Cấu hình STT

1.1.1. Truy cập: https://console.cloud.google.com/

1.1.2. Đăng nhập với tài khoản Google và đồng ý với Terms of Service

1.1.3. Tạo 1 project với tên, sau đó mở Project

1.1.4. Chọn APIs & Service, sau đó chọn Library 

1.1.5. Lần lượt tìm Google Cloud Speech to Text và Googe Cloud Text to Speech và Enable cả 2 API này

1.1.6. Tạo Credentials bằng cách ấn Create new credentials

1.1.7. Chọn Service Account

Làm theo các bước hướng dẫn cho đến khi có nút download thì download file .json về và máy
đổi tên thành google.json

1.2. Cấu hình TTS Google

1.2.1 Lặp lại bước 1.1.6 ở trên, nhưng chọn API 

Làm theo các bước hướng dẫn cho đến khi tạo ra API thì copy và lưu lại API

Link hỗ trợ: https://support.google.com/googleapi/answer/6158862?hl=en

### TTS Google CLOUD (MIỄN PHÍ)

1. Truy cập vào trang sau:
```sh
https://www.gstatic.com/cloud-site-ux/text_to_speech/text_to_speech.min.html
```
2.Thao tác để hiển thị Code

2.1. Ấn phím F12

2.2. Ấn phím Ctrl + R
 
2.3. Ấn phím SPEAK IT Button

2.2.4. Thực hiện thủ tục Capcha

2.2.5. Ấn vào Tab Network tại cửa sổ bên phải 

2.2.6.

Ấn vào Tab Fetch/XHR Tab tại cửa sổ bên phải

Click line: proxy?url= at Left Column tại cửa sổ bên phải

Đọc giá trị dòng này từ Tab Header tại cửa sổ nhỏ bên phải

Nếu nội dung của nó là 
```sh
https://cxl-services.appspot.com/proxy?url=https://texttospeech.googleapis.com/v1beta1/text:synthesize&token=03AGdBq27QjGOUzzA33Xye3C4mpOK7xnEblcNFBDMHXbzP6X1IRtD_TtT0fKsXRQzpzkQF0JpKxaLRsVcY-NdHWO6XOlV0ZjQCCVMzHsGwk_PHgQVMEiwn-C8YI_BfN3H7kWfw-6HdY0j2TVWD-lPZz5l_hS8sL2hdr3XAP7O0p-Wd7t4r2ggnBtq-e9cYN1laVPBt12oxWHTOhLGn9UlRUQX03O-I7BF2nDlpkLWqhbKO9a9kPfqSfJsa6wOZgy1fQxAvd9fhf3hwwJuQ1KNZaCb6U7pv6FBepyoJtvst8-gyzIJ8QgF8bBUAVmQJ3rB6tWauGK3yRFihaSUdxy8mLdutmCkZ7M6DxNtG-KiVC-08lb2sJM7prZnX7RwSQh8ZLxpfI9cjcNsg5KFEJD22qbIO4aFI3t981R_JPt2j7Q3IHFGCqZEzy6ibdbM0xrRkZtTPX8i7uyAxXZ7dxuWQeu-NanquwMHR7g
```
thì API sẽ là
```sh
03AGdBq27QjGOUzzA33Xye3C4mpOK7xnEblcNFBDMHXbzP6X1IRtD_TtT0fKsXRQzpzkQF0JpKxaLRsVcY-NdHWO6XOlV0ZjQCCVMzHsGwk_PHgQVMEiwn-C8YI_BfN3H7kWfw-6HdY0j2TVWD-lPZz5l_hS8sL2hdr3XAP7O0p-Wd7t4r2ggnBtq-e9cYN1laVPBt12oxWHTOhLGn9UlRUQX03O-I7BF2nDlpkLWqhbKO9a9kPfqSfJsa6wOZgy1fQxAvd9fhf3hwwJuQ1KNZaCb6U7pv6FBepyoJtvst8-gyzIJ8QgF8bBUAVmQJ3rB6tWauGK3yRFihaSUdxy8mLdutmCkZ7M6DxNtG-KiVC-08lb2sJM7prZnX7RwSQh8ZLxpfI9cjcNsg5KFEJD22qbIO4aFI3t981R_JPt2j7Q3IHFGCqZEzy6ibdbM0xrRkZtTPX8i7uyAxXZ7dxuWQeu-NanquwMHR7g
```
Ghi lại để dùng cho TTS Google Cloud

### STT & TTS FPT, Viettel, ZALO (MIỄN PHÍ THEO SỐ LƯỢNG)

Trong trường hợp muốn sử dụng các Engine khác để phản hồi bằng giọng địa phương, Vietbot cũng hỗ trợ FPT, Viettel và Zalo theo các bước sau:

2.1. Đăng ký Acc FPT AI (Miễn phí) cho cả STT và TTS tại: https://fpt.ai/

2.2. Đăng ký Acc Viettel AI (Miễn phí) cho cả STT và TTS tại: https://viettelgroup.ai/en

2.3. Đăng ký Acc Zalo AI (Miễn phí) cho cả STT và TTS tại: https://zalo.ai/user-profile


### Cấu hình STT &TTS

3.1. Cấu hình STT Engine

Tìm đến các giá trị tương ứng với các stt_engine và bổ sung thông tin phù hợp như token/api

3.2. TTS Engine

Tìm đến các giá trị tương ứng với các tts_engine và bổ sung thông tin phù hợp như token/api

