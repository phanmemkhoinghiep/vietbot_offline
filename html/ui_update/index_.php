<?php
//Code By: Vũ Tuyển
//Facebook: https://www.facebook.com/TWFyaW9uMDAx
//include "../Configuration.php";
?>


<body>
  <!--  <script src="../assets/js/jquery.min.js"></script> -->
    <script src="../assets/js/popper.min.js"></script>
	<script src="../assets/js/jquery-3.6.1.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    
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
echo '<center><div id="messageee"></div></center>';
if (isset($_POST['install_lib_gdrive'])) {
$compressedFilePath = $DuognDanUI_HTML.'/assets/lib_php/lib_Google_APIs_Client_php.tar.gz';
$extractedFolderPath = $DuognDanUI_HTML.'/assets/lib_php/';
try {
    // Tải xuống tệp từ URL
    $fileContents = file_get_contents($url_lib_GDrive);
    if ($fileContents === false) {
        //throw new Exception("Lỗi: Không thể tải xuống tệp từ URL.");
			echo "<script>";
            echo "var messageee = document.getElementById('messageee');";
            echo "messageee.innerHTML += '<font color=red>Lỗi: Không thể tải xuống thư viện từ URL</font><br/>';";
            echo "</script>";
    }
    // Lưu nội dung vào tệp cục bộ
    $result = file_put_contents($compressedFilePath, $fileContents);
    if ($result === false) {
       // throw new Exception("Lỗi: Không thể lưu trữ tệp tải xuống.");
			echo "<script>";
            echo "var messageee = document.getElementById('messageee');";
            echo "messageee.innerHTML += '<font color=red>Lỗi: Không thể lưu trữ tệp tải xuống.</font><br/>';";
            echo "</script>";
    }
			//echo "<script>";
            //echo "var messageee = document.getElementById('messageee');";
            //echo "messageee.innerHTML += '<font color=red>Thư viện được cài đặt thành công.</font><br/>';";
            //echo "</script>";
			chmod("$DuognDanUI_HTML/assets/lib_php/lib_Google_APIs_Client_php.tar.gz", 0777);
			// Giải nén tệp .tar.gz
			$phar = new PharData($compressedFilePath);
			$phar->extractTo($extractedFolderPath);
			//  echo "Tệp đã được giải nén vào $extractedFolderPath<br/>";
			chmod("$DuognDanUI_HTML/assets/lib_php/vendor", 0777);
	// Kiểm tra xem tệp tin tồn tại trước khi xóa
if (file_exists($compressedFilePath)) {
    // Thực hiện lệnh xóa bằng system
    $command = "rm $compressedFilePath";
    $output = system($command, $returnValue);
    // Kiểm tra giá trị trả về để xem lệnh có thành công không
    if ($returnValue === 0) {
    } else {
			echo "<script>";
            echo "var messageee = document.getElementById('messageee');";
            echo "messageee.innerHTML += '<font color=red>Xóa tệp tin <b>lib_Google_APIs_Client_php.tar.gz</b> Thất Bại</font><br/>';";
            echo "</script>";
    }
} else {
			echo "<script>";
            echo "var messageee = document.getElementById('messageee');";
            echo "messageee.innerHTML += '<font color=red>Tệp tin <b>lib_Google_APIs_Client_php.tar.gz</b> không tồn tại</font><br/>';";
            echo "</script>";
}
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {
    die($E_rror_HOST);
}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {
    die($E_rror);
}
$stream = ssh2_exec($connection, 'sudo mv '.$DuognDanUI_HTML.'/assets/lib_php/vendor /home/pi/vendor');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
stream_get_contents($stream_out);

} catch (Exception $e) {
    $LoiKhongXD =  $e->getMessage();
			echo "<script>";
            echo "var messageee = document.getElementById('messageee');";
            echo "messageee.innerHTML += '<font color=red>Lỗi không xác định: $LoiKhongXD</font><br/>';";
            echo "</script>";
	
}
}

