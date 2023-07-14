<?php
include "Configuration.php";
include "./include_php/INFO_OS.php";
$jsonDatazXZzz = file_get_contents("assets/json/List_Lat_Lon_Huyen_VN.json");
$dataVTGETtt = json_decode($jsonDatazXZzz);
$latitude = $dataVTGETtt->$wards_Tinh->latitude;
$longitude = $dataVTGETtt->$wards_Tinh->longitude;

?>
<!DOCTYPE html>
<html lang="en" class="max-width-d">
<!--
Code By: Vũ Tuyển
Facebook: https://www.facebook.com/TWFyaW9uMDAx
-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?php echo $MYUSERNAME; ?>, VietBot Bảng Điều Khiển</title>
    <link rel="shortcut icon" href="assets/img/VietBot128.png">
    <link href="assets/css/Font_Muli_300,400,600,700.css" rel="stylesheet">
    <link href="assets/css/Font_Poppins_400,500,600,700.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/style.css">
	  <script src="assets/js/ajax_jquery_3.6.0_jquery.min.js"></script>
	  <style>
    .blinking-container {
      position: fixed;
      bottom: 0;
      width: 100%;
      background-color: #f1f1f1;
      text-align: center;
      z-index: 9999;
    }
    .ptexxt {
	  margin-bottom: 0rem;
    }
    

	  </style>
