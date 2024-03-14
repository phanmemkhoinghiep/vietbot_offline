<?php
//Code By: Vũ Tuyển
//Facebook: https://www.facebook.com/TWFyaW9uMDAx
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
?>
<body>
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
    <script>
        $(document).ready(function() {
            $('#form_dowload_restors').on('submit', function() {
                // Hiển thị biểu tượng loading
                $('#loading-overlay').show();

                // Vô hiệu hóa nút gửi
                $('#submit-btn').attr('disabled', true);
            });
        });
    </script>
    <script>
        function selectAllText() {
            var input = document.getElementById("boidennoidung");
            input.select();
            try {
                document.execCommand("copy");
                //  alert("Nội dung đã được sao chép thành công!");
            } catch (err) {
                //console.error('Lỗi khi sao chép nội dung: ', err);
                // alert("Lỗi khi sao chép nội dung. Vui lòng thử lại.");
            }
        }

        function openNewTab(button) {
            // Lấy giá trị của thuộc tính data-url-link
            var urlToOpen = button.getAttribute('data-url-link');

            if (urlToOpen) {
                // Mở đường dẫn trong tab mới nếu giá trị tồn tại
                window.open(urlToOpen, '_blank');
            } else {
                // Xử lý trường hợp không có giá trị data-url-link
                alert('Không có đường dẫn được cung cấp');
                console.error('Không có đường dẫn được cung cấp.');
            }
        }
    </script>
    <div id="loading-overlay">
        <img id="loading-icon" src="../assets/img/Loading.gif" alt="Loading...">
        <div id="loading-message">Đang tiến hành, vui lòng đợi...</div>

    </div>
    <center>
        <h4>Google Drive Auto Backup Vietbot</h4>
    </center>
    <br/>

    <center>
        <div id="messageee"></div>
    </center>


<?php

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
function deleteContents($directory) {
    if (!is_dir($directory)) {
        return false;
    }

    $files = glob($directory . '/*');

    foreach ($files as $file) {
        is_dir($file) ? deleteDirectorySub($file) : unlink($file);
    }

    //echo 'Đã xóa tất cả nội dung trong thư mục: ' . $directory . '<br>';
}

function deleteDirectorySub($directory) {
    if (!is_dir($directory)) {
        return false;
    }

    deleteContents($directory);
    rmdir($directory);
   // echo 'Đã xóa thư mục: ' . $directory . '<br>';
}
$messageeee = '';
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
			echo "<script>";
            echo "var messageee = document.getElementById('messageee');";
            echo "messageee.innerHTML += '<font color=red>Thư viện được cài đặt thành công.</font><br/>';";
            echo "</script>";
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
            echo "messageee.innerHTML += '<font color=red><h4>Bạn cần cài đặt thư viện, nhấn vào bên dưới để cài đặt</h4></font><br/>';";
            echo "</script>";
			
		echo '<center><form method="POST" id="my-form" action="">';
		echo "<button name='install_lib_gdrive' class='btn btn-success'>Cài Thư Viện</button>";
		echo "<a href='$PHP_SELF'><button class='btn btn-primary'>Làm Mới</button></a></center>";
		echo "</form></center>";
	exit();
}


?>
	
 
<?php
	//restart vietbot
