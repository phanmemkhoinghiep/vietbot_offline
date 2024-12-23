[![trophy](https://github-profile-trophy.vercel.app/?username=phanmemkhoinghiep&theme=onedark)](https://github.com/phanmemkhoinghiep/vietbot_offline)
# vietbot_offline
Phiên bản chính thức

Xử lý hoàn toàn tại chỗ không liên kết tới máy chủ vietbot

# Sơ đồ luồng xử lý của Vietbot

```sh
+---+   +----------------+   +---+   +---+                           +---+
|Mic|-->|Audio Processing|-->|KWS|-->|STT|-------------------------->|NLU|
+---+   +----------------+   +---+   +---+                           +-+-+
                                                                       |
                                                                       |
+-------+   +--------+   +-------------+    +----------------------+   |
|Speaker|<--|Playback|<-- File Path/Link|<--|Knowledge/Skill/Action|<--+
+-------+   +--------+   +-------------+    +----------------------+

```
Mic: Phần cứng để ghi âm, vietbot hỗ trợ tất cả các loại phần cứng Mic mà hệ điều hành Linux/Windows nhận diện được

Audio Processing: Tùy chọn Có/Không có tùy thuộc vào phần cứng của Micro bao gồm Acoustic Echo Cancellation (AEC), Beamforming, Noise Suppression (NS)..vv 

Keyword Spotting (KWS): Cơ chế phát hiện hotword để kích hoạt chế độ lắng nghe dòng lệnh. Vietbot sử dụng cơ chế của Picovoice(porcupine)

Speech To Text (STT): Cơ chế lắng nghe âm thanh và trả về text tức thời. Vietbot sử dụng cơ chế STT của Google, Viettel...

Natural Language Understanding (NLU): Phân tách các text thành các cấu trúc ra lệnh. Vietbot sử dụng hai đối tượng Action/Object đã được khai báo sẵn, cũng như có thể bổ sung để phân tách các cấu trúc ra lệnh

Knowledge/Skill/Action: Các Skill, chia thành Skill xử lý tại chỗ hoặc xử lý trên Cloud, các Skill là các Module xử lý để cho ra câu trả lời.

File Path: Đường dẫn file sinh ra từ cơ chế tổng hợp âm thanh các câu trả lời hoặc đường dẫn File nhạc có sẵn trên thẻ dựa theo kết quả trả lời từ Skill

Link: Link online theo kết quả trả về từ các Skill

Playback: Cơ chế phát nhạc theo đường dẫn File hoặc link, hỗ trợ tiếp tục nhận lệnh trong khi đang Playback

Speaker: Phần cứng phát âm thanh

![DANH SÁCH PHẦN CỨNG TƯƠNG THÍCH](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/hardware_guide/hardware_compatibility_list.md) =>
![ĐỘ PHẦN CỨNG](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/diy_smart_speaker_guide/GH_Mini_Mod_Complete_Guide.md) =>
![FLASH THẺ NHỚ](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/021_software_enviroment_installation_guide.md) => 
![CÀI MỚI TỪ ĐẦU](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/022_software_enviroment_installation_guide.md) => 
![CÀI ĐẶT, CẬP NHẬT PHẦN MỀM](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/03_software_install_update_guide.md) => 
![CẤU HÌNH STT VÀ TTS](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/04_stt_and_tts_configuration_guide.md) => 
![CẤU HÌNH HOTWORD](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/05_hotword_configuration.guide) =>
![CÁCH CHẠY](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/06_running_guide.md) =>
![WIFI-CONNECT](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/08_auto_wifi-connect.md)> =>
![LOA TTS](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/09_real_time_tts.md)> =>
![ĐIỀU KHIỂN HASS](https://github.com/phanmemkhoinghiep/vietbot_offline/blob/beta/12_homeassistant_configuration_guide.md)> =>

