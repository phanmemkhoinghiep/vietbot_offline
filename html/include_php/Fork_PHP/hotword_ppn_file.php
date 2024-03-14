<?php
//Code By: Vũ Tuyển
//Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../../Configuration.php";
?>
<?php
$uploadDir = "$DuognDanThuMucJson/hotword/";

function listFiles($uploadDir, $selectedLanguage) {
    if ($selectedLanguage === '') {
        echo "<center><font color=red>Hãy chọn ngôn ngữ Hotword</font></center>";
        return;
    }
	if ($selectedLanguage == 'vi') {
    $selectedLanguageReplace = 'Tiếng Việt';
	} 
	elseif ($selectedLanguage == 'eng') {
    $selectedLanguageReplace = 'Tiếng Anh';
	}
	/*
	elseif ($selectedLanguage == 'default') {
    $selectedLanguageReplace = 'Mặc Định';
	}
	*/
	else{
		echo "<center><font color=blue>List Hotword không được chấp nhận<br/>Chỉ chấp nhận <b>Tiếng Việt</b> hoặc <b>Tiếng Anh</b></font></center>";
		return;
	}
    $files = glob($uploadDir . $selectedLanguage . '/*.ppn');
	echo "<p>Tổng số file Hotword $selectedLanguageReplace: <font color=red>" . count($files) . "</font></p>";
    echo "<ul>";
	$fileCount = 0;
    foreach ($files as $file) {
		$fileCount++;
		$explodedPath = explode('/', $file);
		$lastElement = end($explodedPath);
		$Name_File = $lastElement;
		//$Name_File = basename($file);
		$Dowload_Name_File = $selectedLanguage."/".$Name_File;
		
        echo "<li>" . $Name_File. " <font color=\"red\" type=\"button\" class=\"delete-button\" onclick=\"deleteFileAjax('$file')\" title=\"Xóa file: " . $Name_File . "\">Xóa</font>
		<font color=\"blue\" type=\"button\" class=\"download-button\" onclick=\"downloadFileAjax('".$Dowload_Name_File."')\" title=\"Tải xuống file: " . $Name_File . "\">Tải xuống</font></li>";
	}
    echo "</ul>";
}
function deleteFile($filePath) {
    if (preg_match('/\.ppn$/', $filePath)) {
        $utf8FilePath = mb_convert_encoding($filePath, 'UTF-8', 'auto');
        if (file_exists($utf8FilePath)) {
            if (unlink($utf8FilePath)) {
                echo "success";
            } else {
                echo "error";
            }
        } else {
            echo "not_found";
        }
    } else {
        echo "not_ppn_file";
    }
}



function downloadFile($fileName, $selectedLanguage,$DuognDanThuMucJson) {
    $allowedExtension = 'ppn';
    $filePath = "$DuognDanThuMucJson/hotword/" . $selectedLanguage . '/' . $fileName;  // Đường dẫn đầy đủ
    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
    if (file_exists($filePath) && strtolower($fileExtension) === $allowedExtension) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        ob_clean();
        readfile($filePath);
        exit;
    } else {
        echo "not_found";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_file') {
    if (isset($_POST['fileToDelete'])) {
        $fileToDelete = $_POST['fileToDelete'];
        deleteFile($fileToDelete);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] === 'list_files') {
       // $selectedLanguage = $_GET['language'] ?? '';
        $selectedLanguage = $_GET['language'];
        listFiles($uploadDir, $selectedLanguage);
    }
		elseif ($_GET['action'] === 'download_file') {
        if (isset($_GET['fileToDownload'])) {
            $fileToDownload = $_GET['fileToDownload'];
            $selectedLanguage = isset($_GET['language']) ? $_GET['language'] : '';
            downloadFile($fileToDownload, $selectedLanguage,$DuognDanThuMucJson);
        }
    }else {
            // Xử lý trường hợp thiếu tham số 'fileToDownload'
            echo "<center><font color=red>Tham số truyền vào sai cú pháp<font></center>";
        }
}

?>
