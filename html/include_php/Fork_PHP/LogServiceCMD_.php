<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
//error_reporting(E_ALL);
?>



	<body>
 <script src="../../assets/js/jquery-3.6.1.min.js"></script>
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


<?php
function picovoice_version($noi_dung_tep, $ten_lop, $ten_phuong_thuc) {
    try {
        $dong = explode("\n", $noi_dung_tep);
        $trong_lop = $noi_dung_lop = $trong_phuong_thuc = $noi_dung_phuong_thuc = $gia_tri_return = false;
        foreach ($dong as $line) {
            $noi_dung_lop .= $line;
            if (strpos($line, "class {$ten_lop}(") !== false) {
                $trong_lop = true;
            }
            if ($trong_lop && strpos($line, "def {$ten_phuong_thuc}(") !== false) {
                $trong_phuong_thuc = true;
            }
            if ($trong_phuong_thuc) {
                $noi_dung_phuong_thuc .= $line;
                if (strpos($line, 'return ') !== false) {
                    $gia_tri_return = trim(trim(str_replace("'", "", explode('return ', $line)[1])));
                    break;
                }
            }
        }
        return $gia_tri_return;
    } catch (Exception $e) {
        return "Lỗi xử lý tệp.";
    }
}
function porcupine_version($file_path, $skip_count = 9) {
    try {
        $file = fopen($file_path, 'r');
        // Đọc và bỏ qua 9 ký tự đầu
        fread($file, $skip_count);
        // Đọc 15 ký tự tiếp theo
        $next_14_characters = fread($file, 5);
        fclose($file);
        return $next_14_characters;
    } catch (Exception $e) {
        return "File not found.";
    }
}
//

// Khởi tạo biến để lưu output
$output = '';

//echo "Địa chỉ IP của server là: " . $serverIP;

