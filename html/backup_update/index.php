<?php
//Code By: Vũ Tuyển
//Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../Configuration.php";
?>
<!DOCTYPE html>
<html>
<head>
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $MYUSERNAME; ?>, Update Vietbot src</title>
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
        margin-left: 1px;
        margin-right: 1px;
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
$backupDir = $DuognDanUI_HTML."/backup_update/backup"; // Đường dẫn thư mục sao lưu
// Tạo tên tệp tin nén với ngày giờ và thời gian
$timestamp = date('d_m_Y_His');
$backupFile = $backupDir . '/vietbot_src_' . $timestamp . '.tar.gz';
function deleteFiles($directory, $excludedFiles, $excludedDirectories, &$deletedItems)
{
    $files = glob($directory . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            $fileName = basename($file);
            
            if (!in_array($fileName, $excludedFiles)) {
                unlink($file);
                $deletedItems[] = $file . '</span>';
            }
        } elseif (is_dir($file)) {
            $dirName = basename($file);
            
            if (!in_array($dirName, $excludedDirectories)) {
                deleteFiles($file, $excludedFiles, $excludedDirectories, $deletedItems);
                rmdir($file);
                $deletedItems[] = $file . '</span>';
            }
        }
    }
}
function copyFiles($sourceDirectory, $destinationDirectory, $excludedFiles, &$copiedItems)
{
    $files = glob($sourceDirectory . '/*');
  
    foreach ($files as $file) {
        if (is_file($file)) {
            $fileName = basename($file);
            
            if (!in_array($fileName, $excludedFiles)) {
                copy($file, $destinationDirectory . '/' . $fileName);
                $copiedItems[] = $destinationDirectory . '/' . $fileName ."\n";
            }
        } elseif (is_dir($file)) {
            $dirName = basename($file);
            
            if (!in_array($dirName, $excludedFiles)) {
                mkdir($destinationDirectory . '/' . $dirName);
                copyFiles($file, $destinationDirectory . '/' . $dirName, $excludedFiles, $copiedItems);
            }
        }
    }
}
	//restart vietbot
