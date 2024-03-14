<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
//error_reporting(E_ALL);
require_once '../assets/lib_php/getid3/getid3.php';
?>
<script>
    //icon Loading
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

$cfg_action_json = "$DuognDanUI_HTML/Multimedia/cfg_action.json";
if (!file_exists($cfg_action_json)) {
    // Tạo mới tệp
    $file_content_action = json_encode(['music_source' => 'ZingMp3'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($cfg_action_json, $file_content_action);
    chmod($cfg_action_json, 0777);
    //echo "Tệp $cfg_action_json đã được tạo mới và quyền chmod đã được thiết lập thành 0777.";
}

$Play_List_json = "$DuognDanUI_HTML/Multimedia/Play_List.json";
// Kiểm tra xem tệp có tồn tại không
if (!file_exists($Play_List_json)) {
    // Nếu không tồn tại, tạo nội dung mặc định
    $default_content = array(
        "play_list" => array()
    );
    $json_content = json_encode($default_content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($Play_List_json, $json_content);
    chmod($Play_List_json, 0777);
}




$Data_CFG_ACTION = json_decode(file_get_contents($cfg_action_json), true);

//echo $Data_CFG_ACTION['music_source'];

if (!is_numeric($sync_media_player_sync_delay) || $sync_media_player_sync_delay < 1 || $sync_media_player_sync_delay > 5) {
    // Nếu không nằm trong khoảng, thiết lập giá trị mặc định là 1
    $sync_media_player_sync_delay = 1;
}

function install_source_node($DuognDanUI_HTML,$serverIP,$SSH_Port,$SSH_TaiKhoan,$SSH_MatKhau,$E_rror_HOST,$E_rror) {
	
		$url = 'https://raw.githubusercontent.com/marion001/Google-APIs-Client-Library-PHP/main/node_modules.tar.gz';
		$destination = $DuognDanUI_HTML.'/assets/lib_php/node_modules.tar.gz';
		$extractedFolderPath = $DuognDanUI_HTML.'/assets/lib_php/';
		// Tải file từ URL
		$fileContent = file_get_contents($url);

		if ($fileContent !== false) {
		// Lưu nội dung vào file đích
			$result = file_put_contents($destination, $fileContent);

			if ($result !== false) {
				//echo 'Dữ liệu đã được tải xuống thành công và lưu vào ' . $destination.'<br/>';
				echo '<center>Dữ liệu đã được tải xuống thành công</center>';
				$phar = new PharData($destination);
				$phar->extractTo($extractedFolderPath, null, true);  // Tham số thứ ba (true) cho phép ghi đè
				//echo "Tệp dữ liệu đã được cấu hình thành công vào $extractedFolderPath <br/>Hãy tải lại trang để áp dụng<br/>";
				echo "<center>Tệp dữ liệu đã được cấu hình thành công. <br/>Hãy tải lại trang để áp dụng<br/><center>";
				chmod($extractedFolderPath . 'node_modules', 0777);
				shell_exec("rm $destination");
				$connection = ssh2_connect($serverIP, $SSH_Port);
				if (!$connection) {
				die($E_rror_HOST);
				}
				if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {
				die($E_rror);
				}
				$stream = ssh2_exec($connection, 'sudo mv '.$DuognDanUI_HTML.'/assets/lib_php/node_modules /home/pi/node_modules');
				stream_set_blocking($stream, true);
				$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
				stream_get_contents($stream_out);
				echo '<center><a href="index.php"><button type="submit" class="btn btn-danger">Tải Lại</button></a></center>';
				} 
			else {
        echo 'Lỗi khi lưu nội dung tệp cấu hình vào ' . $destination;
		echo '<br/><center><a href="index.php"><button type="submit" class="btn btn-danger">Tải Lại</button></a></center>';
			}
		} else {
			echo 'Lỗi khi tải xuống tệp cấu hình từ ' . $url;
			echo '<br/><center><a href="index.php"><button type="submit" class="btn btn-danger">Tải Lại</button></a></center>';
		}
		exit();
}

if (isset($_POST['install_lib_node_js'])) {
	
	$connection = ssh2_connect($serverIP, $SSH_Port);
    if (!$connection) {
        die($E_rror_HOST);
    }
    if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {
        die($E_rror);
    }
	//cập nhật nguồn trước khi cài thư viện node js
    $stream1 = ssh2_exec($connection, 'sudo apt update');
    stream_set_blocking($stream1, true);
    $stream_out1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDIO);
    stream_get_contents($stream_out1);
	
    $stream = ssh2_exec($connection, 'sudo apt install nodejs -y');
    stream_set_blocking($stream, true);
    $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
    stream_get_contents($stream_out);
install_source_node($DuognDanUI_HTML,$serverIP,$SSH_Port,$SSH_TaiKhoan,$SSH_MatKhau,$E_rror_HOST,$E_rror);

}
if (isset($_POST['install_ytdl_core_node_js'])) {
		$connection = ssh2_connect($serverIP, $SSH_Port);
    if (!$connection) {
        die($E_rror_HOST);
    }
    if (!ssh2_auth_password($connection, $SSH_TaiKhoan, $SSH_MatKhau)) {
        die($E_rror);
    }
	//cập nhật nguồn trước khi cài thư viện node js
    $stream2 = ssh2_exec($connection, 'npm install ytdl-core');
    stream_set_blocking($stream2, true);
    $stream_out2 = ssh2_fetch_stream($stream2, SSH2_STREAM_STDIO);
    stream_get_contents($stream_out2);
	echo '<br/><br/><center><a href="index.php"><button type="submit" class="btn btn-danger">Tải Lại Trang</button></a></center>';
	exit();
}

// Kiểm tra xem Node.js đã được cài đặt chưa
$nodeCheck = shell_exec('node -v');
if (empty($nodeCheck)) {
    //echo 'Node.js chưa được cài đặt.<br>';
		echo '<br/><br/><center><form method="POST" id="my-form" action="">';
		echo "nodejs chưa được cài đặt, nhấn vào nút bên dưới để cài hoặc cài thủ công bằng 2 lệnh sau:<br/> <b>sudo apt update</b><br/> và: <b>npm install ytdl-core</b><br/><br/>";
		echo "<button name='install_lib_node_js' class='btn btn-success'>Cấu Hình nodejs</button>";
		echo "<a href='$PHP_SELF'><button class='btn btn-primary'>Làm Mới</button></a></center>";
		echo "</form></center>";
    exit;
} else {
    //echo 'Node.js đã được cài đặt. Phiên bản: ' . $nodeCheck . '<br>';
$directory = $PATH_USER_ROOT;
// Kiểm tra xem thư mục node_modules tồn tại hay không
if (is_dir($directory . '/node_modules')) {
    //echo 'Thư mục node_modules tồn tại.<br>';
	

if (is_dir($directory . '/node_modules/ytdl-core')) {
    //echo 'Thư mục ytdl-core đã được tìm thấy trong thư mục node_modules.' . PHP_EOL;
} else {
    //echo 'Thư mục ytdl-core không được tìm thấy trong thư mục node_modules.' . PHP_EOL;

			echo '<br/><br/><center><form method="POST" id="my-form" action="">';
			echo "thư viện ytdl-core chưa được cài đặt, nhấn vào nút bên dưới để cài hoặc cài thủ công bằng lệnh:<br/> <b>npm install ytdl-core</b><br/><br/>";
		echo "<button name='install_ytdl_core_node_js' class='btn btn-success'>Cấu Hình ytdl-core</button> ";
		echo " <a href='$PHP_SELF'><button class='btn btn-primary'>Làm Mới</button></a></center>";
		echo "</form></center>";
    exit;
	
}


	
} else {
    //echo 'Thư mục node_modules không tồn tại.<br>';
	install_source_node($DuognDanUI_HTML,$serverIP,$SSH_Port,$SSH_TaiKhoan,$SSH_MatKhau,$E_rror_HOST,$E_rror);
	
}
	
}

if (isset($_POST['cache_delete'])) {
	// Xóa tất cả dữ liệu trong cache_search hiện tại
    $Data_CFG_ACTION['cache_search'] = [];
	file_put_contents($cfg_action_json, json_encode($Data_CFG_ACTION, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}


?>
<!-- <div class="container"> -->
<div>
    <div class="row">
        <div class="col-sm-6">
            <form method="post" id="my-form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="4" scope="col">
                                <center>Chọn Nguồn Phát:</center>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
<td><center>
                                <!-- Checkbox với giá trị "keymp3" -->
                                <input type="radio" id="LocalMp3" name="action" value="Local" title="Tìm kiếm trên thiết bị" onchange="handleRadioChangeLocal()">
                                <label for="LocalMp3" title="Tìm kiếm trên thiết bị">Local MP3</label>
                           </center> </td>
                            <td><center>
                                <!-- Checkbox với giá trị "keymp3" -->
                                <input type="radio" id="keyzingmp3" name="action" value="ZingMp3" title="Tìm kiếm trên ZingMp3" onchange="handleRadioChangeLocal()">
                                <label for="keyzingmp3" title="Tìm kiếm trên ZingMp3">Zing MP3</label>
                            </center> </td>

                            <td><center>
                                <!-- Checkbox với giá trị "keyyoutube" -->
                                <input type="radio" id="keyyoutube" name="action" value="Youtube"  onchange="handleRadioChangeLocal()">
                                <label for="keyyoutube" title="Tìm kiếm trên youtube">YouTube</label>
                             </center></td>
							                             <td><center>
                                <!-- Checkbox với giá trị "keyyoutube" -->
                                <input type="radio" id="PodCastMp3" name="action" value="PodCast"  onchange="handleRadioChangeLocal()">
                                <label for="PodCastMp3" title="Tìm kiếm PodCast">PodCast</label>
                             </center></td>
                        </tr>
						<tr>
						<td>
						<center>
						 <input type="radio" id="RadioVOV" name="action" value="RadioVOV"  onchange="handleRadioChangeLocal()">
                                <label for="RadioVOV" title="Tìm kiếm RadioVOV">Radio</label></center>
						</td>
						<td colspan="3"><center>
	
<select class="custom-select" name="SelectRadioVOV" id="SelectRadioVOV">
<?php
// Kiểm tra xem có dữ liệu trong mảng radio_data của tệp skill.JSON hiện tại hay không
if (!empty($Data_Json_Skilll['radio_data'])) {
    // Duyệt qua dữ liệu radio từ tệp JSON hiện tại
    foreach ($Data_Json_Skilll['radio_data'] as $radio_data) {
        $name_radio = $radio_data['name'];
        $link_radio = $radio_data['link'];
        // In ra option cho select
        echo '<option data-name_radio="' . $name_radio . '" value="' . $link_radio . '">' . $name_radio . '</option>';
    }
} else {
    // Nếu không có dữ liệu trong mảng radio_data của tệp JSON hiện tại, sử dụng dữ liệu từ tệp JSON cfg_action.json
    foreach ($Data_CFG_ACTION['radio_data'] as $alternative_radio_data) {
        $name_radio = $alternative_radio_data['name'];
        $link_radio = $alternative_radio_data['link'];
        // In ra option cho select
        echo '<option data-name_radio="' . $name_radio . '" value="' . $link_radio . '">' . $name_radio . '</option>';
    }
}
?>
</select>
					
                           </center> </td>
						 
						
						</tr>
                        <tr>
                            <td colspan="4">
                                <div class="form-group mb-2">
								<div class="form-group mx-sm-3 mb-2">
                                  <center>    <input type="text" id="tenbaihatInput" class="form-control" title="Nhập tên bài hát, link Youtube, hoặc link mp3: https://zxc.com/1.mp3" name="tenbaihat" placeholder="Nhập nội dung, tên bài hát, link.mp3, link youtube" aria-label="Recipient's username" aria-describedby="basic-addon2" oninput="handleInputHTTP()">
                                    </center> </div>
                                      <center>  <button class="btn btn-primary" id="TimKiem" type="submit" title="Tìm kiếm bài hát">Tìm Kiếm</button>
                                       
                                   
<button type="button" id="Play_Radio" class="ajax-button btn btn-success" data-song-data_type="2" data-song-data_play_music="play_direct_link" data-song-player_type="system" data-song-images="../assets/img/RADIO1.png" data-song-name="" data-song-id="" value="">Phát Radio</button>
      
                                        <button type="button" id="submitButton" class="ajax-button btn btn-success" data-song-data_type="2" data-song-data_play_music="play_direct_link" data-song-player_type="system" data-song-images="../assets/img/NotNhac.png" data-song-name="Không có dữ liệu" data-song-id="" value="" hidden>Play .Mp3</button>
                                    
<button title="Hiển thị danh sách Play List" type="button" id="play_list" name="play_list" onclick="loadPlayList()" class="btn btn-warning">Play List</button>

                                        <a class="btn btn-danger" href="<?php echo $PHP_SELF; ?>" role="button" title="Làm mới lại trang">Làm Mới</a> 
										
                                   </center>
                                </div></form>
								
<div id="UpLoadFileMp3" hidden>				
<form method="post" id="uploadmp3local" action="<?php echo $_SERVER['PHP_SELF']; ?>"  enctype="multipart/form-data">				
<div class="input-group" >

  <div class="custom-file">
	<input type="file" class="form-control" name="mp3Files[]" id="mp3File" max="<?php echo $maxFilesUploadMp3; ?>" multiple accept=".mp3" required>
	<input type="hidden" name="action" value="UploadMp3">
  </div>
  <div class="input-group-append">
    <button class="btn btn-primary" type="submit" title="Tải lên file mp3">Tải Lên</button>
  </div> 
</div> </form><font color=blue>Chọn tối đa: 20 File, Max 300MB/1 File</font>
</div>
                            </td>

                        </tr>
 <tr>
<th colspan="4" scope="col"></th></tr>
            <tr>
			
                <td colspan="4"><center>
<div id="code-section">
 <div id="infomusicplayer"> </div>
<b><p id="media1-name"></p></b>
    <span id="selected-time"></span>
    <input type="range" id="time-slider" min="1" max=""> 
	<span id="media1-duration"></span>
    <p id="player-state">Trạng thái: Đang đồng bộ...</p>
</div>
<center>
                        <div id="messagee"></div>
                    </center>
				
                    </center>
                </td>

            </tr>
		
  <tr>
    <td rowspan="2" colspan="3"><center>
	
			<!--			<div>
  <i id="volumeIcon" class="bi bi-volume-up"></i>
  <input type="range" id="volume" name="volume" step="1" min="0" max="100" value="">
  <span id="currentVolume">...</span>%
</div><br/> -->
	
	
                        <p>
                        <button type="button" id="playButton" title="Phát nhạc" class="btn btn-success"><i class="bi bi-play-circle"></i>
                        </button>
                        <button type="button" id="pauseButton" title="Tạm dừng phát nhạc" class="btn btn-warning"><i class="bi bi-pause-circle"></i>
                        </button>
                        <button type="button" id="stopButton" title="Dừng phát nhạc" class="btn btn-danger"><i class="bi bi-stop-circle"></i>
                        </button></p>
						<!--<p>
						<button type="button" id="volumeDown" title="Giảm âm lượng" class="btn btn-info"><i class="bi bi-volume-down"></i>
                        </button>
                        <button type="button" id="volumeUp" title="Tăng âm lượng" class="btn btn-info"><i class="bi bi-volume-up"></i>
                        </button></p> -->
					
                    </center>
					</td>
						
   
  </tr>
  <tr>
 <td><center><label for="run-checkbox" class="btn btn-warning" title="Bạn có thể cấu hình mặc định trong tab Skill->Media Player">
 <input title="Bạn có thể cấu hình mặc định trong tab Skill->Media Player" type="checkbox" id="run-checkbox" <?php echo ($sync_media_player_checkbox) ? 'checked' : ''; ?>> Đồng bộ </label>
<i class="bi bi-info-circle-fill" onclick="togglePopupSync()" title="Nhấn Để Tìm Hiểu Thêm"></i>
</center></td>
  </tr>
<div id="popupContainer" class="popup-container" onclick="hidePopupSync()">
    <div id="popupContent" onclick="preventEventPropagationSync(event)">
        <p><b><center>Đồng bộ Trạng Thái Media Player của Loa với Web UI</center></b></p>
		- <b>Tự Động Sync: </b> Truy cập <b>Tab Skill</b> -> <b>Media Player</b> -> <b>Đồng Bộ (Sync)</b> -> tích chọn <b>Đồng Bộ Media Với Web UI</b> -> <b>Lưu cấu hình</b><br/>
		- <b>Thủ Công:</b> Bạn có thể nhấn tích vào nút <b>Đồng Bộ</b> để Sync thủ công ngay tại tab <b>Media player</b><br/><br/>
		<i>Lưu Ý: Có thể ảnh hưởng đến tốc độ của Bot có phần cứng yêu nếu bật <b>Cài Đặt Tự Động Sync</b></i><br/>
        <center><button class="btn btn-info" type="button" onclick="hidePopupSync()">Đóng</button></center>
    </div>
</div>


            </tbody>
            </table>
        </div>
        <div class="col-sm-6">


            <div class="custom-div">
			<div id="messagee2">
			<?php
			
			
	if (isset($Data_CFG_ACTION['cache_search'][0])) {
		
	$source = $Data_CFG_ACTION['cache_search'][0]['source'];
    if ($source == "Podcast") {
        $Cache_source_replace = "Loại Nội Dung";
    } elseif ($source == "ZingMp3") {
        $Cache_source_replace = "Nghệ Sĩ";
    } elseif ($source == "Youtube") {
        $Cache_source_replace = "Tên Kênh";
    } else {
        $Cache_source_replace = "N/A"; // Nếu giá trị không khớp với các điều kiện trên
    }
	echo "<br/>Nội dung tìm kiếm trước đó, nguồn: <font color=red><b> {$Data_CFG_ACTION['cache_search'][0]['source']}</b></font><br/><form method='POST' action=''><button title='Xóa lịch sử tìm kiếm' type='submit' name='cache_delete' class='btn btn-warning'>Xóa Lịch Sử Tìm Kiếm</button></form><hr/>";
    foreach ($Data_CFG_ACTION['cache_search'] as $Cache_Search) {
        $Cache_title = $Cache_Search['title'];
        $Cache_images = $Cache_Search['images'];
        $Cache_channel_artist_content = $Cache_Search['channel_artist_content'];
        $Cache_link = $Cache_Search['link'];
        $Cache_time = $Cache_Search['time'];
        $Cache_source = $Cache_Search['source'];
        // In ra option cho select
            echo " <div class='image-container'>";
            echo "<img src='$Cache_images' class='imagesize' alt='' /> <div class='caption'>";
            echo '<b>Tên bài hát:</b><a href="'.$Cache_link.'" target="_bank" style="color: black;" title="Mở trong tab mới"> '.$Cache_title.'</a><br/><b>'.$Cache_source_replace.': </b> '.$Cache_channel_artist_content.'<br/>';
            echo "<b>Thời Lượng:</b> $Cache_time<br/>";
			echo '<button class="ajax-button btn btn-success" data-song-data_type="2" data-song-data_play_music="play_direct_link" data-song-tenkenhnghesi="Tên Kênh" data-song-player_type="system" data-song-artist="'.$Cache_channel_artist_content.'" data-song-images="'.$Cache_images.'" data-song-name="'.$Cache_title.'" data-song-kichthuoc=" N/A" data-song-thoiluong=" N/A" data-song-id="'.$Cache_link.'" >Phát Nhạc</button>';
            echo "</div></div><br/>";
		
    }
} else {
    echo "<br/>Không có nội dung tìm kiếm trước đó.<hr/>";
}

			?>
			
			</div>
<?php
$api_Search_Zing = "http://ac.mp3.zing.vn/complete?type=song&num=20&query=";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'UploadMp3') {
    $targetDirectory = $DuognDanThuMucJson.'/mp3/';
	$uploadedFilesSelect_name = array();
	$successCountUploadFile = 0; 
	//giới hạn file tải lên
	if (count($_FILES["mp3Files"]["name"]) > $maxFilesUploadMp3) {
        echo "<script>";
        echo "var messageElement = document.getElementById('messagee');";
        echo "messageElement.innerHTML = '<font color=red>Chỉ được phép tải lên tối đa $maxFilesUploadMp3 tệp tin</font>';";
        echo "</script>";
    } else {
    // Lặp qua mỗi file đã tải lên
    foreach ($_FILES["mp3Files"]["name"] as $key => $name) {
        $name_file_mp3 = basename($name);
		// Đổi tên file từ chữ in hoa thành chữ thường
		$name_file_mp3 = strtolower($name_file_mp3);
        $targetFile = $targetDirectory . $name_file_mp3;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Kiểm tra định dạng file
        if ($fileType !== "mp3") {
            echo "<script>";
            echo "var messageElement = document.getElementById('messagee');";
            echo "messageElement.innerHTML = '<font color=red>Chỉ chấp nhận file có đuôi .mp3</font>';";
            echo "</script>";
            $uploadOk = 0;
        }

        // Kiểm tra xem file đã tồn tại chưa
        if (file_exists($targetFile)) {
            echo "<script>";
            echo "var messageElement = document.getElementById('messagee');";
            echo "messageElement.innerHTML = '<font color=red>File<b> $name_file_mp3 </b>đã tồn tại</font>';";
            echo "</script>";
            $uploadOk = 0;
        }

        // Kiểm tra kích thước file (giả sử giới hạn là 300MB)
        if ($_FILES["mp3Files"]["size"][$key] > $Upload_Max_Size * 1024 * 1024) {
            echo "<script>";
            echo "var messageElement = document.getElementById('messagee');";
            echo "messageElement.innerHTML = '<font color=red>File quá lớn, vui lòng chọn file dưới 300MB</font>';";
            echo "</script>";
            $uploadOk = 0;
        }

        // Kiểm tra trạng thái upload
        if ($uploadOk == 0) {
            echo "<script>";
            echo "var messageElement = document.getElementById('messagee');";
            echo "messageElement.innerHTML = '<font color=red>Không thể upload file, hoặc file đã tồn tại</font>';";
            echo "</script>";
			//return; // Dừng lại nếu không thành công
        } else {
            // Nếu mọi điều kiện ok, thực hiện upload
            if (move_uploaded_file($_FILES["mp3Files"]["tmp_name"][$key], $targetFile)) {
                chmod($targetFile, 0777);
				//liệt kê tên file vào bộ nhớ tạm
				$uploadedFilesSelect_name[] = $name_file_mp3;
				//đếm file tải lên ok
				$successCountUploadFile++;
            } else {
                echo "<script>";
                echo "var messageElement = document.getElementById('messagee');";
                echo "messageElement.innerHTML = '<font color=red>Có lỗi xảy ra khi tải lên file: <b>$name_file_mp3</b></font>';";
                echo "</script>";
            }
        }
    }
	        // Hiển thị các file được tải lên thành công
        if ($successCountUploadFile > 0) {
            echo "<script>";
            echo "var successElement = document.getElementById('messagee');";
            echo "successElement.innerHTML = '<font color=green>" .$successCountUploadFile. " File được tải lên thành công: <br/><b> " . implode("<hr/>", $uploadedFilesSelect_name) . "<b></font>';";
            echo "</script>";
        }
}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Local') {
	
	$NguonNhac = $_POST['action'];
	// Cập nhật giá trị mới
    $Data_CFG_ACTION['music_source'] = $NguonNhac;
    // Ghi lại nội dung tệp JSON
    $Data_CFG_ACTION_new_music_source = json_encode($Data_CFG_ACTION, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($cfg_action_json, $Data_CFG_ACTION_new_music_source);
	
    $directory = $DuognDanThuMucJson.'/mp3';
    $pattern = '*.mp3';
    $mp3Files = glob($directory . DIRECTORY_SEPARATOR . $pattern);
    $fileCount = count($mp3Files);

    if ($fileCount > 0) {
        echo "<center>Danh sách file MP3:</center><br/>";

        foreach ($mp3Files as $mp3File) {
           $getID3 = new getID3();
$fileInfo = $getID3->analyze($mp3File);

$duration = isset($fileInfo['playtime_seconds']) ? round($fileInfo['playtime_seconds']) : 'N/A';

            $fileSizeMB = round(filesize($mp3File) / (1024 * 1024), 2);

            echo " <div class='image-container'>";
            echo "<img src='../assets/img/NotNhac.png' class='imagesize' alt='' /> <div class='caption'>";
            echo '<b>Tên bài hát:</b> ' . basename($mp3File) . '<br/>';
           // echo '<b>Thời lượng:</b> ' . formatTimephp($duration) . '<br/>';
            echo '<b>Kích thước:</b> ' . $fileSizeMB . ' MB<br/>';
            echo '<button class="ajax-button btn btn-success" data-song-tenkenhnghesi="Nghệ Sĩ" data-song-data_type="2" data-song-data_play_music="play_direct_link" data-song-kichthuoc="' . $fileSizeMB . ' MB" data-song-thoiluong="' . formatTimephp($duration) . '" data-song-artist=" N/A" data-song-images="../assets/img/NotNhac.png" data-song-name="' . basename($mp3File) . '" data-song-player_type="system" data-song-id="mp3/' . basename($mp3File) . '">Phát Nhạc</button>';
			echo '<button class="deleteBtn btn btn-danger" data-file="' . basename($mp3File) . '">Xóa File</button>';
            echo '<br/><button title="Thêm Vào Play List" type="button" id="add_play_list" name="add_play_list" onclick="addplaylist(this)" class="btn btn-info" data-title="'.basename($mp3File).'" data-images="../assets/img/NotNhac.png" data-channel_artist_content="'.$fileSizeMB.' MB" data-link="mp3/' . basename($mp3File) . '" data-time="'.formatTimephp($duration).'" data-source="Local">Thêm vào Play List</button>';
			
            echo "</div></div><br/>";
        }

        echo "<script>";
        echo "var messageElementtt = document.getElementById('messagee2');";
        echo "messageElementtt.innerHTML = '<font color=green>Tổng số file MP3: <b>".$fileCount."</b> file</font>';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "var messageElement = document.getElementById('messagee');";
        echo "messageElement.innerHTML = '<font color=red><b>Không tìm thấy file MP3 nào trong thư mục</b></font>';";
        echo "</script>";
    }
}




if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Youtube') {
    $Data_TenBaiHat = $_POST['tenbaihat'];
    $NguonNhac = $_POST['action'];
	// Cập nhật giá trị mới
    $Data_CFG_ACTION['music_source'] = $NguonNhac;
    // Ghi lại nội dung tệp JSON
    $Data_CFG_ACTION_new_music_source = json_encode($Data_CFG_ACTION, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($cfg_action_json, $Data_CFG_ACTION_new_music_source);
	
	
    if (empty($Data_TenBaiHat)) {
		
		echo "<script>";
        echo "var messageElementtt = document.getElementById('messagee2');";
        echo "messageElementtt.innerHTML = '<br/><b><font color=red>Hãy nhập tên bài hát, nội dung cần tìm kiếm trên Youtube</font></b><hr/>';";
        echo "</script>";
        //echo "<b><font color=red>Hãy nhập tên bài hát, nội dung cần tìm kiếm trên Youtube</font></b>";
    } else {

    
	
    $searchUrlYoutube = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=" . urlencode($Data_TenBaiHat) . "&maxResults=20&key=" . base64_decode($apiKeyYoutube);

/*
if (strpos($Data_TenBaiHat, 'http') !== false) {
    // Biến chứa "http", hiển thị thông báo và ngừng thực thi
  //  echo "Biến không được chứa 'http'";
  echo '<script>document.getElementById("messagee").innerHTML = "<font color=red><b>‼️ Nội dung tìm kiếm không được phép có \'http\'</b></font>";</script>';
    die();
}
*/

$curlYoutube = curl_init();
curl_setopt_array($curlYoutube, array(
  CURLOPT_URL => $searchUrlYoutube,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$responseYoutube = curl_exec($curlYoutube);

curl_close($curlYoutube);
//echo $responseYoutube;

if ($responseYoutube === false) {
//    echo json_encode(['error' => 'Yêu cầu cURL không thành công.']);
	
		echo "<script>";
		echo "var messageElement = document.getElementById('messagee');";
		echo "messageElement.innerHTML = '<font color=red><b>Yêu cầu cURL tìm kiếm youtube không thành công.</b></font>';";
		echo "</script>";
	
} else {
    $dataYoutube = json_decode($responseYoutube, true);

    // Kiểm tra xem có dữ liệu hay không
    if (empty($dataYoutube) || empty($dataYoutube['items'])) {
		//echo "$responseYoutube";
		//echo "Không có dữ liệu: ".$dataYoutube['error']['message'];
		
		echo "<script>";
		echo "var messageElement = document.getElementById('messagee');";
		echo "messageElement.innerHTML = '<font color=red><b>Không có dữ liệu trả về: " .$dataYoutube['error']['message']."</b></font>';";
		echo "</script>";
		
        
    } else {
        echo "<br/><hr/>Tên Bài Hát Đang Tìm Kiếm: <b><font color=red>" . $_POST['tenbaihat'] . "</font></b> | Nguồn Nhạc: <font color=red><b>" . $NguonNhac . "</b></font><br/><br/>";
	// Xóa tất cả dữ liệu trong cache_search hiện tại
    $Data_CFG_ACTION['cache_search'] = [];
	
        foreach ($dataYoutube['items'] as $itemYoutube) {
            $Youtube_title = $itemYoutube['snippet']['title'];
            $Youtube_description = $itemYoutube['snippet']['description'];
            $Youtube_channelTitle = $itemYoutube['snippet']['channelTitle'];
            $Youtube_videoId = $itemYoutube['id']['videoId'];
            $Youtube_images = $itemYoutube['snippet']['thumbnails']['high']['url'];
            $Youtube_videoLink = "https://www.youtube.com/watch?v=" . $Youtube_videoId;

            echo " <div class='image-container'>";
            echo "<img src='$Youtube_images' class='imagesize' alt='' /> <div class='caption'>";
            echo '<b>Tên bài hát:</b><a href="'.$Youtube_videoLink.'" target="_bank" style="color: black;" title="Mở trong Youtube"> ' . $Youtube_title . '</a><br/><b>Tên Kênh:</b> ' . $Youtube_channelTitle . '<br/>';
            //echo '<b>Mô tả:</b> ' . $Youtube_description . ' <br/>';
            //echo '<b>Link:</b> ' . $Youtube_videoLink . ' <br/>';
            echo '<button class="ajax-button btn btn-success" data-song-data_type="2" data-song-data_play_music="play_direct_link" data-song-tenkenhnghesi="Tên Kênh" data-song-player_type="system" data-song-artist="' . $Youtube_channelTitle . '" data-song-images="' .$Youtube_images.'" data-song-name="'  . $Youtube_title . '" data-song-kichthuoc=" N/A" data-song-thoiluong=" N/A" data-song-id="' . $Youtube_videoLink . '" >Phát Nhạc</button>';
            echo '<br/><button title="Thêm Vào Play List" type="button" id="add_play_list" name="add_play_list" onclick="addplaylist(this)" class="btn btn-info" data-title="'.$Youtube_title.'" data-images="'.$Youtube_images.'" data-channel_artist_content="'.$Youtube_channelTitle.'" data-link="'.$Youtube_videoLink.'" data-time="N/A" data-source="Youtube">Thêm vào Play List</button>';
			
			echo "</div></div><br/>";
			
			$Data_CFG_ACTION['cache_search'][] = [
            "title" => $Youtube_title,
            "images" => $Youtube_images,
            "channel_artist_content" => $Youtube_channelTitle,
            "link" => $Youtube_videoLink,
            "time" => "N/A",
            "source" => "Youtube"
        ];
			
        }
		    file_put_contents($cfg_action_json, json_encode($Data_CFG_ACTION, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
			
        echo "<script>";
        echo "var messageElementtt = document.getElementById('messagee2');";
        echo "messageElementtt.innerHTML = '';";
        echo "</script>";
			
    }

}
}
}


//Lấy Token PodCast
// Hàm kiểm tra xem token đã hết hạn chưa
function isTokenExpired($tokenData) {
    // Lấy thời gian hết hạn từ dữ liệu token
    $expire_time = $tokenData['expire_time'];
    // Lấy thời gian hiện tại
    $current_time = time();
    // So sánh với thời gian hiện tại
    return $current_time > $expire_time;
}
// Hàm lấy lại token từ API
function refreshToken() {
    //echo "Đang lấy lại token...\n";
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => base64_decode("aHR0cHM6Ly91c2Vycy5pdmlldC5jb20vdjEvYXV0aC9sb2dpbg=="),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{"email":"'.base64_decode("dmlldGJvdHNtYXJ0c3BlYWtlckBnbWFpbC5jb20=").'","password":"'.base64_decode("VmlldGJvdEAx").'"}',
      CURLOPT_HTTPHEADER => array(
        'Host: '.base64_decode("dXNlcnMuaXZpZXQuY29t"),
        'pragma: no-cache',
        'cache-control: no-cache',
        'sec-ch-ua: "Not A(Brand";v="99", "Google Chrome";v="121", "Chromium";v="121"',
        'accept: application/json, text/plain, */*',
        'content-type: application/json',
        'dnt: 1',
        'sec-ch-ua-mobile: ?0',
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
        'sec-ch-ua-platform: "Windows"',
        'origin: '.base64_decode("aHR0cHM6Ly9hcHAubWFpa2EuYWk="),
        'sec-fetch-site: cross-site',
        'sec-fetch-mode: cors',
        'sec-fetch-dest: empty',
        'referer: '.base64_decode("aHR0cHM6Ly9hcHAubWFpa2EuYWkv"),
        'accept-language: vi'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    // Trả về phản hồi từ API
    return $response;
}
//END Kiểm tra và lấy token
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'PodCast') {
	
$file_path = "$DuognDanUI_HTML/Multimedia/PodCast_Bear.json";
// Kiểm tra xem tệp tồn tại hay không
if (!file_exists($file_path)) {
    // Tạo tệp mới nếu chưa tồn tại
    $file = fopen($file_path, 'w');
    fclose($file);
    chmod($file_path, 0777);
    //echo "Tệp PodCast_Bear.json đã được tạo và quyền truy cập đã được thay đổi thành 777.";
}
	
    $Data_TenBaiHat = $_POST['tenbaihat'];
	$NguonNhac = $_POST['action'];
	// Cập nhật giá trị mới
    $Data_CFG_ACTION['music_source'] = $NguonNhac;
    // Ghi lại nội dung tệp JSON
    $Data_CFG_ACTION_new_music_source = json_encode($Data_CFG_ACTION, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($cfg_action_json, $Data_CFG_ACTION_new_music_source);
	
	if (empty($Data_TenBaiHat)) {
		echo "<script>";
        echo "var messageElementtt = document.getElementById('messagee2');";
        echo "messageElementtt.innerHTML = '<br/><b><font color=red>Hãy nhập tên bài hát, nội dung cần tìm kiếm PodCast</font></b><hr/>';";
        echo "</script>";
		
    //echo "<b><font color=red>Hãy nhập tên bài hát, nội dung cần tìm kiếm PodCast</font></b>";
} else {
	
// Đọc dữ liệu token từ file
$tokenData = json_decode(file_get_contents('PodCast_Bear.json'), true);
// Kiểm tra xem token đã hết hạn chưa
if (isTokenExpired($tokenData)) {
    // Nếu đã hết hạn, lấy lại token từ API
    $newTokenData = refreshToken();
    // Cập nhật lại dữ liệu token và thời gian hết hạn mới
    $tokenData = json_decode($newTokenData, true);
    // Lấy thời gian hiện tại
    $current_time = time();
    // Lấy thời gian hết hạn mới là 6 tiếng sau thời điểm hiện tại
    $tokenData['expire_time'] = $current_time + $tokenData['data']['expire_time'] - 6 * 3600;
    // Lưu dữ liệu token vào file
    file_put_contents('PodCast_Bear.json', json_encode($tokenData));
    //echo "Token đã được cập nhật và lưu vào file.\n";
} 
//else {
    //echo "Token hiện tại vẫn còn hiệu lực.\n";
//}
// Bây giờ bạn có thể sử dụng $tokenData['data']['access_token'] để gửi các yêu cầu API khác
$access_token = $tokenData['data']['access_token'];
//Tìm kiếm	
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => base64_decode("aHR0cHM6Ly9jb3JlLm9jcy5pdmlldC5jb20vdjEvZ3JhcGhxbA=="),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"operationName":"Search","query":"query Search($keyword: String!, $category: [String]!, $offset: Int!, $limit: Int!) {\\n  search(\\n    q: $keyword\\n    offset: $offset\\n    limit: $limit\\n    filter: {media: {types: $category}}\\n  ) {\\n    __typename\\n    episode {\\n      __typename\\n      audio\\n      duration\\n      id\\n      is_gcs\\n      published_at\\n      title\\n      media {\\n        __typename\\n        audio\\n        cover\\n        created_at\\n        id\\n        slug\\n        title\\n        total_episode\\n        content_type {\\n          __typename\\n          description\\n          value\\n        }\\n      }\\n      authors\\n      description\\n    }\\n    media {\\n      __typename\\n      cover\\n      created_at\\n      is_list\\n      slug\\n      title\\n      total_episode\\n      type\\n      id\\n      content_type {\\n        __typename\\n        description\\n        value\\n      }\\n    }\\n  }\\n}","variables":{"category":[],"keyword":"'.$Data_TenBaiHat.'","limit":25,"offset":0}}',
  CURLOPT_HTTPHEADER => array(
    'Host: '.base64_decode("Y29yZS5vY3MuaXZpZXQuY29t"),
    'content-type: application/json',
    'accept: */*',
    'apollographql-client-version: 3.1.6-347',
    'authorization: Bearer '.$access_token,
    'source: ios',
    'device-type: ios',
    'accept-language: vi-VN,vi;q=0.9',
    'x-apollo-operation-type: query',
    'user-agent: '.base64_decode("TUFJS0EvMzQ3IENGTmV0d29yay8xMzM1LjAuMyBEYXJ3aW4vMjEuNi4w"),
    'apollographql-client-name: '.base64_decode("Y29tLm9sbGkub21uaS1hcG9sbG8taW9z"),
    'x-apollo-operation-name: Search'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

echo "<br/>Nội Dung Đang Tìm Kiếm: <b><font color=red>" . $_POST['tenbaihat'] . "</font></b> | Nguồn: <font color=red><b>" . $NguonNhac . "</b></font><hr/>";

	// Xóa tất cả dữ liệu trong cache_search hiện tại
    $Data_CFG_ACTION['cache_search'] = [];
$data = json_decode($response, true);

if(isset($data['data']['search']) && is_array($data['data']['search'])) {

    foreach($data['data']['search'] as $item) {
        if(isset($item['episode'])) {
            $title = $item['episode']['title'];
            $duration = $item['episode']['duration'];
            $cover = isset($item['episode']['media']['cover']) ? $item['episode']['media']['cover'] : null;
            $description = isset($item['episode']['media']['content_type']['description']) ? $item['episode']['media']['content_type']['description'] : null;
            $audio_PodCast = $item['episode']['audio'];
                    // Kiểm tra nếu URL không bắt đầu bằng "http" thì thêm "https://"
                    if(strpos($audio_PodCast, 'http') !== 0) {
                        $audio_PodCast = 'https://cdn-ocs.iviet.com/' . $audio_PodCast;
                    }
			$img_images = "https://cdn-ocs.iviet.com/".$cover;
			//$audio_PodCast = "https://cdn-ocs.iviet.com/".$item['episode']['audio'];
			    echo " <div class='image-container'>";
                echo "<img src='$img_images' class='imagesize' alt='' /> <div class='caption'>";
                echo '<b>Tên: </b> ' . $title . '<br/><b>Loại nội dung: </b> ' . $description . '<br/>';
                echo '<b>Thời lượng: </b>' . $duration . ' <br/>';
                echo '<button class="ajax-button btn btn-success" data-song-tenkenhnghesi="Nghệ Sĩ" data-song-kichthuoc="N/A" data-song-thoiluong="N/A" data-song-player_type="system" data-song-data_type="2" data-song-data_play_music="play_direct_link" data-song-artist="" data-song-name="' . $title . '" data-song-images="' . $img_images . '" data-song-id="' . $audio_PodCast . '">Phát PodCast</button>';
                echo '<br/><button title="Thêm Vào Play List" type="button" id="add_play_list" name="add_play_list" onclick="addplaylist(this)" class="btn btn-info" data-title="'.$title.'" data-images="'.$img_images.'" data-channel_artist_content="'.$description.'" data-link="'.$audio_PodCast.'" data-time="'.$duration.'" data-source="Podcast">Thêm vào Play List</button>';
				echo "</div></div><br/>";
				
			$Data_CFG_ACTION['cache_search'][] = [
            "title" => $title,
            "images" => $img_images,
            "channel_artist_content" => $description,
            "link" => $audio_PodCast,
            "time" => $duration,
            "source" => "Podcast"
        ];
				
        }
    }
	file_put_contents($cfg_action_json, json_encode($Data_CFG_ACTION, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	    echo "<script>";
        echo "var messageElementtt = document.getElementById('messagee2');";
        echo "messageElementtt.innerHTML = '';";
        echo "</script>";
}
}
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'ZingMp3') {
    $Data_TenBaiHat = urlencode($_POST['tenbaihat']);
	$NguonNhac = $_POST['action'];
	// Cập nhật giá trị mới
    $Data_CFG_ACTION['music_source'] = $NguonNhac;
    // Ghi lại nội dung tệp JSON
    $Data_CFG_ACTION_new_music_source = json_encode($Data_CFG_ACTION, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($cfg_action_json, $Data_CFG_ACTION_new_music_source);
	
	if (empty($Data_TenBaiHat)) {
		
		echo "<script>";
        echo "var messageElementtt = document.getElementById('messagee2');";
        echo "messageElementtt.innerHTML = '<br/><b><font color=red>Hãy nhập tên bài hát, nội dung cần tìm kiếm trên Zing MP3</font></b><hr/>';";
        echo "</script>";
		
		
    //echo "<b><font color=red>Hãy nhập tên bài hát, nội dung cần tìm kiếm trên Zing MP3</font></b>";
} else {
    // Thực hiện các hành động khác nếu $Data_TenBaiHat có giá trị
	/*
	if (strpos($Data_TenBaiHat, 'http') !== false) {
    // Biến chứa "http", hiển thị thông báo và ngừng thực thi
    echo '<script>document.getElementById("messagee").innerHTML = "<font color=red><b>‼️ Nội dung tìm kiếm không được phép có \'http\'</b></font>";</script>';
  
    die();
}
*/
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $api_Search_Zing . $Data_TenBaiHat,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    curl_close($curl);
//echo $response;
if ($response === false) {
  //  echo json_encode(['error' => 'Yêu cầu cURL không thành công.']);
		echo "<script>";
		echo "var messageElement = document.getElementById('messagee');";
		echo "messageElement.innerHTML = '<font color=red><b>Yêu cầu cURL tìm kiếm ZingMp3 không thành công.</b></font>';";
		echo "</script>";
} else {
    $data = json_decode($response, true);
    // Kiểm tra xem có dữ liệu hay không
    if (empty($data)) {
        //echo "Không có dữ liệu trên ZingMp3.";
		echo "<script>";
		echo "var messageElement = document.getElementById('messagee');";
		echo "messageElement.innerHTML = '<font color=red><b>Không có dữ liệu trả về trên ZingMp3.</b></font>';";
		echo "</script>";
    } else {
		
	// Xóa tất cả dữ liệu trong cache_search hiện tại
    $Data_CFG_ACTION['cache_search'] = [];
        echo "<br/><hr/>Tên Bài Hát Đang Tìm Kiếm: <b><font color=red>" . $_POST['tenbaihat'] . "</font></b><br/>Nguồn Nhạc: <font color=red><b>" . $NguonNhac . "</b></font><br/><br/>";
        if ($data['result'] === true && isset($data['data'][0]['song'])) {
            foreach ($data['data'][0]['song'] as $song) {
                $ID_MP3 = $song['id'];
                $originalUrl = "http://api.mp3.zing.vn/api/streaming/audio/$ID_MP3/128";
                $img_images = "https://photo-zmp3.zmdcdn.me/" . $song['thumb'];
                echo " <div class='image-container'>";
                echo "<img src='$img_images' class='imagesize' alt='' /> <div class='caption'>";
                echo '<b>Tên bài hát:</b> ' . $song['name'] . '<br/><b>Nghệ sĩ:</b> ' . $song['artist'] . '<br/>';
                //echo 'ID bài hát: ' . $song['id'] . ' <br/>';
                echo '<button class="ajax-button btn btn-success" data-song-tenkenhnghesi="Nghệ Sĩ" data-song-kichthuoc="N/A" data-song-thoiluong="N/A" data-song-player_type="system" data-song-data_type="2" data-song-data_play_music="play_direct_link" data-song-artist="' . $song['artist'] . '" data-song-name="' . $song['name'] . '" data-song-images="' . $img_images . '" data-song-id="' . $originalUrl . '">Phát Nhạc</button>';
                echo '<br/><button title="Thêm Vào Play List" type="button" id="add_play_list" name="add_play_list" onclick="addplaylist(this)" class="btn btn-info" data-title="'.$song['name'].'" data-images="'.$img_images.'" data-channel_artist_content="'.$song['artist'].'" data-link="'.$originalUrl.'" data-time="N/A" data-source="ZingMp3">Thêm vào Play List</button>';
			   //echo "Original URL: $originalUrl<br>";
                // echo "MP3 128 URL: $finalUrl<br/><br/>";
                echo "</div></div><br/>";
			$Data_CFG_ACTION['cache_search'][] = [
            "title" => $song['name'],
            "images" => $img_images,
            "channel_artist_content" => $song['artist'],
            "link" => $originalUrl,
            "time" => "N/A",
            "source" => "ZingMp3"
			];
				
            }
			file_put_contents($cfg_action_json, json_encode($Data_CFG_ACTION, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
		echo "<script>";
        echo "var messageElementtt = document.getElementById('messagee2');";
        echo "messageElementtt.innerHTML = '';";
        echo "</script>";
        } else {
            echo "Không có dữ liệu với từ khóa đang tìm kiếm trên ZingMp3";
        }
    }
}
    //exit; // Dừng xử lý ngay sau khi gửi dữ liệu JSON về trình duyệt
}
}
?>
      </div>
	</div>
  </div>
</div>
<!-- Đoạn mã JavaScript của bạn -->
<script>
    function truncateFileName(fileName, maxLength) {
        if (fileName.length <= maxLength) {
            return fileName;
        }

        // Tìm vị trí khoảng trắng gần giới hạn maxLength
        const lastSpaceIndex = fileName.lastIndexOf(' ', maxLength);

        // Nếu không có khoảng trắng, cắt tên file
        if (lastSpaceIndex === -1) {
            return fileName.substring(0, maxLength) + '...';
        }

        // Ngắt tên file tại khoảng trắng gần giới hạn maxLength
        return fileName.substring(0, lastSpaceIndex) + '...';
    }

    $(document).ready(function() {
		
        // Xử lý sự kiện khi nút Ajax được nhấn
        //$('.ajax-button').on('click', function() {
			$(document).on('click', '.ajax-button', function() {
            $('#loading-overlay').show();
            var messageElement = document.getElementById("messagee");
            var songId = $(this).data('song-id');
            var player_type = $(this).data('song-player_type');
            var data_play_music = $(this).data('song-data_play_music');
            var data_type = $(this).data('song-data_type');
            var songImages = $(this).data('song-images');
            var songTenKenhNgheSi = $(this).data('song-tenkenhnghesi');
            var songKichThuoc = $(this).data('song-kichthuoc');
            var songThoiLuong = $(this).data('song-thoiluong');
            var songArtist = $(this).data('song-artist');
            var songName = $(this).data('song-name');
            var startTime = new Date(); // Lấy thời gian bắt đầu yêu cầu
            var getTimee = formatTime(startTime.getHours()) + ':' + formatTime(startTime.getMinutes()) + ':' + formatTime(startTime.getSeconds());

            messageElement.innerHTML = '<font color=red>Đang Chuyển Đổi Dữ Liệu...</font>';
            if (!songId) {
                //alert('Không có dữ liệu cho songId');
                messageElement.innerHTML = '<font color=red>Không Có Dữ Liệu Đầu Vào!</font>';
				$('#loading-overlay').hide();
				return; // Dừng thực thi nếu không có dữ liệu đầu vào
				
            }
            //console.log('song id:', songId);
            $.ajax({
                url: '../include_php/Ajax/Get_Final_Url_ZingMp3.php?url=' + encodeURIComponent(songId),
                method: 'GET',
                dataType: 'json',
                success: function(response) {

                    if (response.finalUrl) {

                        var finalUrl = response.finalUrl;
                        //console.log('Final URL:', finalUrl);
                        // Phần còn lại của đoạn mã xử lý Ajax
                        var settings = {
                            "url": "http://<?php echo $serverIP; ?>:<?php echo $Port_Vietbot; ?>",
                            "method": "POST",
                            "timeout": <?php echo $Time_Out_MediaPlayer_API; ?> ,
                            "headers": {
                                "Content-Type": "application/json"
                            },
                            "data": JSON.stringify({
                                "type": data_type,
                                "data": data_play_music,
                                "player_type": player_type,
                                "direct_link": finalUrl
                            }),
                        };
                        messageElement.innerHTML = '<font color=red>Thực Thi Dữ Liệu Đã Chuyển Đổi...</font>';
                        // Gửi yêu cầu Ajax
                        $.ajax(settings)
                            .done(function(response) {
                                //nếu kết quả trả về thành công thì Gửi thông tin tên bài hát và cover tới vietbot	
                                if (response.state === "Success") {

                                    var settings_cover_name = {
                                        "url": "http://<?php echo $serverIP; ?>:<?php echo $Port_Vietbot; ?>",
                                        "method": "POST",
                                        "timeout": <?php echo $Time_Out_MediaPlayer_API; ?>,
                                        "headers": {
                                            "Content-Type": "application/json"
                                        },
                                        "data": JSON.stringify({
                                            "type": 2,
                                            "data": "set_song_info",
                                            "song_title": songName,
                                            "cover_link": songImages
                                        }),
                                    };
                                    $.ajax(settings_cover_name).done(function(response_cover_name) {
                                        //console.log(response_cover_name);
                                    });
									//Tải lại trang nếu chứa url vov khi truyền dữ liệu xong
									if (songId && songId.startsWith("https://str.vov.gov.vn")) {
									location.reload();
									}
									
                                } else {
                                    //console.log("Thất Bại");
                                    alert("Phát thất bại: " + songName)

                                }
                                //var messageElement = document.getElementById("messagee");
                                var messageinfomusicplayer = document.getElementById("infomusicplayer");
                                let modifiedStringSuccess = response.state.replace("Success", "Thành Công");
                                var endTime = new Date(); // Lấy thời gian kết thúc yêu cầu
                                var elapsedTime = endTime - startTime; // Tính thời gian thực hiện yêu cầu

                                const maxLengthhhh = 50;
                                const truncatedFileNamesongName = truncateFileName(songName, maxLengthhhh);
                                //hiển thị thẻ div  messagee
                                messageElement.style.display = "block";
                                messageElement.innerHTML = '<div style="color: green;"><b>' + getTimee + ' - ' + modifiedStringSuccess + ' | ' + elapsedTime + 'ms</b></div>';
                                messageinfomusicplayer.innerHTML = '<div class="image-container"><div class="rounded-image"><img src=' + songImages + ' alt="" /></div><div class="caption"><ul><li><p style="text-align: left;"><b>Tên bài hát: </b> ' + truncatedFileNamesongName + '</p></li><li><p style="text-align: left;"><b>' + songTenKenhNgheSi + ': </b> ' + songArtist + '</p></li><li><p style="text-align: left;"><b>Kích thước: </b> ' + songKichThuoc + '</p></li></ul></div></div>';
                                if (messageElement) {
                                    // Sử dụng setTimeout để ẩn thẻ sau 5 giây
                                    setTimeout(function() {
                                        messageElement.style.display = "none";
                                    }, 7000); // 5000 milliseconds = 5 giây
                                }

                            })
                            .fail(function(jqXHR, textStatus, errorThrown) {
                                //var messageElement = document.getElementById("messagee");
                                var endTime = new Date(); // Lấy thời gian kết thúc yêu cầu
                                var elapsedTime = endTime - startTime; // Tính thời gian thực hiện yêu cầu
                                if (textStatus === "timeout") {
                                    messageElement.innerHTML = '<div style="color: red;"><b>' + getTimee + ' - Lỗi: Yêu cầu đã vượt quá thời gian chờ. | ' + elapsedTime + 'ms</b></div>';

                                } else {
                                    messageElement.innerHTML = '<div style="color: red;"><b>' + getTimee + ' - Lỗi: Không thể kết nối đến API. | ' + elapsedTime + 'ms</b></div>';
                                }
                            });
                    } else {
                        //console.error('Lỗi:', response.error || 'Không xác định');
                        messageElement.innerHTML = '<div style="color: red;"><b>' + getTimee + ' - Lỗi: ' + response.error + ' Không xác định || ' + elapsedTime + 'ms</b></div>';
                    }
                    $('#loading-overlay').hide();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#loading-overlay').hide();
                    //console.error('Lỗi AJAX:', textStatus, errorThrown);
                    messageElement.innerHTML = '<div style="color: red;"><b>' + getTimee + ' - Lỗi AJAX: ' + textStatus + ' || ' + errorThrown + ' || ' + elapsedTime + 'ms</b></div>';
                }

            });


        });
    });



    //đổi thời gian nếu có 1 số thì thêm số 0 phía trước
    function formatTime(time) {
        return (time < 10) ? '0' + time : time;
    }


    //icon Loading
    $(document).ready(function() {
        $('#uploadmp3local').on('submit', function() {
            // Hiển thị biểu tượng loading
            $('#loading-overlay').show();
            // Vô hiệu hóa nút gửi
            $('#submit-btn').attr('disabled', true);
        });
    });
</script>
<script>
    function setupAudioControls() {

        var messageElement = document.getElementById("messagee");
        $('#playButton').on('click', function() {
            sendAudioControlCommand('continue', 'set_sys_player', 2, 'POST');
        });

        $('#pauseButton').on('click', function() {
            sendAudioControlCommand('pause', 'set_sys_player', 2, 'POST');
        });

        $('#stopButton').on('click', function() {
            sendAudioControlCommand('stop', 'set_sys_player', 2, 'POST');
        });
        function sendAudioControlCommand(action, data, type, method) {
            $('#loading-overlay').show();
            var settings = {
                "url": "http://<?php echo $serverIP; ?>:<?php echo $Port_Vietbot; ?>",
                "method": method,
                "timeout": <?php echo $Time_Out_MediaPlayer_API; ?> ,
                "headers": {
                    "Content-Type": "application/json"
                },
                "data": JSON.stringify({
                    "type": type,
                    "data": data,
                    "action": action
                }),
            };

            $.ajax(settings)
                // Biến để theo dõi trạng thái của checkbox
            .done(function(responseh) {
                var isCheckboxChecked = $("#run-checkbox").is(":checked");
                // Kiểm tra nếu checkbox được tích
                if (isCheckboxChecked) {
                    var displayText = responseh.new_volume !== undefined ? 'Âm Lượng: ' + responseh.new_volume + '%' : responseh.response;
                    messageElement.innerHTML = ' ';
                    // Hiển thị thông báo khi checkbox được tích và responseh.response không phải là một trong các giá trị chỉ định
                    if (!(responseh.response === "Đã dừng!" || responseh.response === "Đã tiếp tục!" || responseh.response === "Đã tạm dừng!")) {
                        // Xử lý và hiển thị response
                        messageElement.style.display = "block";
                        messageElement.innerHTML = '<div style="color: green;"><b>' + displayText + '</b></div>';
                        $('#loading-overlay').hide();
                        // Kiểm tra xem thẻ có tồn tại không trước khi ẩn
                        if (messageElement) {
                            // Sử dụng setTimeout để ẩn thẻ sau 5 giây
                            setTimeout(function() {
                                messageElement.style.display = "none";
                            }, 7000); // 5000 milliseconds = 5 giây
                        }

                    }
                }
                //nếu checkbox đồng bộ không được tích
                else {
                    var displayText = responseh.new_volume !== undefined ? 'Âm Lượng: ' + responseh.new_volume + '%' : responseh.response;
                    messageElement.innerHTML = ' ';
                    // Hiển thị thông báo khi checkbox được tích và responseh.response không phải là một trong các giá trị chỉ định
                    if (responseh.response === "Đã dừng!" || responseh.response === "Đã tiếp tục!" || responseh.response === "Đã tạm dừng!") {
                        // Xử lý và hiển thị response
                        messageElement.style.display = "block";
                        messageElement.innerHTML = '<div style="color: green;"><b>' + displayText + '</b></div>';
                        $('#loading-overlay').hide();
                        // Kiểm tra xem thẻ có tồn tại không trước khi ẩn
                        if (messageElement) {
                            // Sử dụng setTimeout để ẩn thẻ sau 5 giây
                            setTimeout(function() {
                                messageElement.style.display = "none";
                            }, 7000); // 5000 milliseconds = 5 giây
                        }

                    }
                    $('#loading-overlay').hide();
                }
            })

            .fail(function(jqXHR, textStatus, errorThrown) {
                if (textStatus === "timeout") {
                    messageElement.innerHTML = '<div style="color: red;"><b>Lỗi: Hết thời gian chờ khi kết nối với API.</b></div>';
                    $('#loading-overlay').hide();
                } else {
                    messageElement.innerHTML = '<div style="color: red;"><b>Lỗi! Không thể kết nối tới API</b></div>';
                    $('#loading-overlay').hide();
                }
                // console.error('<div style="color: red;"><b>Error sending audio control command:</b></div>', textStatus, errorThrown);
                messageElement.innerHTML = '<div style="color: red;"><b>Lỗi khi gửi lệnh điều khiển chức năng:</b></div>' + textStatus + errorThrow;
                $('#loading-overlay').hide();
            });
        }

        function showMessage(message) {
            messageElement.innerHTML = '<div style="color: red;"><b>' + message + '</b></div>';
        }
    }
    $(document).ready(function() {
        setupAudioControls();
    });
</script>

<script>
    function myFunctionmp3local() {
            // Lắng nghe sự kiện mouseup trên nút
            $('#submitButton').on('mouseup', function(event) {
                // Lấy giá trị từ thẻ input
                var tenbaihatValue = $('#tenbaihatInput').val();
                // Kiểm tra nếu giá trị không bắt đầu bằng "http"

                var inputValueLowercase = tenbaihatValue.toLowerCase();
                var searchStringLowercase = "http";

                if (!inputValueLowercase.startsWith(searchStringLowercase)) {
                    alert("Dữ liệu đầu vào để Play .mp3 phải bắt đầu bằng 'http'");
                    event.preventDefault(); // Ngăn chặn hành động mặc định của nút
                    return; // Dừng thực thi nếu không hợp lệ
                }
                // Truyền giá trị vào thuộc tính data-song-id của thẻ button html
                $(this).data('song-id', tenbaihatValue);
                // Log giá trị để kiểm tra
                //  console.log('Tên bài hát:', tenbaihatValue);
                //  console.log('data-song-id:', $(this).data('song-id'));
            });
        }
        // Gọi hàm mới khi trang đã sẵn sàng
    $(document).ready(myFunctionmp3local);
</script>


<script>

    // chọn radio
    // điều kiện khi nhập text vào input
    function handleRadioChangeLocal() {
            // Lấy tham chiếu đến radio button và input
            var radio_Local = document.getElementById("LocalMp3");
            var PodCastMp3 = document.getElementById("PodCastMp3");
            var keyyoutube = document.getElementById("keyyoutube");
            var radio_VOV = document.getElementById("RadioVOV");
            var SelectRadioVOV = document.getElementById("SelectRadioVOV");
            var UpLoadFileMp3 = document.getElementById("UpLoadFileMp3");
            var button_Playmp3 = document.getElementById("submitButton");
            var input_tenbaihatInput = document.getElementById("tenbaihatInput");
            var keyzingmp3 = document.getElementById("keyzingmp3");
            var timkiemButton = document.getElementById("TimKiem");
            var Play_Radio = document.getElementById("Play_Radio");

            // Nếu radio được chọn, disabled input
            if (radio_Local.checked) {
                UpLoadFileMp3.hidden = false;
                input_tenbaihatInput.disabled = true;
                input_tenbaihatInput.hidden = true;
                //input_tenbaihatInput.value = "";
                button_Playmp3.disabled = true;
                button_Playmp3.hidden = true;
                timkiemButton.hidden = false;
                timkiemButton.disabled = false;
				SelectRadioVOV.hidden = true;
				Play_Radio.hidden = true;
				
            }
			else if (radio_VOV.checked) {
				UpLoadFileMp3.hidden = true;
                input_tenbaihatInput.disabled = true;
                input_tenbaihatInput.hidden = true;
				timkiemButton.hidden = true;
                timkiemButton.disabled = true;
				SelectRadioVOV.hidden = false;
				Play_Radio.hidden = false;
                    
                } 
			else if (keyzingmp3.checked) {
				SelectRadioVOV.hidden = true;
				UpLoadFileMp3.hidden = true;
                input_tenbaihatInput.disabled = false;
                input_tenbaihatInput.hidden = false;
                timkiemButton.hidden = false;
                timkiemButton.disabled = false;
				Play_Radio.hidden = true;
                } 
			else if (keyyoutube.checked) {
				SelectRadioVOV.hidden = true;
				UpLoadFileMp3.hidden = true;
                input_tenbaihatInput.disabled = false;
                input_tenbaihatInput.hidden = false;
                timkiemButton.hidden = false;
                timkiemButton.disabled = false;
				Play_Radio.hidden = true;
                }
			else if (PodCastMp3.checked) {
				SelectRadioVOV.hidden = true;
				UpLoadFileMp3.hidden = true;
                input_tenbaihatInput.disabled = false;
                input_tenbaihatInput.hidden = false;
                timkiemButton.hidden = false;
                timkiemButton.disabled = false;
				Play_Radio.hidden = true;
                } 
			else {
                UpLoadFileMp3.hidden = true;
                input_tenbaihatInput.disabled = false;
                input_tenbaihatInput.hidden = false;
                button_Playmp3.disabled = true;
                button_Playmp3.hidden = true;
                timkiemButton.hidden = false;
                timkiemButton.disabled = false;
				Play_Radio.hidden = true;
            }
        }
        //Nhập text vào input
    function handleInputHTTP() {
        var input_http = document.getElementById("tenbaihatInput");
        var timkiemButton = document.getElementById("TimKiem");
        var submitButton = document.getElementById("submitButton");
        var inputValueLowercase = input_http.value.toLowerCase();
        var searchStringLowercase = "http";
        if (inputValueLowercase.startsWith(searchStringLowercase)) {
            timkiemButton.disabled = true;
            timkiemButton.hidden = true;
            submitButton.hidden = false;
            submitButton.disabled = false;
        } else {
            timkiemButton.disabled = false;
            timkiemButton.hidden = false;
            submitButton.hidden = true;
            submitButton.disabled = true;
        }
    }
</script>
<script>
    //xóa file
    $(document).ready(function() {
        var messageElement = document.getElementById("messagee");
        // Khi nút "Xóa File" được nhấn
        $('.deleteBtn').on('click', function() {
            var fileToDelete = $(this).data('file');
            //console.log(fileToDelete)
            var url = '../include_php/Ajax/Mp3_Del.php?fileToDelete=' + fileToDelete;
            var xacNhan = confirm("Bạn có chắc chắn muốn xóa file: " + fileToDelete);
            if (xacNhan) {
                // Gửi yêu cầu AJAX
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        messageElement.innerHTML = '<div style="color: red;">' + response + '</div>';
                        //alert(response);
                    },
                    error: function() {
                        alert('Có lỗi xảy ra của ajax khi gửi yêu cầu xóa file');
                    }
                });
                // Người dùng đã nhấn nút "OK"
                // alert("Hành động đã được thực hiện!");
            } else {
                // Người dùng đã nhấn nút "Cancel" hoặc đóng hộp thoại
                // alert("Hành động đã bị hủy bỏ!");
                messageElement.innerHTML = '<div style="color: red;">Thao tác xóa file <b>' + fileToDelete + '</b> đã bị hủy bỏ</div>';

            }
        });
    });
</script>
<script>
    // Hàm thực hiện AJAX để đọc dữ liệu từ tệp JSON
    function readJsonAndCheckCheckbox() {
		
		var Play_Radio = document.getElementById("Play_Radio");
        var SelectRadioVOV = document.getElementById("SelectRadioVOV");
        var UpLoadFileMp3 = document.getElementById("UpLoadFileMp3");
        var timkiemButton = document.getElementById("TimKiem");
        var input_tenbaihatInput = document.getElementById("tenbaihatInput");
        $.ajax({
            url: 'cfg_action.json',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Đánh dấu checked cho checkbox nếu điều kiện được đáp ứng
                if (data && data.music_source === 'ZingMp3') {
                    $('#keyzingmp3').prop('checked', true);
					Play_Radio.hidden = true;
					SelectRadioVOV.hidden = true;
					UpLoadFileMp3.hidden = true;
                } else if (data && data.music_source === 'Youtube') {
                    // Thực hiện hành động khác nếu giá trị khác
                    $('#keyyoutube').prop('checked', true);
					Play_Radio.hidden = true;
					SelectRadioVOV.hidden = true;
					UpLoadFileMp3.hidden = true;
					
                } else if (data && data.music_source === 'Local') {
                    // Thực hiện hành động khác nếu giá trị khác
                    $('#LocalMp3').prop('checked', true);
					Play_Radio.hidden = true;
					SelectRadioVOV.hidden = true;
					input_tenbaihatInput.hidden = true;
					UpLoadFileMp3.hidden = false;
					
					
					
                }else if (data && data.music_source === 'PodCast') {
                    // Thực hiện hành động khác nếu giá trị khác
                    $('#PodCastMp3').prop('checked', true);
					Play_Radio.hidden = true;
					SelectRadioVOV.hidden = true;
					UpLoadFileMp3.hidden = true;
                }
				else if (data && data.music_source === 'RadioVOV') {
                    // Thực hiện hành động khác nếu giá trị khác
                    $('#RadioVOV').prop('checked', true);
					UpLoadFileMp3.hidden = true;
                }
            },
            error: function(error) {
                //Nếu lỗi json thì mặc định sẽ chọn zingmp3
                $('#keyzingmp3').prop('checked', true);
				Play_Radio.hidden = true;
				SelectRadioVOV.hidden = true;
				UpLoadFileMp3.hidden = true;
                //console.error('Failed to read JSON file cfg_action.json:', error);
            }
        });
    }

    // Gọi hàm khi trang web được tải
    $(document).ready(function() {
        readJsonAndCheckCheckbox();
    });
</script>

<script>
    function removeAllAndAddNewClass(elementId, newClass) {
            var element = document.getElementById(elementId);

            // Xóa hết tất cả các giá trị trong classList
            while (element.classList.length > 0) {
                element.classList.remove(element.classList.item(0));
            }

            // Thêm giá trị mới vào classList
            element.classList.add(newClass);
        }
        // Function to convert seconds to HH:MM:SS format
    function formatTimeajax(seconds) {
            var hours = Math.floor(seconds / 3600);
            var minutes = Math.floor((seconds % 3600) / 60);
            var remainingSeconds = seconds % 60;
            // Ensure two digits for hours, minutes, and seconds
            var formattedHours = hours < 10 ? "0" + hours : hours;
            var formattedMinutes = minutes < 10 ? "0" + minutes : minutes;
            var formattedSeconds = remainingSeconds < 10 ? "0" + remainingSeconds : remainingSeconds;

            return formattedHours + ":" + formattedMinutes + ":" + formattedSeconds;
        }
    // Function to make the API request and handle data
    function fetchData() {
        var selectedOption = $("#select-playback").find('option:selected');
        var get_playback = selectedOption.data('playback');
        var settings = {
            "url": "http://<?php echo $serverIP; ?>:<?php echo $Port_Vietbot; ?>/?api_type=2&data=sys_player",
            "method": "GET",
            //"timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            }
        };

        $.ajax(settings)
            .done(function(response) {
                var messageinfomusicplayer = document.getElementById("infomusicplayer");
                var media_path = response.media1_path;
                var playervlc_state = response.sys_player_state;
                var media_position = response.media1_position;
                var cover_link = response.cover_link;
                //var last_request = response.last_request;

                var volumeIcon = document.getElementById('volumeIcon');

                var song_name = response.song_title;
                var state = response.sys_player_state;
                var media_durationInSeconds = Math.round(response.media1_duration);
                var media1_positionInSeconds = media_position === -1.0 ? -1.0 : Math.round(media_position * media_durationInSeconds);
var nguonnhac;
if (!media_path || media_path === null) {
    nguonnhac = "N/A";
	song_name = "Tên: N/A";
	cover_link = "../assets/img/media_null.png";
} else if (media_path.startsWith("file://<?php echo $DuongDanThuMucJson; ?>/mp3/")) {
    // Giải mã chuỗi URL
    const decodedString = decodeURIComponent(media_path);
    // Bỏ phần đường dẫn
    const fileNameWithoutPath = decodedString.split('/').pop();
    // Bỏ phần mở rộng
    const fileNameWithoutExtension = fileNameWithoutPath.replace(/\..+$/, '');
    // Giới hạn tên file tối đa 20 ký tự và ngắt tại khoảng trắng
    const maxLength = 25;
    const truncatedFileName = truncateFileName(fileNameWithoutExtension, maxLength);
    nguonnhac = "<font color=green>Local MP3</font>";
    // console.log('Tên file sau khi giải mã, loại bỏ đường dẫn và mở rộng:', truncatedFileName);
} else if (media_path.startsWith("http://vnno-") || media_path.startsWith("https://a128-") || media_path.startsWith("http://mp3-s1")) {
    nguonnhac = "<font color=green>ZingMp3</font>";
} else if (media_path.startsWith("https://rr")) {
    nguonnhac = "<font color=green>Youtube</font>";
} else if (media_path.startsWith("https://str.vov")) {
    nguonnhac = "<font color=green>Radio</font>";
} else if (media_path.startsWith("https://d3ct") || media_path.startsWith("https://cdn") || media_path.startsWith("https://data.voh")) {
    nguonnhac = "<font color=green>PodCast</font>";
} else if (media_path.startsWith("file://<?php echo $DuongDanThuMucJson; ?>/tts_saved/")) {
    nguonnhac = "tts_saved";
} else {
    nguonnhac = "<font color=green>N/A</font>";
}

				
				//gửi dữ liệu response  trả về từ ajax  lên trang cha index.php để cập nhật volume
                window.parent.postMessage(response, '*');

                var parentUrl = window.top.location.href;
                // Tách đường dẫn URL để lấy phần fragment sau dấu #
                var fragments = parentUrl.split('#');
                if (fragments.length > 1) {
                    var fragment = fragments[1];
                    // Kiểm tra giá trị của fragment
                    if (fragment === "MediaPlayer") {
				  if (media1_positionInSeconds !== -1.0) {
                    $("#selected-time").text(formatTimeajax(media1_positionInSeconds));
                }
                $("#time-slider").attr("max", media_durationInSeconds);
                $("#time-slider").val(media1_positionInSeconds);
                // Convert and display media1_duration in HH:MM:SS format
                $("#media1-duration").text(formatTimeajax(media_durationInSeconds));
                $("#infomusicplayer").html("Nguồn nhạc: <font color=green>.....</font>");
                messageinfomusicplayer.innerHTML = '<div class="image-container"><div class="rounded-image"><img src=' + cover_link + ' alt="" /></div><div class="caption"><ul><li><p style="text-align: left;"><b title="'+song_name+'"></b><font color=blue title="'+song_name+'">' + truncateFileName(song_name, 20) + '</font></p></li><li><p style="text-align: left;"><b>Nguồn:</b> ' + nguonnhac + '</li></p></ul></div></div>';
              
                    }
                    //else {console.log("Không có MediaPlayer trong đường dẫn URL của trang cha.");}
                }
				
                var playerStateText = "";
                var playerStateColor = "";
                switch (playervlc_state) {
                    case "State.Ended":
                        playerStateText = "Đã kết thúc";
                        playerStateColor = "gray";
                        break;
                    case "State.Playing":
                    case "State.Opening":
                        playerStateText = "Đang phát";
                        playerStateColor = "green";
                        break;
                    case "State.Paused":
                        playerStateText = "Đã tạm dừng";
                        playerStateColor = "blue";
                        break;
                    case "State.Stopped":
                        playerStateText = "Đã dừng";
                        playerStateColor = "red";
                        break;
                    default:
                        playerStateText = "Không có dữ liệu";
                        playerStateColor = "black";
                }
                $("#player-state").text("Trạng thái: " + playerStateText).css("color", playerStateColor);
                $('#loading-overlay').hide();
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                // Handle the failure (e.g., no connection to API)
                $("#player-state").text("Trạng thái: Không kết nối được tới API get_api_playback");
                $('#loading-overlay').hide();
            });
    }

    // Function to check if the code should run
    function shouldRunCode() {
        return $("#run-checkbox").is(":checked");
    }

    // Set an interval to call the fetchData function every 3 seconds
    var intervalID;

	//Luôn luôn chạy API khi checkbox được tích
    function startInterval() {
        intervalID = setInterval(function() {
            if (shouldRunCode()) {
                //var parentUrl = window.top.location.href;
                // Tách đường dẫn URL để lấy phần fragment sau dấu #
               // var fragments = parentUrl.split('#');
                //if (fragments.length > 1) {
                    //var fragment = fragments[1];
                    // Kiểm tra giá trị của fragment
                   // if (fragment === "MediaPlayer") {
                        fetchData();
                    //}
                    //else {console.log("Không có MediaPlayer trong đường dẫn URL của trang cha.");}
               // }
                //else {console.log("Không có fragment trong đường dẫn URL của trang cha.");}
            }
        }, <?php echo $sync_media_player_sync_delay; ?> * 1000);
    }

    // Check the initial state of the checkbox and show/hide the code section accordingly
    $(document).ready(function() {
        if (shouldRunCode()) {
            startInterval();
            $("#code-section").show();
        } else {
            $("#code-section").hide();
            //   $("#player-state").text("Player State: Code execution stopped.");
        }
    });

    // Update the selected time when the slider value changes
    $("#time-slider").on("input", function() {
        $("#selected-time").text(formatTimeajax($(this).val()));
    });

    // Update the code execution and visibility when the checkbox state changes
    $("#run-checkbox").on("change", function() {
        if (shouldRunCode()) {
            startInterval();
            $("#code-section").show();
        } else {
            clearInterval(intervalID);
            $("#code-section").hide();
            // $("#player-state").text("Trạng thái: Code execution stopped.");
        }
    });
</script>


<script>
    // Your JavaScript code here
    function togglePopupSync() {
        var popupContainer = document.getElementById("popupContainer");
        popupContainer.classList.toggle("show");
    }

    function hidePopupSync() {
        var popupContainer = document.getElementById("popupContainer");
        popupContainer.classList.remove("show");
    }

    function preventEventPropagationSync(event) {
        event.stopPropagation();
    }
</script>
	

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var selectElement = document.getElementById('SelectRadioVOV');
      var buttonElement = document.getElementById('Play_Radio');

      // Cập nhật giá trị của data-song-id và data-song-name khi trang được tải
      var selectedOption = selectElement.options[selectElement.selectedIndex];
      var selectedValue = selectedOption.value;
      var selectedName = selectedOption.getAttribute('data-name_radio');

      buttonElement.setAttribute('data-song-id', selectedValue);
      buttonElement.setAttribute('data-song-name', selectedName);

      // Thêm sự kiện 'change' vào select
      selectElement.addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var selectedValue = selectedOption.value;
        var selectedName = selectedOption.getAttribute('data-name_radio');

        buttonElement.setAttribute('data-song-id', selectedValue);
        buttonElement.setAttribute('data-song-name', selectedName);
      });

      // Thêm sự kiện 'click' vào button
      buttonElement.addEventListener('click', function() {
        var songId = buttonElement.getAttribute('data-song-id');
        var songName = buttonElement.getAttribute('data-song-name');

        
          //console.log("Button clicked with song ID:", songId);
          //console.log("Song name:", songName);
          // Thêm dữ liệu khác nếu cần
        
      });
	  
	  
    });
  </script>
<script>
//Không cho kéo thanh slide time line
var timeSlider = document.getElementById("time-slider");

function disableInput() {
    timeSlider.disabled = true;
}

function enableInput() {
    timeSlider.disabled = false;
}

timeSlider.addEventListener("mouseenter", disableInput);
timeSlider.addEventListener("touchstart", disableInput);

timeSlider.addEventListener("mouseleave", enableInput);
timeSlider.addEventListener("touchend", enableInput);

</script>
<script>
    // Hàm thay đổi giá trị của song.source
    function changeSourceName(source) {
        switch (source) {
            case "ZingMp3":
                return "Nghệ Sĩ";
            case "Youtube":
                return "Kênh";
            case "Podcast":
                return "Loại Nội Dung";
            case "Local":
                return "Kích Thước";
            default:
                return source;
        }
    }

    function loadPlayList() {
        //Get Data PlayList
        $('#loading-overlay').show();
        $.ajax({
            url: "Play_List.json",
            type: "GET",
            dataType: "json",
            success: function(data) {
                $("#messagee2").html(""); // Xóa thông báo trước đó (nếu có)
                if (data && data.play_list && data.play_list.length > 0) {
                    $('#loading-overlay').hide();
                    $("#messagee2").html("Danh Sách Play List Của Bạn:<br/><button title='Xóa lịch sử tìm kiếm' type='button' name='delete_all_play_list' onclick='delete_all_play_list()' class='btn btn-warning'>Xóa Toàn Bộ Play List</button><br/><br/>");
                    $.each(data.play_list, function(index, song) {
                        songsourcereplace = changeSourceName(song.source);
                        $("#messagee2").append("<div class='image-container'>" +
                            "<img src='" + song.images + "' class='imagesize' alt='" + song.title + "'> <div class='caption'>" +
                            "<b>Tên bài hát: </b><a href='" + song.title + "' target='_bank' style='color: black;' title='Mở trong tab mới'>" + song.title + "</a><br/>" +
                            "<b>" + songsourcereplace + ": </b>" + song.channel_artist_content + "<br/>" +
                            "<b>Thời Lượng: </b>" + song.time + "<br/>" +
                            "<b>Nguồn Phát: </b>" + song.source + "<br/>" +
                            "<button class='ajax-button btn btn-success' data-song-data_type='2' data-song-data_play_music='play_direct_link' data-song-tenkenhnghesi=' N/A' data-song-player_type='system' data-song-artist='" + song.channel_artist_content + "' data-song-images='" + song.images + "' data-song-name='" + song.title + "' data-song-kichthuoc=' N/A' data-song-thoiluong=' N/A' data-song-id='" + song.link + "'>Phát Nhạc</button>" +
                            "<button type='button' class='delete-song btn btn-danger' value='" + song.link + "'>Xóa</button>" +
                            "</div></div><br>");
                    });
					
                } else {
                    $('#loading-overlay').hide();
                    // Hiển thị thông báo nếu không có dữ liệu
                    $("#messagee2").html("Play List của bạn trống!");
                }
            },
            error: function(xhr, status, error) {
                $('#loading-overlay').hide();
                console.log("Error:", error);
            }
        });
    }

    function addplaylist(button) {
        var title = button.getAttribute("data-title");
        var images = button.getAttribute("data-images");
        var channel_artist_content = button.getAttribute("data-channel_artist_content");
        var link = button.getAttribute("data-link");
        var time = button.getAttribute("data-time");
        var source = button.getAttribute("data-source");
        //console.log(title);
        var settings_add_playlist = {
            "url": "Add_Delete_PlayList.php",
            "method": "POST",
            "data": {
                "add_play_list": "add_play_list",
                "title": title,
                "images": images,
                "channel_artist_content": channel_artist_content,
                "link": link,
                "time": time,
                "source": source
            }
        };
        // Sử dụng AJAX để gửi yêu cầu
        $.ajax(settings_add_playlist).done(function(responseez) {
            // Xử lý phản hồi từ máy chủ nếu cần
            if (responseez.success) {
                // Hiển thị thông báo xóa thành công
                alert(responseez.message + ": " + title);
            } else {
                alert(responseez.message + ": " + title);
            }
        });
    }

    function delete_all_play_list() {
        var settings = {
            "url": "Add_Delete_PlayList.php",
            "method": "POST",
            "data": {
                "delete_all_play_list": "delete_all_play_list"
            }
        };
        $.ajax(settings)
            .done(function(response) {
                // Xử lý khi xóa thành công
                if (response.success) {
                    alert(response.message); // Hiển thị thông báo thành công
                    loadPlayList(); // Tải lại danh sách phát
                } else {
                    alert("Xóa toàn bộ Play List thất bại!");
                    console.error(response.message); // Hiển thị thông báo lỗi
                }
            })
            .fail(function(xhr, status, error) {
                // Xử lý khi có lỗi xảy ra trong quá trình gửi yêu cầu
                console.error("Error:", error);
            });
    }


    $(document).ready(function() {
        // Xử lý sự kiện khi nút Xóa bài lẻ trong play list được nhấn
        $(document).on('click', '.delete-song', function() {
            $('#loading-overlay').show();
            var songLinkss = $(this).val();
            var settingsss = {
                "url": "Add_Delete_PlayList.php",
                "method": "POST",
                "data": {
                    "song_link": songLinkss
                }
            };

            // Gửi yêu cầu Ajax để xóa bài hát
            $.ajax(settingsss)
                .done(function(responsess) {
                    $('#loading-overlay').hide();
                    // Xử lý khi yêu cầu thành công
                    console.log(responsess);
                    if (responsess.success) {
                        // Hiển thị thông báo xóa thành công
                        alert("Xóa bài hát thành công: " + responsess.message);
                        // Tải lại danh sách phát
                        loadPlayList();
                    } else {
                        // Hiển thị thông báo xóa thất bại
                        alert("Lỗi: " + responsess.message);
                    }
                })
                .fail(function(xhr, status, error) {
                    $('#loading-overlay').hide();
                    // Xử lý khi yêu cầu thất bại
                    console.log("Error:", error);
                    alert("Xóa bài hát thất bại. Vui lòng thử lại sau.");
                });
        });
    });
</script>


    

<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/bootstrap.js"></script>
</body>
</html>
<?php

function formatTimephp($seconds)
{
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}


?>
