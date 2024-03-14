<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../Configuration.php";
?>
<?php
// Kiểm tra nếu có tham số 'action' và 'wifiName' trong yêu cầu POST
if (isset($_POST['action']) && $_POST['action'] == 'delete_wifi' && isset($_POST['wifiName'])) {
    // Thực hiện lệnh xóa WiFi
    $wifiName = $_POST['wifiName'];
    //$result = shell_exec("sudo nmcli connection delete $wifiName");
	
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, "sudo nmcli connection delete '$wifiName'");
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
echo stream_get_contents($stream_out);

    //echo $result;
} else {
    echo "Lỗi khi Xóa Wifi: '$wifiName'";
}
?>
