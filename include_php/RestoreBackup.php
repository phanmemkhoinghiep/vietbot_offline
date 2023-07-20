<html>
<head>
<!--
Code By: Vũ Tuyển
Facebook: https://www.facebook.com/TWFyaW9uMDAx
-->
    <title><?php echo $MYUSERNAME; ?>, Cấu Hình Config</title>
	    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" href="../assets/img/VietBot128.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-icons.css">
	</head>
	<body>
<?php
// Đường dẫn đến thư mục "Backup_Config"
$backupDir = "Backup_Config/";
// Lấy danh sách các file .json trong thư mục "Backup_Config"
$fileListt = glob($backupDir . "*.json");
// Kiểm tra xem có file nào trong thư mục hay không
if (count($fileListt) > 0) {
    // Tạo dropdown list để hiển thị các file
    echo '<form method="post">';
    echo '<select name="selectedFile">';
    echo '<option value="">Chọn file config</option>'; // Thêm lựa chọn "Chọn file"
    foreach ($fileListt as $file) {
        $fileName = basename($file);
        echo '<option value="' . $file . '">' . $fileName . '</option>';
    }
    echo '</select>';
    echo '<input type="submit" value="Restore/Khôi Phục">';
    echo '</form>';
    // Xử lý khi form được submit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Kiểm tra xem file đã được chọn hay chưa
        if (isset($_POST['selectedFile']) && !empty($_POST['selectedFile'])) {
            $selectedFile = $_POST['selectedFile'];
            $configFile = $backupDir . "../config.json";

            // Đọc nội dung file được chọn
            $fileContent = file_get_contents($selectedFile);

            // Ghi nội dung file được chọn vào file "config.json"
            file_put_contents($configFile, $fileContent);

            echo "Đã Khôi Phục File Được Chọn Thành Công.";
        }
    }
} else {
    echo "Không tìm thấy file trong thư mục.";
}
?>
</body>
</html>