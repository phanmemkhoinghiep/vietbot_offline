<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "./Configuration.php";
require('./assets/lib_php/MQTT/phpMQTT.php');

//Cấu Hình MQTT trong file Configuration.php
$Vietbot_MQTT = new Bluerhinos\phpMQTT($MQTT_Server, $MQTT_Port, $MQTT_Client_ID);

$temperature  = round(file_get_contents("/sys/class/thermal/thermal_zone0/temp") / 1000, 1);



$message = "Tuyển Test MQTT";


?>
<?php
//MQTT sensor:
/*
  - name: "VietBot MQTT Messenger"
    state_topic: "phpMQTT/Vietbot/Messenger"
  - name: "VietBot MQTT Temperature"
    state_topic: "phpMQTT/Vietbot/Temperature"
    unit_of_measurement: "°C"
    
*/

$Mes_Successfully = json_encode(array(
            'message' => 'Đẩy dữ liệu lên MQTT thành công',
            'mqtt_server' => $MQTT_Server,
            'thoi_gian' => date('H:i:s d-m-Y'),
			'data_publish' => $message
        ));
$Mes_Failed = json_encode(array(
            'message' => 'Không thể kết nối với MQTT, vui lòng kiểm tra lại',
            'mqtt_server' => $MQTT_Server,
            'thoi_gian' => date('H:i:s d-m-Y')
        ));
		
if ($Vietbot_MQTT->connect(true, NULL, $MQTT_UserName, $MQTT_Password)) {
	
    $topic = 'phpMQTT/Vietbot/Messenger';
    $topic1 = 'phpMQTT/Vietbot/Temperature';
    
    $Vietbot_MQTT->publish($topic, $message, 0, false);
    $Vietbot_MQTT->publish($topic1, $temperature, 0, false);
	
	
	
    $Vietbot_MQTT->close();
   // echo "Message published successfully.\n";
	echo $Mes_Successfully;
} else {
    echo $Mes_Failed;
}


