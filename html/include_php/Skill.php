<?php
//Code By: Vũ Tuyển
//Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../Configuration.php";
$FileSkillJson = "$DuognDanThuMucJson"."/skill.json";
$skillData = file_get_contents($FileSkillJson);
$skillArray = json_decode($skillData, true);
?>
<html>
<head>
    <title><?php echo $MYUSERNAME; ?>, Cấu Hình Skill VietBot</title>
	    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" href="../assets/img/VietBot128.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/4.5.2_css_bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/loading.css">
	<link rel="stylesheet" href="../assets/css/11.3.1_styles_monokai-sublime.min.css">
	<script src="../assets/js/3.5.1_jquery.min.js"></script>
	<script src="../assets/js/1.16.0_umd_popper.min.js"></script>
	<script src="../assets/js/11.3.1_highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
<style>
    body,
    html {
        background-color: #dbe0c9;
        overflow-x: hidden;
        /* Ẩn thanh cuộn ngang */
        
        max-width: 100%;
        /* Ngăn cuộn ngang trang */
    }
    
    .scrollable-content {
        overflow-y: auto;
        max-height: 400px;
        display: none;
    }
    
    ::-webkit-scrollbar {
        width: 5px;
    }
    
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        -webkit-border-radius: 10px;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        -webkit-border-radius: 10px;
        border-radius: 10px;
        background: rgb(251, 255, 7);
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
    }
    
    .popup-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }
    
    .popup-container.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    #popupContent {
        background-color: white;
        padding: 20px;
        border: 1px solid gray;
        border-radius: 5px;
    }
    
    .scrollable-divradio {
        height: 200px;
        overflow: auto;
    }
    
    pre {
        border: 1px solid #ccc;
        border-radius: 5px;
        font-family: 'Courier New', monospace;
        font-size: 14px;
        white-space: pre-wrap;
        overflow: auto;
        /* Thêm thuộc tính này */
    }
    
    #popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
    
    #popup-content {
        background-color: #ffffff00;
        padding: 5px;
        border-radius: 5px;
        width: 100vw;
        /* Sử dụng đơn vị vw cho chiều rộng tối đa */
        
        height: 100%;
        overflow: auto;
    }
    
    .thoi-gian-container {
        display: flex;
        align-items: center;
    }
    
    .thoi-gian-container label {
        margin-right: 10px;
    }
    
    .thoi-gian-container select {
        padding: 5px;
    }
</style>
<style>
    /* CSS cho popup */
    
    .popup-hass {
        display: none;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 8;
    }
    /* CSS cho nội dung popup */
    
    .popup-hass-content {
        margin: 10px;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        /* Hiển thị nội dung dưới dạng cột */
        
        align-items: center;
        justify-content: center;
        position: relative;
        top: 50%;
        /* Dịch phần trên của popup lên 50% của màn hình */
        
        transform: translateY(-50%);
        /* Điều chỉnh phần trên của popup lên trên */
    }
    /* CSS cho nút đóng */
    
    .close-button {
        cursor: pointer;
        position: absolute;
        bottom: 10px;
        /* Đặt nút ở dưới cùng */
        
        right: 50%;
    }
</style>
	</head>
	<body>
	    <div id="loading-overlay">
          <img id="loading-icon" src="../assets/img/Loading.gif" alt="Loading...">
		  <div id="loading-message">Đang Thực Thi...</div>
    </div>
	<script>
	$(document).ready(function() {
    $('#my-form').on('submit', function() {
        // Hiển thị biểu tượng loading
        $('#loading-overlay').show();

        // Vô hiệu hóa nút gửi
        $('#submit-btn').attr('disabled', true);
    });
});
</script>


<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['root_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập (index.php)
    //header("Location: ./index.php");
	echo "<br/><center><h1>Có Vẻ Như Bạn Chưa Đăng Nhập!<br/><br>
	- Nếu Bạn Đã Đăng Nhập, Hãy Nhấn Vào Nút Dưới<br/><br/><a href='$PHP_SELF'><button type='button' class='btn btn-danger'>Tải Lại</button></a></h1>
	</center>";
    exit();
}
?>


<?php
// Đường dẫn đến thư mục "Backup_Config"
$backupDirz = "Backup_Skill/";
$fileLists = glob($backupDirz . "*.json");
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['selectedFile']) && !empty($_GET['selectedFile'])) {
            $selectedFile = $_GET['selectedFile'];
            $skillFile = $DuognDanThuMucJson . "/skill.json";
            $fileContent = file_get_contents($selectedFile);
            file_put_contents($skillFile, $fileContent);
			header("Location: ".$PHP_SELF);
            exit();
            //echo "Đã Khôi Phục File config.json Được Chọn Thành Công.";
        }}
	//END Khôi Phục File skill	
// Kiểm tra nếu form đã được gửi
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['skill_saver'])) {
		-
	//Backup Skill
	$backupDir = __DIR__ . '/Backup_Skill/';
	if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
	}
$backups = glob($backupDir . '*.json');
$numBackups = count($backups);
if ($numBackups >= $Limit_Skill_Backup) {
    // Sắp xếp các tệp sao lưu theo thứ tự tăng dần về thời gian
    usort($backups, function ($a, $b) {
        return filemtime($a) - filemtime($b);
    });
    // Xóa các tệp sao lưu cũ nhất trừ tệp config_default.json và số lượng tệp cần giữ lại
    $keepBackups = ['skill_default.json']; //Bỏ qua file
    $numToDelete = $numBackups - $Limit_Skill_Backup;
    $backupsToDelete = array_slice($backups, 0, $numToDelete);
    foreach ($backupsToDelete as $backup) {
        if (!in_array(basename($backup), $keepBackups)) {
            unlink($backup);
        }
    }
}
$backupFile = $backupDir . 'backup_skill_' . date('d-m-Y_H:i:s') . '.json';
copy($FileSkillJson, $backupFile);
chmod($backupFile, 0777);
	// echo "Đã sao chép thành công tệp tin skill.json sang $backupFile";
	//END Backup Skill
    $anniversary_data = $skillArray['anniversary_data'];
    $new_anniversary_data = [];
    $count = min(count($_POST['namei']), count($_POST['day']), count($_POST['month']));
    for ($i = 0; $i < $count; $i++) {
        $name = $_POST['namei'][$i];
        $day = $_POST['day'][$i];
        $month = $_POST['month'][$i];
        $is_lunar_calendar = isset($_POST['is_lunar_calendar'][$i]) ? true : false;
        if (!empty($name) && !empty($day) && !empty($month)) {
            $new_anniversary_data[] = [
                'name' => $name,
                'day' => $day,
                'month' => $month,
                'is_lunar_calendar' => $is_lunar_calendar
            ];
        }
    }
    // Thay thế hoặc thêm mới các giá trị trong anniversary_data
    $skillArray['anniversary_data'] = $new_anniversary_data;
	//telegramData
	$telegramData = $skillArray['telegram_data'];
    $newTelegramData = [];
    $count = min(count($_POST['name']), count($_POST['chat_id']));
    for ($i = 0; $i < $count; $i++) {
        $name = $_POST['name'][$i];
        $chatId = $_POST['chat_id'][$i];

        if (!empty($name) && !empty($chatId)) {
            $newTelegramData[] = [
                'name' => $name,
                'chat_id' => $chatId
            ];
        }
    }
    $skillArray['telegram_data'] = $newTelegramData;
    // Hiển thị thông báo thành công
	// tin tức
		$news_Data = $skillArray['news_data'];
    $newNewsData = [];
    $count = min(count($_POST['name_tintuc']), count($_POST['link_tintuc']));
    for ($i = 0; $i < $count; $i++) {
        $name_tintuc = $_POST['name_tintuc'][$i];
        $link_tintuc = $_POST['link_tintuc'][$i];
        if (!empty($name_tintuc) && !empty($link_tintuc)) {
            $newNewsData[] = [
                'name' => $name_tintuc,
                'link' => $link_tintuc
            ];
        }
    }
    $skillArray['news_data'] = $newNewsData;
	// end tin tức
//Radio
    $radioList = $_POST["radio"];
    // Xóa các đài phát thanh nếu nội dung trong input rỗng
    foreach ($radioList as $index => $radio) {
        $name = $radio["name"];
        $link = $radio["link"];

        // Kiểm tra nội dung trong input
        if (empty($name) || empty($link)) {
            // Xóa đài khỏi mảng radio_data
            unset($skillArray["radio_data"][$index]);
        } else {
            // Cập nhật nội dung đài
            $skillArray["radio_data"][$index]["name"] = $name;
            $skillArray["radio_data"][$index]["link"] = $link;
        }
    }
    // Loại bỏ các phần tử null trong mảng radio_data
    $skillArray["radio_data"] = array_values($skillArray["radio_data"]);
    // Kiểm tra số lượng đài đã đạt đến giới hạn hay chưa
    if (count($skillArray["radio_data"]) < 10) {
        // Lấy dữ liệu đài mới
        $newRadioName = $_POST["new_radio"]["name"];
        $newRadioLink = $_POST["new_radio"]["link"];

        // Kiểm tra nội dung đài mới
        if (!empty($newRadioName) && !empty($newRadioLink)) {
            // Thêm đài mới vào mảng radio_data
            $newRadio = [
                "name" => $newRadioName,
                "link" => $newRadioLink
            ];
            $skillArray["radio_data"][] = $newRadio;
        }
    }