if (isset($_POST['reset_token'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, "rm $DuognDanUI_HTML/GoogleDrive/token.json");
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
stream_get_contents($stream_out);
header("Location: $PHP_SELF");
exit;
}

if (isset($Web_UI_Enable_GDrive_Backup) && $Web_UI_Enable_GDrive_Backup === true) {
    $jsonFilePath = $DuognDanUI_HTML.'/GoogleDrive/client_secret.json';

    $jsonData = file_get_contents($jsonFilePath);
    $DataArrayClient_Secret = json_decode($jsonData, true);
// Kiểm tra lỗi JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    // Có lỗi khi giải mã JSON
    echo '<center><font color=red><h4>Lỗi sai cấu trúc tệp json, mã lỗi: <b>' . json_last_error_msg().'</b><br/>';
	echo "Kiểm tra lại dữ liệu nhập vào ở tab <b>Config/Cấu Hình</b></h4></font><br/>";
	echo "<a href='$PHP_SELF'><button class='btn btn-primary'>Làm Mới</button></a></center>";
	die();
}

    if ($DataArrayClient_Secret === null) {
        echo '<center><font color=red><h4>Lỗi cấu trúc khi đọc và chuyển đổi dữ liệu tệp <b>client_secret.json</b></h4></font><br/>';
		die ("<a href='$PHP_SELF'><button class='btn btn-primary'>Làm Mới</button></a></center>");
		
		
    }
    $tokenFilePath = $DuognDanUI_HTML.'/GoogleDrive/token.json';
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
// Kiểm tra xem tệp tồn tại không
if (file_exists($tokenFilePath)) {
$tokenDatajjj = json_decode(file_get_contents($tokenFilePath), true);
    if (
        isset($tokenDatajjj['access_token']) &&
        isset($tokenDatajjj['expires_in']) &&
        isset($tokenDatajjj['refresh_token']) &&
        isset($tokenDatajjj['scope']) &&
        isset($tokenDatajjj['token_type']) &&
        isset($tokenDatajjj['created'])
    ) {
            $accessToken = readTokenFromFile($tokenFilePath);
    $client->setAccessToken($accessToken);

    // Kiểm tra xem token có hợp lệ và chưa hết hạn không
    if ($client->isAccessTokenExpired()) {
        try {
            // Làm mới token nếu nó đã hết hạn
            $newAccessToken = $client->fetchAccessTokenWithRefreshToken();
            saveTokenToFile($newAccessToken, $tokenFilePath);
            chmod($tokenFilePath, 0777);

            echo '<center><font color=green><h4>Token đã được tự động làm mới thành công!</h4></font>';
			echo "<br/><a href='$PHP_SELF'><button class='btn btn-primary'>Về Trang Chủ</button></a></center>";
        } catch (Exception $e) {
            error_log('Lỗi khi làm mới token: ' . $e->getMessage());
            echo '<br/><center><font color=red><h4>Lỗi khi làm mới token: ' . $e->getMessage().'</h4></font></center>';
			echo "<br/><a href='$PHP_SELF'><button class='btn btn-primary'>Về Trang Chủ</button></a>";
        }
    } else {
		echo '<form method="POST" id="my-form" action="">';
        echo '<center><h4><font color=green>Google Drive Auto Backup hiện đang hợp lệ và hoạt động bình thường!</font></h4><br/>';
		echo "<button name='reset_token' class='btn btn-danger'>Reset Token</button>";
		echo "<a href='$PHP_SELF'><button class='btn btn-primary'>Làm Mới</button></a>";
		echo "<button name='list_backup_web_ui' class='btn btn-success'>List Backup WEB UI</button>";
		echo "<button name='list_back_up_vietbot' class='btn btn-warning'>List Backup Vietbot</button></center><br/>";
		
		echo "</form>";
		$driveService = new Google_Service_Drive($client);
		// Lấy thông tin người dùng đang đăng nhập
		$about = $driveService->about->get(array('fields' => 'user'));
		// Hiển thị tên tài khoản
		$accountName = $about->getUser()->getDisplayName();
		//echo 'Tên tài khoản: ' . $accountName;
		$messageeee .= "<br/><font color=blue>Tên tài khoản: <b>$accountName</b></font>";
		
    }
	
    } else {
    	echo '<form method="POST" id="my-form" action="">';
        echo '<center><h4><font color=red>Chuỗi Định Dạng Token Không Hợp Lệ, Cần Cấu Hình Lại Trình Xác Thực</font></h4><br/>';
		echo "<button name='reset_token' class='btn btn-danger'>Cấu Hình Lại</button>";
		echo "<a href='$PHP_SELF'><button class='btn btn-primary'>Làm Mới</button></a></center>";
		echo "</form><hr/>";
    }
} else {
        if (!isset($_POST['code_token'])) {
			$client->setAccessType('offline');
			$client->setPrompt('consent');
			$authUrl = $client->createAuthUrl();
			echo '<div class="row g-3 d-flex justify-content-center">
            <div class="col-auto">';
			echo "<h5><font color=red>- Trình Xác Thực</font></h5>";
            echo '<font color=green>Vui lòng xác thực ứng dụng với <b>Vietbot</b> bằng cách truy cập đường dẫn sau và nhập mã ủy quyền:</font><br/><br/>';
			echo 'Sao chép địa chỉ bên dưới đây và dán vào trình duyệt để <a href="' . $authUrl . '" target="_bank">Lấy Mã Ủy Quyền</a>:<br/>';
            echo '<div class="input-group mb-3"><input type="text" id="boidennoidung" class="form-control" value="' . $authUrl . '" aria-describedby="basic-addon2">
			<button onclick="selectAllText()" class="btn btn-primary">Sao Chép</button>
			
<button type="button" class="btn btn-success" data-url-link="'.$authUrl.'" onclick="openNewTab(this)">Đi Tới</button>
			
			</div>
			<br>';
			echo '<form method="POST" id="my-form" action="">Nhập Mã Ủy Quyền <font color=red>*</font>:<br/><div class="input-group mb-3">
			<input type="text" name="code_token" class="form-control" placeholder="Nhập mã ủy quyền vào đây" aria-describedby="basic-addon2" required>
			<div class="input-group-append"><input class="btn btn-primary" type="submit" value="Xác thực"></div></div></form>';
			echo "</div></div>";
					echo "<br/><center><a href='$PHP_SELF'><button class='btn btn-danger'>Làm Mới</button></a></center>";
            die();
        } else {
			if (empty($_POST['code_token'])) {
			echo '<center><font color=red><h4>Vui lòng nhập mã ủy quyền để xác thực!</h4></font>';
			echo "Mã ủy quyền có dạng: <code>4/1AfJohXngyjRjD4jTPCQDTzp6mZ2PdL4xMIupmfvdvf542J0vQCer_bxCbgfggf</code><br/><br/>";
			echo "<a href='$PHP_SELF'><button class='btn btn-primary'>Quay lại</button></a></center>";
				}else {
				$client->authenticate($_POST['code_token']);
				$accessToken = $client->getAccessToken();
					if (!$accessToken) {
					// Thông báo khi xác thực thất bại
					echo '<center><h4><font color=red>Xác thực thất bại. Vui lòng kiểm tra lại mã ủy quyền</font></h4>';
					echo "Mã ủy quyền có dạng: <code>4/1AfJohXngyjRjD4jTPCQDTzp6mZ2PdL4xMIupmfvdvf542J0vQCer_bxCbgfggf</code><br/><br/>";
					echo "<a href='$PHP_SELF'><button class='btn btn-primary'>Thử Lại</button></a></center>";
					
					}else {
				saveTokenToFile($accessToken, $tokenFilePath);
				chmod($tokenFilePath, 0777);
				// Thông báo khi xác thực thành công
				echo '<center><font color=green><h4>Xác thực thành công! Dữ liệu đã được lưu.</h4></font><br/>';
				echo "<a href='$PHP_SELF'><button class='btn btn-primary'>Về Trang Chủ</button></a></center>";
    }
    }
}
    }
} 
else {
    echo "<font color=red><h4><center>Cần phải được bật <b>Google Drive Auto Backup</b> trong tab <b>Config/Cấu Hình</b> để xem và thiết lập</center></h4></font><br/>";
	echo "<center><a href='$PHP_SELF'><button class='btn btn-primary'>Tải lại</button></a></center>";
}

