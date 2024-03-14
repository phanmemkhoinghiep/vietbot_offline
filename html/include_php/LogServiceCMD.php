<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../Configuration.php";
?>
<!DOCTYPE html>
<!--
Code By: Vũ Tuyển
Facebook: https://www.facebook.com/TWFyaW9uMDAx
-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $MYUSERNAME; ?>, Check Log, Services, CMD VietBot</title>
    <link rel="shortcut icon" href="../assets/img/VietBot128.png">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="../assets/css/loading.css">
  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
	<style>
    body, html {
        background-color: #6c757d;
		overflow-x: hidden; /* Ẩn thanh cuộn ngang */
		max-width: 100%; /* Ngăn cuộn ngang trang */
    }
    
::-webkit-scrollbar {
    width: 10px; 
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
.scrollable-menu {
    height: auto;
    max-height: 200px;
    overflow-x: hidden;
}
	</style>
	</head>

<?php	
if (isset($Web_UI_Login) && $Web_UI_Login === true) {
	if (!isset($_SESSION['root_id'])) {
		echo "<br/><center><h1>Có Vẻ Như Bạn Chưa Đăng Nhập!<br/><br>
		- Nếu Bạn Đã Đăng Nhập, Hãy Nhấn Vào Nút Dưới<br/><br/><a href='$PHP_SELF'><button type='button' class='btn btn-danger'>Tải Lại</button></a></h1>
		</center>";
		exit();
}
	include "Fork_PHP/LogServiceCMD_.php";
	
	} else {
	   
	   include "Fork_PHP/LogServiceCMD_.php";
	   
	   
	}
?>	
	