if (isset($_POST['restart_vietbot'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'systemctl --user restart vietbot');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
stream_get_contents($stream_out);
header("Location: $PHP_SELF");
exit;
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
// Kiểm tra xem thư mục nguồn có tồn tại không
if (!is_dir($DuognDanThuMucJson)) {
    echo "<center>Thư mục nguồn $DuognDanThuMucJson không tồn tại.</center>";
    exit;
}
?>
<div class="my-div">
    <span class="corner-text"><h5>Cập Nhật:</h5></span><br/><br/>
<center>
<div id="messagee"></div></center><br/>

    <form method="POST" id="my-form" action="">
	<div class="row g-3 d-flex justify-content-center"><div class="col-auto">
	
    	<table class="table table-bordered">

        <tr>
            <th colspan="2"><center class="text-danger">Chọn File Cần Giữ Lại</center></th>
            <th colspan="2"><center class="text-danger">Chọn Thư Mục Cần Giữ Lại</center></th>
        </tr>
        <tr>
            <th scope="row">config.json</th>
			<td><input type="checkbox" class="form-check-input" name="exclude[]" value="config.json" checked></td>
            <th scope="row">tts_saved</th>
            <td> <input type="checkbox" class="form-check-input" name="exclude[]" value="tts_saved" checked></td>

        </tr>
        <tr>
            <th scope="row">skill.json</th>
			<td><input type="checkbox" class="form-check-input" name="exclude[]" value="skill.json" checked></td>
			<th scope="row">hotword</th>
			<td><input type="checkbox" class="form-check-input" name="exclude[]" value="hotword" checked></td>

        </tr>
		        <tr>
           <th scope="row">google_stt.json</th>
           <td><input type="checkbox" class="form-check-input" name="exclude[]" value="google_stt.json" checked></td>
           <th scope="row">sound</th>
           <td><input type="checkbox" class="form-check-input" name="exclude[]" value="sound" checked></td>
        </tr>
		<tr>
            <th scope="row">google_tts.json</th>
            <td><input type="checkbox" class="form-check-input" name="exclude[]" value="google_tts.json" checked></td>
            <th scope="row">mp3</th>
            <td><input type="checkbox" class="form-check-input" name="exclude[]" value="mp3" checked></td>
        </tr>
		<tr>
           <th scope="row">credentials.json</th>
           <td><input type="checkbox" class="form-check-input" name="exclude[]" value="credentials.json" checked></td>
            <th scope="row">__pycache__</th>
             <td><input type="checkbox" class="form-check-input" name="exclude[]" value="__pycache__"></td>

        </tr>
				<tr>
           <th scope="row">device_config.json</th>
           <td><input type="checkbox" class="form-check-input" name="exclude[]" value="device_config.json" checked></td>
            <th scope="row">-</th>
             <td>-</td>

        </tr>
				<tr>
           <th scope="row" colspan="4"><div class="form-check form-switch d-flex justify-content-center"> <div class="input-group">
		  <input type="submit" name="checkforupdates" class="btn btn-success" value="Kiểm Tra">
		   <input type="submit" name="backup_update" class="btn btn-warning" value="Cập Nhật">
		   <a class="btn btn-danger" href="<?php echo $PHP_SELF; ?>" role="button">Làm Mới</a>
		    <button type="submit" name="restart_vietbot" class="btn btn-dark">Restart VietBot</button>
	
		   </div></div></th>
        
        </tr>
    </table>
</div>
</div>
    </div><br/>
<div class="my-div">
    <span class="corner-text"><h5>Sao Lưu/Khôi Phục:</h5></span><br/><br/>

	<center> 
	<div id="message"></div>
	
	</center><br/>
	<?php
	    // Lấy danh sách các tệp tin sao lưu
    $files = glob($backupDir . '/*.tar.gz');
    if (count($files) === 0) {
        echo '<center>Không có tệp tin sao lưu nào</center>';
    } else {
		?>
       
        <div class="row justify-content-center"><div class="col-auto"><div class="input-group">
  <?php
  // Tạo danh sách tệp tin sao lưu dưới dạng select dropdown
  echo '<select class="form-select" name="selectedFile"><option value="">Chọn file backup</option>';
        foreach ($files as $file) {
            $filename = basename($file);
            echo '<option value="' . $filename . '">' . $filename . '</option>';
        }
        echo '</select>';
        echo '<input type="submit" name="download" class="btn btn-primary" value="Tải xuống">';
        echo ' <input type="submit" name="restore" class="btn btn-warning" value="Khôi Phục">';
       
    }
	?>
	</div></div>
	</div><br/>
</div>
	</form>
	<br/> <p class="right-align"><b>Phiên bản Vietbot:  <font color=red><?php echo $dataVersionVietbot->vietbot_version->latest; ?></font></b></p>
	<?php
// Xử lý tải xuống tệp tin được chọn
if (isset($_POST['download']) && isset($_POST['selectedFile'])) {
    $selectedFile = $_POST['selectedFile'];
    $filePath = '/backup_update/backup/' . $selectedFile; // Đường dẫn đến thư mục chứa tệp tin
   // Tạo liên kết tới trang mục tiêu trong tab mới
   // $targetLink = "http://$serverIP$filePath"; // Đặt đường dẫn mục tiêu tại đây
    //echo "<script>window.open('$targetLink',  '_blank');</script>";
	    if (!empty($selectedFile)) {
        // Tạo liên kết tới trang mục tiêu trong tab mới
        $targetLink = "http://$serverIP$filePath"; // Đặt đường dẫn mục tiêu tại đây
        echo "<script>window.open('$targetLink',  '_blank');</script>";
    } else {
        // Xử lý khi $selectedFile không có giá trị
        $message .= 'Không có tệp tin được chọn để tải xuống\n';
    }
}
?>

<br/>


<?php


if (isset($_POST['checkforupdates'])) {
	
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://'.$serverIP.':5000',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"type": 3,"data": "vietbot_version"}',
  CURLOPT_HTTPHEADER => array(
    'Accept: */*',
    'Accept-Language: vi',
    'Connection: keep-alive',
    'Content-Type: application/json',
    'DNT: 3',
    'Origin: http://'.$serverIP,
    'Referer: http://'.$serverIP.'/',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36'
  ),
));
$response = curl_exec($curl);
curl_close($curl);
$data = json_decode($response, true);
// Kiểm tra kết quả từ yêu cầu cURL
if (!empty($data) && isset($data['result'])) {
  $currentresult = $data['result'];
} else {
  // Lấy dữ liệu "latest" từ tệp tin version.json cục bộ
  $localJson = file_get_contents($DuognDanThuMucJson.'/version.json');
  $localData = json_decode($localJson, true);
  $currentresult = $localData['vietbot_version']['latest'];
}
$gitJson = file_get_contents($Vietbot_Version);
$gitData = json_decode($gitJson, true);
$latestVersion = $gitData['vietbot_version']['latest'];
// So sánh giá trị "vietbot_version" từ cURL và từ GitHub
if ($currentresult === $latestVersion) {
  $messagee .= "Bạn đang sử dụng phiên bản mới nhất: " . $currentresult;
} else {
  $messagee .= "Có phiên bản mới: " . $latestVersion.'\n';
  $messagee .= "Phiên bản hiện tại: " . $currentresult.'\n';
}
}