if (isset($_POST['dowload_file_end_restor_ui'])) {
	$serviceRestorUI = new Google_Service_Drive($client);
	$fileId = $_POST['dowload_file_end_restor_ui'];
if (empty($fileId)) {
    echo '<center><font color=red>Có lỗi xả ra, Không lấy được ID của tệp. Vui lòng thử lại</font></center>';
} else {
    try {
        // Lấy thông tin về file
        $file = $serviceRestorUI->files->get($fileId);

        // Lấy nội dung của file
        $content = $serviceRestorUI->files->get($fileId, ['alt' => 'media']);
		
		$ExtractDir = $DuognDanUI_HTML.'/ui_update/dowload_extract/';
        // Thay đổi đường dẫn lưu file
        $savePath = $ExtractDir.$file->getName();
		
        // Lưu file vào ổ đĩa cục bộ
        file_put_contents($savePath, $content->getBody()->getContents());
		chmod($savePath, 0777); 
		//giải nén tệp tar.gz
		extractTarGz($savePath, $ExtractDir);
                // Xóa tệp tin nén và thư mục đã giải nén
                unlink($savePath); 
                // Kiểm tra xem trong thư mục $ExtractDir đã có thư mục "html" hay không
                $htmlDirectory = $ExtractDir . 'html';
                if (is_dir($htmlDirectory)) { 
                    //echo 'Thư mục "html" đã tồn tại sau khi giải nén.';
					copyRecursiveExclude($htmlDirectory, $DuognDanUI_HTML, array('.zip', '.tar.gz'));
					//deleteDirectory($htmlDirectory);
					shell_exec("rm $DuognDanUI_HTML/ui_update/dowload_extract/README.md");
					deleteContents($ExtractDir);
					//SSH Chmod file
					$connection = ssh2_connect($serverIP, $SSH_Port);
					if (!$connection) {die($E_rror_HOST);}
					if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
					$stream1 = ssh2_exec($connection, 'sudo chmod -R 0777 '.$Path_Vietbot_src);
					stream_set_blocking($stream1, true);
					$stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO);
					stream_get_contents($stream_out1);
					//echo '<meta http-equiv="refresh" content="1">';   
					//header("Location: $PHP_SELF"); 
					//exit;
					echo "<center><font color=green>Khôi phục dữ liệu Web UI từ Drive thành công, hãy tải lại trang để áp dụng</font></center>";
                } else {
					deleteContents($ExtractDir);
                    echo '<center><font color=red>Khôi Phục Thất Bại, Thư mục "html" không tồn tại sau khi giải nén.</font></center>';
                }
    } catch (Exception $e) {
        echo 'Lỗi: ' . $e->getMessage();
    }
}
}