//END Radio
    // Lấy giá trị từ form
	// Google Assistant Mode
	$Google_Assistant_Mode = isset($_POST['gg_ass_Mode']) && $_POST['gg_ass_Mode'] === 'on' ? "default" : "manual";
	//openweathermap
    $openweathermapKey = @$_POST['openweathermap_key'];
    $active = isset($_POST['active']) && $_POST['active'] === 'on' ? true : false;
	//Hass
    $HassKey = @$_POST['hass_key'];
    $HassUrl = @$_POST['hass_url'];
    $HassDisplay_Full_State = isset($_POST['hass_display_full_state']) ? true : false;
    $activeHass = isset($_POST['activeHass']) && $_POST['activeHass'] === 'on' ? true : false;
	//Chat GPT
	$ChatGptKey = @$_POST['chatgpt_key'];
	//Google Brand
	$Google_bard_Secure1PSID = @$_POST['Secure-1PSID'];
	$Google_bard_Secure_1PSIDTS = @$_POST['Secure-1PSIDTS'];
	$Google_bard_Secure_1PSIDCC = @$_POST['Secure-1PSIDCC'];
	
	//Telegram
	$activeTelegram = isset($_POST['activeTelegram']) && $_POST['activeTelegram'] === 'on' ? true : false;
	$TelegramKey = @$_POST['telegram_key'];


    // Cập nhật giá trị trong mảng 
	//skillArray openweathermap
    $skillArray['weather']['openweathermap_key'] = $openweathermapKey;
    $skillArray['weather']['active'] = $active;
	//Hass
    $skillArray['hass']['token'] = $HassKey;
    $skillArray['hass']['url'] = $HassUrl;
    $skillArray['hass']['display_full_state'] = $HassDisplay_Full_State;
    $skillArray['hass']['active'] = $activeHass;
	//ChatGPT
    $skillArray['chatgpt']['token'] = $ChatGptKey;
	//Camera hanet
	$activeCameraHanet = isset($_POST['activeCameraHanet']) && $_POST['activeCameraHanet'] === 'on' ? true : false;
	
	$hanet_agent_start_time = $_POST['hanet_agent_start_time_hour'].':'.$_POST['hanet_agent_start_time_minute'];
	$hanet_agent_end_time = $_POST['hanet_agent_end_time_hour'].':'.$_POST['hanet_agent_end_time_minute'];
	
	$hanet_partner_start_time = $_POST['hanet_partner_start_time_hour'].':'.$_POST['hanet_partner_start_time_minute'];
	$hanet_partner_end_time = $_POST['hanet_partner_end_time_hour'].':'.$_POST['hanet_partner_end_time_minute'];
	
	$hanet_stranger_start_time = $_POST['hanet_stranger_start_time_hour'].':'.$_POST['hanet_stranger_start_time_minute'];
	$hanet_stranger_end_time = $_POST['hanet_stranger_end_time_hour'].':'.$_POST['hanet_stranger_end_time_minute'];
		//Người Nhà/Nhân Viên
	$skillArray['hanet']['agent']['number'] = intval($_POST['hanet_agent_number']);
	$skillArray['hanet']['agent']['content'] = $_POST['hanet_agent_content'];
	$skillArray['hanet']['agent']['start_time'] = $hanet_agent_start_time;
	$skillArray['hanet']['agent']['end_time'] = $hanet_agent_end_time;
		//Người Quen/Đối Tác
	$skillArray['hanet']['partner']['number'] = intval($_POST['hanet_partner_number']);
	$skillArray['hanet']['partner']['content'] = $_POST['hanet_partner_content'];
	$skillArray['hanet']['partner']['start_time'] = $hanet_partner_start_time;
	$skillArray['hanet']['partner']['end_time'] = $hanet_partner_end_time;
		//Người Lạ/Khách
	$skillArray['hanet']['stranger']['number'] = intval($_POST['hanet_stranger_number']);
	$skillArray['hanet']['stranger']['content'] = $_POST['hanet_stranger_content'];
	$skillArray['hanet']['stranger']['start_time'] = $hanet_stranger_start_time;
	$skillArray['hanet']['stranger']['end_time'] = $hanet_stranger_end_time;
	
	
	//Google Brand
    $skillArray['gg_bard']['Secure-1PSID'] = $Google_bard_Secure1PSID;
    $skillArray['gg_bard']['Secure-1PSIDTS'] = $Google_bard_Secure_1PSIDTS;
    $skillArray['gg_bard']['Secure-1PSIDCC'] = $Google_bard_Secure_1PSIDCC;
	// Google Asssitant Mode
    $skillArray['gg_ass']['mode'] = $Google_Assistant_Mode;
	//Lưu Chế Độ Ưu Tiên
	$skillArray['external_bot']['priority_1'] = @$_POST['priority1'];
	$skillArray['external_bot']['priority_2'] = @$_POST['priority2'];
	$skillArray['external_bot']['priority_3'] = @$_POST['priority3'];
	//Lưu Chế Độ Ưu Tiên Media Player
	$skillArray['music_source']['priority_1'] = @$_POST['music_source_priority1'];
	$skillArray['music_source']['priority_2'] = @$_POST['music_source_priority2'];
	$skillArray['music_source']['priority_3'] = @$_POST['music_source_priority3'];
	//Telegram
    $skillArray['telegram']['token'] = $TelegramKey;
    $skillArray['telegram']['active'] = $activeTelegram;
	//Camera Hanet
    $skillArray['hanet']['active'] = $activeCameraHanet;
    // Chuyển đổi mảng PHP thành JSON
    //$updatedSkillData = json_encode($skillArray, JSON_PRETTY_PRINT);
    $updatedSkillData = json_encode($skillArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    // Lưu dữ liệu vào file skill.json
    file_put_contents($FileSkillJson, $updatedSkillData);
	//shell_exec('systemctl --user restart vietbot');
}
	//Chmod sét full quyền
if (isset($_POST['set_full_quyen'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream1 = ssh2_exec($connection, "sudo chmod -R 0777 $Path_Vietbot_src");
$stream2 = ssh2_exec($connection, "sudo chown -R pi:pi $Path_Vietbot_src");
stream_set_blocking($stream1, true); 
stream_set_blocking($stream2, true); 
$stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO); 
$stream_out2 = ssh2_fetch_stream($stream2, SSH2_STREAM_STDIO); 
stream_get_contents($stream_out1); 
stream_get_contents($stream_out2); 
header("Location: $PHP_SELF"); exit;
}


	//Chmod sét full quyền
if (isset($_POST['check_home_assistant'])) {

$homeAssistantUrl = 'http://192.168.14.17:8123/api'; // URL của Home Assistant API
$accessToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiI3MGJkNmMzOTNhYTY0ZTJhODQwZDE5ZGNjZGQzNDQwZSIsImlhdCI6MTY4Nzk3MDQ2OSwiZXhwIjoyMDAzMzMwNDY5fQ.Baz2jYShPIT4Mo7rGu_ekuRtqr07BnCGJKDfjG0ifzc'; // Token truy cập của bạn

// Tạo một yêu cầu HTTP GET để lấy danh sách các thiết bị từ Home Assistant
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $homeAssistantUrl . '/config');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken,
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

// Kiểm tra mã trạng thái HTTP
$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

echo $response;


}



//////////////////////////Khôi Phục Gốc Skill.Json
if (isset($_POST['restore_skill_json'])) {
$sourceFile = $DuognDanUI_HTML.'/assets/json/skill.json';
$destinationFile = $DuognDanThuMucJson.'/skill.json';
// Kiểm tra xem tệp nguồn tồn tại
if (file_exists($sourceFile)) {
	shell_exec("rm $destinationFile");
    // Thực hiện sao chép bằng lệnh cp
    $command = "cp $sourceFile $destinationFile";
    $output = shell_exec($command);
	shell_exec("chmod 0777 $destinationFile");
    // Kiểm tra kết quả
    if ($output === null) {
        echo "<center>Khôi Phục Gốc <b>skill.json</b> thành công!</center>";
    } else {
        echo "<center>Đã xảy ra lỗi khi khôi phục gốc <b>skill.json</b> : $output</center>";
    }
} else {
    echo "<center>Tệp gốc <b>skill.json</b> không tồn tại!</center>";
}
header("Location: $PHP_SELF"); exit;
}
// Thư mục cần kiểm tra 777
$directories = array(
    "$Path_Vietbot_src"
);
function checkPermissions($path, &$hasPermissionIssue) {
    $files = scandir($path);
    foreach ($files as $file) {
		// bỏ qua thư mục tts_saved check quyền
        if ($file === '.' || $file === '..' || $file === 'tts_saved' || $file === '__pycache__') {continue;}
        $filePath = $path . '/' . $file;
        $permissions = fileperms($filePath);
        if ($permissions !== false && ($permissions & 0777) !== 0777) {
            if (!$hasPermissionIssue) {
               // echo "<br/><center><h3 class='text-danger'>Một Số File,Thư Mục Trong <b>$path</b> Không Có Quyền Can Thiệp.<h3><br/>";
			   echo "<br/><br/><br/><center>Phát hiện thấy một số nội dung bị thay đổi quyền hạn.<br/><br/>";
			echo " <form id='my-form'  method='POST'><button type='submit' name='set_full_quyen' class='btn btn-success'>Cấp Quyền Cho File, Thư Mục</button></center></form>";
			
                $hasPermissionIssue = true;
				exit();
			}	
            break;}
        if (is_dir($filePath)) {
            checkPermissions($filePath, $hasPermissionIssue);
        }}}
// Kiểm tra từng thư mục
foreach ($directories as $directory) {
    $hasPermissionIssue = false;
    checkPermissions($directory, $hasPermissionIssue);
}
if (json_last_error() !== JSON_ERROR_NONE) {
	echo "";
     echo "<center><h1> <font color=red>Phát hiện lỗi, cấu trúc tập tin skill.json không hợp lệ!</font></h1><br/>- Mã Lỗi: <b>" . json_last_error_msg()."</b><br/><br/>";
	echo "Hướng Dẫn Khắc Phục 1 Trong Các Gợi Ý Dưới Đây:<i><br>- Bạn cần sửa trực tiếp trên file<br/>- Chọn <b>các file sao lưu trước đó</b><br/>- Nhấn vào nút <b>Khôi Phục Gốc</b> bên dưới để về trạng thái khi mới flash</i>";
	echo "<br/><i>(Lưu Ý: khi chọn <b>Khôi Phục Gốc</b> bạn cần cấu hình lại các tác vụ trong skill.json đã lưu trước đó.)</i><br/>";
	echo '<br/><div class="form-check form-switch d-flex justify-content-center">';
// Kiểm tra xem có file nào trong thư mục hay không
if (count($fileLists) > 0) {
    // Tạo dropdown list để hiển thị các file
    echo '<form id="my-form" method="get"><div class="input-group">';
    echo '<select class="custom-select" id="inputGroupSelect04" name="selectedFile">';
    echo '<option value="">Chọn file backup skill</option>'; // Thêm lựa chọn "Chọn file"
    foreach ($fileLists as $file) {
        $fileName = basename($file);
        echo '<option value="' . $file . '">' . $fileName . '</option>';
    }
    echo '</select><div class="input-group-append">';
    echo '<input type="submit" class="btn btn-warning" title="Khôi Phục Lại File skill.json trước đó đã sao lưu" value="Khôi Phục/Recovery">';
    echo ' </div></div></form><form id="my-form"  method="POST"><button type="submit" name="restore_skill_json" class="btn btn-danger">Khôi Phục Gốc</button></center></form></div>';
}
 else {
    echo "Không tìm thấy file backup skill trong thư mục.";
}
    exit(); // Kết thúc chương trình
}
?>





