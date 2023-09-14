<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Mã hóa MD5</title>
</head>
<body>
    <center><h1>Mã hóa MD5</h1>
    <form method="post" action="">
        <label for="text">Nhập chuỗi cần mã hóa:</label>
        <input type="text" id="text" name="text">
        <input type="submit" value="Mã hóa">
    </form><br/>

    <?php
    // Xử lý khi biểu mẫu được gửi đi
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ trường nhập liệu
        $text = $_POST["text"];

        // Kiểm tra xem người dùng đã nhập dữ liệu hay chưa
        if (empty($text)) {
            echo "Vui lòng nhập chuỗi cần mã hóa.";
        } else {
            // Mã hóa chuỗi bằng MD5
            $md5_hash = md5($text);
            echo "Chuỗi gốc: <font color=red><b>" . $text . "</b></font><br><br/>";
            echo "MD5 Hash: <font color=red><b>" . $md5_hash."</b></font>";
        }
    }
    ?>
	</center>
</body>
</html>