if (isset($_POST['dowload_file_end_restor_vietbot'])) {
	$serviceRestorUI = new Google_Service_Drive($client);
	$fileId = $_POST['dowload_file_end_restor_vietbot'];
if (empty($fileId)) {
    echo '<center><font color=red>Có lỗi xả ra, Không lấy được ID của tệp. Vui lòng thử lại</font></center>';
} else {
    try {
        // Lấy thông tin về file
        $file = $serviceRestorUI->files->get($fileId);

        // Lấy nội dung của file
        $content = $serviceRestorUI->files->get($fileId, ['alt' => 'media']);
		
		$ExtractDirVietbot = $DuognDanUI_HTML.'/backup_update/extract/';
        // Thay đổi đường dẫn lưu file
        $savePathVietbot = $ExtractDirVietbot.$file->getName();
		
        // Lưu file vào ổ đĩa cục bộ
        file_put_contents($savePathVietbot, $content->getBody()->getContents());
		chmod($savePathVietbot, 0777); 
		//giải nén tệp tar.gz
		extractTarGz($savePathVietbot, $ExtractDirVietbot);
                // Xóa tệp tin nén và thư mục đã giải nén
                unlink($savePathVietbot); 
                // Kiểm tra xem trong thư mục $ExtractDirVietbot đã có thư mục "html" hay không
                $VietbotDirectory = $ExtractDirVietbot . 'src';
                $VietbotDirectoryRESOURCE = $ExtractDirVietbot . 'resources';
                if (is_dir($VietbotDirectory)) { 
                    //echo 'Thư mục "html" đã tồn tại sau khi giải nén.';
					copyRecursiveExclude($VietbotDirectory, $DuognDanThuMucJson, array('.zip', '.tar.gz'));
					copyRecursiveExclude($VietbotDirectoryRESOURCE, $PathResources, array('.zip', '.tar.gz'));
					deleteContents($ExtractDirVietbot);
					//SSH Chmod file
					$connection = ssh2_connect($serverIP, $SSH_Port);
					if (!$connection) {die($E_rror_HOST);}
					if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
					$stream1 = ssh2_exec($connection, 'sudo chmod -R 0777 '.$Path_Vietbot_src);
					stream_set_blocking($stream1, true);
					$stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO);
					stream_get_contents($stream_out1);
					//echo '<meta http-equiv="refresh" content="1">';   
					//header("Location: $PHP_SELF"); 
					//exit;
					echo "<center><font color=green>Khôi phục dữ liệu Vietbot từ Drive thành công, hãy Khởi Động Lại Vietbot để áp dụng</font></center>";
                } else {
					deleteContents($ExtractDirVietbot);
                    echo '<center><font color=red>Khôi Phục Thất Bại, Thư mục "src" của Vietbot không tồn tại sau khi giải nén.</font></center>';
                }
    } catch (Exception $e) {
        echo 'Lỗi: ' . $e->getMessage();
    }
}
}


	//list_backup_web_ui
