<?php
//Code By: Vũ Tuyển
//Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../Configuration.php";
?>
<html>
<head>
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $MYUSERNAME; ?>, Câp Nhật Giao Diện Vietbot</title>
    <link rel="shortcut icon" href="../assets/img/VietBot128.png">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

<style>
body {
	background-color: #d2d8bb;
	}
    .div-div1 {
      height: 200px; /* Chiều cao giới hạn của thẻ div */
      overflow: auto; /* Hiển thị thanh cuộn khi nội dung vượt quá chiều cao */
      border: 1px solid #ccc; /* Đường viền cho thẻ div */
      padding: 2px; /* Khoảng cách giữa nội dung và đường viền */
	
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
   
}

	#loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    display: none;
}
#loading-icon {
    width: 30px;
    height: 30px;
    position: absolute;
    top: 45%;
    left: 50%;
    transform: translate(-50%, -50%);
}
#loading-message {
	   position: absolute;
    color: white;
	  top: 57%;
    left: 50%;
	  transform: translate(-50%, -50%);
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
	</style>
</head>
<body>
<br/>
</center>
<script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
   <script src="../assets/js/jquery-3.6.1.min.js"></script>
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
      <div id="loading-overlay">
          <img id="loading-icon" src="../assets/img/Loading.gif" alt="Loading...">
		  <div id="loading-message">Đang tiến hành, vui lòng đợi...</div>
    </div>

<?php
    // Hàm đệ quy để sao chép tất cả các tệp và thư mục
    function copyRecursive($source, $destination) {
        $dir = opendir($source);
        @mkdir($destination);

        while (($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $sourceFile = $source . '/' . $file;
                $destinationFile = $destination . '/' . $file;

                if (is_dir($sourceFile)) {
                    copyRecursive($sourceFile, $destinationFile);
                } else {
                    copy($sourceFile, $destinationFile);
                }
            }
        }

        closedir($dir);
    }

    // Hàm đệ quy để xóa nội dung trong thư mục
    function deleteRecursive($path) {
        if (is_dir($path)) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                $filePath = $path . '/' . $file;

                if (is_dir($filePath)) {
                    deleteRecursive($filePath);
                } else {
                    unlink($filePath);
                }
            }

            return rmdir($path);
        } elseif (is_file($path)) {
            return unlink($path);
        }

        return false;
    }
