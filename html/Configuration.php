<?php
//Code By: Vũ Tuyển
//Facebook: https://www.facebook.com/TWFyaW9uMDAx
//Bỏ qua hiển thị lỗi trên màn hình nếu có
//Mail: vietbotsmartspeaker@gmail.com
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
@error_reporting(0);
@date_default_timezone_set('Asia/Ho_Chi_Minh');
ini_set('memory_limit', '256M');
// Khởi động session

$session_expiration = 86400; //Cài đặt thời gian sống của session cookie thành 1 ngày 1 ngày (1 giờ = 3600 giây)
session_set_cookie_params($session_expiration);
session_start();

$SESSION_ID_Name = "Marion001"; //để nguyên
$HostName = gethostname();
$PHP_SELF = $_SERVER['PHP_SELF'];
$GET_current_USER = get_current_user();
$serverIP = $_SERVER['SERVER_ADDR'];

//Nhóm Facebook và GITHUB, UI VietBot, Version
$FacebookGroup = "https://www.facebook.com/groups/1082404859211900";
$GitHub_VietBot_OFF = "https://github.com/phanmemkhoinghiep/vietbot_offline";
$UI_VietBot = "https://github.com/marion001/UI_VietBot";
$Vietbot_Version = "https://raw.githubusercontent.com/phanmemkhoinghiep/vietbot_offline/beta/src/version.json";
$UI_Version = "https://raw.githubusercontent.com/marion001/UI_VietBot/main/version.json";

//list Url Dowload thư viện
//lib Google APIs Client PHP
$url_lib_GDrive = 'https://raw.githubusercontent.com/marion001/Google-APIs-Client-Library-PHP/main/lib_Google_APIs_Client_php.tar.gz';

$apiUrlporcupine = "https://api.github.com/repos/Picovoice/porcupine/releases";

//Mật Khẩu Đăng Nhập Trình Quản Lý File Manager
$Pass_Login_File_Manager = "admin"; // admin

//Cấu Hình Send Mail
//App Passwords: https://myaccount.google.com/apppasswords
//Tài Khoản Gmail
$Mail_Gmail = "dmlldGJvdHNtYXJ0c3BlYWtlckBnbWFpbC5jb20="; //Giữ Nguyên  B64
//Key App Passwords (Thay Cho Mật Khẩu) Của Gmail
$Mail_APP_Passwords = "Y2J1aWZjemJwZGx0enRpZg==";  //Giữ Nguyên  B64
$Mail_Host = "smtp.gmail.com";  //Giữ Nguyên
$Mail_Port = 587;  //Giữ Nguyên
$Mail_SMTPSecure = "tls";  //Giữ Nguyên

//cấu hình MQTT (beta)
$MQTT_Server = '192.168.14.17';     				// server mqtt của bạn
$MQTT_Port = "1883";                     			// port mqtt của bạn
$MQTT_UserName = 'hassio';                   	// tài khoản mqtt
$MQTT_Password = 'hassio';                   		// mật khẩu mqtt
$MQTT_Client_ID = 'Vietbot_MQTT_'.$serverIP; 		// đặt danh tính cho client khi kết nối mqtt

//upload MP3 Media Player 
$Upload_Max_Size = "300"; //MB kích thước file .mp3 tải lên tối đa
//Số lượng tệp tối đa được phép tải lên file mp3, quá 20 cần can thiệp trong file php.ini
$maxFilesUploadMp3 = "20"; 
//Key youtube tìm kiếm nhạc mp3 mã hóa base64
$apiKeyYoutube = "QUl6YVN5QXVXZVZueU0zaWphbzVYUEQ2MnpyTVh1QmowSmdMWUF3"; // Thay YOUR_YOUTUBE_API_KEY bằng khóa API YouTube của bạn


$PATH_USER_ROOT = "/home/pi";
//ĐƯờng Dẫn VietBot Chính
$Path_Vietbot_src = $PATH_USER_ROOT.'/vietbot_offline';
//Đường dẫn nhánh để hết mặc định
$DuognDanThuMucJson = $Path_Vietbot_src.'/src';
$DuognDanUI_HTML = $Path_Vietbot_src.'/html';
$PathResources = $Path_Vietbot_src.'/resources';
$directorySound = $Path_Vietbot_src.'/src/sound/default/';
$Lib_Hotword = $Path_Vietbot_src.'/resources/picovoice/lib';
$path_picovoice = $PATH_USER_ROOT.'/.local/lib/python3.9/site-packages/picovoice';

//SSH Tải Khoản, Mật Khẩu Đăng Nhập SSH (Bắt Buộc Phải Nhập Để Dùng Các Lệnh Hệ Thống)
$SSH_TaiKhoan = "pi"; //Tài Khoản Đăng Nhập pi SSH Của Bạn
$SSH_MatKhau = "vietbot"; //Mật Khẩu Đăng Nhập pi SSH Của Bạn
$SSH_Port = "22"; //Mặc Định: "22"

//Thông Báo Lỗi Khi Kết Nối SSH
$E_rror = "<center><h1>Đăng Nhập SSH Thất Bại, Kiểm Tra Lại Tài Khoản Hoặc Mật Khẩu</h1></center>";
$E_rror_HOST = "<center><h1>Không thể kết nối tới máy chủ SSH, Kiểm Tra lại ip</h1></center>";

