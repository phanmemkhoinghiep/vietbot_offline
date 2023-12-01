<?php
//Code By: Vũ Tuyển
//Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../../Configuration.php";
?>
<!DOCTYPE html>
<html><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $MYUSERNAME; ?>, Change Pass Web UI</title>
    <link rel="shortcut icon" href="../../assets/img/VietBot128.png">
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="../../assets/css/loading.css">
  <script src="../../assets/js/jquery.min.js"></script>
  <script src="../../assets/js/popper.min.js"></script>
  <script src="../../assets/js/bootstrap.min.js"></script>
  <style>
    body, html {
        background-color: #dbe0c9;
		overflow-x: hidden; /* Ẩn thanh cuộn ngang */
		max-width: 100%; /* Ngăn cuộn ngang trang */
    }
    </style>
	</head>
	<body>
	
<center>
<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['root_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập (index.php)
    //header("Location: ./index.php");
	echo "<br/><center><h1>Có Vẻ Như Bạn Chưa Đăng Nhập!<br/><br>
	- Nếu Bạn Đã Đăng Nhập, Hãy Nhấn Vào Nút Dưới<br/><br/><a href='$PHP_SELF'><button type='button' class='btn btn-danger'>Tải Lại</button></a></h1>
	</center>";
    exit();
}
?>
    <h2>Thay Đổi Mật Khẩu Web UI</h2>
<?php
    $jsonDataa = file_get_contents("$DuognDanUI_HTML"."/assets/json/password.json");
    $dataa = json_decode($jsonDataa, true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ biểu mẫu
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];
    // Đọc mật khẩu từ tệp JSON
    $jsonData = file_get_contents("$DuognDanUI_HTML"."/assets/json/password.json");
    $data = json_decode($jsonData, true);
    // Kiểm tra xem có giá trị mật khẩu_ui trong dữ liệu không
    if (isset($data['password_ui'])) {
        $password_ui = $data['password_ui'];
        // Kiểm tra xem mật khẩu cũ nhập từ biểu mẫu có khớp với mật khẩu trong tệp JSON không
        if (md5($currentPassword) === $password_ui) {
            // Mật khẩu cũ hợp lệ
            if ($newPassword === $confirmNewPassword) {
                // Mật khẩu mới khớp
                // Bạn có thể tiếp tục xử lý việc thay đổi mật khẩu ở đây
                echo "<font color=red size=3><b><i>Mật khẩu đã được thay đổi thành công.</i></b></font><br/><br/>";
				 // Cập nhật mật khẩu mới trong dữ liệu JSON
                $data['password_ui'] = md5($newPassword);
                // Chuyển dữ liệu thành chuỗi JSON
                $updatedJsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                // Ghi dữ liệu cập nhật vào tệp JSON
                file_put_contents("$DuognDanUI_HTML"."/assets/json/password.json", $updatedJsonData);
            } else {
                echo "<font color=red size=3><b><i>Mật khẩu mới không khớp</i></b></font><br/><br/>";
            }
        } else {
            echo "<font color=red size=3><b><i>Mật khẩu cũ không đúng.</i></b></font><br/><br/>";
        }
    } else {
        echo "<font color=red size=3><b><i>Không tìm thấy mật khẩu trong dữ liệu.</i></b></font><br/><br/>";
    }
}
?>


    <form action="" method="POST">
	Mail: 
	<?php 
$parts = explode('@', $dataa['mail']);
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
        <label for="currentPassword">Nhập mật khẩu cũ:</label>
        <input type="password" class="input-group-text" id="currentPassword" name="currentPassword" required>
        <br>

        <label for="newPassword">Mật Khẩu Mới:</label>
        <input type="password" class="input-group-text" id="newPassword" name="newPassword" required>

        <label for="confirmNewPassword">Nhập Lại Mật Khẩu Mới:</label>
        <input type="password" class="input-group-text" id="confirmNewPassword" name="confirmNewPassword" required>
        <br>
        <input type="checkbox" id="showPassword">
        <label for="showPassword">Hiển Thị Mật Khẩu</label> | <a style="color:Green" href="/#ForgotPassword" target="_bank"><b>Quên mật khẩu</b></a><br/> 
        <input type="submit" class="btn btn-primary" value="Đổi Mật Khẩu">
    </form></center>
	
	
	
	    <script>
        const showPasswordCheckbox = document.getElementById('showPassword');
        const passwordInputs = document.querySelectorAll('input[type="password"]');

        showPasswordCheckbox.addEventListener('change', function () {
            const newType = showPasswordCheckbox.checked ? 'text' : 'password';
            passwordInputs.forEach(function (input) {
                input.type = newType;
            });
        });
    </script>
</body>
</html>

