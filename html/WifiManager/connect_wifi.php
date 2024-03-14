<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../Configuration.php";
?>

<?php

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'connect_wifi' && isset($_POST['wifiName'])) {

    // Lấy tên SSID từ dữ liệu POST
    $ssid = $_POST['wifiName'];
	
		$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, "sudo nmcli connection up '$ssid'");
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$result = stream_get_contents($stream_out);
	
    //$result = shell_exec("sudo nmcli device wifi connect '$ssid' password '$password'");
    // Trả về thông báo kết quả (tùy thuộc vào $result)
    echo $result;
		
    } 
    elseif ($action == 'connect_and_save_wifi' && isset($_POST['ssid'])) {
		
    // Lấy tên SSID và mật khẩu từ dữ liệu POST
    $ssid = $_POST['ssid'];
    $password = $_POST['password'];
	
	
	    if (!empty($password)) {
        //nếu mật khẩu có dữ liệu thì wifi có pass chạy lệnh
        $Command = "sudo nmcli device wifi connect '$ssid' password '$password'";
    } else {
        // Nếu không có dữ liệuthì wifi mở sẽ chạy lệnh
         $Command = "sudo nmcli device wifi connect '$ssid'";
    }


		$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, $Command);
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$result = stream_get_contents($stream_out);
	
    //$result = shell_exec("sudo nmcli device wifi connect '$ssid' password '$password'");
    // Trả về thông báo kết quả (tùy thuộc vào $result)
    echo $result;
    
	
	
	} 
    else {
        echo "Hành động không được phép";
    }
} 
else {
    echo "Yêu cầu không được phép";
}
?>