<!-- Form để hiển thị và chỉnh sửa dữ liệu -->
<form id="my-form" onsubmit="return vuTuyen();"  method="POST">
<h5>Open Weather Map: <i class="bi bi-info-circle-fill" onclick="togglePopupOpenWeatherMap()" title="Nhấn Để Tìm Hiểu Thêm"></i></h5>
      <div id="popupContainerOpenWeatherMap" class="popup-container" onclick="hidePopupOpenWeatherMap()">
    <div id="popupContent" onclick="preventEventPropagationOpenWeatherMap(event)">
      <center><b>Open Weather Map Skill</b></center><br/>
	 - <b>Switch On/Off:</b> để bật và tắt skill tương ứng với (active=true/false)<br/>
	 - <b>Key OpenWeatherMap:</b> Nhập key OpenWeatherMap của bạn vào<br/>
	 - <b>Trang Chủ:</b> <a href="https://openweathermap.org/" target="_bank">https://openweathermap.org/</a><br/>
	 <br/>
    </div>
  </div>
    <div class="form-group">
<!-- <label for="active">Active:</label> -->
<div class="row justify-content-center">
<div class="col-auto">
<div class="custom-control custom-switch" title="Bật/Tắt để kích hoạt/huỷ kích hoạt">
<input type="checkbox" class="custom-control-input" id="active" name="active" <?php echo $skillArray['weather']['active'] ? 'checked' : ''; ?>>
<label class="custom-control-label" for="active"></label></div></div></div></div>
<div class="form-group" id="extraData" <?php echo $skillArray['weather']['active'] ? '' : 'style="display: none;"'; ?>>
<!-- Thẻ div hiển thị khi nút bật được chọn -->
<div class="row justify-content-center"><div class="col-auto">
<table class="table table-responsive table-striped table-bordered align-middle">
<tbody>
<tr>
<th scope="row"> <label for="openweathermap_key">Token OpenWeatherMap:</label></th>
<td><input type="text" class="form-control" id="openweathermap_key" name="openweathermap_key" placeholder="Nhập Key Của OpenWeatherMap" title="Nhập Key Của OpenWeatherMap" value="<?php echo $skillArray['weather']['openweathermap_key']; ?>"></td>
</tr>
</tbody>
</table>
</div></div>
<!-- kết thúc ẩn hiện thẻ div -->
</div>
<hr/>
<h5>HomeAssistant (Hass): <i class="bi bi-info-circle-fill" onclick="togglePopupHass()" title="Nhấn Để Tìm Hiểu Thêm"></i></h5>
      <div id="popupContainerHass" class="popup-container" onclick="hidePopupHass()">
    <div id="popupContent" onclick="preventEventPropagationHass(event)">
      <center><b>HomeAssistant Skill</b></center><br/>
	 - <b>URL:</b> Nhập Url HomeAssistant của bạn kèm port VD: http://192.168.14.104:8123<br/>
	 - <b>Token:</b> Nhập token của HomeAssistant<br/>
	 - <b>Display Full State:</b> Câu trả lời có thêm chi tiết về thiết bị (nếu được tích)<br/>
<br/></div></div>
<div class="row justify-content-center">
<div class="col-auto">
<div class="custom-control custom-switch" title="Bật/Tắt để kích hoạt/huỷ kích hoạt">
<input type="checkbox" class="custom-control-input" id="activeHass" name="activeHass" <?php echo $skillArray['hass']['active'] ? 'checked' : ''; ?>>
<label class="custom-control-label" for="activeHass"></label></div></div></div>
<div class="form-group" id="extraDataHass" <?php echo $skillArray['hass']['active'] ? '' : 'style="display: none;"'; ?>>
<div class="alert">
<div class="row justify-content-center"><div class="col-auto">	 
 <table class="table table-responsive table-striped table-bordered align-middle">
<tbody>
<tr><th scope="row"> <label>URL:</label></th>
<td><input type="text" class="form-control" id="hass_url" name="hass_url" placeholder="http://192.168.14.104:8123" title="Nhập Url Của HomeAssistant" value="<?php echo $skillArray['hass']['url']; ?>"></td>
</tr><tr>
<th scope="row"> <label>Token Hass:</label></th>
<td><input type="text" class="form-control" id="hass_key" name="hass_key" placeholder="Nhập Key Của HomeAssistant" title="Nhập Key Của HomeAssistant" value="<?php echo $skillArray['hass']['token']; ?>"></td>
</tr>
<tr>
<th scope="row"> <label title="Câu Trả Lời Có Thêm Chi Tiết Về Thiết Bị">Display Full State:</label></th>
<td><input type="checkbox" id="hass_display_full_state" name="hass_display_full_state" title="Tích Để Bật/Tắt" <?php echo $skillArray['hass']['display_full_state'] ? 'checked' : ''; ?>></td>
</tr>

<tr>
<th scope="row" colspan="2"><center>


 <input type="button" id="HomeAssistantshowPopup" class="btn btn-warning" value="Kiểm Tra Kết Nối">

</center></th>
</tr>

</tbody>
</table></div></div></div></div>


	
    <div id="popupHass" class="popup-hass">
	
        <div class="popup-hass-content" id="popupContentHass">
            <!-- Nội dung JSON sẽ được hiển thị ở đây -->
			 
			   
			  
 
        </div>
		 <input type="button"class="close-button btn btn-primary" id="closeButtonHass" value="Đóng">
    </div>
	
	
<hr/>
<h5>Google Bard: <i class="bi bi-info-circle-fill" onclick="togglePopupggbard()" title="Nhấn Để Tìm Hiểu Thêm"></i></h5>
      <div id="popupContainerggbard" class="popup-container" onclick="hidePopupggbard()">
    <div id="popupContent" onclick="preventEventPropagationggbard(event)">
      <center><b>Hướng Dẫn Lấy Session Authentication</b></center><br/>
- Đi tới: <a href="https://bard.google.com/" target="_bank">https://bard.google.com/</a> và đăng nhập tài khoản google<br/>
B1: Nhấn Vào <b>Dùng thử Bard</b> -> kéo hết điều khoản và sử dụng và chọn <b>Tôi Đồng Ý</b><br/>
B2: khi hiện lên thông báo: <b>Bard là một thử nghiệm</b> Nhấn vào <b>Tiếp Tục</b><br/>
B3: Nhấn F12 cho bảng điều khiển hoặc (nhấn chuột phải chọn Kiểm Tra Phần Tử)<br/>
B4: Go to Application -> Cookies -> "__Secure-1PSID" và "__Secure-1PSIDTS" và "__Secure-1PSIDCC"
 
</div> </div>
<div class="row justify-content-center"><div class="col-auto">	 
 <table class="table table-responsive table-striped table-bordered align-middle">
<tbody>
<tr><th scope="row"colspan="2"><center><font color=red>Session Google Bard</font></center></th>
</tr>
<tr><th scope="row"> <label>Secure-1PSID:</label></th>
<td><input type="text" class="form-control" id="Secure-1PSID" name="Secure-1PSID" placeholder="Nhập Cookie Secure-1PSID Của Google bard" title="Nhập Cookie Secure-1PSID Của Google bard" value="<?php echo $skillArray['gg_bard']['Secure-1PSID']; ?>">
</td>
</tr><tr>
<th scope="row"> <label>Secure-1PSIDTS:</label></th>
<td><input type="text" class="form-control" id="Secure-1PSIDTS" name="Secure-1PSIDTS" placeholder="Nhập Cookie Secure-1PSIDTS Của Google bard" title="Nhập Cookie Secure-1PSIDTS Của Google bard" value="<?php echo $skillArray['gg_bard']['Secure-1PSIDTS']; ?>">
</td>
</tr>

<tr>
<th scope="row"> <label>Secure-1PSIDCC:</label></th>
<td><input type="text" class="form-control" id="Secure-1PSIDCC" name="Secure-1PSIDCC" placeholder="Nhập Cookie Secure-1PSIDCC Của Google bard" title="Nhập Cookie Secure-1PSIDCC Của Google bard" value="<?php echo $skillArray['gg_bard']['Secure-1PSIDCC']; ?>">
</td>
</tr>

</tbody>
</table></div></div>
	
	<hr/>
<h5>ChatGPT: <i class="bi bi-info-circle-fill" onclick="togglePopupGPT()" title="Nhấn Để Tìm Hiểu Thêm"></i></h5>
      <div id="popupContainerGPT" class="popup-container" onclick="hidePopupGPT()">
    <div id="popupContent" onclick="preventEventPropagationGPT(event)">
      <center><b>Chat GPT Skill</b></center><br/>
<center>- Chỉ Cần Nhập Token Của ChatGPT<center><br/>
- Đây là skill tích hợp Chat GPT vào vietbot, để dung Chat GPT là trợ lý trả lời các câu hỏi<br/>
- Vào web <a href="https://platform.openai.com/account/api-keys" target="_bank">https://platform.openai.com/account/api-keys</a>, tạo tài khoản, lấy Key<br/>
 và trong tài khoản phải có tiền thì mới dùng được skill.
</div> </div>
<div class="row justify-content-center"><div class="col-auto">	 
 <table class="table table-responsive table-striped table-bordered align-middle">
<tbody><tr>
<th scope="row"> <label for="chatgpt_key">Token ChatGPT:</label></th>
<td><input type="text" class="form-control" id="chatgpt_key" name="chatgpt_key" placeholder="Nhập Token Của ChatGPT" title="Nhập Token Của ChatGPT" value="<?php echo $skillArray['chatgpt']['token']; ?>"></td>
</tr></tbody></table></div></div><hr/>
<h5>Google Assistant: <i class="bi bi-info-circle-fill" onclick="togglePopupGGASS()" title="Nhấn Để Tìm Hiểu Thêm"></i></h5>
      <div id="popupContainerGGASS" class="popup-container" onclick="hidePopupGGASS()">
    <div id="popupContent" onclick="preventEventPropagationGGASS(event)">
      <center><b>Google Assistant Skill:</b></center><br/>
	  - <b>Bật </b> để chạy chế độ Mặc Định (default)<br/>
	  - <b>Tắt </b> để chạy chế độ Thủ Công (manual)