function extractTarGz($file, $destination) {
    $command = "tar -xzf $file -C $destination";
    exec($command);
}
function copyRecursiveExclude($source, $destination, $excludeExtensions = array('.zip', '.tar.gz')) {
    $dir = opendir($source);
    @mkdir($destination);

    while (($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            $sourceFile = $source . '/' . $file;
            $destinationFile = $destination . '/' . $file;

            if (is_dir($sourceFile)) {
                copyRecursiveExclude($sourceFile, $destinationFile, $excludeExtensions);
            } else {
                $extension = pathinfo($sourceFile, PATHINFO_EXTENSION);
                if (!in_array($extension, $excludeExtensions)) {
                    copy($sourceFile, $destinationFile);
                }
            }
        }
    }
    closedir($dir);
}
function deleteDirectory($directory) {
    if (!file_exists($directory)) {
        return;
    }
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($iterator as $file) {
        if ($file->isDir()) {
            rmdir($file->getPathname());
        } else {
            unlink($file->getPathname());
        }
    }
    rmdir($directory);
}
//Chmod 777
if (isset($_POST['set_full_quyen'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream1 = ssh2_exec($connection, 'sudo chmod -R 0777 '.$Path_Vietbot_src);
stream_set_blocking($stream1, true);
$stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO);
stream_get_contents($stream_out1);
header("Location: $PHP_SELF"); exit;
}
// Thư mục cần kiểm tra 777
$directories = array("$DuognDanUI_HTML","$DuognDanThuMucJson");
function checkPermissions($path, &$hasPermissionIssue) {
    $files = scandir($path);
    foreach ($files as $file) {
		// bỏ qua thư mục tts_saved và __pycache__ check quyền
        if ($file === '.' || $file === '..' || $file === 'tts_saved' || $file === '__pycache__' || $file === 'backup') {continue;}
        $filePath = $path . '/' . $file;
        $permissions = fileperms($filePath);
        if ($permissions !== false && ($permissions & 0777) !== 0777) {
            if (!$hasPermissionIssue) {
               // echo "<br/><center><h3 class='text-danger'>Một Số File,Thư Mục Trong <b>$path</b> Không Có Quyền Can Thiệp.<h3><br/>";
			   echo "<center>Phát hiện thấy một số nội dung bị thay đổi quyền hạn.<br/>";
			echo "<form method='post' id='my-form' action='".$PHP_SELF."'> <button type='submit' name='set_full_quyen' class='btn btn-success'>Cấp Quyền</button></form></center>";
                $hasPermissionIssue = true;
				exit();
			}	
            break;}
        if (is_dir($filePath)) {
            checkPermissions($filePath, $hasPermissionIssue);
        }}}
// Kiểm tra từng thư mục 777
foreach ($directories as $directory) {
    $hasPermissionIssue = false;
    checkPermissions($directory, $hasPermissionIssue);
}

if (isset($_POST['checkforupdates_ui'])) {
$localFile = $DuognDanUI_HTML.'/version.json';
// Lấy nội dung JSON từ URL
$remoteJsonData = file_get_contents($UI_Version);
$remoteData = json_decode($remoteJsonData, true);
// Đọc nội dung JSON từ tệp tin cục bộ
$localJsonData = file_get_contents($localFile);
$localData = json_decode($localJsonData, true);
// Lấy giá trị 'value' từ cả hai nguồn dữ liệu
$remoteValue = $remoteData['ui_version']['latest'];
$localValue = $localData['ui_version']['current'];
// So sánh giá trị
if ($remoteValue !== $localValue) {
    $messagee .= 'Có phiên bản mới: '.$remoteValue.'\n';
    $messagee .= 'Phiên bản hiện tại của bạn: '.$localValue.'\n Vui lòng cập nhật.\n';
    $messagee .= $remoteData['ui_version']['notification'].'\n';
} else {
    $messagee .= 'Bạn đang sử dụng phiên bản mới nhất: '.$localValue.'\n';
}
}

if (isset($_POST['ui_update'])) {
$backupDir = $DuognDanUI_HTML.'/ui_update/backup'; // Đường dẫn thư mục sao lưu lại file sao lưu
$timestamp = date('d_m_Y_His');
$backupFile = $backupDir . '/ui_backup_' . $timestamp . '.tar.gz';
$excludeArgs = '--exclude="*.tar.gz" --exclude="backup_update/extract/UI_VietBot-main/*"';
$tarCommand = 'tar -czvf ' . $backupFile . ' ' . $excludeArgs . ' -C ' . dirname($DuognDanUI_HTML) . ' ' . basename($DuognDanUI_HTML);
exec($tarCommand, $output, $returnCode);
if ($returnCode === 0) {
    chmod($backupFile, 0777);
  //  $messagee .= 'Tạo bản sao lưu giao diện thành công, hãy tải lại trang để áp dụng\n';
    $backupFiles = glob($backupDir . '/*.tar.gz');
    $numBackupFiles = count($backupFiles);
    if ($numBackupFiles > $maxBackupFilesUI) {
        usort($backupFiles, function ($a, $b) {
            return filemtime($a) - filemtime($b);
        });
        $filesToDelete = array_slice($backupFiles, 0, $numBackupFiles - $maxBackupFilesUI);
        foreach ($filesToDelete as $file) {
            unlink($file);
			$basenameeee = basename($file);
           // $messagee .= 'Backup đạt giới hạn, đã xóa tệp tin sao lưu cũ: ' . $basenameeee . '\n';
        }
    }
} else {
    $messagee .= 'Có lỗi xảy ra khi tạo bản sao lưu.\n';
}
//END sao Lưu
$url = $UI_VietBot.'/archive/master.zip';
$zipFile = $DuognDanUI_HTML.'/ui_update/dowload_extract/UI_VietBot.zip';
$extractPath = $DuognDanUI_HTML.'/ui_update/extract';
//$destinationPath = '/home/pi/vietbot_offline/html';
$sourceDirectory = $extractPath . '/UI_VietBot-main';
// Tải tập tin từ URL
$fileContents = file_get_contents($url);
// Lưu nội dung vào tập tin đích
file_put_contents($zipFile, $fileContents);
// Mở tập tin zip
$zip = zip_open($zipFile);
if ($zip) {
    // Lặp qua các mục trong tập tin zip
    while ($zipEntry = zip_read($zip)) {
        $entryName = zip_entry_name($zipEntry);
        $entryPath = $extractPath . '/' . $entryName;
        // Tạo các thư mục cha nếu chưa tồn tại
        $dirPath = dirname($entryPath);
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true);
        }
        // Mở mục trong tập tin zip
        if (zip_entry_open($zip, $zipEntry, "r")) {
            // Đọc nội dung mục trong tập tin zip
            $entryContent = zip_entry_read($zipEntry, zip_entry_filesize($zipEntry));
            // Lưu nội dung vào đường dẫn cụ thể
            file_put_contents($entryPath, $entryContent);
            // Đóng mục trong tập tin zip
            zip_entry_close($zipEntry);
        }
    }
    // Đóng tập tin zip
    zip_close($zip);
  //  $messagee .= 'Đã tải xuống và giải nén giao diện mới thành công!\n';
    // Gọi hàm sao chép đệ quy
    copyRecursive($sourceDirectory, $DuognDanUI_HTML);
    $messagee .= 'Cập nhật giao diện mới thành công!\n';
    $messagee .= 'Bạn Hãy Tắt Trang Và Truy Cập Lại Để Áp Dụng, (Hoặc F5 Để Áp Dụng)....!\n';
    // Gọi hàm xóa đệ quy
    deleteRecursive($sourceDirectory);
	shell_exec("rm $zipFile");
} else {
    $messagee .= 'Có lỗi xảy ra, không thể mở tập tin giao diện đã tải về!\n';
}
//Chmod 777 khi chạy xong backup
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream1 = ssh2_exec($connection, 'sudo chmod -R 0777 '.$Path_Vietbot_src);
$stream2 = ssh2_exec($connection, 'sudo chown -R pi:pi '.$Path_Vietbot_src);
stream_set_blocking($stream1, true); 
stream_set_blocking($stream2, true); 
$stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO); 
$stream_out2 = ssh2_fetch_stream($stream2, SSH2_STREAM_STDIO); 
stream_get_contents($stream_out1);
stream_get_contents($stream_out2);
}
if (isset($_POST['restors_ui'])) {
    $selectedFile = $_POST['tarFile'];
    if ($selectedFile === "....") {
        $message .= 'Vui lòng chọn file cần khôi phục!\n\n';
    } else {
        $tarFile = $DuognDanUI_HTML.'/ui_update/backup/' . $selectedFile;
        $extractDirectory = $DuognDanUI_HTML.'/ui_update/extract';
        //$copyDestination = '/home/pi/vietbot_offline/html';
        $deleteDirectory = $extractDirectory . '/html';
        // Giải nén tệp tin .tar.gz
        extractTarGz($tarFile, $extractDirectory);
        // Sao chép nội dung và loại trừ các tệp .zip và .tar.gz
        copyRecursiveExclude($extractDirectory . '/html', $DuognDanUI_HTML, array('.zip', '.tar.gz'));
        // Xóa thư mục /home/pi/vietbot_offline/html/ui_update/extract/html
        deleteDirectory($deleteDirectory);
         $message .= 'Đã khôi phục giao diện backup thành công! \n';
         $message .= 'Bạn Hãy Tải Lại Trang Để Áp Dụng....! \n';
    }
}
if (isset($_POST['download']) && isset($_POST['tarFile'])) {
    $selectedFile = $_POST['tarFile'];
    $filePath = '/ui_update/backup/' . $selectedFile; // Đường dẫn đến thư mục chứa tệp tin
    if ($selectedFile === "....") {
         $message .= 'Vui lòng chọn file cần tải xuống!\n\n';
    } else {
        // Tạo liên kết tới trang mục tiêu trong tab mới
        $targetLink = "http://$serverIP$filePath"; // Đặt đường dẫn mục tiêu tại đây
        echo "<script>window.open('$targetLink', '_blank');</script>";
    }
}
?>
  <form method="POST" id="my-form" action="">
   	<div class="my-div">
    <span class="corner-text"><h5>Cập Nhật:</h5></span><br/><br/>
	<center> 
	<div id="messagee"></div><br/></center>
  <div class="row justify-content-center"><div class="col-auto"><div class="input-group">
    		  <input type="submit" name="checkforupdates_ui" class="btn btn-success" value="Kiểm tra">
		   <input type="submit" name="ui_update" class="btn btn-warning" value="Cập Nhật">
		   <a class="btn btn-danger" href="<?php echo $PHP_SELF; ?>" role="button">Làm Mới</a>
		   </div>
		   </div>
		   </div>  <br/></div>
	<br/>   <div class="my-div">
    <span class="corner-text"><h5>Sao Lưu/Khôi Phục:</h5></span><br/><br/>

