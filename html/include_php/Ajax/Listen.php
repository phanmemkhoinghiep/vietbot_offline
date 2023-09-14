<?php
//Code By: Vũ Tuyển
//Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../../Configuration.php";
$songName = $_GET['song'];
$audioFilePath = $DuognDanThuMucJson.'/'.$songName;
if (file_exists($audioFilePath)) {
    $base64Audio = base64_encode(file_get_contents($audioFilePath));
    echo $base64Audio;
} else {
    echo "";
}
?>