//Giới hạn file backup Firmware src Vietbot tar.gz (Khi Cập Nhật Firmware)
$maxBackupFiles = "10";

//Giới hạn file backup UI  Vietbot tar.gz (Khi Cập Nhật Firmware)
$maxBackupFilesUI = "5";

//giới hạn tệp backup Google Dirver
$maxBackupGoogleDrive = "10";

//Giới hạn ngày kỷ niệm: 10 giá trị
$Limit_NgayKyNiem = "15"; 

//Giới Hạn Số Lượng Báo, Tin Tức: 3 giá trị
$Limit_BaoTinTuc = "5"; 

//Giới hạn số lượng Danh Bạ Người Gửi Tele
$Limit_Telegram = "3"; 

//Giới hạn Phản Hồi Khi Được Đánh Thức
$Limit_Wakeup_Reply = "7";


//giới hạn Cast
$Limit_Cast = "20";

//Cài Văn Bản Mặc Định Nếu Biến $Limit_Wakeup_Reply bị xóa hết
$Limit_Wakeup_Reply_Default_Response = "Dạ";

//giới hạn số lượng file config cần backup (Khi Nội Dụng config.json bị thay đổi ở dao diện)
$Limit_Config_Backup = "10";

//giới hạn số lượng file config cần backup (Khi Nội Dụng config.json bị thay đổi ở dao diện)
$Limit_Skill_Backup = "10";

//Limit Radio Đài Báo
$Limit_Radio = "10";

//Limit Nội Dung Thông Báo Chờ
$Limit_Pre_Answer = "3";

//Thời gian đếm ngược tải lại trang khi update UI và Vietbot
$Page_Load_Time_Countdown = "6"; //Giây

//thời gian đếm ngược đọc log màn hình 1000 = 1 giây
$Log_Load_Time_Countdown = "2000"; //2000 = 2Giây

//thời gian chờ time out media player api
$Time_Out_MediaPlayer_API = "10000"; //4000 bằng 4 giây

///////////////////////////////////////////////////////////////////////////////
//API webui Config Setting
$API_Messenger_Disabled = "Thao tác thất bại, API WEB UI chưa được bật";
$allowedCommands_ALL = "all"; //"all" Biến cho phép chạy tất cả các lệnh
// Danh sách chỉ cho phép chạy các lệnh an toàn khi bỏ chữ "all" bên trên
$allowedCommands = "ls,dir,touch,reboot,uname"; //Tester
$apiKey = 'vietbot'; //api key, user cần mã hóa api key này dạng md5 3f406f61a2b5053b53cda80e0320a60b


///////////////////////////////////////////////////////////////////////////////
$Data_Json_Skill = json_decode(file_get_contents("$DuognDanThuMucJson"."/skill.json"));
$Data_Json_Skilll = json_decode(file_get_contents("$DuognDanThuMucJson"."/skill.json"), true);

$dataVTGET = json_decode(file_get_contents("$DuognDanThuMucJson"."/config.json"));

$dataVersionUI = json_decode(file_get_contents("$DuognDanUI_HTML"."/version.json"));

$dataVersionVietbot = json_decode(file_get_contents("$DuognDanThuMucJson"."/version.json"));

$action_json = json_decode(file_get_contents("$DuognDanThuMucJson"."/action.json"));

$object_json = json_decode(file_get_contents("$DuognDanThuMucJson"."/object.json"));

$state_json = json_decode(file_get_contents("$DuognDanThuMucJson"."/state.json"));

//$api_vietbot = json_decode(file_get_contents("/home/pi/vietbot_offline/html/assets/json/api_list_vietbot.json"));


$PORT_CHATBOT = $dataVTGET->smart_config->web_interface->port;
$MYUSERNAME = $dataVTGET->smart_config->user_info->name;
$Web_UI_Login = $dataVTGET->smart_config->block_updates->web_ui_login;
$Web_UI_Enable_Api = $dataVTGET->smart_config->block_updates->enable_api;
$Web_UI_Enable_GDrive_Backup = $dataVTGET->smart_config->block_updates->google_drive_backup;

//Vị Trí, Địa Chỉ
$wards_Lang = $dataVTGET->smart_config->user_info->address->wards; 
$wards_Huyen = $dataVTGET->smart_config->user_info->address->district;
$wards_Tinh = $dataVTGET->smart_config->user_info->address->province;

//Lấy Dữ Liệu Config Chặn Cập Nhật
$block_updates_vietbot_program = $dataVTGET->smart_config->block_updates->vietbot_program;
$block_updates_web_ui = $dataVTGET->smart_config->block_updates->web_ui;
//lấy dữ liệu config kiểm tra trạng thái hiển thị log hiện tại
$check_current_log_status = $dataVTGET->smart_config->logging_type;

$Get_hotword_Lang = $dataVTGET->smart_wakeup->hotword[0]->lang;

//Port Vietbot
$Port_Vietbot = $dataVTGET->smart_config->web_interface->port;

$apiKeyWeather = $Data_Json_Skill->weather->openweathermap_key;

$sync_media_player_checkbox = $Data_Json_Skill->ui_media_player->sync_media_player;
$sync_media_player_sync_delay = $Data_Json_Skill->ui_media_player->sync_delay;
//$sync_music_stream = $Data_Json_Skill->ui_media_player->music_stream;
?>