if (isset($_POST['list_backup_web_ui'])) {
#$driveService = new Google_Service_Drive($client);
$folderName = 'Vietbot_WebUi';
$folders = $driveService->files->listFiles([
    'q' => "mimeType='application/vnd.google-apps.folder' and name='$folderName'",
]);

if (count($folders) > 0) {
    $folderId = $folders[0]->getId();
    $files = $driveService->files->listFiles([
        'q' => "'$folderId' in parents",
    ]);
    if (count($files) > 0) {
		$i = 0;
		echo '<form method="POST" id="form_dowload_restors" action=""><br/><div class="row justify-content-center"><div class="col-auto"><table class="table table-bordered">
		<thead>
		<tr><th colspan="4"><center><font color=red>Danh Sách File Backup WebUI Trên Google Drive</font></center></th></tr>
    <tr>
      <th scope="col"><center>Tên File</center></th>
      <th scope="col"><center>Khôi Phục</center></th>
      <th scope="col"><center>Tải Xuống</center></th>
      <th scope="col"><center>Xem File</center></th>
    </tr>
  </thead>
		<tbody>';
        foreach ($files as $file) {
			$i++;
            $fileName = $file->getName();
            $fileId = $file->getId();
            $downloadLink = "https://drive.google.com/uc?export=download&id=$fileId";
            $viewLink = "https://drive.google.com/file/d/$fileId/view";

            //echo "<p>$fileName <a href=\"$downloadLink\" target=\"_blank\" download>Tải Xuống</a> | <a href=\"$viewLink\" target=\"_blank\">Xem file</a></p>";

echo '<tr>
      <th scope="row" title="ID file: '.$fileId.'">'.$fileName.'</th>
		<td><button name="dowload_file_end_restor_ui" class="btn btn-warning" title="Khôi phục dữ liệu từ File: '.$fileName.'" value="'.$fileId.'">Khôi Phục</button></center></td>
      <td><a href="'.$downloadLink.'" data-url-link="'.$downloadLink.'" onclick="openNewTab(this)" download><button type="button" class="btn btn-danger" title="Tải xuống file: '.$fileName.'">Tải Xuống</button></a></td>
      <td><button type="button" class="btn btn-primary" data-url-link="'.$viewLink.'" onclick="openNewTab(this)" title="Xem file '.$fileName.' trực tiếp từ link Google Drive">Mở Trong Tab Mới</button></td>
    </tr>
	';
            // Cài đặt quyền truy cập công khai cho tệp tin
            $userPermission = new Google_Service_Drive_Permission([
                'type' => 'anyone',
                'role' => 'reader',
            ]);

            $driveService->permissions->create($fileId, $userPermission, ['fields' => 'id']);
        }
		echo '<tr><td colspan="3">Tổng số: <font color=red>'.$i.'</font> file</td></tr></tbody></table></div></div></form>';
		
    } else {
        echo "<center>Không có tệp tin trong thư mục sao lưu của WebUI trên Google Drive</center>";
    }
} else {
    //echo "Không tìm thấy thư mục có tên '$folderName'.";
    echo "<center>Không tìm thấy thư mục chứa các tệp sao lưu WebUI</center>";
}

}


	//list_back_up_vietbot
