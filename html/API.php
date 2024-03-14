<?php
/**
 * File: API.php
 * Description: Example code to execute shell commands securely through an API using cURL in PHP.
 * Author: Vũ Tuyển
 * Facebook: https://www.facebook.com/TWFyaW9uMDAx
 * Version: 1.1
 */
include "Configuration.php";
include "./include_php/Fork_PHP/INFO_OS.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
$version = "1.1";

//$Web_ui_jSon = json_decode(file_get_contents("assets/json/webui_.json"), true);

//$Enable_API = $Web_ui_jSon['enable_api'];
$Enable_API = $Web_UI_Enable_Api;
//echo "$apiActive";

// Lấy thông tin về model Raspberry Pi
$modelInfo = trim(file_get_contents('/proc/device-tree/model'));

// Kiểm tra xem có thông tin về model không
if (!empty($modelInfo)) {
   $infomodel = $modelInfo;
} else {
    $infomodel = null;
}


$information = array(
		'username' => $MYUSERNAME,
		'current_user' => $GET_current_USER,
		'hostname' => $HostName,
		'server_ip' => $serverIP,
		'info_model' => $infomodel,
		'php_uname' => php_uname(),
        'api_version' => $version,
        'github_vietbot_offline' => $GitHub_VietBot_OFF,
        'ui_vietbot' => $UI_VietBot,
        'api_webui_guide' => "https://github.com/marion001/UI_VietBot/blob/main/README_HomeAssistant.md",
        //'author' => $MYUSERNAME,
        'author' => 'Vũ Tuyển',
        'last_update_time' =>  date("H:i"),
		'enable_api' => $Enable_API,
		'query_instructions' => array(
		'command' => 'restart, linux command (ls, sudo, sudo reboot, dir, v..v...), ',
		'query' => 'info',
		'volume' => '0->100'
		
		)
);

if (isset($_GET['vietbotscan'])) {
    echo json_encode(array(
        'information' => $information
    ));
	exit();
} 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array(
        'message' => 'Phương pháp truy vấn không được phép.',
        'http_response_code' => 405,
		'output_api' => null,
		'information' => $information
		));
    exit();
}
$input = file_get_contents('php://input');
$data = json_decode($input, true);

//$presentFieldsCount = isset($data['command']) + isset($data['query']) + isset($data['api_key']);
if (isset($data['command']) + isset($data['query']) + isset($data['volume']) + isset($data['api_key']) < 2) {
    http_response_code(400); // Bad Request
    echo json_encode(array(
        'message' => 'Dữ liệu đầu vào sai cú pháp hoặc API không được cung cấp cho truy vấn này',
        'http_response_code' => 400,
        'output_api' => null,
        'information' => $information
    ));
    exit();
}
$command = $data['command'];
$query = $data['query'];
$volume = $data['volume'];
$providedApiKey = $data['api_key'];
// Kiểm tra xác thực API key
if ($providedApiKey !== md5($apiKey)) {
    http_response_code(401); // Unauthorized
    echo json_encode(array(
		'message' => 'Xác thực lỗi! Vui lòng kiểm tra lại key api.',
		'http_response_code' => 401,
		'output_api' => null,
		'information' => $information
		));
    exit();
}
// Thực hiện kiểm tra lệnh an toàn trước khi thực thi
if (!isSafeCommand($command)) {
    http_response_code(403); // Forbidden
    echo json_encode(array(
		'message' => 'Dữ liệu được gửi tới api đã bị chặn không được phép thực thi.',
		'http_response_code' => 403,
		'allowed_commands' => $allowedCommands,
		'output_api' => null,
		'information' => $information
		));
    exit();
}