// Kiểm tra xem có yêu cầu thực hiện lệnh "ls" hay "dir" hay "systemctl --user restart vietbot" hay "journalctl --user-unit vietbot.service" hay không
if (isset($_POST['reboot_power'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'sudo reboot');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ sudo reboot\n\n";
$output .=  stream_get_contents($stream_out);
$output .= "$GET_current_USER@$HostName:~$ >Lệnh Được Thực Hiện Thành Công";
}

//restart vietbot
if (isset($_POST['restart_vietbot'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'systemctl --user restart vietbot');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ systemctl --user restart vietbot\n\n";
$output .=  stream_get_contents($stream_out);
$output .= "$GET_current_USER@$HostName:~$ >Lệnh Được Thực Hiện Thành Công\n\n";
}
//Kiểm Tra Manual Run
if (isset($_POST['check_manual_run'])) {
	
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'ps aux | grep -i start.py');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ ps aux | grep -i start.py\n\n";
$output .=  stream_get_contents($stream_out);

}
//Chạy Manual Run
if (isset($_POST['start_manual_run'])) {
	//echo '<script>document.getElementById("loading-overlay").style.display = "none";</script>';
// Lệnh cần chạy
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'cd /home/pi/vietbot_offline/src && python3 start.py  2>/dev/null');
stream_set_blocking($stream, false); //false chặn kết quả của luồng stream
// Trả về đoạn mã JavaScript để thay đổi thuộc tính style của #loading-overlay

$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ cd /home/pi/vietbot_offline/src && python3 start.py  2>/dev/null\n\n";
$output .=  "$GET_current_USER@$HostName:~$ Lệnh đã được thực thi, vui lòng đợi thiết bị khởi động\n\n";

}
//Dừng Manual Run
if (isset($_POST['stop_manual_run'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'pkill -f start.py');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ pkill -f start.py\n\n";
$output .=  stream_get_contents($stream_out);
}

//sudo_apt_update
if (isset($_POST['sudo_apt_update'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'sudo apt update');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ sudo apt update\n\n";
$output .=  stream_get_contents($stream_out);
}

//sudo_apt_upgrade
if (isset($_POST['sudo_apt_upgrade'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'sudo apt upgrade');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ sudo apt upgrade\n\n";
$output .=  stream_get_contents($stream_out);
}

//Kiểm Tra Dung Lượng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kiem_tra_dung_luong'])) {
	
	$message = "$GET_current_USER@$HostName:~ $ free -mh\n\n";
    $output = shell_exec('free -mh');
	$message .= $output;

}
//Kiểm Tra Bộ Nhớ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kiem_tra_bo_nho'])) {
	$message = "$GET_current_USER@$HostName:~ $ df -hm\n\n";
    $output = shell_exec('df -hm');
	$message .= $output;
}
//Check ifconfig
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_ifconfig'])) {
	$message = "$GET_current_USER@$HostName:~ $ ifconfig\n\n";
    $output = shell_exec('ifconfig');
	$message .= $output;
}
//Check thông tin cpu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_thong_tin_cpu'])) {
	$message = "$GET_current_USER@$HostName:~ $ lscpu\n\n";
    $output = shell_exec('lscpu');
	$message .= $output;
}
//Thông tin hệ điều hành
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['thong_tin_he_dieu_hanh'])) {
	$message = "$GET_current_USER@$HostName:~ $ hostnamectl\n\n";
    $output = shell_exec('hostnamectl');
	$message .= $output;
}
//Kiểm tra auto run
if (isset($_POST['check_auto_run'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'ps aux | grep -i start.py');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ ps aux | grep -i start.py\n\n";
$output .=  stream_get_contents($stream_out);

}
//chạy auto run
if (isset($_POST['start_auto_run'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'systemctl --user start vietbot.service');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ systemctl --user start vietbot.service\n\n";
$output .=  stream_get_contents($stream_out);
	
	
}
//dừng auto run
if (isset($_POST['stop_auto_run'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'systemctl --user stop vietbot.service');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ systemctl --user stop vietbot.service\n\n";
$output .=  stream_get_contents($stream_out);

}
//Kích Hoạt auto run
if (isset($_POST['enable_auto_run'])) {
	
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'systemctl --user enable vietbot.service');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ systemctl --user enable vietbot.service\n\n";
$output .=  stream_get_contents($stream_out);

}
//Vô hiệu hóa auto run
if (isset($_POST['disable_auto_run'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'systemctl --user disable vietbot.service');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ systemctl --user disable vietbot.service\n\n";
$output .=  stream_get_contents($stream_out);

}
//Log theo thời gian thực
if (isset($_POST['journalctl_vietbot'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'journalctl --user-unit vietbot.service');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ journalctl --user-unit vietbot.service\n\n";
$output .=  stream_get_contents($stream_out);
}
//Log dịch vụ chạy tự động
if (isset($_POST['systemctl_vietbot'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'systemctl --user status vietbot.service');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ systemctl --user status vietbot.service\n\n";
$output .=  stream_get_contents($stream_out);
	
}
if (isset($_POST['check_lib_pvporcupine'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'pip show pvporcupine');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ pip show pvporcupine\n\n";
$output .=  stream_get_contents($stream_out);
	
}
if (isset($_POST['check_lib_pip'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, 'pip list');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~$ pip list\n\n";
$output .=  stream_get_contents($stream_out);
	
}
//Chmod
if (isset($_POST['set_full_quyen'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream1 = ssh2_exec($connection, "sudo chmod -R 0777 $Path_Vietbot_src");
$stream2 = ssh2_exec($connection, "sudo chown -R pi:pi $Path_Vietbot_src");
stream_set_blocking($stream1, true); 
stream_set_blocking($stream2, true); 
$stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO); 
$stream_out2 = ssh2_fetch_stream($stream2, SSH2_STREAM_STDIO); 
$output = "$GET_current_USER@$HostName:~$ sudo chmod -R 0777 $Path_Vietbot_src\n";
$output .= stream_get_contents($stream_out1); 
$output .= stream_get_contents($stream_out2); 
$output .= "$GET_current_USER@$HostName:~$ >Lệnh Được Thực Hiện Thành Công";
}
//set_owner
if (isset($_POST['set_owner'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream1 = ssh2_exec($connection, "sudo chown -R pi:pi $Path_Vietbot_src");
stream_set_blocking($stream1, true); 
$stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO); 
$output = "$GET_current_USER@$HostName:~$ sudo chown -R pi:pi $Path_Vietbot_src\n";
$output .= stream_get_contents($stream_out1); 
$output .= "$GET_current_USER@$HostName:~$ >Lệnh Được Thực Hiện Thành Công";
}

//Restart Apache2
if (isset($_POST['restart_appache2'])) {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream1 = ssh2_exec($connection, "sudo systemctl restart apache2.service");
stream_set_blocking($stream1, true); 
$stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO); 
$output = "$GET_current_USER@$HostName:~$ sudo systemctl restart apache2.service\n";
$output .= stream_get_contents($stream_out1); 
$output .= "$GET_current_USER@$HostName:~$ >Lệnh Được Thực Hiện Thành Công";
}

//Command
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['commandd'])) {
	$commandnd = @$_POST['commandnd'];

	if (empty($commandnd)) {
            $output .= "Command:~> Hãy Nhập Lệnh Cần Thực Thi";
        }
else {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, $commandnd);
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output = "$GET_current_USER@$HostName:~ssh$: $commandnd\n";
$output .=  stream_get_contents($stream_out);
}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hash_generator'])) {
	$Hash_input = @$_POST['commandnd'];
	if (empty($Hash_input)) {
            $output .= "Hash Generator:~> Hãy Nhập Nội Dung";
        }
		else {
	$Hash_MD5_Encode = md5($Hash_input); //MD5
	$Hash_Base64_Encode = base64_encode($Hash_input); //base64_encode
	$Hash_Base64_Decode = base64_decode($Hash_input); //base64_decode
	$Hash_URL_Decode = urldecode($Hash_input); //base64_decode
	$Hash_URL_Encode = urlencode($Hash_input); //base64_decode
	
	$output = "Hash Generator:> $Hash_input\n\n";
	$output .= "MD5:> $Hash_MD5_Encode\n";
	$output .= "Base64 Encode:> $Hash_Base64_Encode\n";
	$output .= "Base64 Decode:> $Hash_Base64_Decode\n";
	$output .= "URL Encode:> $Hash_URL_Encode\n";
	$output .= "URL Decode:> $Hash_URL_Decode\n";
		}
	
}
//check_version_picovoice_porcupine
if (isset($_POST['check_version_picovoice_porcupine'])) {
$remotePath = "/home/pi/.local/lib/python3.9/site-packages/";
$pattern = '/^pvporcupine-(\d+\.\d+\.\d+)\.dist-info$/m';
// Thực hiện lệnh ls để lấy danh sách thư mục
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, "ls $remotePath");
stream_set_blocking($stream, true);
$outputhh = stream_get_contents($stream);
fclose($stream);
$output .= "$GET_current_USER@$HostName:~ssh$:\n";
// Kiểm tra xem có thư mục nào khớp với biểu thức chính quy không
if (preg_match($pattern, $outputhh, $matches)) {
    $foundVersion = $matches[1];
    $output .= "Phiên bản Picovoice: $foundVersion\n";
} else {
    //echo "Không tìm thấy thư mục pvporcupine-X.X.X.dist-info.";
$path_picovoice = '/home/pi/.local/lib/python3.9/site-packages/picovoice/_picovoice.py';
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream = ssh2_exec($connection, "cat $path_picovoice");
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$output =  stream_get_contents($stream_out);
//echo $output;
$text_picovoice_version = picovoice_version($output, 'Picovoice', 'version');
$firstThreeCharspicovoice_version = substr($text_picovoice_version, 0, 3);
$output .= "Phiên bản Picovoice: $text_picovoice_version\n";
}

if ($Get_hotword_Lang == 'default') {
    $porcupine_check = "default/porcupine_params.pv";
} elseif ($Get_hotword_Lang == 'eng') {
    $porcupine_check = "porcupine_params.pv";
} elseif ($Get_hotword_Lang == 'vi') {
    $porcupine_check = "porcupine_params_vn.pv";
}

$file_path = "$Lib_Hotword/$porcupine_check";
$text_porcupine_version = porcupine_version($file_path);
//echo "Phiên bản Porcupine: $text_porcupine_version";
$output .= "Phiên bản Porcupine: $text_porcupine_version";
}
if (isset($_POST['install_picovoice'])) {
$versions_picovoice_install = $_POST['versions_picovoice_install'];
if (empty($versions_picovoice_install)) {
    $output = "Picovoice:> Hãy chọn phiên bản picovoice cần cài đặt\n";
} else {
$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {die($E_rror_HOST);}
if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {die($E_rror);}
$stream1 = ssh2_exec($connection, "pip install picovoice==$versions_picovoice_install");
stream_set_blocking($stream1, true); 
$stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO); 
$output = "$GET_current_USER@$HostName:~$ pip install picovoice==$versions_picovoice_install\n";
$output .= stream_get_contents($stream_out1);
}
}


if (isset($_POST['install_porcupine'])) {
$destinationPath = "$PathResources/picovoice/lib";
$versions_porcupine_install = $_POST['versions_porcupine_install'];
if (empty($versions_porcupine_install)) {
    $output .= "Porcupine:> Hãy chọn phiên bản Porcupine cần cài đặt\n";
} else {
$fileUrl = 'https://github.com/Picovoice/porcupine/archive/refs/tags/v'.$versions_porcupine_install.'.zip';
$fileContent = file_get_contents($fileUrl);
$filename = basename($fileUrl);
$destinationFile = $destinationPath . '/' . $filename;
file_put_contents($destinationFile, $fileContent);
chmod($destinationFile, 0777);
$output .= "Porcupine:> Phiên bản thư viện Porcupine (.pv) được cài đặt là: $versions_porcupine_install\n";

$fileNameZip = 'porcupine-'.$versions_porcupine_install.'/lib/common';
$zipFilePath = $destinationPath.'/v'.$versions_porcupine_install.'.zip'; // Đường dẫn đến file ZIP
$zip = new ZipArchive;
if ($zip->open($zipFilePath) === TRUE) {
    $fileNamesToCopy = ["$fileNameZip/porcupine_params.pv", "$fileNameZip/porcupine_params_vn.pv"];

    foreach ($fileNamesToCopy as $fileNameInZip) {
        // Kiểm tra xem file có tồn tại trong ZIP hay không
        $index = $zip->locateName($fileNameInZip);
        if ($index !== false) {
            // Đọc nội dung của file từ ZIP
            $fileContent = $zip->getFromIndex($index);
            // Đường dẫn đến thư mục đích
            $destinationFilee = $destinationPath . '/' . basename($fileNameInZip);
            // Ghi nội dung của file vào thư mục đích
            file_put_contents($destinationFilee, $fileContent);
            
            //$output .= 'Porcupine:> File '.basename($fileNameInZip).' đã được đưa vào thư mục lib có chứa tệp .pv | ';
        } else {
            $output .= 'Porcupine:> File '.basename($fileNameInZip). 'không tồn tại | ';
        }
    }
    $zip->close();
	shell_exec('rm ' . escapeshellarg($zipFilePath));
	$output .= 'Porcupine:> HÃY CHỌN LẠI NGÔN NGỮ HOTWORD VÀ LƯU CẤU HÌNH SAU ĐÓ KHỞI ĐỘNG LẠI VIETBOT ĐỂ ÁP DỤNG.';
	
} else {
    $output .= 'Porcupine:> Lỗi không thể mở file thư viện Porcupine: v'.$versions_porcupine_install.'.zip \n';
}
}
}

?>
<br/>
    <form  id="my-form"  method="post">
	<div class="row g-3 d-flex justify-content-center">
  <div class="col-auto"> 
  <input type="text" name="commandnd" class="form-control input-sm" placeholder="Nhập Lệnh/Nội Dung" aria-label="Recipient's username" aria-describedby="basic-addon2">
</div> 

<div class="col-auto"> 
    <button class="btn btn-success" name="commandd" type="submit">Command</button>
    <a href='<?php echo $PHP_SELF; ?>'><button class='btn btn-danger'>Làm Mới</button></a>
	
 </div>
 <div class="col-auto"> 
 	<label for="fetchCheckbox" class="btn btn-warning">   <input type="checkbox" id="fetchCheckbox" onchange="startStopFetching(this)">
    Đọc Log Debug</label>
	
</div>
</div>
<br/><center>
<div class="btn-group">
  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Kiểm Tra Log
  </button>
  <div class="dropdown-menu">
 <center><button  type="submit" name="systemctl_vietbot" class="btn btn-warning">Dịch Vụ Chạy Tự Động</button>
<div class="dropdown-divider"></div>   <button type="submit" name="journalctl_vietbot" class="btn btn-warning">Theo Thời Gian Thực</button>
 </center></div></div>

<div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Auto Run
  </button>
  <div class="dropdown-menu scrollable-menu">
 <center><button  type="submit" name="check_auto_run" class="btn btn-danger">Kiểm Tra Auto Run</button>
<div class="dropdown-divider"></div>  <button type="submit" name="stop_auto_run" class="btn btn-danger">Dừng Auto Run</button>
 <div class="dropdown-divider"></div>  <button type="submit" name="start_auto_run" class="btn btn-danger">Chạy Auto Run</button>
 <div class="dropdown-divider"></div>  <button type="submit" name="enable_auto_run" class="btn btn-danger">Kích Hoạt Auto Run</button>
 <div class="dropdown-divider"></div>  <button type="submit" name="disable_auto_run" class="btn btn-danger">Vô Hiệu Auto Run</button>
 </center></div></div>
	
<div class="btn-group">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Manual run
  </button>
  <div class="dropdown-menu scrollable-menu">
 <center><button  type="submit" name="check_manual_run" class="btn btn-primary">Kiểm Tra Manual Run</button>

<div class="dropdown-divider"></div>  <button type="submit" name="start_manual_run" class="btn btn-primary" disabled>Chạy Manual Run</button>

 <div class="dropdown-divider"></div>  <button type="submit" name="stop_manual_run" class="btn btn-primary">Dừng Manual Run</button>
 </center></div></div>

	
		<div class="btn-group">
  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Chức Năng Khác
  </button>
  <div class="dropdown-menu scrollable-menu">
 <center> <button class="btn btn-success" name="hash_generator" type="submit">Hash Generator</button>
<div class="dropdown-divider"></div>  <button  type="submit" name="kiem_tra_dung_luong" class="btn btn-success">Kiểm Tra Dung Lượng</button>
 <div class="dropdown-divider"></div>  <button type="submit" name="kiem_tra_bo_nho" class="btn btn-success">Kiểm Tra Bộ Nhớ</button>
  <div class="dropdown-divider"></div><button  type="submit" name="check_ifconfig" class="btn btn-success">Kiểm Tra Mạng</button>
 <div class="dropdown-divider"></div><button  type="submit" name="check_thong_tin_cpu" class="btn btn-success">Thông Tin CPU</button>
 <div class="dropdown-divider"></div><button  type="submit" name="thong_tin_he_dieu_hanh" class="btn btn-success">Thông Tin OS HĐH</button>
 <!-- <div class="dropdown-divider"></div>  <button type="submit" name="khoi_dong_os" class="btn btn-success">Khởi Động OS</button> -->
<!-- <div class="dropdown-divider"></div>  <button type="submit" name="tat_mach_xu_ly" class="btn btn-success">Tắt Mạch Xử Lý</button> -->
 </center>
  </div>
</div>
<div class="btn-group">
  <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Hệ Thống
  </button>
  <div class="dropdown-menu scrollable-menu">
 <center><button type="submit" name="restart_vietbot" class="btn btn-dark" title="Chỉ Khởi Động Lại Trợ Lý Ảo VietBot">Restart VietBot</button>
<div class="dropdown-divider"></div>  <button type="submit" name="reboot_power" class="btn btn-dark" title="Khởi Động Lại Toàn Bộ Hệ Thống">Reboot OS</button>
 <div class="dropdown-divider"></div>  <button type='submit' name='set_full_quyen' class='btn btn-dark' title='Cấp Quyền Cho Các File Và Thư Mục Cần Thiết'>Cấp Quyền Chmod</button>
 <div class="dropdown-divider"></div>  <button type='submit' name='set_owner' class='btn btn-dark' title='Chuyển các file và thư mục cần thiết về người dùng pi'>Change Owner</button> 
 <div class="dropdown-divider"></div>  <button type='submit' name='restart_appache2' class='btn btn-dark' title='Restart Apache2'>Restart Apache2</button>
  <div class="dropdown-divider"></div>  <button type='submit' name='check_lib_pvporcupine' class='btn btn-dark' title='Kiểm tra thư viện pvporcupine'>Check lib pvporcupine</button>
  <div class="dropdown-divider"></div>  <button type='submit' name='check_lib_pip' class='btn btn-dark' title='Liệt kê các thư viện đã cài bằng pip'>Check lib pip list</button>
  <div class="dropdown-divider"></div>  <button type='submit' name='sudo_apt_update' class='btn btn-dark' title='cập nhật gói và hệ thống update'>sudo apt update</button>
  <div class="dropdown-divider"></div>  <button type='submit' name='sudo_apt_upgrade' class='btn btn-dark' title='cập nhật gói và hệ thống upgrade'>sudo apt upgrade</button>
 </center></div></div><hr/>
 
   
	<div class="row g-3 d-flex justify-content-center">
	<div class="col-auto"><div class="input-group"><span class="input-group-text text-success">Nâng/Hạ Cấp Picovoice</span>
    <select class="btn btn-success dropdown-toggle" data-toggle="dropdown" id="inputGroupSelect04" name="versions_picovoice_install">
	<option value="" selected>Chọn Phiên Bản</option>
 <?php
$url = 'https://pypi.org/rss/project/picovoice/releases.xml';
// Lấy nội dung từ RSS feed
$xml_content = file_get_contents($url);
// Kiểm tra xem có dữ liệu hay không
if ($xml_content) {
    // Tìm vị trí của các thẻ <item>
    $start_pos = strpos($xml_content, '<item>');
    $end_pos = strpos($xml_content, '</item>');
    // Tạo một mảng để lưu trữ các phiên bản
    $versions = [];
    // Lặp qua từng mục và thêm thông tin vào mảng
    while ($start_pos !== false && $end_pos !== false) {
        $item_xml = substr($xml_content, $start_pos, $end_pos - $start_pos + strlen('</item>'));
        // Trích xuất thông tin từ mỗi mục
        preg_match('/<title>(.*?)<\/title>/', $item_xml, $title_match);
        // Thêm phiên bản vào mảng
        $versions[] = $title_match[1];
        // Di chuyển đến mục tiếp theo
        $start_pos = strpos($xml_content, '<item>', $end_pos);
        $end_pos = strpos($xml_content, '</item>', $start_pos);
    }
    // Hiển thị dropdown list
    foreach ($versions as $version) {
        echo '<option value="' . $version . '">Picovoice: ' . $version . '</option>';
    }
} else {
    echo "<option value=''>Phiên bản: -----</option>";
}
?>
 </select></div> </div><div class="col-auto"> <div class="input-group-append">
 <button class="btn btn-danger" name="install_picovoice" title="Cài đặt Picovoice" type="submit">Cài Đặt Picovoice</button>
 <button type='submit' name='check_version_picovoice_porcupine' class='btn btn-primary' title='Kiểm tra phiên bản Picovoice và Porcupine'>Kiểm tra phiên bản</button>
 </div> 
 </div> 


 </div><hr/>
 <div class="row g-3 d-flex justify-content-center">
 <div class="col-auto">
 <div class="input-group">
 <span class="input-group-text text-success">Thư Viện Porcupine (.pv)</span>
     <select class="btn btn-success dropdown-toggle" data-toggle="dropdown" id="inputGroupSelect04" name="versions_porcupine_install">
	<option value="" selected>Chọn Phiên Bản</option>
 <?php
 $uniqueVersions = [];
    foreach ($versions as $versionpv) {
    // Lấy 3 ký tự đầu tiên của chuỗi
    $versionFirstThreeChars = substr($versionpv, 0, 3);
    
    // Kiểm tra xem giá trị đã xuất hiện chưa
    if (!in_array($versionFirstThreeChars, $uniqueVersions)) {
        // Nếu chưa xuất hiện, thêm vào mảng và hiển thị
        $uniqueVersions[] = $versionFirstThreeChars;
        echo '<option value="' . $versionFirstThreeChars . '">Porcupine: ' . $versionFirstThreeChars . '</option>';
    }
   }
?>
 </select>
 </div>
 </div>
 <div class="col-auto"> <div class="input-group-append">
 <button class="btn btn-danger" name="install_porcupine" title="Cài đặt Porcupine" type="submit">Cài Đặt Porcupine</button>
 </div> 
 </div> 
 </div>

    </form>
    <div id="loading-overlay">
          <img id="loading-icon" src="../../assets/img/Loading.gif" alt="Loading...">
		  <div id="loading-message">Đang Thực Thi...</div>
    </div>
    <br/><br/><textarea name="textarea_log_command" id="log-textarea" style="width: 95%; height: 340px;" class="text-info form-control bg-dark" readonly rows="10" cols="50"><?php echo $output; ?></textarea>



</center>

<br/>
    <script>
        let intervalId;
        let logType = "<?php echo $check_current_log_status; ?>"; // Default log type

        function startStopFetching(checkbox) {
            const validLogTypes = ['web', 'both'];

            if (checkbox.checked) {
                if (validLogTypes.includes(logType)) {
                    // đặt thời gian load dữ liệu 1 lần
                    intervalId = setInterval(fetchData, <?php echo $Log_Load_Time_Countdown; ?>);
                } else {
                    // Hiển thị cảnh báo cho loại nhật ký không hợp lệ
                    alert('Có vẻ như bạn chưa bật chế độ: "Kiểu hiển thị log" trên Web \n\n Bạn cần đi tới tab "Cấu Hình/Config -> Log -> Kiểu Hiển Thị Log"\n\n Chọn vào "Web" hoặc "Cả Hai" sau đó Lưu Cấu Hình và Khởi Động Lại VietBot để áp dụng.');
                    checkbox.checked = false;
                }
            } else {
                clearInterval(intervalId);
            }
        }
		
function fetchData() {
    if (logType === 'web' || logType === 'both') {
        $.ajax({
            type: "GET",
            url: "http://<?php echo $serverIP; ?>:<?php echo $Port_Vietbot; ?>/get_log",
            //timeout: 7000, // Đặt timeout là 7 giây
            success: function(data) {
                const logTextarea = $("#log-textarea");
                const scrollTop = logTextarea.scrollTop(); 
                logTextarea.val(''); 

                data.forEach(function(item) {
                    const logEntry = item.message + '\n';
                    logTextarea.val(logEntry + logTextarea.val()); 
                });

                logTextarea.scrollTop(scrollTop + 2000); 
            },
            error: function(xhr, status, error) {
				 const logTime = getFormattedTime();
				const logTextarea = $("#log-textarea");
                logTextarea.val("pi@get_log:~> "+logTime+" Lỗi không thể kết nối tới api get_log, vui lòng kiểm tra lại");
            }
        });
    }
}
		
	function getFormattedTime() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    return `${hours}:${minutes}:${seconds}`;
}	

    </script>

</body>

</html>
