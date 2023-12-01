<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
//error_reporting(E_ALL);
?>


<body>
 <script src="../../assets/js/jquery-3.6.1.min.js"></script>
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
<br/>
<center>
<br/>
<?php
include ($DuognDanUI_HTML.'/assets/lib_php/smtp/PHPMailerAutoload.php');


$jsonContent = file_get_contents($DuognDanUI_HTML.'/assets/json/password.json');
// Giải mã JSON thành một mảng asscociative
$data = json_decode($jsonContent, true);



if (isset($_POST['re_configuration'])) { 
$mail_forgot = $_POST['mail_forgot'];

if ($data && isset($data['mail']) && $data['mail'] === $mail_forgot) {
	
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
//$stream1 = ssh2_exec($connection, "sudo chmod -R 0777 $Path_Vietbot_src");
$stream2 = ssh2_exec($connection, "rm $DuognDanUI_HTML/assets/json/password.json");
//stream_set_blocking($stream1, true); 
stream_set_blocking($stream2, true); 
//$stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO); 
$stream_out2 = ssh2_fetch_stream($stream2, SSH2_STREAM_STDIO); 
//stream_get_contents($stream_out1); 
stream_get_contents($stream_out2); 
session_unset();
session_destroy();
echo "<font size=4 color=red><b>- Cấu hình lại được thực hiện thành công<br/>- Tất cả dữ liệu mail, mật khẩu đã được xóa</b></font><br/><br/>";
} else {
    echo "<font size=4 color=red><b>Mail không trùng khớp</b></font><br/><br/>";
}

}

 
if (isset($_POST['start_send_mail'])) { 
 
 $mail_forgot = $_POST['mail_forgot'];
 $Get_Pass_Base = base64_decode($data['salt']);

 if ($data && isset($data['mail']) && $data['mail'] === $mail_forgot) {
	$subject = "Loa Thông Minh Vietbot";
	$msg = "Mật khẩu đăng nhập Web UI của <b>$MYUSERNAME</b> là: <font size=4 color=red><b>$Get_Pass_Base</b></font>
	<br/>- Địa Chỉ IP Loa Vietbot: <font color=red>$serverIP</font><br/>- Host Name: <font color=red>$HostName</font>
	<br/>- Group Hỗ Trợ: https://www.facebook.com/groups/1082404859211900<br/>
	Chúng tôi luôn sẵn sàng hỗ trợ bạn. Xin cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.<br/><br/>
	<b><i>Trân trọng!</i></b>";
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = $Mail_SMTPSecure; 
	$mail->Host = $Mail_Host;
	$mail->Port = $Mail_Port; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	//$mail->SMTPDebug = 2; 
	$mail->Username = base64_decode($Mail_Gmail);
	$mail->Password = base64_decode($Mail_APP_Passwords);
	$mail->SetFrom("email");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	//$mail->AddAddress($to);
	$mail->AddAddress($data['mail']);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo "<font size=4 color=red>Không Thành Công, Có Lỗi Xảy Ra: <b>".$mail->ErrorInfo."</b></font><br/><br/>";
	}else{
	//	return 'Sent';
	echo "<font size=4 color=red><b>Thành Công, Mật Khẩu Đã Được Gửi Tới Mail Của Bạn.</b></font><br/><br/>";
	}
} else {
    echo "<font size=4 color=red><b>Mail không trùng khớp</b></font><br/><br/>";
}
}
?>
<form id='my-form'  method='POST'>

 Mail của bạn: 
 	<?php 
$parts = explode('@', $data['mail']);
// Lấy phần username
$username = $parts[0];
// Lấy phần domain
$domain = $parts[1];
// Lấy 2 ký tự đầu và 2 ký tự trước dấu '@'
$visibleUsername = substr($username, 0, 2);
$visibleUsername .= str_repeat('*', strlen($username) - 4);
$visibleUsername .= substr($username, -2);
// Kết hợp phần username đã ẩn và phần domain để tạo địa chỉ email mới
$hiddenEmail = $visibleUsername . '@' . $domain;
echo "<font color=red>".$hiddenEmail."</font><br/>";
	?>
 <br/>Nhập Địa Chỉ Mail:
 <input type="text" class="input-group-text" name="mail_forgot" placeholder="Nhập Địa Chỉ Mail" title="Nhập địa chỉ mail của bạn đã cấu hình trước đó" required><br/>
 <button type='submit' name='start_send_mail' class='btn btn-success' title="Gửi mật khẩu về mail đã được thiết lập trước đó.">Send Mail</button>
 <button type='submit' name='re_configuration' class='btn btn-warning' title="Xóa tất cả dữ liệu được lưu trước đó bao gồm Mật Khẩu, Mail. Sau đó bạn cần nhập mới lại tại Trang Chính">Re-Configuration</button>
 <a href='ForgotPassword.php'><button type='button' class='btn btn-danger' title="Tải lại trang">Tải Lại</button></a><br/>
 
 </center></form><br/><br/>
 - <b>Lưu Lý:</b> <i>cần nhập mail của bạn vào ô trước, sau đó click vào 1 trong 2 nút 
	<font color=red>Send Mail:</font> hoặc <font color=red>Re-Configuration:</font> tương ứng với yêu cầu của bạn</i></b><br/><br/>
 - <b><font color=red>Send Mail:</b></font> <i>Gửi mật khẩu về mail đã được thiết lập trước đó.</i></b><br/>
 - <b><font color=red>Re-Configuration:</font> <i>Xóa tất cả dữ liệu được lưu trước đó bao gồm Mật Khẩu, Mail. Sau đó bạn cần nhập mới lại tại Trang Chính</i></b>
 
 
     <div id="loading-overlay">
          <img id="loading-icon" src="../../assets/img/Loading.gif" alt="Loading...">
		  <div id="loading-message">Đang Thực Thi...</div>
    </div>
 
</center>
</body></html>