if ($Enable_API === true) {
if ($volume === "$volume") {
//Ghi volume vào file state.json
$dataaa = json_decode(file_get_contents("$DuognDanThuMucJson/state.json"), true);
$dataaa['volume'] = intval($volume);
$newJsonStringVolume = json_encode($dataaa, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
file_put_contents("$DuognDanThuMucJson/state.json", $newJsonStringVolume);
$volume_mapping = array(
0 => 0,1 => 12,2 => 23,3 => 30,4 => 35,5 => 39,6 => 42,7 => 45,8 => 48,9 => 51,10 => 53,11 => 55,12 => 57,13 => 58,14 => 60,15 => 61,16 => 63,17 => 64,18 => 65,19 => 66,20 => 67,
21 => 68,22 => 69,23 => 70,24 => 71,25 => 72,26 => 73,27 => 73,28 => 74,29 => 75,30 => 76,31 => 76,32 => 76,33 => 77,34 => 78,35 => 79,36 => 80,37 => 80,38 => 80,39 => 81,40 => 81,
41 => 82,42 => 82,43 => 83,44 => 83,45 => 83,46 => 84,47 => 84,48 => 85,49 => 85,50 => 86,51 => 86,52 => 87,53 => 87,54 => 87,55 => 87,56 => 88,57 => 88,58 => 89,59 => 89,60 => 89,
61 => 90,62 => 90,63 => 90,64 => 90,65 => 90,66 => 91,67 => 91,68 => 92,69 => 92,70 => 92,71 => 93,72 => 93,73 => 93,74 => 94,75 => 94,76 => 94,77 => 94,78 => 94,79 => 95,80 => 95,
81 => 95,82 => 95,83 => 96,84 => 96,85 => 96,86 => 97,87 => 97,88 => 97,89 => 98,90 => 98,91 => 98,92 => 98,93 => 98,94 => 98,95 => 98,96 => 99,97 => 99,98 => 99,99 => 99,100 => 100
);
if (isset($volume_mapping[$volume])) {
    $result_volume = $volume_mapping[$volume];
} else {
    // Nếu không khớp với các giá trị trong mảng, giữ nguyên giá trị ban đầu
    $result_volume = $volume;
}
if (isset($data['api_key']) && $data['api_key'] === md5($apiKey)) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, "amixer sset 'Speaker' $result_volume.'%'");
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output =  stream_get_contents($stream_out);
        echo json_encode(array(
            'message' => 'volume change '.$volume.'%',
            'http_response_code' => 200,
            'output_api' => $output,
            'information' => $information
        ));
        exit();
    } else {
		unauthorized();
    }
}
}else {
    // Xuất thông báo nếu API không được kích hoạt
    echo json_encode(array(
        'message' => $API_Messenger_Disabled,
        'information' => $information
    ));
	exit();
}

if ($Enable_API === true) {
if ($command === "reboot") {
    if (isset($data['api_key']) && $data['api_key'] === md5($apiKey)) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'sudo reboot');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output =  stream_get_contents($stream_out);
        echo json_encode(array(
            'message' => 'reboot hệ thống thành công',
            'http_response_code' => 200,
            'output_api' => $output,
            'information' => $information
        ));
        exit();
    } else {
		unauthorized();
    }
}
}else {
    // Xuất thông báo nếu API không được kích hoạt
    echo json_encode(array(
        'message' => $API_Messenger_Disabled,
        'information' => $information
    ));
	exit();
}