if (isset($_POST['backup_update'])) {
/////////////////////
        // Tạo lệnh để nén thư mục
       // $tarCommand = 'tar -czvf ' . $backupFile . ' -C ' . dirname($DuognDanThuMucJson) . ' ' . basename($DuognDanThuMucJson);
		$tarCommand = "tar -czvf " . $backupFile . " -C $Path_Vietbot_src resources src";
	  // Thực thi lệnh
        exec($tarCommand, $output, $returnCode);
        // Kiểm tra mã trạng thái trả về
        if ($returnCode === 0) {
            // Đặt quyền chmod 777 cho thư mục sao lưu
          //  chmod($backupDir, 0777);
            chmod($backupFile, 0777);
         //   $messagee .= 'Tạo bản sao lưu thành công\n';
            // Xóa các file cũ nếu số lượng tệp tin sao lưu vượt quá giới hạn
            $backupFiles = glob($backupDir . '/*.tar.gz');
            $numBackupFiles = count($backupFiles);
            if ($numBackupFiles > $maxBackupFiles) {
                // Sắp xếp tệp tin sao lưu theo thời gian tăng dần
                usort($backupFiles, function ($a, $b) {
                    return filemtime($a) - filemtime($b);
                });
                // Xóa các tệp tin cũ nhất cho đến khi số lượng tệp tin sao lưu đạt đến giới hạn
                $filesToDelete = array_slice($backupFiles, 0, $numBackupFiles - $maxBackupFiles);
                foreach ($filesToDelete as $file) {
                    unlink($file);
                   //  $messaege .= 'Backup đã đạt giới hạn, đã xóa tệp tin cũ: ' . $file . '\n';
				;
                }
            }
        } else {
            $messagee .= 'Có lỗi xảy ra khi tạo bản sao lưu. Thư mục resources hoặc src không tồn tại .\n';
        }
		
	
		
		if (!file_exists($PathResources)) {
    // Nếu không tồn tại, tạo mới thư mục
    if (!mkdir($PathResources, 0777, true)) {
       // die('Không thể tạo thư mục');
    } else {
        // Nếu tạo mới thành công, đặt quyền chmod 777 cho thư mục
        chmod($PathResources, 0777);
       // echo 'Tạo và đặt quyền thành công!';
    }
}
		
///////////////////////
  //  $directory = '/home/pi/vietbot_offline/src';
    $excludedFiles = [];
    $excludedDirectories = [];
    $deletedItems = [];
    $copiedItems = [];
    
    if (isset($_POST['exclude'])) {
        foreach ($_POST['exclude'] as $item) {
            if (is_file($DuognDanThuMucJson . '/' . $item)) {
                $excludedFiles[] = $item;
            } elseif (is_dir($DuognDanThuMucJson . '/' . $item)) {
                $excludedDirectories[] = $item;
            }
        }
    }
    deleteFiles($DuognDanThuMucJson, $excludedFiles, $excludedDirectories, $deletedItems);
    $downloadLink = "$GitHub_VietBot_OFF/archive/beta.zip";
    $zipFile = 'vietbot_offline.zip';
    $zipFilePath = $DuognDanUI_HTML.'/backup_update/update' . $zipFile;
    
    if (copy($downloadLink, $zipFilePath)) {
        $zip = new ZipArchive;
        if ($zip->open($zipFilePath) === true) {
            $zip->extractTo($DuognDanUI_HTML.'/backup_update/extract');
            $zip->close();
            
            $sourceDirectory = $DuognDanUI_HTML.'/backup_update/extract/vietbot_offline-beta/src';
			$sourceDirectoryyy = $DuognDanUI_HTML.'/backup_update/extract/vietbot_offline-beta/resources';
            copyFiles($sourceDirectory, $DuognDanThuMucJson, $excludedFiles, $copiedItems);
			copyFiles($sourceDirectoryyy, $PathResources, $excludedFiles, $copiedItems);
            $messagee .= 'Đã tải xuống phiên bản Vietbot mới và cập nhật thành công!\n';
            $messagee .= 'BẠN CẦN KHỞI ĐỘNG LẠI LOA THÔNG MINH ĐỂ ÁP DỤNG LẠI CÀI ĐẶT!\n';
			shell_exec("rm -rf $DuognDanUI_HTML/backup_update/extract/vietbot_offline-beta");
			?>
			<div class="form-check form-switch d-flex justify-content-center"> 
<div class="container">
  <div class="row">
   <div class="col div-div1 scrollable-menu">
			<?php
            if (!empty($deletedItems)) {
              //  echo '<font color="red"><b>Các file/thư mục đã xóa để cập nhật:</b></font><br/>';
                foreach ($deletedItems as $item) {
                  //  echo $item . '<br/>';
                }
              
            }
			?>
			</div>
			   <div class="col div-div1 scrollable-menu">
			<?php

            if (!empty($copiedItems)) {
              //  echo '<font color="green"><b>Các file/thư mục đã được cập nhật:</b></font><br>';
                foreach ($copiedItems as $item) {
                //    echo $item . '<br/>';
                }
            }
			?>
			</div>
			</div>
			</div>
			</div>
			<?php
			
        } else {
            $messagee .=  'Có lỗi xảy ra, không thể giải nén tệp tin cập nhật.\n';
        }
        
        unlink($zipFilePath);
    } else {
        $messagee .=  'Có lỗi xảy ra, không thể tải xuống tệp tin cập nhật.\n';
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
//Dowload backup restor
//Chọn file backup và restore
if (isset($_POST['restore']) && isset($_POST['selectedFile'])) {
    $selectedFile = $_POST['selectedFile'];
	$sourceDirectory = $DuognDanUI_HTML.'/backup_update/extract/src';
	$sourceDirectoryyy = $DuognDanUI_HTML.'/backup_update/extract/resources';
 //   echo 'Tiến Hành Khôi Phục File: '.$selectedFile.'<br/>';
 if (!empty($selectedFile)) {
//Giải nén backup
	$archivePath = $DuognDanUI_HTML.'/backup_update/backup/'.$selectedFile;
	$extractPath = $DuognDanUI_HTML.'/backup_update/extract';
// Kiểm tra xem tệp tin nén tồn tại
if (file_exists($archivePath)) {
    // Kiểm tra xem đường dẫn giải nén tồn tại, nếu không tồn tại thì tạo mới
    if (!file_exists($extractPath)) {
        mkdir($extractPath, 0777, true);
    }
// Giải nén tệp tin
    $command = "tar -xvf $archivePath -C $extractPath";
    exec($command);
// Kiểm tra kết quả giải nén
    if (file_exists($extractPath)) {
        //$message .= 'Giải nén thành công: '.$selectedFile.'\n';
    } else {
        $message .= 'Có lỗi xảy ra khi giải nén: '.$selectedFile.'\n';
    }
} else {
    $message .= 'Tệp tin giải nén không tồn tại: '.$selectedFile.'\n';
}
//End giải nén backup

//Chmod 777 thưu mục src restore
/*
if (is_dir($sourceDirectory)) {
    if (chmod($sourceDirectory, 0777)) {
     //   $message .= 'Thay đổi quyền truy cập thành công: '.$sourceDirectory.'\n';
    } else {
        $message .= 'Thay đổi quyền truy cập thất bại: '.$sourceDirectory.'\n';
    }
} else {
    $message .= 'Thư mục không tồn tại: '.$sourceDirectory.'\n';
}
*/

$excludedFiles = array('excluded_file_VUTUYEN.txt'); //Bỏ Qua File không coppy giai đoạn thử nghiệm
$copiedItems = array();
copyFiles($sourceDirectory, $DuognDanThuMucJson, $excludedFiles, $copiedItems);
copyFiles($sourceDirectoryyy, $DuognDanThuMucJson, $excludedFiles, $copiedItems);
 $message .= 'Khôi phục bản sao lưu thành công\n';
?>
<div class="form-check form-switch d-flex justify-content-center"> 
<div class="container">
  <div class="row">
 
 <div class="col div-div1 scrollable-menu">
<?php
//echo  '<font color="green"><b>Đã khôi phục Firmware Vietbot thành công file:</b></font><br/>';
// Hiển thị danh sách các tệp tin đã được sao chép
foreach ($copiedItems as $copiedItem) {
    //echo  '<font color="green">Đã khôi phục thành công file: </font>'.$copiedItem.'<br/>';
   // echo  $copiedItem.'<br/>';
}
?>
</div>
<?php
//Xóa Nội dung đã giải nén khi restore
$excludedFilesrestore = array('README.md'); //bỏ qua file không bị xóa
$excludedDirectories = array('excluded_file_VUTUYEN'); // bỏ qua thư mục không bị xóa giai đoạn thử nghiệm
$deletedItems = array();
deleteFiles($sourceDirectory, $excludedFilesrestore, $excludedDirectories, $deletedItems);
deleteFiles($sourceDirectoryyy, $excludedFilesrestore, $excludedDirectories, $deletedItems);
?>

 <div class="col div-div1 scrollable-menu">
<?php
//echo '<font color="red"><b>Đã xóa các file khôi phục trong bộ nhớ tạm:</b></font><br/>';
// Hiển thị danh sách các tệp tin và thư mục đã bị xóa
foreach ($deletedItems as $deletedItem) {
   // echo $deletedItem . '<br/>';
}
    } else {
        // Xử lý khi $selectedFile không có giá trị
        $message .= "Không có tệp tin được chọn để tiến hành khôi phục.";
    }	
//Chmod 777 khi restor xong backup
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream1 = ssh2_exec($connection, 'sudo chmod -R 0777 '.$Path_Vietbot_src);
stream_set_blocking($stream1, true); 
$stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO);
stream_get_contents($stream_out1); 
}
	?>
</div>
	</div>
	</div>
	</div>
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