<center><div id="message"></div></center>

	   <div class="row justify-content-center"><div class="col-auto"><div class="input-group">
<?php
$directory = $DuognDanUI_HTML.'/ui_update/backup';
// Lấy danh sách các tệp .tar.gz trong thư mục
$files = glob($directory . '/*.tar.gz');
// Tạo đoạn mã HTML cho select dropdown
$selectDropdown = '<select class="form-select" name="tarFile"><option value="....">Chọn File Giao Diện</option>';
// Lặp qua từng tệp và thêm mục vào select dropdown
foreach ($files as $file) {
    // Lấy tên tệp từ đường dẫn đầy đủ
    $filename = basename($file);
    // Thêm mục vào select dropdown
    $selectDropdown .= '<option value="' . $filename . '">' . $filename . '</option>';
}
$selectDropdown .= '</select>';
// Hiển thị select dropdown
echo $selectDropdown;
?>
<input type="submit" name="download" class="btn btn-primary" value="Tải xuống">
<input type="submit" name="restors_ui" class="btn btn-warning" value="Khôi Phục">
</div>
</div>
</div><br/>
  </div>
  </form>
 <br/> <p class="right-align"><b>Phiên bản giao diện:  <font color=red><?php echo $dataVersionUI->ui_version->current; ?></font></b></p>
  
  	    <script>
        var messageElement = document.getElementById("message");
        var message = "<?php echo $message; ?>";
        messageElement.innerText = message;
    </script>
	
	
	    <script>
        var messageElementt = document.getElementById("messagee");
        var messagee = "<?php echo $messagee; ?>";
        messageElementt.innerText = messagee;
    </script>
	</body>
	</html>
