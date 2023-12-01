<?php
// Nhận URL và token từ yêu cầu GET
//$url = $_GET['url']; // URL từ yêu cầu GET
$token = $_GET['token']; // Token từ yêu cầu GET




// Tạo một yêu cầu HTTP GET để lấy danh sách các thiết bị từ Home Assistant
// Thực hiện kiểm tra Home Assistant bằng cURL
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.openweathermap.org/data/2.5/weather?id=1581130&appid=$token", //1581130 hà nội
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Lấy mã trạng thái HTTP

// Kiểm tra lỗi cURL
if (curl_errno($curl)) {
    echo json_encode(['error' => 'Lỗi cURL: ' . curl_error($curl)]);
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

curl_close($curl);




?>
