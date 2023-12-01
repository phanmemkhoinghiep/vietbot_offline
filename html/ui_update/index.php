<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../Configuration.php";
include("../assets/lib_php/Net/SSH2.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>
        <?php echo $MYUSERNAME; ?>, Câp Nhật Giao Diện Vietbot</title>
    <link rel="shortcut icon" href="../assets/img/VietBot128.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/loading.css">

    <style>
        body,
        html {
            background-color: #d2d8bb;
            overflow-x: hidden;
            /* Ẩn thanh cuộn ngang */
            
            max-width: 100%;
            /* Ngăn cuộn ngang trang */
        }
        
        .div-div1 {
            height: 200px;
            /* Chiều cao giới hạn của thẻ div */
            
            overflow: auto;
            /* Hiển thị thanh cuộn khi nội dung vượt quá chiều cao */
            
            border: 1px solid #ccc;
            /* Đường viền cho thẻ div */
            
            padding: 2px;
            /* Khoảng cách giữa nội dung và đường viền */
        }
        
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            -webkit-border-radius: 10px;
            border-radius: 10px;
            background: rgb(251, 255, 7);
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
        }
        
        .scrollable-menu {
            height: auto;
            max-height: 200px;
        }
        
        .my-div {
            border: 1.5px solid black;
            border-radius: 10px;
            position: relative;
            margin-left: 5px;
            margin-right: 5px;
        }
        
        .corner-text {
            position: absolute;
            top: 10px;
            left: 10px;
        }
        
        .right-align {
            text-align: right;
        }
        
        .inline-elements {
            display: inline-block;
            vertical-align: middle;
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
	include "index_.php";
	
	} else {
	   
	  include "index_.php";
	   
	   
	}
?>	
	