</head>
<body>
    <script>
    $(document).ready(function() {
        var apiKey = "<?php echo $apiKeyWeather; ?>";
        var lat = "<?php echo $latitude ?>"; // Latitude
        var lon = "<?php echo $longitude ?>"; // Longitude

        function getWeather() {
            var apiUrl = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`;

            $.ajax({
                url: apiUrl,
                method: "GET",
                success: function(response) {
                    var temperature = response.main.temp;
                    var humidity = response.main.humidity;
                    var windSpeed = response.wind.speed;
                    var cityName = response.name;
                    var countryName = response.sys.country;
                    var iconCode = response.weather[0].icon;

                    $("#" + "temperature").text(temperature + "°C");
                    $("#" + "humidity").text(humidity + "%");
                    $("#" + "wind-speed").text(windSpeed + " m/s");
                    $("#" + "city").text(cityName);
                    $("#" + "country").text(countryName);
                    $("#" + "weather-icon").attr("src", "https://openweathermap.org/img/w/" + iconCode + ".png");
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching weather data:", error);
                    var errorMessage = "<h2>Error:</h2>" +
                                       "<p>Failed to fetch weather data.</p>";
                    $("#weather-info").html(errorMessage);
                }
            });
        }

        getWeather();
    });
    </script>
    <div class="menu-overlay d-none"></div>
    <!--   Right Side Start  -->
    <div class="right-side d-none d-lg-block">
      <div id="date"></div><hr/>
	   <body onload="time()">
	  <b><div id="clock"></div></b>
      <div class="social-box">
      <div class="follow-label">
          <span><b><?php echo $MYUSERNAME; ?></b> 
		  <a title="Nhóm VietBot" href="<?php echo $FacebookGroup; ?>" target="_bank">
            <i class="bi bi-facebook"></i>
          </a>
		  <a title="Github VietBot Offline" href="<?php echo $GitHub_VietBot_OFF; ?>" target="_bank">
            <i class="bi bi-github"></i>
          </a>
		 
		  		  <a title="Web UI VietBot Offline" href="<?php echo $UI_VietBot; ?>" target="_bank">
            <i class="bi bi-pentagon-half"></i>
          </a>
		  </span>
        </div> 
      </div>
      <div class="next-prev-page">
        <button type="button" class="prev-page bg-base-color hstack">
          <i class="bi bi-chevron-compact-up mx-auto" title="Trước Đó"></i>
        </button>
        <button type="button" class="next-page bg-base-color mt-3 hstack">
          <i class="bi bi-chevron-compact-down mx-auto" title="Sau Đó"></i>
        </button>
      </div>
    </div>
    <!--  Right Side End  -->
    <!--  Left Side Start  -->
    <div class="left-side  nav-close">
      <div class="menu-content-align">
        <div class="left-side-image">
          <a href="./"><img src="assets/img/VietBot128.png" alt="/"></a>
        </div>
      <h1 class="mt-1" style="font-size: 14px;"><?php echo $MYUSERNAME; ?></h1>
			<a class="download-cv btn btn-warning d-none d-lg-inline-block" href="#LogServiceCMD" style="opacity: 1; font-size: 16px; padding: 10px 30px;">Log/Service/CMD</a>
      </div>
      <div class="menu-align">
        <ul class="list-group menu text-center " id="menu">
          <li class="list-group-item">
            <a href="#hero">
              <i class="bi bi-house" title="Trang Chủ"></i>
              <span>HOME</span>
            </a>
          </li>

          <li class="list-group-item">
            <a href="#config">
              <i class="bi bi-gear-wide-connected" title="Cấu Hình/Config"></i>
              <span>Config</span>
            </a>
          </li>
		  
		            <li class="list-group-item">
            <a href="#Skill">
              <i class="bi bi-stars" title="Skill"></i>
              <span>Skill</span>
            </a>
          </li>
		            <li class="list-group-item">
            <a href="#ChatBot">
              <i class="bi bi-chat-dots" title="Chat Bot"></i>
              <span>ChatBot</span>
            </a>
          </li>
          <li class="list-group-item">
            <a href="#File_Shell">
              <i class="bi bi-file-earmark-code" title="Quản Lý File"></i>
              <span>File</span>
            </a>
          </li>
          <li class="list-group-item">
            <a href="#about" class="custom-btn">
              <i class="bi bi-info-circle-fill" title="Thông Tin"></i>
              <span>Info</span>
            </a>
          </li>
		  		           
         
        </ul>
        <div class="menu-footer">
          <a class="download-cv primary-button mt-3 mb-4 d-lg-none" href="#LogServiceCMD" title="Kiểm Tra Log, Các Hoạt Động Của Hệ Thống, Command">Log/Service/CMD</a>
        </div>
	
      </div>
    </div>
    <!--  Left Side End  -->
    <!--  Main Start  -->
    <main id="main" class="main-2">
      <!--  Hero Start  -->
      <section id="hero" class="bg-primary text-white section hero w-100">
	  	  				<!--		<div class="d-flex flex-row-reverse">
							  <div class="p-2"><?php //echo "$wards_Duong $wards_Lang $wards_Huyen $wards_Tinh"; ?></div></div> -->
							<div class="d-flex flex-row">
				<div class="p-2"><div id="tmptoday"></div></div>  <div class="p-2"><div id="clock1"></div></div></div>
		
		
<div class="d-flex flex-row">
  <div class="p-2"><div class="d-flex flex-row"> <div id="temperature" class="h1"></div> <img id="weather-icon" src="" alt="Weather Icon"></div></div>
  
  <div class="d-flex flex-column">
  <div class="d-flex flex-row"><?php echo "$wards_Tinh".",<div id='country'></div>"; ?></div>
 <div class="d-flex flex-row">Độ ẩm: &nbsp;<div id="humidity"></div></div>
  
 <div class="d-flex flex-row"> Tốc độ gió: &nbsp;<div id="wind-speed"></div></div>
</div>
</div>
			<div class="info">
				<center><h1>Xin chào, <?php echo $MYUSERNAME; ?>!</h1></center>
				<p><b>Chào mừng bạn đến với trang quản trị VietBot</b><br/><br/><i>- Nền tảng loa thông minh tương tác hàng đầu!<br/>
				- Tận hưởng trí tuệ nhân tạo tiên tiến và trải nghiệm âm thanh vượt trội với VietBot, 
				người bạn đồng hành đáng tin cậy trong không gian sống của bạn.</i></p>
				- <i>Với tính năng trí tuệ nhân tạo tiên tiến, Vietbot không chỉ là một loa thông minh thông thường, 
				mà còn là một trợ thủ đa năng trong cuộc sống hàng ngày của bạn. Bạn có thể giao tiếp với Vietbot bằng giọng nói tự nhiên, yêu cầu phát nhạc, đọc tin tức, tìm kiếm thông tin,
				và thực hiện nhiều tác vụ khác một cách thuận tiện.</i><br/><br/>
				- <i>Vietbot sẽ lắng nghe và đáp ứng mọi yêu cầu của bạn.
				Hãy đồng hành cùng Vietbot và khám phá một thế giới mới của công nghệ âm thanh và trí tuệ nhân tạo.
				Chúng tôi tin rằng bạn sẽ trải nghiệm những điều tuyệt vời và hài lòng với Vietbot.
				Nếu có bất kỳ câu hỏi hoặc yêu cầu nào, chúng tôi luôn sẵn lòng <b><a class="text-white" href="https://www.facebook.com/groups/1082404859211900" target="_bank">hỗ trợ</a></b> bạn. </i>
		
		</div>
      </section>
      <!--  Hero End  -->
	        <section id="LogServiceCMD" class="section about bg-secondary text-primary">
			 <iframe src="./include_php/LogServiceCMD.php" width="100%" height="430px"></iframe>
			 </section>
      <!--  About Start  -->
      <section id="about" class="section about bg-gray-400 text-black">
        <div class="container">
          <!--  Count up  -->
          <div id="count-up" class="count-up text-center box-border">
            <div class="row">
              <!-- Item-01 -->
			                <div class="col-6 col-lg-3 my-4 count-item">
                <div class="count-icon">🖥️</div>
                <span><a href="http://<?php echo gethostname(); ?>" target="_bank"><?php echo gethostname(); ?></a></span>
                <p class="mb-0">Host Name</p>
              </div>
			  <!-- Item-04 -->
              <div class="col-6 col-lg-3 my-4 count-item">
                <div class="count-icon">📟</div>
                <span><?php echo $_SERVER['SERVER_NAME']; ?></span>
                <p class="mb-0">Server Name</p>
              </div>
              <!-- Item-02 -->
              <div class="col-6 col-lg-3 my-4 count-item">
                <div class="count-icon">💻</div>
                <span><?php echo get_client_ip(); ?></span>
                <p class="mb-0">IP Của Thiết Bị Truy Cập</p>
              </div>
              <!-- Item-03 -->
              <div class="col-6 col-lg-3 my-4 count-item">
                <div class="count-icon">🌀</div>
                <span><?php echo phpversion(); ?></span>
                <p class="mb-0">PHP Version</p>
              </div>
              <!-- Item-04 -->
            </div>
          </div>
          <!--  Skillbar  -->
          <div class="row mt-5 skills">
            <div class="col-lg-6">
              <h3 class="subtitle">Thông Tin Máy Chủ</h3>
              <div id="skills">
                <!-- Item 01 -->
                <div class="col-lg-12 skill-box">
                  <div class="skill-text">
                    <div class="skillbar-title">🏽 Dung Lượng Ram Đã Dùng: </div>
                    <div class="skill-bar-percent"><span data-from="0" data-to="<?php echo $memusage; ?>" data-speed="4000"><?php echo $memusage; ?></span>%</div>
                  </div>
                  <div class="skillbar clearfix" data-percent="<?php echo $memusage."%";?>">
                    <div class="skillbar-bar"></div>
                  </div>
                </div>
                <!-- Item 02 -->
                <div class="col-lg-12 skill-box">
                  <div class="skill-text">
                    <div class="skillbar-title">🏾 Dung Lượng CPU Đã Dùng</div>
                    <div class="skill-bar-percent"><span data-from="" data-to="<?php echo $cpuload; ?>" data-speed="4000"><?php echo $cpuload; ?></span>%</div>
                  </div>
                  <div class="skillbar clearfix" data-percent="<?php echo $cpuload."%"; ?>">
                    <div class="skillbar-bar"></div>
                  </div>
                </div>
                <!-- Item 03 -->

              </div>
            </div>
            <div class="col-lg-5 ms-auto mt-5 mt-lg-0">
          
              <div class="language-bar">
			    <!-- Item 01 -->
			                  <div class="col-lg-12 skill-box">
                  <div class="skill-text">
                    <div class="skillbar-title">💽 Tổng Dung Lượng Ổ Đĩa</div>
                    <div class="skill-bar-percent"><span data-from="0" data-to="<?php echo $disktotal; ?>" data-speed="4000"><?php echo $disktotal; ?></span>GB</div>
                  </div>
                  <div class="skillbar clearfix" data-percent="<?php echo $disktotal."%"; ?>">
                    <div class="skillbar-bar"></div>
                  </div>
                </div>
			    <!-- Item 01 -->
                <!-- Item 01 -->
                <div class="col-lg-12 skill-box">
                  <div class="skill-text">
                    <div class="skillbar-title">💽 Dung Lượng Ổ Đĩa Đã Dùng</div>
                    <div class="skill-bar-percent"><span data-from="0" data-to="<?php echo $diskusage; ?>" data-speed="4000"><?php echo $diskusage; ?></span>%</div>
                  </div>
                  <div class="skillbar clearfix" data-percent="<?php echo $diskusage."%"; ?>">
                    <div class="skillbar-bar"></div>
                  </div>
                </div>
                <!-- Item 02 -->
                <div class="col-lg-12 skill-box">
                  <div class="skill-text">
                    <div class="skillbar-title">🖥️ Số Luồng CPU</div>
                    <div class="skill-bar-percent"><span data-from="0" data-to="<?php echo $cpu_count; ?>" data-speed="4000"><?php echo $cpu_count; ?></span></div>
                  </div>
                  <div class="skillbar clearfix" data-percent="30%">
                    <div class="skillbar-bar"></div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <!--  Client  -->
          <div class="testimonial mt-5">
		  <hr/>
            <div class="owl-carousel">
			              <!-- Item 03 -->
              <div class="testimonial-box">
                <p class="testimonial-comment">THÔNG TIN KHÁC</p>
                <div class="testimonial-item">
                  <div class="testimonial-info">
				  <p><span class="description">SYSTEM: </span> <span class="result"><?php system("uname -a"); ?></span><br/><br/>
		<span class="description">🕔 Thời Gian Khởi Động: </span> <span class="result"><?php echo "$ut[0] Ngày, $ut[1]:$ut[2] Phút"; ?></span> | 
		<span class="description">🖧 Kết nối được thiết lập: </span> <span class="result"><?php echo $connections; ?></span> | 
		<span class="description">🖧 Tổng số kết nối: </span> <span class="result"><?php echo $totalconnections; ?></span> | 
					<span class="description">🏋️ PHP Load: </span> <span class="result"><?php echo $phpload; ?> GB</span> | 
					<span class="description">⏱️ Thời gian tải: </span> <span class="result"><?php echo $total_time; ?> Giây</span></p>
                  </div>
                </div>
              </div>
              <!-- Item 01 -->
              <div class="testimonial-box">
                <p class="testimonial-comment">THÔNG TIN RAM</p>
                <div class="testimonial-item">

                  <div class="testimonial-info">
		<p><span class="description">🌡️ Dung Lượng RAM:</span> <span class="result"><?php echo $memtotal; ?> GB</span> | 
		<span class="description">🌡️ Dung Lượng RAM Đã Dùng:</span> <span class="result"><?php echo $memused; ?> GB</span> | 
		<span class="description">🌡️ Dung Lượng RAM Còn Lại:</span> <span class="result"><?php echo $memavailable; ?> GB</span></p>
                  </div>
                </div>
              </div>
              <!-- Item 02 -->
              <div class="testimonial-box">
                <p class="testimonial-comment">THÔNG TIN Ổ ĐĨA (BỘ NHỚ)</p>
                <div class="testimonial-item">
                  <div class="testimonial-info">
		<span class="description">💽 Dung Lượng Ổ Đĩa:</span> <span class="result"><?php echo $disktotal; ?> GB</span> |  
		<span class="description">💽 Dung Lượng Đã Dùng:</span> <span class="result"><?php echo $diskused; ?> GB</span> | 
		<span class="description">💽 Dung Lượng Còn Lại:</span> <span class="result"><?php echo $diskfree; ?> GB</span></p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </section>
      <!--  About End  -->

      <!--  Resume Start  -->
      <section id="config" class="bg-gray-400 text-white section">
        <div class="container">
          <!-- Servises -->
          <div class="services  mb-6">
            <div class="boxes">
              <h3 class="subtitle">Config/Cấu Hình</h3>
<iframe src="./include_php/ConfigSetting.php" width="100%" height="470px"></iframe>
            </div>
          <!--  Resume  -->
        </div>
        </div>
      </section>
      <!--  Resume End  -->
      <!--  Portfolio Start  -->
      <section id="File_Shell" class="section portfolio bg-gray-400 text-white">
 <iframe src="./include_php/Shell.php" width="100%" height="470px"></iframe>
      </section>
      <!--  Portfolio End  -->
      <!--  Blog Start  -->
      <section id="ChatBot" class="section blog bg-gray-400 text-white">
 <iframe src="./include_php/ChatBot.php" width="100%" height="570px"></iframe>
      </section>
      <!--  Blog End  -->
	  
	        <section id="vietbot_update" class="section blog bg-gray-400 text-white">
			        <div class="container">
          <h3 class="subtitle">Firmware Vietbot Upgrade</h3>
 <iframe src="./backup_update/index.php" width="100%" height="570px"></iframe>
      </section>
  	        <section id="UI_update" class="section blog bg-gray-400 text-white">
			        <div class="container">
          <h3 class="subtitle">UI Upgrade</h3>
<br/><h1><center class="text-danger">UI Upgrade Đang Được Xây Dựng</center></h1>
      </section>
	  
      <!-- Contact Start -->
      <section id="Skill" class="section contact w-100 bg-gray-400 text-white">
        <div class="container">
          <h3 class="subtitle">VietBot Skill</h3>
 <iframe src="./include_php/Skill.php" width="100%" height="470px"></iframe>
 
 
        </div>
      </section>
      <!--  Contact End  -->

    </main>
    <!--  Main End  -->

    <!--  Mobile Next and Prev Button Start -->
	
    <div class="next-prev-page d-block d-lg-none">
	
   <div class="btn-group">   <button type="button" class="prev-page bg-base-color hstack">      
        <i class="bi bi-chevron-compact-left mx-auto"></i>
      </button></div><div class="btn-group">
      <button type="button" class="next-page bg-base-color mt-1 mt-lg-3 hstack">
        <i class="bi bi-chevron-compact-right mx-auto"></i>
      </button></div>
    </div>
	
    <!--  Mobile Next and Prev Button End -->
    <!--  Navbar Button Mobile Start -->
    <div class="menu-toggle">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <!--  Navbar Button Mobile End -->
    <!--  Color Pallet  -->
    <div id="color-switcher" class="color-switcher">
      <div class="text-center color-pallet hide">
	  
	  <a class="btn btn-success" href="#vietbot_update" role="button">Kiểm Tra Cập Nhật Firmware </a>

	  <a class="btn btn-warning" href="#UI_update" role="button">Kiểm Tra Cập Nhật UI </a>

<hr/>
	 
	 
        <h6 class="text-center theme-skin-title">Đổi Màu Dao Diện</h6>
        <div class="colors text-center">
          <span class="WhiteBg" id="colorss"></span>
          <span class="01Bg" id="colorss"></span>
          <span class="03Bg" id="colorss"></span>
          <span class="BlackBg" id="colorss"></span>
          <span class="GG01Bg" id="colorss"></span>
          <span class="GG02Bg" id="colorss"></span>

        </div>
      </div>
      <div class="pallet-button hide" title="Đổi Màu Dao Diện">
          <a href="javascript:void(0)" class="cp-toggle"><i class="bi bi-gear"></i></a>
      </div>
	
    </div>
	
	
	  
    <!-- Văn bản nằm ở cuối trang -->
  <?php
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
// Lấy dữ liệu "latest" từ tệp tin version.json trên GitHub
//$gitJson = file_get_contents('https://raw.githubusercontent.com/phanmemkhoinghiep/vietbot_offline/beta/src/version.json');
$gitJson = file_get_contents($Vietbot_Version);
$gitData = json_decode($gitJson, true);
$latestVersion = $gitData['vietbot_version']['latest'];
//echo $currentresult."<br/>";
//echo $latestVersion."<br/>";
//echo $gitJson."<br/>";
//$currentresult1 = "beta 12-07-2023";
//$latestVersion1 = "beta 13-07-2023";
// So sánh giá trị "vietbot_version" từ cURL và từ GitHub
if ($currentresult === $latestVersion) {
  //echo "Bạn đang sử dụng phiên bản mới nhất: " . $currentresult;
} else {
  //$messagee .= "Có phiên bản mới: " . $latestVersion.'\n';
  echo '<div class="blinking-container"><p class="ptexxt"><font color="red"><b>Có phiên bản Vietbot mới: '.$latestVersion.' </font><a href="#vietbot_update"> Kiểm Tra</b></a></p></div>';
}

  
  // echo '<div class="blinking-container"><p class="ptexxt"><font color="red"><b>Có phiên bản Vietbot mới: '.$github_latest_version.' </font><a href="#vietbot_update"> Kiểm Tra</b></a></p></div>';
  
  ?>
 

    <!-- Mouase Magic Cursor Start -->
    <div class="m-magic-cursor mmc-outer"></div>
	  <div class="m-magic-cursor mmc-inner"></div>
    <!-- Mouase Magic Cursor End -->

    <!--  JavaScripts  -->
    <!--  Jquery 3.4.1  -->
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <!--  Bootstrap Js  -->
    <script src="assets/js/bootstrap.js"></script>
    <!--  Malihu ScrollBar Js  -->
    <script src="assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <!--  CountTo Js  -->
    <script src="assets/js/jquery.countTo.js"></script>
    <!--  Swiper Js  -->
    <script src="assets/js/owl.carousel.min.js"></script>
    <!--  Isotope Js  -->
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <!--  Magnific Popup Js  -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <!--  Arshia Js  -->
    <script src="assets/js/main.js"></script>




<script type="text/javascript">
function time() {
   var today = new Date();
   var weekday=new Array(7);
   weekday[0]="Chủ nhật";
   weekday[1]="Thứ Hai";
   weekday[2]="Thứ Ba";
   weekday[3]="Thứ Tư";
   weekday[4]="Thứ Năm";
   weekday[5]="Thứ Sáu";
   weekday[6]="Thứ Bảy";
   var day = weekday[today.getDay()];
   var dd = today.getDate();
   var mm = today.getMonth()+1; //January is 0!
   var yyyy = today.getFullYear();
   var h=today.getHours();
   var m=today.getMinutes();
   var s=today.getSeconds();
   m=checkTime(m);
   s=checkTime(s);
   nowTime = h+":"+m+":"+s;
   if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = day+', '+ dd+'/'+mm+'/'+yyyy;

  tmptoday='<span class="date">'+today+'</span>';
   tmp='<span class="date">'+nowTime+'</span>';

   document.getElementById("clock").innerHTML=tmp;
   document.getElementById("clock1").innerHTML=tmp;
   document.getElementById("tmptoday").innerHTML=tmptoday;

   clocktime=setTimeout("time()","1000","JavaScript");
   function checkTime(i)
   {
      if(i<10){
     i="0" + i;
      }
      return i;
   }
}
</script>


</body>

</html>