</div></div>
<div class="row justify-content-center"><div class="col-auto">	 
        <div class="custom-control custom-switch" title="Bật/Tắt để kích hoạt/huỷ kích hoạt">
            <input type="checkbox" class="custom-control-input" id="gg_ass_Mode" name="gg_ass_Mode" <?php echo $skillArray['gg_ass']['mode'] === 'default' ? 'checked' : ''; ?>>
            <label class="custom-control-label" for="gg_ass_Mode"></label>
</div></div></div>
<hr/>



<h5>Ưu Tiên Trợ Lý Ảo/AI:</h5>
<?php
	//Get Ưu tiên Trợ Lý Ảo/ AI
	$external_bot_priority_1 = $skillArray['external_bot']['priority_1'];
	$external_bot_priority_2 = $skillArray['external_bot']['priority_2'];
	$external_bot_priority_3 = $skillArray['external_bot']['priority_3'];
?>
<div class="form-check form-switch d-flex justify-content-center">   <div class="col-auto">
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col" colspan="2"><center><font color=red>Chọn Thứ Tự Ưu Tiên Trợ Lý Của Bạn</font></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Top 1:</th>
      <td>    
	  <select class="custom-select" name="priority1" id="priority1">
        <option value="">-- Chọn Trợ Lý/AI 1 --</option>
        <option value="gg_bard" <?php if ($external_bot_priority_1 === "gg_bard") echo "selected"; ?>>Google Bard</option>
        <option value="gg_ass" <?php if ($external_bot_priority_1 === "gg_ass") echo "selected"; ?>>Google Assistant</option>
        <option value="chatGPT" <?php if ($external_bot_priority_1 === "chatGPT") echo "selected"; ?>>Chat GPT</option>
    </select></td>

    </tr>
    <tr>
      <th scope="row">Top 2:</th>
      <td>    
	  <select class="custom-select" name="priority2" id="priority2">
        <option value="">-- Chọn Trợ Lý/AI 2 --</option>
        <option value="gg_bard" <?php if ($external_bot_priority_2 === "gg_bard") echo "selected"; ?>>Google Bard</option>
        <option value="gg_ass" <?php if ($external_bot_priority_2 === "gg_ass") echo "selected"; ?>>Google Assistant</option>
        <option value="chatGPT" <?php if ($external_bot_priority_2 === "chatGPT") echo "selected"; ?>>Chat GPT</option>
    </select></td>

    </tr>
    <tr>
      <th scope="row">Top 3:</th>
      <td>    
	  <select class="custom-select" name="priority3" id="priority3" onchange="vuTuyen()">
        <option value="">-- Chọn Trợ Lý/AI 3 --</option>
        <option value="gg_bard" <?php if ($external_bot_priority_3 === "gg_bard") echo "selected"; ?>>Google Bard</option>
        <option value="gg_ass" <?php if ($external_bot_priority_3 === "gg_ass") echo "selected"; ?>>Google Assistant</option>
        <option value="chatGPT" <?php if ($external_bot_priority_3 === "chatGPT") echo "selected"; ?>>Chat GPT</option>
    </select></td>
    </tr>
  </tbody>
</table>
</div>
</div>
<hr/>


<h5>Ưu Tiên Nguồn Phát Media Player:</h5>
<?php
	//Get Ưu tiên Trợ Lý Ảo/ AI
	$music_source_priority_1 = $skillArray['music_source']['priority_1'];
	$music_source_priority_2 = $skillArray['music_source']['priority_2'];
	$music_source_priority_3 = $skillArray['music_source']['priority_3'];
?>
<div class="form-check form-switch d-flex justify-content-center">   <div class="col-auto">
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col" colspan="2"><center><font color=red>Chọn Thứ Tự Nguồn Phát Media Player</font></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Top 1:</th>
      <td>    
	  <select class="custom-select" name="music_source_priority1" id="music_source_priority1">
        <option value="">-- Chọn Nguồn Phát --</option>
        <option value="local" <?php if ($music_source_priority_1 === "local") echo "selected"; ?>>Local</option>
        <option value="ZingMP3" <?php if ($music_source_priority_1 === "ZingMP3") echo "selected"; ?>>ZingMP3</option>
        <option value="Youtube" <?php if ($music_source_priority_1 === "Youtube") echo "selected"; ?>>Youtube</option>
    </select></td>

    </tr>
    <tr>
      <th scope="row">Top 2:</th>
      <td>    
	  <select class="custom-select" name="music_source_priority2" id="music_source_priority2">
        <option value="">-- Chọn Nguồn Phát --</option>
        <option value="local" <?php if ($music_source_priority_2 === "local") echo "selected"; ?>>Local</option>
        <option value="ZingMP3" <?php if ($music_source_priority_2 === "ZingMP3") echo "selected"; ?>>ZingMP3</option>
        <option value="Youtube" <?php if ($music_source_priority_2 === "Youtube") echo "selected"; ?>>Youtube</option>
    </select></td>

    </tr>
    <tr>
      <th scope="row">Top 3:</th>
      <td>    
	  <select class="custom-select" name="music_source_priority3" id="music_source_priority3" onchange="vuTuyen()">
        <option value="">-- Chọn Nguồn Phát --</option>
        <option value="local" <?php if ($music_source_priority_3 === "local") echo "selected"; ?>>Local</option>
        <option value="ZingMP3" <?php if ($music_source_priority_3 === "ZingMP3") echo "selected"; ?>>ZingMP3</option>
        <option value="Youtube" <?php if ($music_source_priority_3 === "Youtube") echo "selected"; ?>>Youtube</option>
    </select></td>
    </tr>
  </tbody>
</table>
</div>
</div>
<hr/>



<h5>Telegram: <i class="bi bi-info-circle-fill" onclick="togglePopupTelegram()" title="Nhấn Để Tìm Hiểu Thêm"></i></h5>
      <div id="popupContainerTelegram" class="popup-container" onclick="hidePopupTelegram()">
    <div id="popupContent" onclick="preventEventPropagationTelegram(event)">
      <center><b>Telegram Skill</b></center><br/>
<center><i><b>Danh Bạ Người Gửi: </b></i>Nếu Có Thông Báo Giá trị <b>'telegram_data'</b> trong skill.json đã vượt quá <b><?php echo $Limit_Telegram; ?></b> giá trị, bạn cần ssh sửa trực tiếp file skill.json</center><br/>
- <b>Xóa Danh Bạ Người Gửi: </b> Để xóa danh bạ người gửi đã thêm, bạn hãy tìm tới người cần xóa, <br/>sau đó bỏ trống 1 trong 2 ô (<b>"Tên Người Nhận"</b> hoặc <b>"ID Người Nhận"</b>) sau đó nhấn Lưu Cài Đặt Skill.
</div></div>

    <div class="form-group">
	      <div class="row justify-content-center">
    <div class="col-auto">
        <div class="custom-control custom-switch" title="Bật/Tắt để kích hoạt/huỷ kích hoạt">
            <input type="checkbox" class="custom-control-input" id="activeTelegram" name="activeTelegram" <?php echo $skillArray['telegram']['active'] ? 'checked' : ''; ?>>
            <label class="custom-control-label" for="activeTelegram"></label>
</div></div></div></div>
<div class="form-group" id="extraDataTelegram" <?php echo $skillArray['telegram']['active'] ? '' : 'style="display: none;"'; ?>>
<div class="row justify-content-center"><div class="col-auto">
<table class="table table-responsive table-striped table-bordered align-middle">
<tbody><tr>
<th scope="row"> <label for="telegram_key">Token Telegram:</label></th>
<td><input type="text" class="form-control" id="telegram_key" name="telegram_key" placeholder="Nhập Key Của Telegram" title="Nhập Key Của Telegram" value="<?php echo $skillArray['telegram']['token']; ?>"></td>
</tr></tbody></table></div></div>
<div class="row justify-content-center"><div class="col-auto">
<?php
$telegramData = $skillArray['telegram_data'];
$count = count($telegramData);
// Kiểm tra số lượng giá trị trong telegram_skillArray
if ($count > $Limit_Telegram) {
    // Hiển thị thông báo nếu vượt quá 3 giá trị
    echo "<center><i><b>Danh Bạ Người Gửi: </b></i> Giá trị <b>'telegram_data'</b> trong <b>skill.json</b> đã vượt quá $Limit_Telegram giá trị.</center>";
		echo "<div style='display: none;'>";
		
		        foreach ($telegramData as $index => $telegram) {
            $name = $telegram['name'];
            $chatId = $telegram['chat_id'];
			$cxzcewcdszd = $index + 1;
	echo "<tbody><tr><tr><th>Người $cxzcewcdszd:</th><td><input class='form-control' type='text' id='name_$index' name='name[]' value='$name'></td>
		  <td><input class='form-control' type='text' id='chat_id_$index' name='chat_id[]' value='$chatId'></td></tr>";
           
        }
		echo "</div>";
} else {
?>
<table class="table table-responsive table-striped table-bordered align-middle">
  <thead> <tr>
      <th colspan="3"><center>Danh Bạ Người Gửi</center></th>
    </tr></thead><thead><tr><th></th>
 <th><label><center>Tên Người Nhận</center></label></th>
      <th><label><center>ID Người Nhận</center></label></th>
    </tr> </thead>
       <?php
        foreach ($telegramData as $index => $telegram) {
            $name = $telegram['name'];
            $chatId = $telegram['chat_id'];
			$cxzcewcdszd = $index + 1;
	echo "<tbody><tr><tr><th>Người $cxzcewcdszd:</th><td><input class='form-control' type='text' id='name_$index' name='name[]' value='$name'></td>
		  <td><input class='form-control' type='text' id='chat_id_$index' name='chat_id[]' value='$chatId'></td></tr>";
           
        }
        // Hiển thị trường nhập liệu trống để thêm mới
        if ($count < $Limit_Telegram) {
            $newIndex = $count;
			$zxczxq = $newIndex + 1;
			   echo  "<tr><th>Người $zxczxq:</th>
      <td><input class='form-control' type='text' placeholder='Nhập Mới Tên Người Nhận' title='Nhập Tên Người Nhận' id='name_$newIndex' name='name[]'></td>
      <td><input class='form-control' type='text' placeholder='Nhập Mới ID Người Nhận' title='Nhập ID Người Nhận' id='chat_id_$newIndex' name='chat_id[]'</td>
    </tr>";
        }
}
?>
</tbody></table></div></div></div></div><hr/>
<h5>Báo/Tin Tức: <i class="bi bi-info-circle-fill" onclick="togglePopupTINTUC()" title="Nhấn Để Tìm Hiểu Thêm"></i></h5>
      <div id="popupContainerTINTUC" class="popup-container" onclick="hidePopupTINTUC()">
    <div id="popupContent" onclick="preventEventPropagationTINTUC(event)">
      <center><b>Báo/Tin Tức</b></center><br/>
	  - Nhập Tên Báo Và Link Báo Để Thêm Vào File skill.json<br/>
	  - Tối đa được phép thêm <?php echo $Limit_BaoTinTuc; ?> sự kiện<br/>
	  - <b>Xóa Báo/Tin Tức: </b> bạn phải xoá hết các giá trị trong 2 ô: (<b>"Tên Báo"</b> Và <b>"Link Báo"</b>) sau đó nhấn Lưu Cài Đặt
