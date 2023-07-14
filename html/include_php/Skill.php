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
		<script src="../assets/js/3.5.1_jquery.min.js"></script>
		<script src="../assets/js/1.16.0_umd_popper.min.js"></script>
  <style>
  	body {
    background-color: #dbe0c9;

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
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
    -webkit-border-radius: 10px;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background: rgb(251, 255, 7); 
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
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
	#loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    display: none;
}
#loading-icon {
    width: 30px;
    height: 30px;
    position: absolute;
    top: 45%;
    left: 50%;
    transform: translate(-50%, -50%);
}
#loading-message {
	   position: absolute;
    color: white;
	  top: 57%;
    left: 50%;
	  transform: translate(-50%, -50%);
}
.scrollable-divradio {
           
            height: 200px; 
            overflow: auto;
        }
  </style>
	</head>
	<body>
<?php
// Kiểm tra nếu form đã được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
	// Google Asssitant Mode
    $skillArray['gg_ass']['mode'] = $Google_Assistant_Mode;
	//Telegram
    $skillArray['telegram']['token'] = $TelegramKey;
    $skillArray['telegram']['active'] = $activeTelegram;
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
if (!$connection) {die('Không thể kết nối tới máy chủ.');}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die('Đăng nhập không thành công.');}
$stream1 = ssh2_exec($connection, "sudo chmod -R 0777 $DuognDanUI_HTML");
$stream2 = ssh2_exec($connection, "sudo chmod -R 0777 $DuognDanThuMucJson");
stream_set_blocking($stream1, true); stream_set_blocking($stream2, true);
$stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO); $stream_out2 = ssh2_fetch_stream($stream2, SSH2_STREAM_STDIO);
stream_get_contents($stream_out1); stream_get_contents($stream_out2);
header("Location: $PHP_SELF"); exit;
}
//////////////////////////////////////////

?>
<!-- Form để hiển thị và chỉnh sửa dữ liệu -->
<form id="my-form"  method="POST">
<?php
// Thư mục cần kiểm tra
$directories = array(
    "$DuognDanThuMucJson"
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
                echo "<br/><center><h3 class='text-danger'>Một Số File,Thư Mục Trong <b>$path</b> Không Có Quyền Can Thiệp.<h3><br/>";
			echo " <button type='submit' name='set_full_quyen' class='btn btn-success'>Cấp Quyền Cho File, Thư Mục</button></center><hr/>";
                $hasPermissionIssue = true;
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
?>
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
<tr><th scope="row"> <label for="hass_url">URL:</label></th>
<td><input type="text" class="form-control" id="hass_url" name="hass_url" placeholder="http://192.168.14.104:8123" title="Nhập Url Của HomeAssistant" value="<?php echo $skillArray['hass']['url']; ?>"></td>
</tr><tr>
<th scope="row"> <label for="hass_key">Token Hass:</label></th>
<td><input type="text" class="form-control" id="hass_key" name="hass_key" placeholder="Nhập Key Của HomeAssistant" title="Nhập Key Của HomeAssistant" value="<?php echo $skillArray['hass']['token']; ?>"></td>
</tr><tr>
<th scope="row"> <label title="Câu Trả Lời Có Thêm Chi Tiết Về Thiết Bị">Display Full State:</label></th>
<td><input type="checkbox" id="hass_display_full_state" name="hass_display_full_state" title="Tích Để Bật/Tắt" <?php echo $skillArray['hass']['display_full_state'] ? 'checked' : ''; ?>></td>
</tr></tbody>
</table></div></div></div></div>
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
            <input type="checkbox" class="custom-control-input" id="gg_ass_Mode" name="gg_ass_Mode" <?php echo $skillArray['gg_ass']['mode'] ? 'checked' : ''; ?>>
            <label class="custom-control-label" for="gg_ass_Mode"></label>
</div></div></div>
<hr/>
<h5>Telegram: <i class="bi bi-info-circle-fill" onclick="togglePopupTelegram()" title="Nhấn Để Tìm Hiểu Thêm"></i></h5>
      <div id="popupContainerTelegram" class="popup-container" onclick="hidePopupTelegram()">
    <div id="popupContent" onclick="preventEventPropagationTelegram(event)">
      <center><b>Telegram Skill</b></center><br/>
<center><i><b>Danh Bạ Người Gửi: </b></i>Nếu Có Thông Báo Giá trị <b>'telegram_data'</b> trong skill.json đã vượt quá <b><?php echo $Limit_Telegram; ?></b> giá trị, bạn cần ssh sửa trực tiếp file skill.json</center><br/>
- <b>Xóa Danh Bạ Người Gửi: </b> Để xóa danh bạ người gửi đã thêm, bạn hãy tìm tới người cần xóa, <br/>sau đó bỏ trống 1 trong 2 ô (<b>"Tên Người Nhận"</b> hoặc <b>"ID Người Nhận"</b>) sau đó nhấn Lưu Cài Đặt Skill.
</div></div>
    <div class="form-group">
       <!-- <label for="active">Active:</label> -->
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
      <th colspan="3"><center>Tin Tức</center></th>
    </tr></thead><thead><tr><th></th>
 <th><label><center>Tên Báo</center></label></th>
      <th><label><center>Link Báo RSS</center></label></th>
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
      <th scope="col"><center>Tên Đài</center></th>
      <th scope="col"><center>Link Đài</center></th>
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
			echo "<table class='table table-responsive align-middle'><thead><tr><th colspan='2' class='table-success'><center>Sự Kiện/Ngày Kỉ Niệm $indexxxxx</center></th></tr> </thead> <tbody>";
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
            echo "<br/><table class='table table-responsive table-striped align-middle'> <thead><tr><th colspan='2' class='table-danger'><center>Thêm Mới Sự Kiện</center></th></tr> </thead> <tbody>";
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
<input type="submit" class="btn btn-primary" value="Lưu Cài Đặt"></div><div class="col-auto"> <a href="<?php echo $PHP_SELF ?>"><button type="button" class="btn btn-danger">Hủy Bỏ/Làm Mới</button></a></div>


<div class="col-auto">
 <button type="submit" name="restart_vietbot" class="btn btn-warning">Khởi Động Lại VietBot</button>
</div>

</div>
</form>
    <div id="loading-overlay">
          <img id="loading-icon" src="../assets/img/Loading.gif" alt="Loading...">
		  <div id="loading-message">Đang Thực Thi...</div>
    </div>
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
//Khởi động Lại vietbot
$(document).ready(function() {
    $('#my-form').on('submit', function() {
        // Hiển thị biểu tượng loading
        $('#loading-overlay').show();

        // Vô hiệu hóa nút gửi
        $('#submit-btn').attr('disabled', true);
    });
});
</script>
	<script src="../assets/js/bootstrap.js"></script>
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/axios_0.21.1.min.js"></script>
	
	</body>
	</html>