if (isset($_POST['list_back_up_vietbot'])) {
#$driveService = new Google_Service_Drive($client);
$folderName = 'Vietbot_Source';
$folders = $driveService->files->listFiles([
    'q' => "mimeType='application/vnd.google-apps.folder' and name='$folderName'",
]);

if (count($folders) > 0) {
    $folderId = $folders[0]->getId();
    $files = $driveService->files->listFiles([
        'q' => "'$folderId' in parents",
    ]);
    if (count($files) > 0) {
		$i = 0;
		echo '<form method="POST" id="form_dowload_restors" action=""><br/><div class="row justify-content-center"><div class="col-auto"><table class="table table-bordered">
		<thead>
		<tr><th colspan="4"><center><font color=red>Danh Sách File Backup Vietbot src Trên Google Drive</font></center></th></tr>
    <tr>
      <th scope="col"><center>Tên File</center></th>
      <th scope="col"><center>Khôi Phục</center></th>
      <th scope="col"><center>Tải Xuống</center></th>
      <th scope="col"><center>Xem File</center></th>
    </tr>
  </thead>
		<tbody>';
        foreach ($files as $file) {
			$i++;
            $fileName = $file->getName();
            $fileId = $file->getId();
            $downloadLink = "https://drive.google.com/uc?export=download&id=$fileId";
            $viewLink = "https://drive.google.com/file/d/$fileId/view";

            //echo "<p>$fileName <a href=\"$downloadLink\" target=\"_blank\" download>Tải Xuống</a> | <a href=\"$viewLink\" target=\"_blank\">Xem file</a></p>";

echo '<tr>
      <th scope="row" title="ID file: '.$fileId.'">'.$fileName.'</th>
	  <td><button name="dowload_file_end_restor_vietbot" class="btn btn-warning" title="Khôi phục dữ liệu từ File: '.$fileName.'" value="'.$fileId.'">Khôi Phục</button></td>
      <td><a href="'.$downloadLink.'" data-url-link="'.$downloadLink.'" onclick="openNewTab(this)" download><button type="button" class="btn btn-danger">Tải Xuống</button></a></td>
	  <td><button type="button" class="btn btn-primary" data-url-link="'.$viewLink.'" onclick="openNewTab(this)" title="Xem file '.$fileName.' trực tiếp từ link Google Drive">Mở Trong Tab Mới</button></td>
    </tr>
	';
            // Cài đặt quyền truy cập công khai cho tệp tin
            $userPermission = new Google_Service_Drive_Permission([
                'type' => 'anyone',
                'role' => 'reader',
            ]);

            $driveService->permissions->create($fileId, $userPermission, ['fields' => 'id']);
        }
		echo '<tr><td colspan="3">Tổng số: <font color=red>'.$i.'</font> file</td></tr></tbody></table></div></div></form>';
		
    } else {
        echo "<center>Không có tệp tin trong thư mục sao lưu của Vietbot trên Google Drive</center>";
    }
} else {
    //echo "Không tìm thấy thư mục có tên '$folderName'.";
    echo "<center>Không tìm thấy thư mục chứa các tệp sao lưu Vietbot</center>";
}

}

?>





	<br/><div class="right-align" id="messageeee"></div>
				<script>
            var messageeee = document.getElementById('messageeee');
            messageeee.innerHTML += '<?php echo $messageeee; ?>';
             </script>


</body></html>
