<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include "../Configuration.php";
include("../assets/lib_php/Net/SSH2.php");
?>
<!DOCTYPE html>
<html><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $MYUSERNAME; ?>, Google Drive Backup</title>
    <link rel="shortcut icon" href="../assets/img/VietBot128.png">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="../assets/css/loading.css">
  <script src="../assets/js/jquery.min.js"></script>
<!--  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script> -->
  	<style>
		body, html {
        background-color: #d2d8bb;
		/* overflow-x: hidden; */
		max-width: 100%;
    }
	
        .right-align {
            text-align: right;
			margin-right: 30px;
        }
    
	</style>
  </head>
<?php	
if (isset($Web_UI_Login) && $Web_UI_Login === true) {
	if (!isset($_SESSION['root_id'])) {
		echo "<html><body><br/><center><h1>Có Vẻ Như Bạn Chưa Đăng Nhập!<br/><br>
		- Nếu Bạn Đã Đăng Nhập, Hãy Nhấn Vào Nút Dưới<br/><br/><a href='$PHP_SELF'><button type='button' class='btn btn-danger'>Tải Lại</button></a></h1>
		</center></body></html>";
		exit();
}
	include "index_.php";
	
	} else {
	   
	   	include "index_.php";
	   
	   
	}
?>	
	
