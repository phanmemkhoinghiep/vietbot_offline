<?php
// Nhận URL và token từ yêu cầu GET
$url = $_GET['url']; // URL từ yêu cầu GET
$token = $_GET['token']; // Token từ yêu cầu GET




// Tạo một yêu cầu HTTP GET để lấy danh sách các thiết bị từ Home Assistant
// Thực hiện kiểm tra Home Assistant bằng cURL
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json',
]);

$response = curl_exec($ch);
$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Lấy mã trạng thái HTTP

// Kiểm tra lỗi cURL
if (curl_errno($ch)) {
    echo json_encode(['error' => 'Lỗi cURL: ' . curl_error($ch)]);
} else {
    // Kiểm tra mã trạng thái HTTP 401 (Unauthorized)
    if ($httpStatus === 401) {
        http_response_code(401); // Trả về mã trạng thái 401
        echo json_encode(['error' => '[401] Lỗi, không có quyền truy cập, Hãy kiểm tra lại mã token']);
    } elseif ($httpStatus === 404) {
        http_response_code(404); // Trả về mã trạng thái 404
        echo json_encode(['error' => '[404] Lỗi, không tìm thấy dữ liệu, hãy kiểm tra lại địa chỉ HomeAssistant hoặc Token']);
    } else {
        echo $response;
    }
}

curl_close($ch);




?>
