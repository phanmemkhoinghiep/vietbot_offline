<?php
//Code By: Vũ Tuyển
//Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../../Configuration.php";
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = "$DuognDanThuMucJson/hotword/";
    $maxFiles = 20;
    $selectedLanguage = $_POST['language_hotword'] ?? '';

    // Kiểm tra xem ngôn ngữ có được xác định không
	if ($selectedLanguage !== 'eng' && $selectedLanguage !== 'vi') {
    //echo "Chỉ nhấp nhận tải lên khi chọn ngôn ngữ Tiếng Anh hoặc Tiếng Việt";
    echo "only_click_accept_vi_eng";
    return;
	}
    // Thêm ngôn ngữ vào đường dẫn
    $uploadDir .= $selectedLanguage . '/';
    // Biến để kiểm tra xem có tệp tin được tải lên hay không
    $fileUploaded = false;
    // Kiểm tra xem có tệp tin được tải lên hay không
    if (isset($_FILES['files'])) {
        $files = $_FILES['files'];
        // Duyệt qua từng file
        for ($i = 0; $i < count($files['name']); $i++) {
            $fileName = $files['name'][$i];
            $fileTmpName = $files['tmp_name'][$i];
            // Lấy thông tin về tên file
            $fileInfo = pathinfo($fileName);
            // Kiểm tra nếu phần mở rộng là '.ppn'
             if (strtolower($fileInfo['extension']) === 'ppn' || strtolower($fileInfo['extension']) === 'pv') {
                // Đường dẫn đến file đích
                $destination = $uploadDir . $fileName;
				// Kiểm tra nếu là file '.pv' thì đặt vào đường dẫn khác
                if (strtolower($fileInfo['extension']) === 'pv') {
                    // Kiểm tra tên file .pv
                    if ($fileName === 'porcupine_params.pv' || $fileName === 'porcupine_params_vn.pv') {
                        $destination = $Lib_Hotword.'/'.$fileName;
                    } else {
                        //echo "Chỉ chấp nhận tệp tin .pv có 2 tên là:\n porcupine_params.pv cho tiếng anh và\n porcupine_params_vn.pv cho tiếng việt\n\n";
                        echo "name_file_eng_vi";
                        continue; // Bỏ qua file không hợp lệ và tiếp tục vòng lặp tải lên file hợp lệ
                    }
                }
                // Di chuyển file tải lên đến đúng đường dẫn
                move_uploaded_file($fileTmpName, $destination);
				chmod($destination, 0777);
                echo "Tải lên thành công: $fileName\n";
		$fileUploaded = true;
            } else {
                //echo "Chỉ chấp nhận tệp tin có phần mở rộng .ppn và .pv";
                echo "only_accept_ppn_pv";
            }
        }
    }
	// Hiển thị thông báo nếu không có tệp tin nào được tải lên
    if (!$fileUploaded) {
        //echo "Không có tệp tin nào được tải lên.";
        echo "no_files_uploaded";
		
    }
}
?>