$autoloadPath = '/home/pi/vendor/autoload.php';
// Kiểm tra xem tệp autoload.php tồn tại hay không
if (file_exists($autoloadPath) && is_file($autoloadPath)) {
    // Nếu tồn tại, thực hiện require để autoload các classes
    require_once $autoloadPath;

    // Kiểm tra xem lớp Google_Client (hoặc các lớp khác) có tồn tại hay không
    if (class_exists('Google_Client')) {
     //   echo "Thư viện Google APIs Client Library for PHP đã được cài đặt.";
        
        // Kiểm tra phiên bản của thư viện (nếu cần)
        if (defined('Google_Client::LIBVER')) {
            $libraryVersion = Google_Client::LIBVER;
           // echo " Phiên bản: $libraryVersion";
            $messageeee .= "<font color=red>Phiên Bản Google APIs Client: <b>$libraryVersion</b></font>";
            
        }
    } else {
       // echo "Lớp Google_Client không tồn tại, có thể thư viện chưa được cài đặt đúng cách.";
			echo "<script>";
            echo "var messageee = document.getElementById('messageee');";
            echo "messageee.innerHTML += '<font color=red>Thư viện Google APIs Client Library for PHP chưa được cài đặt</font><br/>';";
            echo "messageee.innerHTML += '<font color=red>Google Drive Auto Backup sẽ không dùng được trong tình huống này</font><br/>';";
            echo "</script>";
			
		echo '<center><form method="POST" id="my-form" action="">';
		echo "<button name='install_lib_gdrive' class='btn btn-success'>Cài Thư Viện</button>";
		echo "<a href='$PHP_SELF'><button class='btn btn-primary'>Làm Mới</button></a></center>";
		echo "</form></center>";
		
    }
} else {
    //echo "Tệp autoload.php không tồn tại, có thể Composer chưa được sử dụng để cài đặt thư viện.";
	
			echo "<script>";
            echo "var messageee = document.getElementById('messageee');";
            echo "messageee.innerHTML += '<font color=red><h4><br/>Một số cấu hình chưa được cài đặt, hãy nhấn vào nút bên dưới để cài tự động</h4></font><br/>';";
            echo "</script>";
			
		echo '<center><form method="POST" id="my-form" action="">';
		echo "<button name='install_lib_gdrive' class='btn btn-success'>Auto Cài Đặt</button>";
		echo "<a href='$PHP_SELF'><button class='btn btn-primary'>Làm Mới</button></a></center>";
		echo "</form></center>";
	exit();
}


?>
	
	
  <form method="POST" id="my-form" action="">
  
   	<div class="my-div">
    <span class="corner-text"><h5>Cập Nhật:</h5></span><br/><br/>
	<center> 
	<div id="messagee"></div><br/></center>
	
	<center>
		 <div id="MessageGDriver"></div>
		 </center>
	<br/><div class="row justify-content-center"><div class="col-auto">
	<table class="table table-bordered">
  <thead> 
    <tr>
      <th scope="col" colspan="2"><font color=red>Lựa Chọn Nâng Cao Khi Cập Nhật Hoàn Tất</font></th> 
    </tr> 
  </thead>
  <tbody>
    <tr>
      <th>Thông Báo Âm Thanh:</th>
	  <td><input class="form-check-input" type="checkbox" name="audioo_playmp3_success" value="playmp3_success" checked></td>
    </tr>
	    <tr>
      <th title="Bạn cần bật tắt trong tab Config/Cấu Hình">Google Drive Auto Backup:</th>
	  <td title="Bạn cần bật tắt trong tab Config/Cấu Hình"><input type="checkbox" name="HienThiChechBoxGDrive" title="Bạn cần bật tắt trong tab Config/Cấu Hình" class="form-check-input" <?php echo ($Web_UI_Enable_GDrive_Backup ? 'checked' : ''); ?> disabled></td>
    </tr>
    <tr>
      <th><span class="inline-elements" title="Tự Động Tải Lại Trang Khi Cập Nhật Hoàn Tất">Tự Động Làm Mới Lại Trang: <font color=red><span id="countdown"></span></font></span></th>
	  <td> <input class="form-check-input" type="checkbox" name="startCheckboxReload" id="startCheckbox" title="Tự Động Tải Lại Trang Khi Cập Nhật Hoàn Tất" value="start" checked></td>
    </tr>
  </tbody>
</table> 
	</div></div>
  <div class="row justify-content-center"><div class="col-auto"><div class="input-group">
    		<center>  <input type="submit" name="checkforupdates_ui" class="btn btn-success" value="Kiểm tra">
		   <input type="submit" name="ui_update" class="btn btn-warning" value="Cập Nhật">
		   <a class="btn btn-primary" href="<?php echo $PHP_SELF; ?>" role="button">Làm Mới</a>
		   <button class="btn btn-danger" id="reloadButton">Tải Lại Trang</button></center>
		   </div>
		   </div>
		   </div>  <br/></div>
	<br/>   <div class="my-div">
    <span class="corner-text"><h5>Sao Lưu/Khôi Phục:</h5></span><br/><br/>

