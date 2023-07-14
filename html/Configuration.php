<?php
//Code By: Vũ Tuyển
//Facebook: https://www.facebook.com/TWFyaW9uMDAx
//Bỏ qua hiển thị lỗi trên màn hình nếu có
@error_reporting(0);
@date_default_timezone_set('Asia/Ho_Chi_Minh');
//Nhóm Facebook và GITHUB, UI VietBot
$FacebookGroup = "https://www.facebook.com/groups/1082404859211900";
$GitHub_VietBot_OFF = "https://github.com/phanmemkhoinghiep/vietbot_offline";
$UI_VietBot = "https://github.com/marion001/UI_VietBot";
$Vietbot_Version = "https://raw.githubusercontent.com/phanmemkhoinghiep/vietbot_offline/beta/src/version.json";

//Mật Khẩu Đăng Nhập Phần Quản Lý File
$Pass_Login = "admin";

//Đường dẫn tới thư mục chứa các file json: /home/pi/vietbot_offline/src/
$DuognDanThuMucJson = "/home/pi/vietbot_offline/src"; //Để Mặc Định
$DuognDanUI_HTML = "/var/www/html"; 				   //Để Mặc Định
$directorySound = '/home/pi/vietbot_offline/src/sound/default/'; // Đường dẫn tới thư mục chứa các tệp tin .mp3

//SSH Tải Khoản, Mật Khẩu Đăng Nhập SSH (Bắt Buộc Phải Nhập Để Dùng Các Lệnh Hệ Thống)
$SSH_TaiKhoan = "pi"; //Tài Khoản Đăng Nhập pi SSH Của Bạn
$SSH_MatKhau = "21041997"; //Nật Khẩu Đăng Nhập pi SSH Của Bạn
$SSH_Port = "22"; //Mặc Định: "22"

//Thông Báo Lỗi Khi Kết Nối SSH
$E_rror = "<center><h1>Đăng Nhập SSH Thất Bại, Kiểm Tra Lại Tài Khoản Hoặc Mật Khẩu</h1></center>";
$E_rror_HOST = "<center><h1>Không thể kết nối tới máy chủ SSH, Kiểm Tra lại ip</h1></center>";

//Giới hạn file backup Firmware src Vietbot tar.gz (Khi Cập Nhật Firmware)
$maxBackupFiles = 10;

//Giới hạn ngày kỷ niệm: 10 giá trị
$Limit_NgayKyNiem = "15"; 

//Giới Hạn Số Lượng Báo, Tin Tức: 3 giá trị
$Limit_BaoTinTuc = "5"; 

//Giới hạn số lượng Danh Bạ Người Gửi Tele
$Limit_Telegram = "3"; 

//Giới hạn Phản Hồi Khi Được Đánh Thức
$Limit_Wakeup_Reply = "7";

//giới hạn số lượng file config cần backup (Khi Nội Dụng config.json bị thay đổi)
//các file backup config.json nằm trong đường dẫn: /var/www/html/include_php/Backup_Config
$Limit_Config_Backup = "10";

//Limit Radio Đài Báo
$Limit_Radio = "10";

//Limit Nội Dung Thông Báo Chờ
$Limit_Pre_Answer = "3";

//Đọc, lấy vài dữ liệu của config.json
$jsonSKILL = file_get_contents("$DuognDanThuMucJson"."/skill.json");
$Data_Json_Skill = json_decode($jsonSKILL);


$jsonDatazXZ = file_get_contents("$DuognDanThuMucJson"."/config.json");
$dataVTGET = json_decode($jsonDatazXZ);


$PORT_CHATBOT = $dataVTGET->smart_config->web_interface->port;
$MYUSERNAME = $dataVTGET->smart_config->user_info->name;

$wards_Lang = $dataVTGET->smart_config->user_info->address->wards; //Xã
$wards_Huyen = $dataVTGET->smart_config->user_info->address->district;
$wards_Tinh = $dataVTGET->smart_config->user_info->address->province;

$apiKeyWeather = $Data_Json_Skill->weather->openweathermap_key;

$HostName = gethostname();
$PHP_SELF = $_SERVER['PHP_SELF'];
$GET_current_USER = get_current_user();
$serverIP = $_SERVER['SERVER_ADDR'];

?>
