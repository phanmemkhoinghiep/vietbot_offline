<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../Configuration.php";
?>
<!DOCTYPE html>
<html lang="vi">
<!--
Code By: Vũ Tuyển
Facebook: https://www.facebook.com/TWFyaW9uMDAx
-->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title>Vietbot WiFi Management</title>



<?php	
if (isset($Web_UI_Login) && $Web_UI_Login === true) {
	if (!isset($_SESSION['root_id'])) {
		echo "<!DOCTYPE html><head><link rel='stylesheet' href='../assets/css/loading.css'><link rel='stylesheet' href='../assets/css/bootstrap.css'></head><body><br/><center><h1>Có Vẻ Như Bạn Chưa Đăng Nhập!<br/><br>
		- Nếu Bạn Đã Đăng Nhập, Hãy Nhấn Vào Nút Dưới<br/><br/><a href='$PHP_SELF'><button type='button' class='btn btn-danger'>Tải Lại</button></a></h1>
		</center></body></html>";
		exit();
}
	include "index_.php";
	
	} else {
	   
	   	include "index_.php";
	   
	   
	}
?>	