<br/></div></div>
<div class="row justify-content-center"><div class="col-auto">
<?php
$news_Data = $skillArray['news_data'];
$count_news = count($news_Data);

if ($count_news > $Limit_BaoTinTuc ) {
    // Hiển thị thông báo nếu vượt quá 3 giá trị
    echo "<center><i><b>Tin Tức: </b></i> Giá trị <b>'news_data'</b> trong <b>skill.json</b> đã vượt quá $Limit_BaoTinTuc giá trị.</center>";
		echo "<div style='display: none;'>";
		
		        foreach ($news_Data as $new => $news_tintuc) {
            $name_tintuc = $news_tintuc['name'];
            $link_tintuc = $news_tintuc['link'];
			$tintuc_count = $new + 1;
	echo "<tbody><tr><tr><th>Báo $tintuc_count:</th><td><input class='form-control' type='text' id='name_tintuc_$new' name='name_tintuc[]' value='$name_tintuc'></td>
		  <td><input class='form-control' type='text' id='link_tintuc_$new' name='link_tintuc[]' value='$link_tintuc'></td></tr>";
        }
		echo "</div>";
} else {
?>
<table class="table table-responsive table-striped table-bordered align-middle">
  <thead> <tr>
      <th colspan="3"><center><font color=red>Tin Tức</font></center></th>
    </tr></thead><thead><tr><th></th>
 <th><label><center><font color=red>Tên Báo</font></center></label></th>
      <th><label><center><font color=red>Link Báo RSS</font></center></label></th>
    </tr> </thead>
       <?php
	    foreach ($news_Data as $new => $news_tintuc) {
       // foreach ($telegramData as $index => $telegram) {
        $name_tintuc = $news_tintuc['name'];
            $link_tintuc = $news_tintuc['link'];
			$tintuc_count = $new + 1;
		//	$cxzcewcdszd = $index + 1;
		echo "<tbody><tr><tr><th>Báo $tintuc_count:</th><td><input class='form-control' type='text' id='name_tintuc_$new' name='name_tintuc[]' value='$name_tintuc'></td>
		  <td><input class='form-control' type='text' id='link_tintuc_$new' name='link_tintuc[]' value='$link_tintuc'></td></tr>";
      
        }
        // Hiển thị trường nhập liệu trống để thêm mới
        if ($count_news < $Limit_BaoTinTuc ) {
            $newIndextt = $count_news;
			$zxczxqtt = $newIndextt + 1;
			   echo  "<tr><th>Báo $zxczxqtt:</th>
      <td><input class='form-control' type='text' placeholder='Nhập Mới Tên Báo' title='Nhập Tên Báo' id='name_tintuc$newIndextt' name='name_tintuc[]'></td>
      <td><input class='form-control' type='text' placeholder='Nhập Mới Link RSS' title='Nhập Link .RSS' id='link_tintuc_$newIndextt' name='link_tintuc[]'</td>
    </tr>";
        }
}
?>
</tbody></table></div>
</div>
<hr/>
<?php

$value_hanet_agent_start_time_hour = explode(":", $skillArray['hanet']['agent']['start_time'])[0];
$value_hanet_agent_start_time_minute = explode(":", $skillArray['hanet']['agent']['start_time'])[1];

$value_hanet_agent_end_time_hour = explode(":", $skillArray['hanet']['agent']['end_time'])[0];
$value_hanet_agent_end_time_minute = explode(":", $skillArray['hanet']['agent']['end_time'])[1];

//echo $value_hanet_agent_start_time_hour;
?>

<!-- Start Camera Hanet -->
<h5>Camera Hanet:</h5>

    <div class="form-group">
	      <div class="row justify-content-center">
    <div class="col-auto">
        <div class="custom-control custom-switch" title="Bật/Tắt để kích hoạt/huỷ kích hoạt">
            <input type="checkbox" class="custom-control-input" id="activeCameraHanet" name="activeCameraHanet" <?php echo $skillArray['hanet']['active'] ? 'checked' : ''; ?>>
            <label class="custom-control-label" for="activeCameraHanet"></label>
</div></div></div></div>
<div class="form-group" id="extraDataCameraHanet" <?php echo $skillArray['hanet']['active'] ? '' : 'style="display: none;"'; ?>>

<div class="row justify-content-center"><div class="col-auto">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col" colspan="2"><center><font color=red>Camera Hanet: Người Nhà/Nhân Viên</font></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Số Lần Thông Báo:</th>
      <td><input class="form-control" type="number" placeholder="1->100" title="Nhập Số Lần Thông Báo" name="hanet_agent_number" min="1" max="100" step="1" value="<?php echo $skillArray['hanet']['agent']['number']; ?>"></td>
    </tr>
    <tr>
      <th scope="row">Nội Dung:</th>
      <td><input class="form-control" type="text" placeholder="Nhập Nội Dung Thông Báo" title="Nội Dung Thông Báo: <?php echo $skillArray['hanet']['agent']['content']; ?>" name="hanet_agent_content" value="<?php echo $skillArray['hanet']['agent']['content']; ?>"></td>
    </tr>
    <tr>
      <th scope="row" title="Định Dạng = Giờ:Phút">Thời Gian Bắt Đầu:</th>
      <td>
<div class="thoi-gian-container">
<select title="Giờ" class="form-select" name="hanet_agent_start_time_hour">
  <?php
    for ($hanet_agent_start_time_hour = 0; $hanet_agent_start_time_hour <= 11; $hanet_agent_start_time_hour++) {
      $formattedHour_agent_start = str_pad($hanet_agent_start_time_hour, 2, "0", STR_PAD_LEFT);
	  ?>
      <option title="<?php echo $formattedHour_agent_start; ?> Giờ" value="<?php echo $formattedHour_agent_start; ?>" <?php if (explode(":", $skillArray['hanet']['agent']['start_time'])[0] === "$formattedHour_agent_start") echo "selected"; ?>><?php echo $formattedHour_agent_start; ?></option>
	  <?php 
    }
  ?>
</select>:<select title="Phút" class="form-select" name="hanet_agent_start_time_minute">
  <?php
    for ($hanet_agent_start_time_minute = 0; $hanet_agent_start_time_minute <= 59; $hanet_agent_start_time_minute++) {
      $formattedMinute_agent_start = str_pad($hanet_agent_start_time_minute, 2, "0", STR_PAD_LEFT);
	  ?>
      <option title="<?php echo $formattedMinute_agent_start; ?> Phút" value="<?php echo $formattedMinute_agent_start; ?>" <?php if (explode(":", $skillArray['hanet']['agent']['start_time'])[1] === "$formattedMinute_agent_start") echo "selected"; ?>><?php echo $formattedMinute_agent_start; ?></option>
   <?php 
   }
  ?>
</select>
</div>
	  </td>
    </tr>
    <tr>
      <th scope="row" title="Định Dạng = Giờ:Phút">Thời Gian Kết Thúc:</th>
      <td>
	  
<div class="thoi-gian-container">
<select class="form-select" title="Giờ" name="hanet_agent_end_time_hour">
  <?php
    for ($hanet_agent_end_time_hour = 0; $hanet_agent_end_time_hour <= 11; $hanet_agent_end_time_hour++) {
      $formattedHour_agent_end_time_hour = str_pad($hanet_agent_end_time_hour, 2, "0", STR_PAD_LEFT);
	  ?>
     <option title="<?php echo $formattedHour_agent_end_time_hour; ?> Giờ" value="<?php echo $formattedHour_agent_end_time_hour; ?>" <?php if (explode(":", $skillArray['hanet']['agent']['end_time'])[0] === "$formattedHour_agent_end_time_hour") echo "selected"; ?>><?php echo $formattedHour_agent_end_time_hour; ?></option>
	  <?php
    }
  ?>
</select>:<select title="Phút" class="form-select" name="hanet_agent_end_time_minute">
  <?php
    for ($hanet_agent_end_time_minute = 0; $hanet_agent_end_time_minute <= 59; $hanet_agent_end_time_minute++) {
      $formattedMinute_gent_end_time_minute = str_pad($hanet_agent_end_time_minute, 2, "0", STR_PAD_LEFT);
	  ?>
     <option title="<?php echo $formattedMinute_gent_end_time_minute; ?> Phút" value="<?php echo $formattedMinute_gent_end_time_minute; ?>" <?php if (explode(":", $skillArray['hanet']['agent']['end_time'])[1] === "$formattedMinute_gent_end_time_minute") echo "selected"; ?>><?php echo $formattedMinute_gent_end_time_minute; ?></option>
	  <?php
    }
  ?>
</select>
</div>
	  </td>
	</tr>
  </tbody>
  <!-- -->
  <thead>
    <tr>
      <th scope="col" colspan="2"><center><font color=red>Camera Hanet: Người Quen/Đối Tác</font></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Số Lần Thông Báo:</th>
      <td><input class="form-control" type="number" placeholder="1->100" title="Nhập Số Lần Thông Báo" name="hanet_partner_number" min="1" max="100" step="1" value="<?php echo $skillArray['hanet']['partner']['number']; ?>"></td>
    </tr>
    <tr>
      <th scope="row">Nội Dung:</th>
      <td><input class="form-control" type="text" placeholder="Nhập Nội Dung Thông Báo" title="Nội Dung Thông Báo: <?php echo $skillArray['hanet']['partner']['content']; ?>" name="hanet_partner_content" value="<?php echo $skillArray['hanet']['partner']['content']; ?>"></td>
    </tr>
   <tr>
      <th scope="row" title="Định Dạng = Giờ:Phút">Thời Gian Bắt Đầu:</th>
      <td>
