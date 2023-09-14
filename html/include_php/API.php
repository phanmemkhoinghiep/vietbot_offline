<?php
/**
 * File: secure_execute.php
 * Description: Example code to execute shell commands securely through an API using cURL in PHP.
 * Author: Vũ Tuyển
 * Facebook: https://www.facebook.com/TWFyaW9uMDAx
 * Version: 1.0
 */

include "../Configuration.php";

// Đặt key API mã MD5
$apiKey = '3f406f61a2b5053b53cda80e0320a60b';
$version = "1.0";
$author = "Vũ Tuyển";

$allowedCommands_ALL = "all"; // Biến cho phép chạy tất cả các lệnh
$allowedCommands = "ls,dir,touch,reboot,uname"; // Danh sách các lệnh an toàn

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array(
        'message' => 'Method not allowed.',
        'api_version' => $version,
        'github_vietbot_offline' => $GitHub_VietBot_OFF,
        'ui_vietbot' => $UI_VietBot,
        'author' => $author
    ));
    exit();
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['command']) || !isset($data['api_key'])) {
    http_response_code(400); // Bad Request
    echo json_encode(array('message' => 'Command or API key not provided.'));
    exit();
}

$command = $data['command'];
$providedApiKey = $data['api_key'];

// Kiểm tra xác thực API key
if ($providedApiKey !== md5($apiKey)) {
    http_response_code(401); // Unauthorized
    echo json_encode(array('message' => 'Unauthorized.'));
    exit();
}

// Thực hiện kiểm tra lệnh an toàn trước khi thực thi
if (!isSafeCommand($command)) {
    http_response_code(403); // Forbidden
    echo json_encode(array('message' => 'Forbidden.'));
    exit();
}

// Thực thi lệnh shell sử dụng shell_exec
$output = shell_exec($command);

// Thiết lập header cho response
header('Content-Type: application/json');

// Trả về kết quả từ lệnh shell
echo json_encode(array('output' => $output));

// Hàm kiểm tra lệnh an toàn
function isSafeCommand($command) {
    global $allowedCommands_ALL, $allowedCommands;

    if ($allowedCommands_ALL === "all") {
        return true; // Cho phép chạy tất cả các lệnh
    } else {
        // Danh sách các lệnh an toàn
        $safeCommands = explode(',', $allowedCommands);
        
        // Kiểm tra xem lệnh có nằm trong danh sách an toàn không
        return in_array($command, $safeCommands);
    }
}
?>
