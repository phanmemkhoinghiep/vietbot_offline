<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../../Configuration.php";
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $MYUSERNAME; ?> Lấy Lại Mật Khẩu WEB UI</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
 <link rel="stylesheet" href="../../assets/css/loading.css">
 <style>
    body,
    html {
        background-color: #dbe0c9;
        overflow-x: hidden;
        /* Ẩn thanh cuộn ngang */
        
        max-width: 100%;
        /* Ngăn cuộn ngang trang */
    }
	 </style>
</head>
<?php	
if (isset($Web_UI_Login) && $Web_UI_Login === true) {
include "ForgotPassword_.php";
	
	} else {
	   
	   		echo "<br/><center><h1>Có Vẻ Như Bạn Chưa Bật Chức Năng Đăng Nhập WEB UI!<br/><br>
		- Nếu Bạn Đã Bật Đăng Nhập, Hãy Nhấn Vào Nút Dưới<br/><br/><a href='$PHP_SELF'><button type='button' class='btn btn-danger'>Tải Lại</button></a></h1>
		</center>";
	   
	   
	}
?>	
	