<div class="thoi-gian-container">
<select title="Giờ" class="form-select" name="hanet_partner_start_time_hour">
  <?php
    for ($hanet_partner_start_time_hour = 0; $hanet_partner_start_time_hour <= 11; $hanet_partner_start_time_hour++) {
      $formattedHour_partner_start = str_pad($hanet_partner_start_time_hour, 2, "0", STR_PAD_LEFT);
	  ?>
      <option title="<?php echo $formattedHour_partner_start; ?> Giờ" value="<?php echo $formattedHour_partner_start; ?>" <?php if (explode(":", $skillArray['hanet']['partner']['start_time'])[0] === "$formattedHour_partner_start") echo "selected"; ?>><?php echo $formattedHour_partner_start; ?></option>
	  <?php
    }
  ?>
</select>:<select title="Phút" class="form-select" name="hanet_partner_start_time_minute">
  <?php
    for ($hanet_partner_start_time_minute = 0; $hanet_partner_start_time_minute <= 59; $hanet_partner_start_time_minute++) {
      $formattedMinute_partner_start = str_pad($hanet_partner_start_time_minute, 2, "0", STR_PAD_LEFT);
	  ?>
      <option title="<?php echo $formattedMinute_partner_start; ?> Phút" value="<?php echo $formattedMinute_partner_start; ?>" <?php if (explode(":", $skillArray['hanet']['partner']['start_time'])[1] === "$formattedMinute_partner_start") echo "selected"; ?>><?php echo $formattedMinute_partner_start; ?></option>
	  <?php
    }
  ?>
</select>
</div>
	  </td>
    </tr>
    <tr>
      <th scope="row" title="Định Dạng = Giờ:Phút">Thời Gian Kết Thúc:</th>
      <td>
	  
<div class="thoi-gian-container">
<select title="Giờ" class="form-select" name="hanet_partner_end_time_hour">
  <?php
    for ($hanet_partner_end_time_hour = 0; $hanet_partner_end_time_hour <= 11; $hanet_partner_end_time_hour++) {
      $formattedHour_partner_end_time_hour = str_pad($hanet_partner_end_time_hour, 2, "0", STR_PAD_LEFT);
	  ?>
      <option title="<?php echo $formattedHour_partner_end_time_hour; ?> Giờ" value="<?php echo $formattedHour_partner_end_time_hour; ?>" <?php if (explode(":", $skillArray['hanet']['partner']['end_time'])[0] === "$formattedHour_partner_end_time_hour") echo "selected"; ?>><?php echo $formattedHour_partner_end_time_hour; ?></option>
	  <?php
    }
  ?>
</select>:<select title="Phút" class="form-select" name="hanet_partner_end_time_minute">
  <?php
    for ($hanet_partner_end_time_minute = 0; $hanet_partner_end_time_minute <= 59; $hanet_partner_end_time_minute++) {
      $formattedMinute_partner_end_time_minute = str_pad($hanet_partner_end_time_minute, 2, "0", STR_PAD_LEFT);
	  ?>
      <option title="<?php echo $formattedMinute_partner_end_time_minute; ?> Phút" value="<?php echo $formattedMinute_partner_end_time_minute; ?>" <?php if (explode(":", $skillArray['hanet']['partner']['end_time'])[1] === "$formattedMinute_partner_end_time_minute") echo "selected"; ?>><?php echo $formattedMinute_partner_end_time_minute; ?></option>
	  <?php
    }
  ?>
</select>
</div>
	  </td>
	</tr>
  </tbody>
  <thead>
    <tr>
      <th scope="col" colspan="2"><center><font color=red>Camera Hanet: Người Lạ/Khách</font></center></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Số Lần Thông Báo:</th>
      <td><input class="form-control" type="number" placeholder="1->100" title="Nhập Số Lần Thông Báo" name="hanet_stranger_number" min="1" max="100" step="1" value="<?php echo $skillArray['hanet']['stranger']['number']; ?>"></td>
    </tr>
    <tr>
      <th scope="row">Nội Dung:</th>
      <td><input class="form-control" type="text" placeholder="Nhập Nội Dung Thông Báo" title="Nội Dung Thông Báo: <?php echo $skillArray['hanet']['stranger']['content']; ?>" name="hanet_stranger_content" value="<?php echo $skillArray['hanet']['stranger']['content']; ?>"></td>
    </tr>
   <tr>
      <th scope="row" title="Định Dạng = Giờ:Phút">Thời Gian Bắt Đầu:</th>
      <td>
<div class="thoi-gian-container">
<select title="Giờ" class="form-select" name="hanet_stranger_start_time_hour">
  <?php
    for ($hanet_stranger_start_time_hour = 0; $hanet_stranger_start_time_hour <= 11; $hanet_stranger_start_time_hour++) {
      $formattedHour_stranger_start = str_pad($hanet_stranger_start_time_hour, 2, "0", STR_PAD_LEFT);
	  ?>
      <option title="<?php echo $formattedHour_stranger_start; ?> Giờ" value="<?php echo $formattedHour_stranger_start; ?>" <?php if (explode(":", $skillArray['hanet']['stranger']['start_time'])[0] === "$formattedHour_stranger_start") echo "selected"; ?>><?php echo $formattedHour_stranger_start; ?></option>
	  <?php
    }
  ?>
</select>:<select title="Phút" class="form-select" name="hanet_stranger_start_time_minute">
  <?php
    for ($hanet_stranger_start_time_minute = 0; $hanet_stranger_start_time_minute <= 59; $hanet_stranger_start_time_minute++) {
      $formattedMinute_stranger_start = str_pad($hanet_stranger_start_time_minute, 2, "0", STR_PAD_LEFT);
	  ?>
      <option title="<?php echo $formattedMinute_stranger_start; ?> Phút" value="<?php echo $formattedMinute_stranger_start; ?>" <?php if (explode(":", $skillArray['hanet']['stranger']['start_time'])[1] === "$formattedMinute_stranger_start") echo "selected"; ?>><?php echo $formattedMinute_stranger_start; ?></option>
	  <?php
    }
  ?>
</select>
</div>
	  </td>
    </tr>
    <tr>
      <th scope="row" title="Định Dạng = Giờ:Phút">Thời Gian Kết Thúc:</th>
      <td>
	  
<div class="thoi-gian-container">
<select title="Giờ" class="form-select" name="hanet_stranger_end_time_hour">
  <?php
    for ($hanet_stranger_end_time_hour = 0; $hanet_stranger_end_time_hour <= 11; $hanet_stranger_end_time_hour++) {
      $formattedHour_stranger_end_time_hour = str_pad($hanet_stranger_end_time_hour, 2, "0", STR_PAD_LEFT);
	  ?>
      <option title="<?php echo $formattedHour_stranger_end_time_hour; ?> Giờ" value="<?php echo $formattedHour_stranger_end_time_hour; ?>" <?php if (explode(":", $skillArray['hanet']['stranger']['end_time'])[0] === "$formattedHour_stranger_end_time_hour") echo "selected"; ?>><?php echo $formattedHour_stranger_end_time_hour; ?></option>
	  <?php
    }
  ?>
</select>:<select title="Phút" class="form-select" name="hanet_stranger_end_time_minute">
  <?php
    for ($hanet_stranger_end_time_minute = 0; $hanet_stranger_end_time_minute <= 59; $hanet_stranger_end_time_minute++) {
      $formattedMinute_stranger_end_time_minute = str_pad($hanet_stranger_end_time_minute, 2, "0", STR_PAD_LEFT);
	  ?>
      <option title="<?php echo $formattedMinute_stranger_end_time_minute; ?> Phút" value="<?php echo $formattedMinute_stranger_end_time_minute; ?>" <?php if (explode(":", $skillArray['hanet']['stranger']['end_time'])[1] === "$formattedMinute_stranger_end_time_minute") echo "selected"; ?>><?php echo $formattedMinute_stranger_end_time_minute; ?></option>
	  <?php
    }
  ?>
</select>
</div>
	  </td>
	</tr>
  </tbody>