if ($Enable_API === true) {
if ($command === "restart") {
    if (isset($data['api_key']) && $data['api_key'] === md5($apiKey)) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'systemctl --user restart vietbot');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output =  stream_get_contents($stream_out);
        echo json_encode(array(
            'message' => 'restart Vietbot thành công',
            'http_response_code' => 200,
            'output_api' => $output,
            'information' => $information
        ));
        exit();
    } else {
		unauthorized();
    }
}
}else {
    // Xuất thông báo nếu API không được kích hoạt
    echo json_encode(array(
        'message' => $API_Messenger_Disabled,
        'information' => $information
    ));
	exit();
}
if ($query === "info") {
    if (isset($data['api_key']) && $data['api_key'] === md5($apiKey)) {
//UI Update	
	$UIlocalFile = $DuognDanUI_HTML.'/version.json';
	$UIremoteJsonData = file_get_contents($UI_Version);
	$UIremoteData = json_decode($UIremoteJsonData, true);
	$UIlocalJsonData = file_get_contents($UIlocalFile);
	$UIlocalData = json_decode($UIlocalJsonData, true);
	$UIremoteValue = $UIremoteData['ui_version']['latest'];
	$UIlocalValue = $UIlocalData['ui_version']['current'];
	if ($UIremoteValue !== $UIlocalValue) {
	$UI_update = true;
	$UI_new_version = $UIremoteValue;
	if (empty($UIremoteData['ui_version']['notification'])) {
	} else {
    $UI_updated_content = $UIremoteData['ui_version']['notification'];
	}
	} else {
	$UI_update = false;
	$UI_new_version = null;
	$UI_updated_content = null;
	}
//End UI update
//Vietbot Update
	$VBremoteJsonData = file_get_contents($Vietbot_Version);
	$VBremoteData = json_decode($VBremoteJsonData, true);
	
	$VBlocalFile = $DuognDanThuMucJson.'/version.json';
	$VBlocalJsonData = file_get_contents($VBlocalFile);
	$VBlocalData = json_decode($VBlocalJsonData, true);
	
	$VBremoteValue = $VBremoteData['vietbot_version']['latest'];
	$VBlocalValue = $VBlocalData['vietbot_version']['latest'];
	
	if ($VBremoteValue !== $VBlocalValue) {
	$VB_update = true;
	$VB_new_version = $VBremoteValue;
	$VB_update_command = $VBremoteData['update_command'];
	$VB_new_features = $VBremoteData['new_features'];
	$VB_bug_fixed = $VBremoteData['bug_fixed'];
	$VB_improvements = $VBremoteData['improvements'];
	}
	else {
	$VB_update = false;
	$VB_update_command = null;
	$VB_new_features = null;
	$VB_bug_fixed = null;
	$VB_improvements = null;
	}

//End Vietbot Update
        echo json_encode(array(
            'message' => 'successfully',
            'http_response_code' => 200,
            'output_api' => null,
			'info_vietbot' => array(
				'vietbot_version' => array(
					'current_version' => $VBlocalValue,
					'new_version' => $VB_new_version,
					'check_for_updates' => $VB_update,
					'content' => array(
						'update_command' => $VB_update_command,
						'new_features' => $VB_new_features,
						'bug_fixed' => $VB_bug_fixed,
						'improvements' => $VB_improvements
					)
				),
				'ui_version' => array(
					'current_version' => $UIlocalValue,
					'new_version' => $UI_new_version,
					'check_for_updates' => $UI_update,
					'content' => $UI_updated_content
				),
			),
            'info_os' => array(
				'host_name' =>  gethostname(),
				'temperature_cpu' =>  round(file_get_contents("/sys/class/thermal/thermal_zone0/temp") / 1000, 1)." °C",
				'uname_a' =>  php_uname(),
				'kernel_version' => php_uname('v'),
				'machine_type' => php_uname('m'),
				'os_version' => php_uname('r'),
				'server_name' => $_SERVER['SERVER_NAME'],
				'client_ip' => get_client_ip(),
				'php_version' => phpversion(),
				'used_cpu_capacity' => $cpuload."%",
				'cpu_count' => rtrim($cpu_count, "\n"),
				'uptime' => $ut[0]." Ngày, " .$ut[1].":".$ut[2]."'",
				'disk' => array(
						'disk_total' => $disktotal."GB",
						'disk_used' => $diskused."GB",
						'disk_free' => $diskfree."GB"
				),
				'ram' => array(
						'ram_total' => $memtotal."GB",
						'ram_used' => $memused."GB",
						'ram_free' => $memavailable."GB"
				)
			),
            'information' => $information
        ));
        exit();
    } else {
		unauthorized();
    }
}


if ($Enable_API === true) {
// Thực thi lệnh shell sử dụng thư viện SSH2
//SSH2
$connection = ssh2_connect($serverIP, $SSH_Port); // Thay 'hostname' bằng địa chỉ IP hoặc tên miền của máy chủ SSH
if (ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) { // Thay 'username' và 'password' bằng thông tin đăng nhập SSH
    $stream = ssh2_exec($connection, $command); // Thực thi lệnh SSH
    stream_set_blocking($stream, true);
    $output = stream_get_contents($stream); // Lấy kết quả từ luồng kết nối
	$messageee = "successfully";
	$http_response_code = 200;
    fclose($stream);
} else {
    // Xử lý lỗi xác thực SSH
    $output = null;
    $messageee = "Kết nối tới ssh thất bại.";
	$http_response_code = 401;
}
// Thiết lập header cho response
header('Content-Type: application/json');
// Trả về kết quả từ lệnh shell
echo json_encode(array(
	'message' => $messageee,
	'http_response_code' => $http_response_code,
	'output_api' => $output,
	'information' => $information
	));
}else {
    // Xuất thông báo nếu API không được kích hoạt
    echo json_encode(array(
        'message' => $API_Messenger_Disabled,
        'information' => $information
    ));
	exit();
}
	
	
	
	
// Kiểm tra xem chuỗi lệnh có chứa từ khóa trong danh sách an toàn không
function isSafeCommand($command) {
    global $allowedCommands_ALL, $allowedCommands;
    if ($allowedCommands_ALL === "all") {
        return true; // Cho phép chạy tất cả các lệnh nếu có chữ all trong biến file Configuration.php
    } else {
        // Danh sách các lệnh cho phép
        $safeCommands = explode(',', $allowedCommands);
        // Kiểm tra xem lệnh có nằm trong danh sách cho phép không
        foreach ($safeCommands as $safeCommand) {
            if (strpos($command, $safeCommand) !== false) {
                return true;
            }
        }
        return false;
    }
}
//thông báo xác thực key nếu thất bại
function unauthorized(){
        http_response_code(401); // Unauthorized
        echo json_encode(array(
            'message' => 'Xác thực lỗi! Vui lòng kiểm tra lại key api.',
            'http_response_code' => 401,
            'output_api' => null,
            'information' => $information
        ));
        exit();
}
?>