<center><div id="message"></div></center>



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
			echo "<script>";
            echo "var messagee = document.getElementById('messagee');";
            echo "messagee.innerHTML += 'Có phiên bản mới: <font color=red>$remoteValue</font><br/>';";
            echo "messagee.innerHTML += 'Phiên bản hiện tại của bạn: <font color=red>$localValue</font> vui lòng cập nhật.<br/>';";
            echo "</script>";
	if (empty($remoteData['ui_version']['notification'])) {
    //echo "Không có dữ liệu";
	} else {
	$NoiDungCapnhat = $remoteData['ui_version']['notification'];
			echo "<script>";
            echo "var messagee = document.getElementById('messagee');";
            echo "messagee.innerHTML += 'Nội Dung Cập Nhật: <font color=red>$NoiDungCapnhat</font><br/>';";
            echo "</script>";
	}
} else {
			echo "<script>";
            echo "var messagee = document.getElementById('messagee');";
            echo "messagee.innerHTML += 'Bạn đang sử dụng phiên bản mới nhất: <font color=red>$localValue<br/>';";
            echo "</script>";
}
}

if (isset($_POST['ui_update'])) {
	if (isset($block_updates_web_ui) && $block_updates_web_ui === true) {
        //echo "Checkbox được tích và không cho cập nhật.";
			echo "<script>";
            echo "var messagee = document.getElementById('messagee');";
            echo "messagee.innerHTML += '<font color=red><i>Cập Nhật <b>Web UI</b> Đã Bị Tắt, Cần Đi Tới Tab <b>Cấu Hình Config</b> Để Bỏ Tích</i></font><br/>';";
            echo "</script>";
    } else {
$backupDir = $DuognDanUI_HTML.'/ui_update/backup'; // Đường dẫn thư mục sao lưu lại file sao lưu
$timestamp = date('d_m_Y_His'); 
$startCheckboxReload = $_POST['startCheckboxReload'];
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
			echo "<script>";
            echo "var messagee = document.getElementById('messagee');";
            echo "messagee.innerHTML += '<font color=red>Có lỗi xảy ra khi tạo bản sao lưu.</font><br/>';";
            echo "</script>";
	
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
			echo "<script>";
            echo "var messagee = document.getElementById('messagee');";
            echo "messagee.innerHTML += '<font color=green>Cập nhật giao diện mới thành công!</font><br/>';";
            echo "</script>";
    // Gọi hàm xóa đệ quy
    deleteRecursive($sourceDirectory);
	shell_exec("rm $zipFile");
} else {
   // $messagee .= '<font color=red>Có lỗi xảy ra, không thể mở tập tin giao diện đã tải về!</font>';
			echo "<script>";
            echo "var messagee = document.getElementById('messagee');";
            echo "messagee.innerHTML += '<font color=red>Có lỗi xảy ra, không thể mở tập tin giao diện đã tải về!</font><br/>';";
            echo "</script>";
	
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
///////////////////








if (isset($Web_UI_Enable_GDrive_Backup) && $Web_UI_Enable_GDrive_Backup === true) {
    $jsonFilePath = $DuognDanUI_HTML.'/GoogleDrive/client_secret.json';
    $jsonData = file_get_contents($jsonFilePath);
    $DataArrayClient_Secret = json_decode($jsonData, true);
    if ($DataArrayClient_Secret === null) {
       $get_loi_e_Messager = $e->getMessage();
			echo "<script>";
            echo "var MessageGDriverrr = document.getElementById('MessageGDriver');";
            echo "MessageGDriverrr.innerHTML += '<br/><font color=red>Lỗi khi đọc và chuyển đổi dữ liệu file JSON /GoogleDrive/client_secret.json: $get_loi_e_Messager</font>';";
            echo "</script>";
    }
    $tokenFilePath = $DuognDanUI_HTML.'/GoogleDrive/token.json';
    $parentFolderName = 'Vietbot_Backup';
    $subFolderName = 'Vietbot_WebUi';
    $client = new Google_Client();
    $client->setClientId($DataArrayClient_Secret['installed']['client_id']);
    $client->setClientSecret($DataArrayClient_Secret['installed']['client_secret']);
    $client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
    $client->setScopes(['https://www.googleapis.com/auth/drive', 'https://www.googleapis.com/auth/drive.file']);
    function saveTokenToFile($token, $filePath)
    {
        file_put_contents($filePath, json_encode($token));
    }
    function readTokenFromFile($filePath)
    {
        return json_decode(file_get_contents($filePath), true);
    }
    function listFilesInFolder($service, $folderId)
    {
        $result = array();
        $pageToken = null;
        do {
            try {
                $parameters = array(
                    'q' => "'" . $folderId . "' in parents",
                    'fields' => 'files(id, name, createdTime)',
                    'orderBy' => 'createdTime',
                    'pageToken' => $pageToken,
                );
                $files = $service->files->listFiles($parameters);
                $result = array_merge($result, $files->getFiles());
                $pageToken = $files->getNextPageToken();
            } catch (Exception $e) {
            $get_loi_e_Messager = $e->getMessage();
			echo "<script>";
            echo "var MessageGDriverrr = document.getElementById('MessageGDriver');";
            echo "MessageGDriverrr.innerHTML += '<br/><font color=red>Lỗi khi lấy danh sách file: $get_loi_e_Messager</font>';";
            echo "</script>";
            $pageToken = null;
            }
        } while ($pageToken);
        return $result;
    }
	if (file_exists($tokenFilePath)) {
    // Tệp tồn tại, tiến hành đọc nội dung và kiểm tra các trường
    $tokenDatasss = json_decode(file_get_contents($tokenFilePath), true);

    if (
        isset($tokenDatasss['access_token']) &&
        isset($tokenDatasss['expires_in']) &&
        isset($tokenDatasss['refresh_token']) &&
        isset($tokenDatasss['scope']) &&
        isset($tokenDatasss['token_type']) &&
        isset($tokenDatasss['created'])
    ) {
        $accessToken = readTokenFromFile($tokenFilePath);
        $client->setAccessToken($accessToken);
        if ($client->isAccessTokenExpired()) {
            try {
                $newAccessToken = $client->fetchAccessTokenWithRefreshToken();
                saveTokenToFile($newAccessToken, $tokenFilePath);
                chmod($tokenFilePath, 0777);
            } catch (Exception $e) {
            $get_loi_e_Messager = $e->getMessage();
			echo "<script>";
            echo "var MessageGDriverrr = document.getElementById('MessageGDriver');";
            echo "MessageGDriverrr.innerHTML += '<br/><font color=red>Lỗi khi làm mới token: $get_loi_e_Messager</font>';";
            echo "</script>";
            }
        }
    } else {
       		echo "<script>";
            echo "var MessageGDriverrr = document.getElementById('MessageGDriver');";
            echo "MessageGDriverrr.innerHTML += '<font color=red><b>Google Drive Auto Backup</b> Tệp token.json Lỗi, Cần Cấu Hình Xác Thực Lại.<br/></font>';";
            echo "MessageGDriverrr.innerHTML += '<font color=red><b>Sẽ không có file backup nào được tải lên<br/></font>';";
            echo "MessageGDriverrr.innerHTML += '<font color=red><a href=../#Google_Drive_Auto_Backup target=_bank>Nhấn vào đây để tới trang Cấu Hình Xác Thực</a><br></font>';";
            echo "MessageGDriverrr.innerHTML += '<font color=red>Xác thực xong bạn cần quay lại đây để <b>Cập Nhật</b> lại.<br/><br></font>';";
            echo "</script>";
    }
}  else {
		    echo "<script>";
            echo "var MessageGDriverrr = document.getElementById('MessageGDriver');";
            echo "MessageGDriverrr.innerHTML += '<font color=red><b>Google Drive Auto Backup</b> chưa được xác thực với <b>Vietbot</b>.<br/></font>';";
            echo "MessageGDriverrr.innerHTML += '<font color=red><b>Sẽ không có file backup nào được tải lên<br/></font>';";
            echo "MessageGDriverrr.innerHTML += '<font color=red><a href=../#Google_Drive_Auto_Backup target=_bank>Nhấn vào đây để tới trang Cấu Hình Xác Thực</a><br></font>';";
            echo "MessageGDriverrr.innerHTML += '<font color=red>Xác thực xong bạn cần quay lại đây để <b>Cập Nhật</b> lại.<br/><br></font>';";
            echo "</script>";
    }
    $driveService = new Google_Service_Drive($client);
    $parentFolders = $driveService->files->listFiles(array(
        'q' => "mimeType='application/vnd.google-apps.folder' and name='$parentFolderName'",
    ));
    if (empty($parentFolders->getFiles())) {
        $parentFolderMetadata = new Google_Service_Drive_DriveFile(array(
            'name' => $parentFolderName,
            'mimeType' => 'application/vnd.google-apps.folder',
        ));
        try { 
            $newParentFolder = $driveService->files->create($parentFolderMetadata, array('fields' => 'id'));
            $parentFolderId = $newParentFolder->id;
        } catch (Exception $e) {
         $get_loi_e_Messager = $e->getMessage();
			echo "<script>";
            echo "var MessageGDriverrr = document.getElementById('MessageGDriver');";
            echo "MessageGDriverrr.innerHTML += '<br/><font color=red>Lỗi khi tạo thư mục cha $parentFolderName Mã Lỗi: $get_loi_e_Messager</font>';";
            echo "</script>";
          //  die();
        }
    } else {
        $parentFolderId = $parentFolders->getFiles()[0]->getId();
    }
    $subFolders = $driveService->files->listFiles(array(
        'q' => "mimeType='application/vnd.google-apps.folder' and name='$subFolderName' and '$parentFolderId' in parents",
    ));
    if (empty($subFolders->getFiles())) {
        $subFolderMetadata = new Google_Service_Drive_DriveFile(array(
            'name' => $subFolderName,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => array($parentFolderId),
        ));
        try {
            $newSubFolder = $driveService->files->create($subFolderMetadata, array('fields' => 'id'));
            $subFolderId = $newSubFolder->id;
        } catch (Exception $e) {
         $get_loi_e_Messager = $e->getMessage();
			echo "<script>";
            echo "var MessageGDriverrr = document.getElementById('MessageGDriver');";
            echo "MessageGDriverrr.innerHTML += '<br/><font color=red>Lỗi khi tạo thư mục con $subFolderName Mã Lỗi: $get_loi_e_Messager</font>';";
            echo "</script>";
          //  die();
        }
    } else {
        $subFolderId = $subFolders->getFiles()[0]->getId();
    }
    $filesInSubFolder = listFilesInFolder($driveService, $subFolderId);
    if (count($filesInSubFolder) >= $maxBackupGoogleDrive) {
        $oldestFileId = $filesInSubFolder[0]->getId();
        $oldestFileTime = $filesInSubFolder[0]->getCreatedTime();

        foreach ($filesInSubFolder as $file) {
            $fileTime = $file->getCreatedTime();
            if ($fileTime < $oldestFileTime) {
                $oldestFileTime = $fileTime;
                $oldestFileId = $file->getId();
            }
        }
        try {
            $driveService->files->delete($oldestFileId);
			echo "<script>";
            echo "var MessageGDriverrr = document.getElementById('MessageGDriver');";
            echo "MessageGDriverrr.innerHTML += '<br/><font color=red>Google Drive đã đạt tối đa <b>$maxBackupGoogleDrive</b> file backup. <br/>Đã xóa file Backup cũ nhất</font>';";
            echo "</script>";
        } catch (Exception $e) {
            $get_loi_e_Messager = $e->getMessage();
			echo "<script>";
            echo "var MessageGDriverrr = document.getElementById('MessageGDriver');";
            echo "MessageGDriverrr.innerHTML += '<br/><font color=red>Lỗi khi xóa file cũ nhất: $get_loi_e_Messager</font>';";
            echo "</script>";
          //  die();
        }
    }
    $filePath = $backupFile;
    $content = file_get_contents($filePath);
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
        'name' => basename($filePath),
        'parents' => array($subFolderId),
    ));
    try {
        $file = $driveService->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'media',
        ));
		$get_id_file_backup = $file->id;
		$get_ten_file_backup = basename($filePath);
			echo "<script>";
            echo "var MessageGDriverrr = document.getElementById('MessageGDriver');";
            echo "MessageGDriverrr.innerHTML += '<br/><font color=green>File Backup: <b> $get_ten_file_backup </b> được tải lên Google Drive thành công</font>';";
            echo "</script>";
    } catch (Exception $e) {
		$get_loi_e_Messager = $e->getMessage();
			echo "<script>";
            echo "var MessageGDriverrr = document.getElementById('MessageGDriver');";
            echo "MessageGDriverrr.innerHTML += '<br/><font color=red>Lỗi khi tải file lên: $get_loi_e_Messager</font>';";
            echo "</script>";
     //   die();
    }
} else {
			echo "<script>";
            echo "var MessageGDriverrr = document.getElementById('MessageGDriver');";
            echo 'MessageGDriverrr.innerHTML += "<br/><font color=red>Google Drive Auto Backup chưa được bật trong Config/Cấu Hình</font>";';
            echo 'MessageGDriverrr.innerHTML += "<br/><font color=red>Sẽ không có file backup nào được tải lên!</font>";';
            echo "</script>";
}