</table>
</div>
</div>
</div>
<hr/>
<!-- //END camera hanet -->
<h5>Đài Báo/Radio: <i class="bi bi-info-circle-fill" onclick="togglePopupradio()" title="Nhấn Để Tìm Hiểu Thêm"></i></h5>

      <div id="popupContainerradio" class="popup-container" onclick="hidePopupradio()">
    <div id="popupContent" onclick="preventEventPropagationradio(event)">
      <center><b>Đài Báo/Radio:</b></center><br/>
	  - Bạn cần nhập tên của đài báo radio và link của đài .m3u8<br/>
	  - Tối đa thêm được là: <?php echo $Limit_Radio; ?> (bạn cần sửa trong file <b>Configuration.php</b> để thêm hoặc bớt tối đa đài cho sẵn.
</div></div>

<div class="row justify-content-center"><div class="col-auto"><div class="scrollable-divradio">
<table class="table">
  <thead>
    <tr>
      <th scope="col"><center><font color=red>Tên Đài</font></center></th>
      <th scope="col"><center><font color=red>Link Đài</font></center></th>
    </tr>
  </thead>
  <tbody>
    <?php
    // Lặp qua mảng radio_data để hiển thị các đài
    foreach ($skillArray["radio_data"] as $index => $radio) {
        $name = $radio["name"];
        $link = $radio["link"];
        echo '<tr><td><input class="form-control" type="text" placeholder="' . $name . '" name="radio[' . $index . '][name]" value="' . $name . '" title="Tên Của Đài Radio"></td>';
        echo '<td><input class="form-control" type="text" placeholder="' . $link . '" name="radio[' . $index . '][link]" value="' . $link . '" title="Link Đài Báo Radio .m3u8"></td>';
        echo "</tr>";
    }
    // Kiểm tra số lượng đài đã đạt đến giới hạn hay chưa
    if (count($skillArray["radio_data"]) < $Limit_Radio) {
        // Hiển thị thẻ input để nhập mới đài
        echo '<tr><td><input class="form-control" type="text" name="new_radio[name]" placeholder=" Nhập tên đài"></td>';
        echo '<td><input class="form-control" type="text" name="new_radio[link]" placeholder="Nhập link đài .m3u8"></td>';
        echo "</tr>";
    }
    ?>
  </tbody>
</table>
</div>
</div>
</div>
<hr/>
<h5>Ngày Kỷ Niệm: <i class="bi bi-info-circle-fill" onclick="togglePopupNKN()" title="Nhấn Để Tìm Hiểu Thêm"></i></h5>
      <div id="popupContainerNKN" class="popup-container" onclick="hidePopupNKN()">
    <div id="popupContent" onclick="preventEventPropagationNKN(event)">
      <center><b>Ngày Kỷ Niệm</b></center><br/>
	  - Thêm sự kiện/ngày kỷ niệm của bạn trong mục <b>Thêm Mới Sự Kiện</b><br/>
	  - Tối đa được phép thêm <?php echo $Limit_NgayKyNiem; ?> sự kiện<br/>
	  - <b>Tính Theo Lịch Âm: </b> Tích vào để tính theo âm lịch, bỏ tích sẽ tính theo dương lịch<br/>
	  - <b>Xóa Sự Kiện: </b> Để xóa sự kiện đã thêm bạn hãy tìm tới sự kiện cần xóa, sau đó bỏ trống 1 trong 3 ô (<b>"Tên Sự Kiện"</b> hoặc <b>"Ngày"</b> hoặc <b>"Tháng"</b>) sau đó nhấn Lưu Cài Đặt.
<br/></div></div>
<div class="row justify-content-center"><div class="col-auto">
<div id="scrollable-div" class="scrollable-content">
<?php
$anniversary_data = $skillArray['anniversary_data'];
$count = count($anniversary_data);
// Kiểm tra số lượng giá trị trong anniversary_data
if ($count > $Limit_NgayKyNiem ) {
    // Hiển thị thông báo nếu vượt quá 10 giá trị
    echo " Giá trị <b>'anniversary_data'</b> trong <b>skill.json</b> đã vượt quá $Limit_NgayKyNiem giá trị, bạn cần ssh sửa trực tiếp file <b>skill.json</b><br/><br/>";
	echo "<div style='display: none;'>";
        foreach ($anniversary_data as $index => $anniversary) {
            $name = $anniversary['name'];
            $day = $anniversary['day'];
            $month = $anniversary['month'];
            $is_lunar_calendar = $anniversary['is_lunar_calendar'];
			$indexxxxx = $index + 1;
			echo "<table class='table table-responsive align-middle'><thead><tr><th colspan='2' class='table-success'><center>Sự Kiện $indexxxxx</center></th></tr> </thead> <tbody>";
            echo "<tr class='table-success'> <th scope='row'><label for='nameb_$index'>Tên Sự Kiện: </label></th>";
            echo "<td><input type='text' class='form-control' id='nameb_$index' name='namei[]' value='$name'></td></tr>";
            echo "<tr class='table-success'> <th scope='row'><label for='day_$index'>Ngày: </label></th>";
            echo "<td><input type='text' class='form-control' id='day_$index' name='day[]' value='$day'></td></tr>";
			echo "<tr class='table-success'> <th scope='row'><label for='month_$index'>Tháng:</label></th>";
			echo "<td><input type='text' class='form-control' id='month_$index' name='month[]' value='$month'></td></tr>";
            echo "<tr class='table-success'> <th scope='row'><label for='is_lunar_calendar_$index'>Tính theo lịch âm:</label></th>";
            echo "<td><input type='checkbox' id='is_lunar_calendar_$index' name='is_lunar_calendar[$index]' value='1'" . ($is_lunar_calendar ? ' checked' : '') . "></td></tr>";
			echo "</tbody></table>";
		}
			echo "</div>";
	
} else {
    // Hiển thị biểu mẫu và trường nhập liệu cho mỗi giá trị trong anniversary_data
    ?>
     <form  id="my-form"  method="post"> 
        <?php
        foreach ($anniversary_data as $index => $anniversary) {
            $name = $anniversary['name'];
            $day = $anniversary['day'];
            $month = $anniversary['month'];
            $is_lunar_calendar = $anniversary['is_lunar_calendar'];
			$indexxxxx = $index + 1;
			echo "<table class='table table-responsive align-middle'><thead><tr><th colspan='2' class='table-success'><center><font color=red>Sự Kiện/Ngày Kỉ Niệm $indexxxxx</font></center></th></tr> </thead> <tbody>";
            echo "<tr class='table-success'> <th scope='row'><label for='nameb_$index'>Tên Sự Kiện: </label></th>";
            echo "<td><input type='text' placeholder='$name' class='form-control' id='nameb_$index' name='namei[]' value='$name'></td></tr>";
            echo "<tr class='table-success'> <th scope='row'><label for='day_$index'>Ngày: </label></th>";
            echo "<td><input type='text' placeholder='$day' class='form-control' id='day_$index' name='day[]' value='$day'></td></tr>";
			echo "<tr class='table-success'> <th scope='row'><label for='month_$index'>Tháng:</label></th>";
			echo "<td><input type='text' placeholder='$month' class='form-control' id='month_$index' name='month[]' value='$month'></td></tr>";
            echo "<tr class='table-success'> <th scope='row'><label title='Tích để tính theo âm lịch, bỏ tích tính theo dương lịch' for='is_lunar_calendar_$index'>Tính theo lịch âm:</label></th>";
            echo "<td><input type='checkbox' title='Tích để tính theo âm lịch, bỏ tích tính theo dương lịch' id='is_lunar_calendar_$index' name='is_lunar_calendar[$index]' value='1'" . ($is_lunar_calendar ? ' checked' : '') . "></td></tr>";
			echo "</tbody></table>";
			}
		echo "</div>";
        // Hiển thị trường nhập liệu trống để thêm mới
        if ($count < $Limit_NgayKyNiem ) {
            $newIndex = $count;
            echo "<br/><table class='table table-responsive table-striped align-middle'> <thead><tr><th colspan='2' class='table-danger'><center><font color=red>Thêm Mới Sự Kiện<font></center></th></tr> </thead> <tbody>";
			echo "<tr class='table-danger'> <th scope='row'><label for='nameb_$newIndex'>Tên Sự Kiện:</label></th>";
            echo "<td><input class='form-control' type='text' id='nameb_$newIndex' placeholder='Tên sự kiện mới' name='namei[]'></td></tr>";
            echo "<tr class='table-danger'> <th scope='row'><label for='day_$newIndex'>Ngày:</label></th>";
            echo "<td><input class='form-control' type='text' id='day_$newIndex' placeholder='Nhập Ngày' name='day[]'></td></tr>";
            echo "<tr class='table-danger'> <th scope='row'><label for='month_$newIndex'>Tháng:</label>";
            echo "<td><input class='form-control' type='text' id='month_$newIndex' placeholder='Nhập Tháng' name='month[]'></td></tr>";
            echo "<tr class='table-danger'> <th scope='row'><label title='Tích để tính theo âm lịch, bỏ tích tính theo dương lịch' for='is_lunar_calendar_$newIndex'>Tính theo lịch âm:</label>";
            echo "<td><center><input type='checkbox' title='Tích để tính theo âm lịch, bỏ tích tính theo dương lịch' id='is_lunar_calendar_$newIndex' name='is_lunar_calendar[$newIndex]' value='1'></center></td></tr>";
			echo '</tbody></table>';
        }
        }
?>
</div>
</div>

<?php
if (isset($_POST['restart_vietbot'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {
    die($E_rror_HOST);
}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {
    die($E_rror);
}
$stream = ssh2_exec($connection, 'systemctl --user restart vietbot');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
//echo stream_get_contents($stream_out);
stream_get_contents($stream_out);
}
?>

<div class="row justify-content-center"><div class="col-auto">
<center>
<input type="submit" name="skill_saver" class="btn btn-primary" value="Lưu Cài Đặt">

 <a href="<?php echo $PHP_SELF ?>"><button type="button" class="btn btn-danger">Hủy Bỏ/Làm Mới</button></a>



 <button type="submit" name="restart_vietbot" class="btn btn-warning">Khởi Động Lại VietBot</button>


<input type="button" id="view-button" class="btn btn-info" value="Json View"></center>
</div>
</div></form>
    <div id="popup">
        <div id="popup-content">
            <pre><code class="json"><?php echo file_get_contents("$DuognDanThuMucJson/skill.json"); ?></code></pre>
			 <center><input type="button"  class="btn btn-info" id="close-button" value="Đóng"></center>
        </div>
    </div>
<hr/>

<h5><center><font color=red>Khôi Phục File skill.json</font></center></h5>
  <div class="form-check form-switch d-flex justify-content-center"> 
<?php
// Kiểm tra xem có file nào trong thư mục hay không
if (count($fileLists) > 0) {
    // Tạo dropdown list để hiển thị các file
    echo '<form id="my-form" method="get"><div class="input-group">';
    echo '<select class="custom-select" id="inputGroupSelect04" name="selectedFile">';
    echo '<option value="">Chọn file backup skill</option>'; // Thêm lựa chọn "Chọn file"
    foreach ($fileLists as $file) {
        $fileName = basename($file);
        echo '<option value="' . $file . '">' . $fileName . '</option>';
    }
    echo '</select><div class="input-group-append">';
    echo '<input type="submit" class="btn btn-warning" title="Khôi Phục Lại File config.json trước đó đã sao lưu" value="Khôi Phục/Recovery">';
    echo ' </div></div></form><br/><br/>';
}
 else {
    echo "Không tìm thấy file backup config trong thư mục.";
}
?></div>


<script>
    //check button ẩn hiện thẻ div OpenWeatherMap
    $(document).ready(function() {
        // Khi trạng thái nút bật/tắt thay đổi
        $('#active').change(function() {
            if ($(this).is(':checked')) {
                $('#extraData').show();
            } else {
                $('#extraData').hide();
            }
        });
    });
    //check button ẩn hiện thẻ div HASS
    $(document).ready(function() {
        // Khi trạng thái nút bật/tắt thay đổi
        $('#activeHass').change(function() {
            if ($(this).is(':checked')) {
                $('#extraDataHass').show();
            } else {
                $('#extraDataHass').hide();
            }
        });
    });

    //check button ẩn hiện thẻ div Telegram
    $(document).ready(function() {
        // Khi trạng thái nút bật/tắt thay đổi
        $('#activeTelegram').change(function() {
            if ($(this).is(':checked')) {
                $('#extraDataTelegram').show();
            } else {
                $('#extraDataTelegram').hide();
            }
        });
    });


    //check button ẩn hiện thẻ div Camera hanet
    $(document).ready(function() {
        // Khi trạng thái nút bật/tắt thay đổi
        $('#activeCameraHanet').change(function() {
            if ($(this).is(':checked')) {
                $('#extraDataCameraHanet').show();
            } else {
                $('#extraDataCameraHanet').hide();
            }
        });
    });

    // togglePopupOpenWeatherMap
    function togglePopupOpenWeatherMap() {
        var popupContainer = document.getElementById("popupContainerOpenWeatherMap");
        popupContainer.classList.toggle("show");
    }

    function hidePopupOpenWeatherMap() {
        var popupContainer = document.getElementById("popupContainerOpenWeatherMap");
        popupContainer.classList.remove("show");
    }

    function preventEventPropagationOpenWeatherMap(event) {
            event.stopPropagation();
        }
        // togglePopupNKN Ngày Kỷ Niệm
    function togglePopupNKN() {
        var popupContainer = document.getElementById("popupContainerNKN");
        popupContainer.classList.toggle("show");
    }

    function hidePopupNKN() {
        var popupContainer = document.getElementById("popupContainerNKN");
        popupContainer.classList.remove("show");
    }

    function preventEventPropagationNKN(event) {
            event.stopPropagation();
        }
        // togglePopupTINTUC  tin tức
    function togglePopupTINTUC() {
        var popupContainer = document.getElementById("popupContainerTINTUC");
        popupContainer.classList.toggle("show");
    }

    function hidePopupTINTUC() {
        var popupContainer = document.getElementById("popupContainerTINTUC");
        popupContainer.classList.remove("show");
    }

    function preventEventPropagationTINTUC(event) {
            event.stopPropagation();
        }
        // togglePopupTelegram
    function togglePopupTelegram() {
        var popupContainer = document.getElementById("popupContainerTelegram");
        popupContainer.classList.toggle("show");
    }

    function hidePopupTelegram() {
        var popupContainer = document.getElementById("popupContainerTelegram");
        popupContainer.classList.remove("show");
    }

    function preventEventPropagationTelegram(event) {
            event.stopPropagation();
        }
        // togglePopupTelegram
    function togglePopupGGASS() {
        var popupContainer = document.getElementById("popupContainerGGASS");
        popupContainer.classList.toggle("show");
    }

    function hidePopupGGASS() {
        var popupContainer = document.getElementById("popupContainerGGASS");
        popupContainer.classList.remove("show");
    }

    function preventEventPropagationGGASS(event) {
            event.stopPropagation();
        }
        // togglePopupGPT
    function togglePopupGPT() {
        var popupContainer = document.getElementById("popupContainerGPT");
        popupContainer.classList.toggle("show");
    }

    function hidePopupGPT() {
        var popupContainer = document.getElementById("popupContainerGPT");
        popupContainer.classList.remove("show");
    }

    function preventEventPropagationGPT(event) {
        event.stopPropagation();
    }

    // togglePopupggbard
    function togglePopupggbard() {
        var popupContainer = document.getElementById("popupContainerggbard");
        popupContainer.classList.toggle("show");
    }

    function hidePopupggbard() {
        var popupContainer = document.getElementById("popupContainerggbard");
        popupContainer.classList.remove("show");
    }

    function preventEventPropagationggbard(event) {
            event.stopPropagation();
        }
        // togglePopupGPT
    function togglePopupradio() {
        var popupContainer = document.getElementById("popupContainerradio");
        popupContainer.classList.toggle("show");
    }

    function hidePopupradio() {
        var popupContainer = document.getElementById("popupContainerradio");
        popupContainer.classList.remove("show");
    }

    function preventEventPropagationradio(event) {
            event.stopPropagation();
        }
        // togglePopupHass
    function togglePopupHass() {
        var popupContainer = document.getElementById("popupContainerHass");
        popupContainer.classList.toggle("show");
    }

    function hidePopupHass() {
        var popupContainer = document.getElementById("popupContainerHass");
        popupContainer.classList.remove("show");
    }

    function preventEventPropagationHass(event) {
        event.stopPropagation();
    }

    window.addEventListener('DOMContentLoaded', function() {
        var div = document.getElementById('scrollable-div');

        if (div.innerHTML.trim() !== '') {
            div.style.display = 'block'; // Hiển thị div khi có nội dung
        }
    });
    //Check Thứ Tự Ưu Tiên
    function vuTuyen() {
        const priority1 = document.getElementById("priority1").value;
        const priority2 = document.getElementById("priority2").value;
        const priority3 = document.getElementById("priority3").value;
        if (priority1 !== '' && priority2 !== '' && priority3 !== '') {
            if (priority1 === priority2 || priority1 === priority3 || priority2 === priority3) {
                alert("Lỗi: Các giá trị ưu tiên của Trợ Lý không được phép trùng nhau! \n\n Hệ thống sẽ tự động làm mới lại trang");
                event.preventDefault(); // Ngăn việc gửi form
                window.location.reload();
                return false;

            }
        }
        //return true;
        const music_source_priority1 = document.getElementById("music_source_priority1").value;
        const music_source_priority2 = document.getElementById("music_source_priority2").value;
        const music_source_priority3 = document.getElementById("music_source_priority3").value;
        if (music_source_priority1 !== '' && music_source_priority2 !== '' && music_source_priority3 !== '') {
            if (music_source_priority1 === music_source_priority2 || music_source_priority1 === music_source_priority3 || music_source_priority2 === music_source_priority3) {
                alert("Lỗi: Các giá trị ưu tiên của Nguồn Phát Media Player không được phép trùng nhau! \n\n Hệ thống sẽ tự động làm mới lại trang");
                event.preventDefault(); // Ngăn việc gửi form
                window.location.reload();
                return false;

            }
        }
        return true;


    }
</script>
<script>
    const viewButton = document.getElementById('view-button');
    const popup = document.getElementById('popup');
    const closeButton = document.getElementById('close-button');

    viewButton.addEventListener('click', () => {
        popup.style.display = 'flex';
    });

    closeButton.addEventListener('click', () => {
        popup.style.display = 'none';
    });
</script>
<script>
    var HomeAssistantshowPopupshowPopupButton = document.getElementById('HomeAssistantshowPopup');
    var popupHass = document.getElementById('popupHass');
    var popupContentHass = document.getElementById('popupContentHass');
    var closeButtonHass = document.getElementById('closeButtonHass');
    var urlInput = document.getElementById('hass_url');
    var tokenInput = document.getElementById('hass_key');

    //var loadingIcon = document.getElementById('loading-icon'); // Biểu tượng loading

    HomeAssistantshowPopupshowPopupButton.addEventListener('click', function() {
        $('#loading-overlay').show();

        var apiUrl = urlInput.value;
        var apiToken = tokenInput.value;
        //console.log(apiUrl);

        // Hiển thị popup
        popupHass.style.display = 'block';
        // Gửi yêu cầu AJAX đến tệp PHP
        var xhr = new XMLHttpRequest();
        //xhr.open('GET', 'Ajax/Check_Hass.php?url=' + apiUrl + '&token=' + apiToken, true);
        xhr.open('GET', 'Ajax/Check_Hass.php?url=' + apiUrl + '/api/config&token=' + apiToken, true);
        xhr.onload = function() {
            $('#loading-overlay').hide();

            if (xhr.status === 200) {
                var responseData = JSON.parse(xhr.responseText);

                // Kiểm tra xem có location_name trong JSON hay không
                if (responseData.location_name) {
                    var home_assistant_locationName = responseData.location_name;
                    var home_assistant_time_zone = responseData.time_zone;
                    var home_assistant_country = responseData.country;
                    var home_assistant_language = responseData.language;

                    var home_assistant_version = responseData.version;
                    var home_assistant_state = responseData.state;
                    var home_assistant_external_url = responseData.external_url;
                    var home_assistant_internal_url = responseData.internal_url;

                    var latitude = responseData.latitude;
                    var longitude = responseData.longitude;
                    // popupContent.textContent = 'Location Name: <span class="red-text">' + home_assistant_locationName + '</span><br>Time Zone: ' + home_assistant_time_zone;
                    popupContentHass.innerHTML = '<center><h5>Kết Nối Tới HomeAssistant Thành Công</h5></center>';
                    popupContentHass.innerHTML += '<font color=red>Tên: <b>' + home_assistant_locationName + '</b></font>';
                    popupContentHass.innerHTML += '<font color=red>Múi Giờ:<b> ' + home_assistant_time_zone + '</b></font>';
                    popupContentHass.innerHTML += '<font color=red>Quốc Gia:<b> ' + home_assistant_country + '</b></font>';
                    popupContentHass.innerHTML += '<font color=red>Ngôn Ngữ:<b> ' + home_assistant_language + '</b></font>';
                    popupContentHass.innerHTML += '<font color=red>Địa Chỉ URL Ngoài:<b> <a href="'+home_assistant_external_url+'" target="_bank">' + home_assistant_external_url + '</a></b></font>';
                    popupContentHass.innerHTML += '<font color=red>Địa Chỉ URL Local:<b> <a href="'+home_assistant_internal_url+'" target="_bank">' + home_assistant_internal_url + '</a></b></font>';;
                    popupContentHass.innerHTML += '<font color=red>Phiên Bản HomeAssistant:<b> ' + home_assistant_version + '</b></font>';
                    popupContentHass.innerHTML += '<font color=red>Trạng Thái Hoạt Động:<b> ' + home_assistant_state + '</b></font>';
                } else {
                    var error_php = responseData.error
                        //Thông báo lỗi
                    popupContentHass.innerHTML = '<font color=red>' + error_php + '</font>';
                }
            } else if (xhr.status === 401) {
                popupContentHass.innerHTML = '<font color=red>Lỗi [401], không có quyền truy cập, Hãy kiểm tra lại mã token</font>';
            } else if (xhr.status === 404) {
                popupContentHass.innerHTML = '<font color=red>Lỗi [404], không tìm thấy dữ liệu, hãy kiểm tra lại địa chỉ HomeAssistant hoặc Token</font>';
            } else {
                popupContentHass.innerHTML = '<font color=red>Lỗi khi gửi yêu cầu</font>';
            }
        };

        xhr.onerror = function() {
            //$('#loading-overlay').hidden();
            popupContentHass.innerHTML = '<font color=red>Lỗi kết nối</font>';
        };

        xhr.send();
    });

    closeButtonHass.addEventListener('click', function() {
        // Đóng popup khi nút đóng được nhấn
        popupHass.style.display = 'none';
    });

    popupHass.addEventListener('click', function(event) {
        if (event.target === popupHass) {
            // Đóng popup khi bấm vào ngoài vùng popup
            popupHass.style.display = 'none';
        }
    });
</script>
	
	<script src="../assets/js/bootstrap.js"></script>
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/axios_0.21.1.min.js"></script>
	
	</body>
	</html>
