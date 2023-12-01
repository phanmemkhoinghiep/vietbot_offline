<?php
include "../../Configuration.php";
include("../../assets/lib_php/Net/SSH2.php");

function getFinalUrl($url) {
    $ch = curl_init($url);
    // Cài đặt các tùy chọn cURL để trả về dữ liệu thay vì hiển thị nó
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Cài đặt cURL để theo dõi tất cả các chuyển hướng
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // Cài đặt thời gian chờ
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    // Tắt chế độ DNS lookup (chỉ sử dụng IPv4)
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    // Tắt xác minh SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Thực hiện yêu cầu cURL và lấy thông tin về chuyển hướng
    curl_exec($ch);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    // Đóng kết nối cURL
    curl_close($ch);
    return $finalUrl;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['url'])) {
    $url = $_GET['url'];

    // Kiểm tra xem chuỗi đầu vào có chứa 'mp3/' hay không
    if (strpos($url, 'mp3/') !== false) {
        echo json_encode(['finalUrl' => $url]);
    } elseif (strpos($url, "https://www.youtube.com/watch?v=") !== false) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://youtubemp3nodejs-67a7bc8771a0.herokuapp.com/link?url=$url",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $output = curl_exec($curl);

        // Kiểm tra xem có lỗi không
        if ($output === false) {
            // Thực hiện mã sau khi cURL không thành công
            $command = "node $DuognDanUI_HTML/include_php/Ajax/Youtube_MP3_Link_Play.js " . escapeshellarg($url);
			//$command = "python3 $DuognDanUI_HTML/include_php/Ajax/Youtube_MP3_Link_Play.py " . escapeshellarg($url);
            $connection = ssh2_connect($serverIP, $SSH_Port);
            if (!$connection) {
                die($Error_HOST);
            }
            if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {
                die($Error);
            }
            $stream = ssh2_exec($connection, $command);
            stream_set_blocking($stream, true);
            $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
            $output = stream_get_contents($stream_out);
            $output = rtrim($output, "\n");
            // In kết quả sau khi thực hiện các bước thay thế
            echo json_encode(['finalUrl' => $output]);
        } else {
            // Kiểm tra xem dữ liệu trả về có chứa "https://" không
            if (strpos($output, "https://") === false) {
                // Nếu không có "https://", thực hiện các lệnh khác
                $command = "node $DuognDanUI_HTML/include_php/Ajax/Youtube_MP3_Link_Play.js " . escapeshellarg($url);
				//$command = "python3 $DuognDanUI_HTML/include_php/Ajax/Youtube_MP3_Link_Play.py " . escapeshellarg($url);
                $connection = ssh2_connect($serverIP, $SSH_Port);
                if (!$connection) {
                    die($Error_HOST);
                }
                if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {
                    die($Error);
                }
                $stream = ssh2_exec($connection, $command);
                stream_set_blocking($stream, true);
                $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
                $output = stream_get_contents($stream_out);
                // Trim trailing newline characters
                $output = rtrim($output, "\n");

                // In kết quả sau khi thực hiện các bước thay thế
                echo json_encode(['finalUrl' => $output]);
            } else {
                // Nếu có "https://", in kết quả
                echo json_encode(['finalUrl' => $output]);
            }
        }
        curl_close($curl);

    } else {
        // Tiếp tục thực hiện yêu cầu cURL chỉ khi không có 'mp3/' trong đường dẫn
        $finalUrl = getFinalUrl($url);
        echo json_encode(['finalUrl' => $finalUrl]);
    }
} else {
    echo json_encode(['error' => 'Yêu cầu không hợp lệ']);
}
?>