if (@$_POST['audioo_playmp3_success'] === "playmp3_success") {
	echo '<audio style="display: none;" id="myAudio_success" controls autoplay>';
    echo '<source src="../assets/audio/ui_update_success.mp3" type="audio/mpeg">';
    echo 'Your browser does not support the audio element.';
    echo '</audio>';
	echo '<script>';
	echo 'var audio = document.getElementById("myAudio_success");';
    echo 'audio.play();';
	echo '</script>';
}
//echo $startCheckboxReload;
?>

<?php





}
}
if (isset($_POST['restors_ui'])) {
    $selectedFile = $_POST['tarFile'];
    if ($selectedFile === "....") {
			echo "<script>";
            echo "var message = document.getElementById('message');";
            echo "message.innerHTML += '<font color=red>Vui lòng chọn file cần khôi phục!</font><br/>';";
            echo "</script>";
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
        // $message .= '<font color=red>Đã khôi phục giao diện backup thành công!<br/>';
        // $message .= 'Bạn Hãy Tải Lại Trang Để Áp Dụng....!</font>';
		 
			echo "<script>";
            echo "var message = document.getElementById('message');";
            echo "message.innerHTML += '<font color=red>Đã khôi phục giao diện backup thành công!</font><br/>';";
            echo "message.innerHTML += '<font color=red>Bạn Hãy Tải Lại Trang Để Áp Dụng....!</font><br/>';";
            echo "</script>";
		 
    }
}
if (isset($_POST['download']) && isset($_POST['tarFile'])) {
    $selectedFile = $_POST['tarFile'];
    $filePath = '/ui_update/backup/' . $selectedFile; // Đường dẫn đến thư mục chứa tệp tin
    if ($selectedFile === "....") {
        // $message .= '<font color=red>Vui lòng chọn file cần tải xuống!</font>';
		 	echo "<script>";
            echo "var message = document.getElementById('message');";
            echo "message.innerHTML += '<font color=red>Vui lòng chọn file cần tải xuống!</font><br/>';";
            echo "</script>";
    } else {
        // Tạo liên kết tới trang mục tiêu trong tab mới
        $targetLink = "http://$serverIP$filePath"; // Đặt đường dẫn mục tiêu tại đây
        echo "<script>window.open('$targetLink', '_blank');</script>";
    }
}
?>






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
// Hiển thị select dropdow
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
var reloadButton = document.getElementById('reloadButton');
var startCheckbox = document.getElementById('startCheckbox');
var countdownElement = document.getElementById('countdown');
var requiredValue = "<?php echo $startCheckboxReload; ?>";
var countdown = '3';
var countdownInterval;
 
function updateCountdown() {
  countdownElement.textContent = countdown;
} 

function reloadHostPage() {
  // Gửi thông điệp tới trang chính để yêu cầu tải lại
  window.parent.postMessage('reload', '*');
  // Tải lại trang chính (host page) bằng cách truy cập vào window cha và gọi hàm location.reload()
  window.parent.location.reload();
}

function startCountdown() {
  //countdown = 3;
  updateCountdown();
  countdownInterval = setInterval(function() {
    if (countdown === 0) {
      clearInterval(countdownInterval);
      reloadHostPage();
    } else {
      countdown--;
      updateCountdown();
    }
  }, 1000);
}

if (startCheckbox.checked && startCheckbox.value === requiredValue) {
  startCountdown();
}

reloadButton.addEventListener('click', function() {
  reloadHostPage();
});

startCheckbox.addEventListener('change', function() {
  if (startCheckbox.checked && startCheckbox.value === requiredValue) {
    startCountdown();
  } else {
    clearInterval(countdownInterval);
    countdownElement.textContent = "";
  }
});
</script>

	</body>
	</html>
