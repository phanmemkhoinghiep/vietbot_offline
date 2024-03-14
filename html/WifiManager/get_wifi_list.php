<?php
include "../Configuration.php";


// Kiểm tra yêu cầu và hành động
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'get_data') {
		

        // Lấy danh sách WiFi và hiển thị nút xóa
        $result = shell_exec('nmcli -t -f NAME,UUID,DEVICE con show');
        $result = nl2br($result); // Thêm dấu xuống dòng (\n) thành dấu <br> để hiển thị trên nhiều dòng

        // Tách các tên mạng WiFi đã lưu thành mảng
        $savedWifiInfo = explode("\n", trim($result));

        // Loại bỏ các giá trị trống từ mảng
        $savedWifiInfo = array_filter($savedWifiInfo);


echo '<div class="row justify-content-center"><div class="col-auto">

<table class="table table-bordered">
  <thead>

  <tr><td colspan="6"><center><div id="showPassWifi"></div></td></tr>
  <tr><th scope="col" colspan="6"><center><font color=red>Danh Sách Wifi Đã Kết Nối</font></th></tr>
    <tr>
      <th scope="col"><center>Tên Wifi</center></th>
      <th scope="col"><center>UUID</center></th>
      <th scope="col"><center>Device</center></th>
      <th scope="col" colspan="3"><center>Hành Động</center></th>
    </tr>
  </thead>
  <tbody>';

        // Hiển thị danh sách WiFi và nút xóa
        foreach ($savedWifiInfo as $wifiInfo) {
            list($wifiName, $uuid, $device) = explode(':', $wifiInfo, 3);
            $wifiNameWithoutBr = htmlspecialchars($wifiName); // Ngăn chặn các ký tự đặc biệt
			$device = str_replace('<br />', '', $device);

echo '
    <tr>
      <th scope="row">'.$wifiNameWithoutBr.'</th>
      <td>'.$uuid.'</td>
      <td><center>'.$device.'</center></td>
      <td><center><button class="connect-wifi-da-luu btn btn-success" data-wifi-name="'.$wifiNameWithoutBr.'" data-wifi-uuid="'.$uuid.'" data-wifi-device="'.$device.'">Kết Nối</button><center></td>
    <td><center><button class="show-matkhau btn btn-warning" data-wifi-name="'.$wifiNameWithoutBr.'">Mật Khẩu</button></center></td>
    <td><center><button class="delete-button btn btn-danger" data-wifi-name="'.$wifiNameWithoutBr.'">Xóa</button></center></td>
	</tr>'; 
        }
		echo   '</tbody>
</table></div></div>';


    } elseif ($action == 'scan_wifi') {
		
		
		
    $connection = ssh2_connect($serverIP, $SSH_Port);
    if (!$connection) {
        die("Không thể kết nối đến server SSH.");
    }
    if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {
        die("Xác thực SSH thất bại.");
    }
    $stream = ssh2_exec($connection, "sudo nmcli -t -f SSID,BSSID,MODE,CHAN,RATE,SIGNAL,BARS,SECURITY dev wifi");
    stream_set_blocking($stream, true);
    $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
    $result = stream_get_contents($stream_out);

    if (!$result) {
        die("Lỗi khi lấy dữ liệu WiFi từ SSH.");
    }

    $lines = explode("\n", $result);

    echo '<div class="row justify-content-center"><div class="col-auto"><table class="table table-bordered">
        <thead>
		<tr><th colspan="8"><center><font color=red>Danh Sách Mạng Wifi Được Tìm Thấy</font></center></th>
		</tr>
		
            <tr>
                <th scope="col" title="SSID"><center>Tên Mạng Wifi</center></th>
                <th scope="col"><center>BSSID</center></th>
              <!--  <th scope="col"><center>MODE</center></th> -->
                <th scope="col"><center>Kênh</center></th>
                <th scope="col"><center>RATE</center></th>
                <th scope="col" title="Tín hiệu càng cao điểm phát wifi càng gần"><center>Tín Hiệu</center></th>
                <th scope="col"><center>Cường Độ</center></th>
                <th scope="col"><center>Bảo Mật</center></th>
                <th scope="col"><center>Hành Động</center></th>
            </tr>
        </thead>
        <tbody>';

    foreach ($lines as $line) {
        if (!empty($line)) {
            // Xử lý giá trị có chứa dấu thoát (\)
            $line = str_replace('\\', '', $line);

            // Tách các giá trị sử dụng explode
            $parts = explode(':', $line);

            // Xử lý các ký tự đặc biệt trong HTML
            $parts = array_map('htmlspecialchars', $parts);

            //$ssid = $parts[0];
            
            // Kết hợp các phần của địa chỉ MAC
            $bssidParts = array_slice($parts, 1, 6);
            $bssid = implode(':', $bssidParts);

            $mode = $parts[7];
            $chan = $parts[8];
            $rate = $parts[9];
            $signal = $parts[10];
            $bars = $parts[11];
			//$security = $parts[12];

			
			if (empty($parts[12])) {
				$security = "<font color=red title='Hãy cân nhắc khi kết nối tới mạng không được bảo mật'><i class='bi bi-unlock-fill'></i> Không mật khẩu</font>";
				$securityy = "";
			} else {
				$security = '<i class="bi bi-lock-fill"></i> '.$parts[12];
				$securityy = $parts[12];
			}
			
			if (empty($parts[0])) {
				$Check_ssid_hide = "<font color=red title='Chưa hỗ trợ kết nối tới mạng ẩn'>Mạng ẩn</font>";
				$Check_ssid_hidee = "wifi_hidden";
				$Button_connect = '<button class="connect-end-save-button btn btn-danger" data-wifi-ssid="'.$Check_ssid_hidee.'" data-wifi-security="'.$Check_ssid_hidee.'" title="Wifi bị ẩn, cần nhập cả tên wifi và mật khẩu">Kết nối</button>';
		
			} else {
				$Check_ssid_hide = $parts[0];
				$Button_connect = '<button class="connect-end-save-button btn btn-success" data-wifi-ssid="'.$Check_ssid_hide.'" data-wifi-security="'.$securityy.'" title="Kết nối tới wifi: '.$Check_ssid_hide.'">Kết nối</button>';
			}
			
            // Hiển thị giá trị
            echo '<tr>
                <th scope="row">'.$Check_ssid_hide.'</th>
                <td><center>'.$bssid.'</center></td>
             <!--   <td>'.$mode.'</td>  -->
                <td><center>'.$chan.'</center></td>
                <td><center>'.$rate.'</center></td>
                <td><center>'.$signal.'</center></td>
                <td><font color=green>'.$bars.'</font></td>
                <td>'.$security.'</td>
                <td><center>'.$Button_connect.'</center></td>
            </tr>';
        }
    }

    echo '</div<</div></tbody></table>';
    } elseif ($action == 'get_wifi_info') {
		
		
$wifiInfo = shell_exec('iwconfig wlan0');
preg_match('/ESSID:"([^"]+)"/', $wifiInfo, $essidMatches);
preg_match('/Frequency:([\d\.]+)\sGHz/', $wifiInfo, $frequencyMatches);
preg_match('/Access Point: ([0-9A-Fa-f:]{17})/', $wifiInfo, $accessPointMatches);

// Tạo chuỗi HTML chứa thông tin Wi-Fi
//$resultHtml = 'ESSID: ' . $essidMatches[1] . '<br>';
//$resultHtml .= 'Frequency: ' . $frequencyMatches[1] . ' GHz<br>';
//$resultHtml .= 'Access Point: ' . $accessPointMatches[1] . '<br>';
echo '<div class="row justify-content-center"><div class="col-auto"><table class="table table-bordered">
 <tbody>
     <tr>
      <td scope="col" colspan="2"><font color=red><b><center>Wifi Đang Kết Nối</center></b></font></td>
    </tr>
    <tr>
      <td scope="col">Tên Wifi:</td>
	  <td scope="col">'.$essidMatches[1].'</td>
    </tr>
    <tr>
      <td scope="col">Băng Tần:</td>
	  <td scope="col">'.$frequencyMatches[1].' GHz</td>
    </tr>
    <tr>
      <td scope="col">BSSID:</td>
	  <td scope="col">'.$accessPointMatches[1].'</td>
    </tr>
  </tbody>
</table></div></div>';
	}elseif ($action == 'get_password') {

$connection = ssh2_connect($serverIP, $SSH_Port);
if (!$connection) {
    die("Không thể kết nối đến server SSH.");
}

if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {
    die("Xác thực SSH thất bại.");
}

 $desiredSSID = isset($_GET['ssid']) ? $_GET['ssid'] : '';

// Đường dẫn đến thư mục chứa tệp cấu hình mạng WiFi
$configFilePath = '/etc/NetworkManager/system-connections/';

// Lấy danh sách tệp cấu hình
$stream = ssh2_exec($connection, "ls \"$configFilePath\"");
stream_set_blocking($stream, true);
$files = explode("\n", trim(stream_get_contents($stream)));

// Lặp qua từng tệp cấu hình
foreach ($files as $file) {
    if (!empty($file)) {
        // Xóa dấu ngoặc kép từ tên file chứa khoảng trắng và dấu cách
        $file = trim($file, '"');

        $configFile = $configFilePath . $file;

        // Thực hiện lệnh để đọc nội dung của tệp cấu hình và lấy SSID và mật khẩu
        $stream = ssh2_exec($connection, "sudo cat \"$configFile\"");
        stream_set_blocking($stream, true);
        $configContent = stream_get_contents($stream);

        // Tìm kiếm thông tin SSID và mật khẩu trong nội dung tệp cấu hình
        preg_match('/ssid=(.*)/', $configContent, $ssidMatches);
        preg_match('/psk=(.*)/', $configContent, $passwordMatches);

        // Kiểm tra xem SSID có khớp với chuỗi cần tìm kiếm không
        if (!empty($ssidMatches[1]) && strpos($ssidMatches[1], $desiredSSID) !== false) {
			echo '<b>Tên Mạng:</b> <font color=blue>' . $file . "</font><br/>";
			echo '<b>Tên Wifi:</b> <font color=blue>' . $ssidMatches[1] . "</font><br/>";
		if (!empty($passwordMatches[1])) {
			echo '<b>Mật khẩu:</b> <font color=blue>' . $passwordMatches[1] . "</font><br/>";
		} else {
			echo '<b>Mật khẩu:</b> <font color=red>Không có mật khẩu</font>';
		}

           // echo '<br>';
        }
    }
}

// Đóng kết nối SSH
ssh2_disconnect($connection);
		
	}


	else {
        echo "Hành động không hợp lệ.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
