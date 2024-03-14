<?php
include "Configuration.php";
include "./include_php/Fork_PHP/INFO_OS.php";
$jsonDatazXZzz = file_get_contents("assets/json/List_Lat_Lon_Huyen_VN.json");
$dataVTGETtt = json_decode($jsonDatazXZzz);
$latitude = $dataVTGETtt->$wards_Tinh->latitude;
$longitude = $dataVTGETtt->$wards_Tinh->longitude;
?>
<!DOCTYPE html>
<html lang="vi" class="max-width-d">
<!--
Code By: Vũ Tuyển
Facebook: https://www.facebook.com/TWFyaW9uMDAx
-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?php echo $MYUSERNAME; ?>, VietBot Bảng Điều Khiển</title>
    <link rel="shortcut icon" href="assets/img/VietBot128.png">
 <!--   <link href="assets/css/Font_Muli_300,400,600,700.css" rel="stylesheet">
    <link href="assets/css/Font_Poppins_400,500,600,700.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/jquery.mCustomScrollbar.css">
   <link rel="stylesheet" href="assets/css/animate.min.css"> 
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/loading.css">
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
    
    .contentt {
        z-index: 9999999;
        width: 100%;
        padding: 20px;
        position: relative;
    }
    
    .right-sidebar {
        border-radius: 10px;
        position: fixed;
        top: 10px;
        right: -100%;
        width: 40%;
        height: 450px;
        background-color: #d2d8bb;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        transition: right 0.1s ease;
        z-index: 1;
        overflow: hidden;
    }
    
    @media (max-width: 768px) {
        /* Media query for mobile devices */
        
        .right-sidebar {
            width: 100%;
            height: 83vh;
        }
        iframe {
            width: 40%;
            /* Đặt chiều rộng của iframe là 100% */
            
            height: auto;
            /* Đặt chiều cao của iframe làborder: none; /* Loại bỏ viền của iframe */
        }
    }
    
    .resize-handle {
        width: 10px;
        height: 10px;
        background-color: #333;
        position: absolute;
        cursor: ne-resize;
        bottom: 0;
        left: 0;
    }
    
    .toggle-btnnn {
        cursor: pointer;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        position: absolute;
        top: 0;
        right: 20px;
        z-index: 2;
        /* Ensure it appears above .right-sidebar */
    }
    
    .toggle-btnnn:focus {
        outline: none;
    }
    /* Add background overlay style */
    
    .background-overlay {
        display: none;
        /* Initially hidden */
        
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        /* Semi-transparent background */
        
        z-index: 0;
        /* Set a lower z-index to be behind .right-sidebar */
    }
    
    a.cp-toggleee {
		margin-top: 1px;
        cursor: pointer;
        z-index: 1000;
        transition: all 0.3s ease;
        border-radius: 0.75rem;
        background: rgb(255 255 255 / 20%);
        border: 1px solid rgb(255 255 255 / 30%);
        -webkit-backdrop-filter: blur(10px);
    }
    
    a.cp-toggleeee {
        z-index: 1000;
        transition: all 0.3s ease;
        border-radius: 0.75rem;
        background: rgb(255 255 255 / 20%);
        border: 1px solid rgb(255 255 255 / 30%);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .rounded-iframe {
        border-radius: 10px 10px 10px 10px;
        overflow: hidden;
        /* Để làm tròn góc thì cần che phần dư thừa */
    }
    
    iframe {
        width: 100%;
        /* Đặt chiều rộng của iframe là 100% */
        
        height: 83vh;
        /* Đặt chiều cao của iframe là 100% */
        
        border: none;
        /* Loại bỏ viền của iframe */
    }
</style>
<style>
    .cp-toggleeeee {
		margin-top: 2px;
        padding: 3px;
        /* Thêm padding để tạo khoảng cách giữa nội dung và viền */
        
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Căn giữa theo chiều dọc */
        
        justify-content: center;
        /* Căn giữa theo chiều ngang */
        
        z-index: 1000;
        transition: all 0.3s ease;
        border-radius: 0.75rem;
        background: rgb(255 255 255 / 20%);
        border: 1px solid rgb(255 255 255 / 30%);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .volume_value {
        cursor: pointer;
        margin: 33px;
        transform: rotate(-90deg);
        width: 90px;
        margin-top: 35px;
    }
    
    .volume-container {
        float: right;
        /* Dịch chuyển về bên phải */
        
        margin-left: 10px;
        /* Khoảng cách giữa div và div bên phải */
    }
    
    .cp-toggleee:hover .bi-chat-dots {
        color: red;
    }
    
    .cp-toggle:hover .bi-gear {
        color: red;
    }
    
    .cp-toggleeeee i:hover {
        color: red;
    }
	.colorred {
		cursor: pointer;
	}
</style>
</head>
<body>
	    <!-- Preloader -->
    <div id="line-loader">
      <div class="middle-line"></div>
    </div>
	    <div id="loading-overlay">
          <img id="loading-icon" src="../assets/img/Loading.gif" alt="Loading...">
		  <div id="loading-message">Đang Thực Thi...</div>
    </div>
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

<!--

    <script>
    $(document).ready(function() {
        var apiKey = "<?php //echo $apiKeyWeather; ?>";
        var lat = "<?php //echo $latitude ?>"; // Latitude
        var lon = "<?php //echo $longitude ?>"; // Longitude

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
	-->
    <div class="menu-overlay d-none"></div>
    <!--   Right Side Start  -->
    <div class="right-side d-none d-lg-block">
      <div id="tmptoday"></div><hr/>
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
          <a href="./"><img src="assets/img/VietBot128.png" alt="/" title="Nhấn Để Về Trang Chủ"></a>
        </div>
      <h1 class="mt-1" style="font-size: 14px;"><?php echo $MYUSERNAME; ?></h1>
		<!--	<a class="download-cv btn btn-warning d-none d-lg-inline-block" href="" style="opacity: 1; font-size: 16px; padding: 10px 30px;" title="Comback_Soon">Comback_Soon</a>
      -->
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
            <a href="#LogServiceCMD1">
              <i class="bi bi-terminal-plus" title="Log/Service/Debug/Command"></i>
              <span>Debug</span>
            </a>
          </li>
		  
		  
		 		  		          <li class="list-group-item">
            <a href="#MediaPlayer" class="custom-btn">
              <i class="bi bi-disc" title="Media Player"></i>
              <span>Media</span>
            </a>
          </li>    
		  
		  
          <li class="list-group-item">
            <a href="#about" class="custom-btn">
              <i class="bi bi-info-circle-fill" title="Thông Tin"></i>
              <span>Info</span>
            </a>
          </li>
        
         
        </ul>
      <!--  <div class="menu-footer">
          <a class="download-cv primary-button mt-3 mb-4 d-lg-none" href="" title="Comback_Soon">Comback_Soon</a>
        </div> -->
	
      </div>
    </div>
    <!--  Left Side End  -->
    <!--  Main Start  -->
    <main id="main" class="main-2">
      <!--  Hero Start  -->
      <section id="hero" style="width: 0px;left: 0px;" class="bg-primary text-white section hero w-100">
	  <h1><center>Xin Chào: <?php echo $MYUSERNAME; ?></center></h1>
	  	  				<!--		<div class="d-flex flex-row-reverse">
							  <div class="p-2"><?php //echo "$wards_Duong $wards_Lang $wards_Huyen $wards_Tinh"; ?></div></div> -->
<!--							<div class="d-flex flex-row">
				<div class="p-2"><div id="tmptoday"></div></div>  <div class="p-2"><div id="clock1"></div></div></div>
<div class="d-flex flex-row">
  <div class="p-2"><div class="d-flex flex-row"> <div id="temperature" class="h1"></div> <img id="weather-icon" src="" alt="Weather Icon"></div></div>
  <div class="d-flex flex-column">
  <div class="d-flex flex-row"><?php //echo "$wards_Tinh".",<div id='country'></div>"; ?></div>
 <div class="d-flex flex-row">Độ ẩm: &nbsp;<div id="humidity"></div></div>
 <div class="d-flex flex-row"> Tốc độ gió: &nbsp;<div id="wind-speed"></div></div>
</div>
</div>
<div class="info"> -->
<?php

// Đường dẫn tới tệp JSON
$jsonFilePath = "$DuognDanUI_HTML/assets/json/password.json";
// Kiểm tra xem tệp JSON đã tồn tại chưa
if (!file_exists($jsonFilePath)) {
    // Tạo một mảng mặc định nếu tệp JSON không tồn tại
    $defaultData = [
        "password_ui" => "",
		"salt" => "",
		"mail" => ""
    ];
    // Tạo tệp JSON và ghi dữ liệu mặc định vào nó
    file_put_contents($jsonFilePath, json_encode($defaultData,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

    // Đặt quyền truy cập cho tệp JSON thành 644 (quyền đọc và ghi cho người sở hữu, quyền đọc cho các người dùng khác)
    chmod($jsonFilePath, 0777);
}
// Đọc nội dung từ tệp JSON
$jsonData = file_get_contents($jsonFilePath);
// Chuyển dữ liệu JSON thành mảng PHP
$data = json_decode($jsonData, true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
        if (isset($_POST['password1']) && isset($_POST['password2'])) {
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];
            $mailllgmail = $_POST['mailllgmail'];

            // Kiểm tra xem mật khẩu và xác nhận mật khẩu có khớp nhau
            if ($password1 === $password2) {
                // Lưu mật khẩu vào mảng và ghi vào tệp JSON
                $data['password_ui'] = md5($password1);
                $data['salt'] = base64_encode($password1);
                $data['mail'] = $mailllgmail;
                file_put_contents($jsonFilePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

                // Đặt quyền truy cập cho tệp JSON thành 644 (quyền đọc và ghi cho người sở hữu, quyền đọc cho các người dùng khác)
                chmod($jsonFilePath, 0777);

                // Đăng nhập thành công, đánh dấu phiên đã đăng nhập
                $_SESSION['logged_in'] = true;
                echo "<br/><center><font size=3><b><i>- Tạo mật khẩu mới thành công!<br/>- Hãy nhập mật khẩu để đăng nhập</i></b></font></center>";
            } else {
                echo "<br/><center><font size=3><b><i>Mật khẩu không khớp, vui lòng thử lại!</i></b></font></center>";
            }
        }else {
			
			    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (isset($_SESSION['root_id'])) {
		if (isset($_POST['logout'])) {
			// Xử lý đăng xuất
			session_unset();
			session_destroy();
			echo "<br/><center><font size=3><b><i>Đăng xuất thành công!</i></b></font></center>";
		}
    } else {
        // Nếu chưa đăng nhập, xử lý đăng nhập
        $password = $_POST["password"];
        if (md5($password) === $data['password_ui']) {
            $_SESSION['root_id'] = "$SESSION_ID_Name"; // Thêm biến root_id
            $_SESSION['username'] = 'example_user';
            echo "<i>Đăng nhập thành công!</i>";
           // header("Location: ./index.php");
            // Kết thúc thực thi của script sau khi đăng nhập
            //exit();
        } else {
            echo "<br/><center><font size=3><b><i>Đăng nhập thất bại, vui lòng kiểm tra lại mật khẩu</i></b></font></center>";
        }
    }
	
		}

}
?>


<?php	
if (isset($Web_UI_Login) && $Web_UI_Login === true) {
if (!isset($_SESSION['root_id'])) {
?>
 <br/><center>
		    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="my-form" method="post">
  <?php if (empty($data['password_ui'])) : ?>
		Tạo Mật Khẩu Mới Cho Web UI<br/>
        <label for="password1">Mật khẩu mới:</label>
        <input type="password" id="password"  class="input-group-text" name="password1" required>
        <label for="password2">Nhập lại mật khẩu:</label>
        <input type="password" id="confirmPassword" class="input-group-text" name="password2" required>
		<label for="mailll">Địa chỉ mail:</label>
		<input type="text" id="mailll" class="input-group-text" name="mailllgmail" required>
		<br/>
		<input type="checkbox" id="showPassword">
		<label for="showPassword">Hiển Thị Mật Khẩu</label>
		<br/>
        <input type="submit" class="btn btn-success" value="Tạo Mật Khẩu Mới"><a href='<?php echo $PHP_SELF; ?>'><button type='button' class='btn btn-danger'>Tải Lại</button></a>
        <?php else : ?>

        <label for="passwordd">Nhập Mật khẩu:</label>

        <input type="password" id="passwordd" class="input-group-text" name="password" required><br>
		<input type="checkbox" id="showPasswordd">
		<label for="showPasswordd">Hiển Thị Mật Khẩu</label> | <a style="color:Yellow" href="#ForgotPassword"><b>Quên mật khẩu</b></a>
		<br/>
        <input type="submit" class="btn btn-success" value="Đăng nhập">
		<a href='<?php echo $PHP_SELF; ?>'><button type='button' class='btn btn-danger'>Tải Lại</button></a>
        <?php endif; ?>
        </form>
		</center>

<?php


} else {
    include "include_php/Fork_PHP/index_.php";
}
	
	} else {
	   
	   include "include_php/Fork_PHP/index_.php";
	   
	   
	}
?>	
		




	
	<!--  	</div> -->

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
        <div class="services">
            <div class="boxes">
                <h3 class="subtitle">Config/Cấu Hình</h3>
					<div class="rounded-iframe">
                <iframe src="./include_php/ConfigSetting.php" width="100%" height="470px"></iframe>
            </div>
            </div>
            <!--  Resume  -->
        </div>
    </div>
</section>
<!--  Resume End  -->
<!--  Portfolio Start  -->
<section id="LogServiceCMD1" class="section portfolio bg-gray-400 text-white">
 <!--   <iframe src="./include_php/Fork_PHP/Shell.php" width="100%" height="470px"></iframe> -->
<iframe src="./include_php/LogServiceCMD.php" width="100%" height="430px"></iframe>
</section>
<!--  Portfolio End  -->
<!--  Blog Start  -->
<!--
<section id="ChatBot" class="section blog bg-gray-400 text-white">
    <iframe src="./include_php/ChatBot.php" width="100%" height="570px"></iframe>
</section>
-->
<section id="Google_Drive_Auto_Backup" class="section blog bg-gray-400 text-white">
    <div class="container">
        <h3 class="subtitle">Google Drive Auto Backup</h3>
			<div class="rounded-iframe">
     <iframe src="./GoogleDrive/index.php" width="100%" height="570px"></iframe>
		</div>
</section>

<section id="MediaPlayer" class="section blog bg-gray-400 text-white">
    <div class="container">
        <h3 class="subtitle">Media Player</h3>
			<div class="rounded-iframe">
     <iframe src="./Multimedia/index.php" width="100%" height="570px"></iframe>
		</div>
</section>

<!--  Blog End  -->
<section id="vietbot_update" class="section blog bg-gray-400 text-white">
    <div class="container">
        <h3 class="subtitle">Cập Nhật Chương Trình</h3>
			<div class="rounded-iframe">
        <iframe src="./backup_update/index.php" width="100%" height="570px"></iframe>
		</div>
</section>
<section id="UI_update" class="section blog bg-gray-400 text-white">
    <div class="container">
        <h3 class="subtitle">Cập Nhật Giao Diện</h3>
			<div class="rounded-iframe">
        <iframe src="./ui_update/index.php" width="100%" height="570px"></iframe>
	</div>
</section>
<section id="PasswordChange" class="section blog bg-gray-400 text-white">
    <div class="container">
        <h3 class="subtitle">Thay Đổi Mật Khẩu</h3>
			<div class="rounded-iframe">
        <iframe src="./include_php/Fork_PHP/ChangePassword.php" width="100%" height="570px"></iframe>
	</div>
</section>
<section id="Skill" class="section blog bg-gray-400 text-white">
    <div class="container">
        <h3 class="subtitle">Cấu hình skill</h3>
			<div class="rounded-iframe">
        <iframe src="./include_php/Skill.php" width="100%" height="570px"></iframe>
	</div>
</section>

<section id="CFG_WifiManager" class="section contact w-100 bg-gray-400 text-white">
    <div class="container">
        <h3 class="subtitle">Cấu Hình Wifi</h3>
<iframe src="./WifiManager/index.php" width="100%" height="570px"></iframe>
    </div>
</section>

<!-- Contact Start -->
<section id="ForgotPassword" class="section contact w-100 bg-gray-400 text-white">
    <div class="container">
        <h3 class="subtitle">Quên Mật Khẩu</h3>
		<div class="rounded-iframe">
        <iframe src="./include_php/Fork_PHP/ForgotPassword.php" width="100%" height="470px"></iframe>
</div>

    </div>
</section>
<!--  Contact End  -->

</main>

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
        <a class="btn btn-danger" href="#vietbot_update" role="button" title="Nhấn Để Kiểm Tra, Cập Nhật Phầm Mềm">Cập Nhật Chương Trình</a>
        <a class="btn btn-success" href="#UI_update" role="button" title="Nhấn Để Kiểm Tra, Cập Nhật Giao Diện">Cập Nhật Giao Diện</a>
        
		
		<?php	
if (isset($Web_UI_Login) && $Web_UI_Login === true) {
	echo '<a class="btn btn-info" href="#PasswordChange" role="button" title="Đổi Mật Khẩu">Đổi Mật Khẩu Web UI</a>';
	echo '<form action="" id="my-form" method="post">
         <button class="btn btn-warning" type="submit" name="logout" title="Đăng Xuất">Đăng Xuất Hệ Thống</button>
        </form>';
	} else {
		//nếu trong config là false thì sẽ ẩn
	   echo '<!-- <a class="btn btn-info" href="#PasswordChange" role="button" title="Đổi Mật Khẩu">Đổi Mật Khẩu Web UI</a> -->';
	}
?>	
        <!--  <h6 class="text-center theme-skin-title">Đổi Màu Giao Diện</h6> -->

	   <a href="#CFG_WifiManager" role="button" class="btn btn-primary"><i class="bi bi-wifi" title="Cài Đặt,Cấu Hình Wifi"></i></a>
	   <a href="#Google_Drive_Auto_Backup" role="button" class="btn btn-dark" title="Google Drive Backup"><img src="assets/img/drive.png" title="Google Drive Backup"></a>
	   <a class="btn btn-secondary" href="./Help_Support/index.php" role="button" target="_bank" title="Hướng Dẫn / Sử Dụng Vietbot"><i class="bi bi-question-square-fill" title="Hướng Dẫn / Sử Dụng Vietbot"></i></a>
	   <div class="colors text-center">
            <span class="WhiteBg" id="colorss" title="Nhấn Để Đổi Màu Giao Diện"></span>
            <span class="01Bg" id="colorss" title="Nhấn Để Đổi Màu Giao Diện"></span>
            <span class="03Bg" id="colorss" title="Nhấn Để Đổi Màu Giao Diện"></span>
            <span class="BlackBg" id="colorss" title="Nhấn Để Đổi Màu Giao Diện"></span>
            <span class="GG01Bg" id="colorss" title="Nhấn Để Đổi Màu Giao Diện"></span>
            <span class="GG02Bg" id="colorss" title="Nhấn Để Đổi Màu Giao Diện"></span>
        </div>
    </div>

    <div class="pallet-button hide">
        <a href="javascript:void(0)" class="cp-toggle"><i class="bi bi-gear" title="Nhấn Để Hiển Thị Cài Đặt"></i></a>
 		
 <a onclick="toggleSidebar()" class="cp-toggleee"><i class="bi bi-chat-dots" title="Nhấn Để Mở ChatBot"></i></a>
 



 
	<div id="volume_slide_index" class="cp-toggleeeee">
	 <b><font color=blue><span id="volume_percentage"><?php echo $state_json->volume; ?></span>%</font></b>   

 
 <input type="range" class="volume_value" title="Kéo Để Thay Đổi Âm Lượng" id="volume_value" name="volume_value" min="0" max="100" step="1" value="<?php echo $state_json->volume; ?>">
	<p class="bi bi-volume-up-fill" title="Âm Lượng"></p>	
 
 
 	  <a class="colorred" onmousedown="startTimerMic()" onmouseup="stopTimerMic()" onclick="handleClickMic()" ontouchstart="startTimerMic()" ontouchend="stopTimerMic()"><i class="bi bi-mic-mute-fill" title="Nhấn nhả để Bật/Tắt mic, nhấn giữ 3s để Bật/Tắt câu phản hồi, nhấn tắt Mic và nhấn giữ 3s để khởi động lại Loa"></i></a>
	


<a class="colorred" onmousedown="startTimer()" onmouseup="stopTimer()" ontouchstart="startTimer()" ontouchend="stopTimer()" onclick="handleClick()">
   <i class="bi bi-play-circle" title="Nhấn nhả để đánh thức Bot, Nhấn giữ 3s để bật chế độ hội thoại (Hỏi đáp liên tục)"></i>
</a>
 
 </div>
	 

	 
	</div>

	
</div>

    <div class="contentt">
        <!-- Content of your website goes here -->
        <!-- Add background overlay element -->
        <div class="background-overlay" onclick="closeSidebar()"></div>

       <!-- <div class="right-sidebar" id="sidebar" onclick="event.stopPropagation()"> -->
        <div class="right-sidebar" id="sidebar">
            <!-- Your sidebar content goes here -->
            <div class="toggle-btnnn-container">
            <center>   <a onclick="toggleSidebar()" class="cp-toggleee"><i class="bi bi-x-circle-fill" title="Nhấn để đóng"></i></a></center>
		
			
				 <iframe id="iframeChatBot" src="./include_php/ChatBot.php" frameborder="0" allowfullscreen></iframe>
               
            </div>
			 <div class="resize-handle"></div>
        </div>
    </div>



<div class="blinking-container" id="updateMessage"></div>



    <!-- Mouase Magic Cursor Start -->
    <div class="m-magic-cursor mmc-outer"></div>
	  <div class="m-magic-cursor mmc-inner"></div>
    <!-- Mouase Magic Cursor End -->
    <script src="assets/js/jquery-3.6.1.min.js"></script>
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

<script>
//$("#iframeChatBot").width("576px");
//$("#iframeChatBot").height("450px");
//thay đổi kích thước chatbox
    $(document).ready(function() {
        let isResizing = false;
        let lastDownX;
        let lastDownY;

        $(".resize-handle").mousedown(function(e) {
            isResizing = true;
            lastDownX = e.clientX;
            lastDownY = e.clientY;
        });

        $(".resize-handle").mouseleave(function(e) {
            // Nếu chuột rời khỏi vùng resize-handle, cập nhật kích thước của thẻ iframe theo kích thước của thẻ div
            let newWidth = $("#sidebar").width();
            let newHeight = $("#sidebar").height();

            $("#iframeChatBot").width(newWidth);
            $("#iframeChatBot").height(newHeight);
        });
        $(document).mousemove(function(e) {
            if (isResizing) {
                let newWidth = $("#sidebar").width() + (lastDownX - e.clientX);
                let newHeight = $("#sidebar").height() + (e.clientY - lastDownY);

                $("#sidebar").width(newWidth);
                $("#sidebar").height(newHeight);

                if (e.buttons === 1) {
                    // Nếu chuột đang được giữ, thì cập nhật kích thước của thẻ iframe thành 100px
                    $("#iframeChatBot").width(100);
                    $("#iframeChatBot").height(100);
                    //console.log("Giữ Chuột");
                }

                lastDownX = e.clientX;
                lastDownY = e.clientY;
            }
        }).mouseup(function(e) {
            if (isResizing) {
                isResizing = false;
                //console.log("Nhả chuột");
                // Nếu chuột đã được giữ khi di chuyển, thì cập nhật kích thước của thẻ iframe theo kích thước của thẻ div
                let newWidth = $("#sidebar").width();
                let newHeight = $("#sidebar").height();
                // Cập nhật kích thước của thẻ iframe thành kích thước của thẻ div
                $("#iframeChatBot").width(newWidth);
                $("#iframeChatBot").height(newHeight);

            }
        });
    });
</script>


<script>
  $(document).ready(function() {
    // AJAX request for UI version
    $.ajax({
      url: '<?php echo $UI_Version; ?>',
      type: 'GET',
      dataType: 'json',
      success: function(remoteData) {
        var localJsonData = <?php echo json_encode(file_get_contents($DuognDanUI_HTML.'/version.json')); ?>;
        var localData = JSON.parse(localJsonData);
        var remoteValue = remoteData['ui_version']['latest'];
        var localValue = localData['ui_version']['current'];
        handleUIVersion(remoteValue, localValue);
      }
    });

    function handleUIVersion(remoteValue, localValue) {
	var updateMessageElement = document.getElementById('updateMessage');
      if (remoteValue === localValue) {
		//Phiên bản mới nhất
      } else {
        //console.log('Có phiên bản giao diện mới: ' + remoteValue);
        var message = '<font color="red"><b>Có phiên bản giao diện mới: ' + remoteValue + ' </font><a href="#UI_update"> Kiểm Tra</b></a>';
        updateMessageElement.innerHTML = message;
      }
    }
  });
</script>

<script>
  $(document).ready(function() {
    // AJAX request for vietbot version
    $.ajax({
      url: '<?php echo $Vietbot_Version; ?>',
      type: 'GET',
      dataType: 'json',
      success: function(remoteDataa) {
        var localJsonDataa = <?php echo json_encode(file_get_contents($DuognDanThuMucJson.'/version.json')); ?>;
        var localDataa = JSON.parse(localJsonDataa);
        var remoteValuea = remoteDataa['vietbot_version']['latest'];
        var localValuea = localDataa['vietbot_version']['latest'];
        handleUIVersion(remoteValuea, localValuea);
      }
    });

    function handleUIVersion(remoteValuea, localValuea) {
	var updateMessageElement = document.getElementById('updateMessage');
      if (remoteValuea === localValuea) {
		//Phiên bản mới nhất
      } else {
        //console.log('Có phiên bản giao diện mới: ' + remoteValuea);
        var message = '<font color="red"><b>Có phiên bản Vietbot mới: ' + remoteValuea + ' </font><a href="#vietbot_update"> Kiểm Tra</b></a>';
        updateMessageElement.innerHTML = message;
      }
    }
  });
</script>
   <script>
        function time() {
            var today = new Date();
            var weekday = ["Chủ nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"];
            var day = weekday[today.getDay()];
            var dd = today.getDate();
            var mm = today.getMonth() + 1; // Tháng 1 là 0!
            var yyyy = today.getFullYear();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            var nowTime = h + ":" + m + ":" + s;
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            var formattedDate = '<font color=red><b>'+day + '</b></font><br/><font color=blue>' + dd + '/' + mm + '<br/>' + yyyy+'</font>';

            var tmptoday = '<span class="date"><b>' + formattedDate + '</b></span>';
            var tmp = '<span class="date"><b>' + nowTime + '</b></span>';

            var clockElement = document.getElementById("clock");
            var tmptodayElement = document.getElementById("tmptoday");

            if (clockElement && tmptodayElement) {
                clockElement.innerHTML = tmp;
                tmptodayElement.innerHTML = tmptoday;

                setTimeout(time, 1000);
            }
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }

        document.addEventListener("DOMContentLoaded", function() {
            time();
        });
    </script>
<script type="text/javascript">

    // Lấy phần tử <div>, phần tử liên kết và phần tử nút bấm
    const divElement = document.querySelector('.text-center.color-pallet');
    const linkElement = document.querySelector('.btn-success');
    const buttonElement = document.querySelector('.btn-danger');
    const buttonnElement = document.querySelector('.btn-secondary');
    const buttonnnElement = document.querySelector('.btn-info');
    const buttonnnnElement = document.querySelector('.btn-primary');
    const buttonnnnnElement = document.querySelector('.btn-dark');

	const volume_slide_index = document.getElementById('volume_slide_index');


    volume_slide_index.addEventListener('click', function() {
		//console.log("volume_slide_index");
        // Loại bỏ lớp "show" và thêm lớp "hide" cho phần tử divElement
		divElement.classList.remove('show');
    });

    buttonElement.addEventListener('click', function() {
        // Loại bỏ lớp "show" và thêm lớp "hide" cho phần tử divElement
        divElement.classList.remove('show');
        divElement.classList.add('hide');
    });
	    buttonnElement.addEventListener('click', function() {
        // Loại bỏ lớp "show" và thêm lớp "hide" cho phần tử divElement
        divElement.classList.remove('show');
        divElement.classList.add('hide');
    });
	
		//bỏ qua lỗi nếu phần tử không tồn tại
		if (buttonnnElement) {
  	    buttonnnElement.addEventListener('click', function() {
        // Loại bỏ lớp "show" và thêm lớp "hide" cho phần tử divElement
        divElement.classList.remove('show');
        divElement.classList.add('hide');
		});
		}
		if (buttonnnnElement) {
  	    buttonnnnElement.addEventListener('click', function() {
        // Loại bỏ lớp "show" và thêm lớp "hide" cho phần tử divElement
        divElement.classList.remove('show');
        divElement.classList.add('hide');
		});
		}
		if (buttonnnnnElement) {
  	    buttonnnnnElement.addEventListener('click', function() {
        // Loại bỏ lớp "show" và thêm lớp "hide" cho phần tử divElement
        divElement.classList.remove('show');
        divElement.classList.add('hide');
		});
		}
	

    // Gắn sự kiện click vào liên kết
    linkElement.addEventListener('click', function() {
        // Loại bỏ lớp "show" và thêm lớp "hide" cho phần tử divElement
        divElement.classList.remove('show');
        divElement.classList.add('hide');
    });

    function handleInteractionStart(event) {
        // Kiểm tra xem người dùng đang bắt đầu tương tác với phần tử div hay không
        const isInteractionInsideDiv = divElement.contains(event.target);

        if (!isInteractionInsideDiv) {
            // Thực hiện hành động mong muốn
            divElement.classList.remove('show');
            divElement.classList.add('hide');
        }
    }

    function handleInteractionEnd(event) {
        // Kiểm tra xem người dùng đã kết thúc tương tác với phần tử div hay không
        const isInteractionInsideDiv = divElement.contains(event.target);

        if (!isInteractionInsideDiv) {
            // Thực hiện hành động mong muốn
            divElement.classList.remove('show');
            divElement.classList.add('hide');
        }
    }

    document.addEventListener('mousedown', handleInteractionStart);
    document.addEventListener('touchstart', handleInteractionStart);

    document.addEventListener('mouseup', handleInteractionEnd);
    document.addEventListener('touchend', handleInteractionEnd);
</script>

    <script>
	//Chatbox Slide
        let isSidebarOpen = false; // Variable to keep track of sidebar state
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');

            // Check the current state of the sidebar
            if (isSidebarOpen) {
                sidebar.style.right = '-100%';
                isSidebarOpen = false;
            } else {
                sidebar.style.right = '0';
                isSidebarOpen = true;
            }

            // Show/hide the background overlay accordingly
            const backgroundOverlay = document.querySelector('.background-overlay');
            backgroundOverlay.style.display = isSidebarOpen ? 'block' : 'none';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const sidebarWidth = sidebar.clientWidth;

            if (isSidebarOpen) {
                sidebar.style.right = `-${sidebarWidth}px`;
                // Hide the background overlay
                const backgroundOverlay = document.querySelector('.background-overlay');
                backgroundOverlay.style.display = 'none';
                isSidebarOpen = false;
            }
        }
    </script>
	 
	<script>
function reloadHostPage() {
  window.location.reload();
}

// Lắng nghe thông điệp từ iframe
window.addEventListener('message', function(event) {
  if (event.data === 'reload') {
    reloadHostPage();
  }
});
</script>
 <script>
        // Lấy các phần tử cần thao tác
        const showPasswordCheckbox = document.getElementById('showPassword');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');
		

	if (showPasswordCheckbox) {
          // Thêm sự kiện change cho checkbox
        showPasswordCheckbox.addEventListener('change', function () {
            // Nếu checkbox được tích, thay đổi type thành "text", ngược lại thì là "password"
            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
                confirmPasswordInput.type = 'text';
                
            } else {
                passwordInput.type = 'password';
                confirmPasswordInput.type = 'password';
                
            }
        });
		
}
    </script>
	
    <script>
        // Lấy các phần tử cần thao tác
        const showPasswordCheckboxx = document.getElementById('showPasswordd');
        const passwordInputt = document.getElementById('passwordd');


		if (showPasswordCheckboxx) {
         // Thêm sự kiện change cho checkbox
        showPasswordCheckboxx.addEventListener('change', function () {
            // Nếu checkbox được tích, thay đổi type thành "text", ngược lại thì là "password"
            if (showPasswordCheckboxx.checked) {
                passwordInputt.type = 'text';
            } else {
                passwordInputt.type = 'password';
            }
        });
}


    </script>
	<script>
    // Lấy các phần tử DOM cần thiết
    const volumeValue = document.getElementById('volume_value');
    const volumePercentage = document.getElementById('volume_percentage');

    // Lắng nghe sự kiện thay đổi giá trị của input range
    volumeValue.addEventListener('input', updatePercentage);

    // Lắng nghe sự kiện nhả chuột hoặc touchend
    volumeValue.addEventListener('mouseup', handleMouseUp);
    volumeValue.addEventListener('touchend', handleMouseUp);

    // Hàm cập nhật giá trị % lên thẻ span và gửi AJAX request
    function updatePercentage() {
        const value = volumeValue.value;
        volumePercentage.textContent = `${value}`;
    }

    // Hàm xử lý khi nhả chuột hoặc touchend
    function handleMouseUp() {
        const value = volumeValue.value;
        //console.log(value);

        // Gửi AJAX request
        var settings = {
            "url": "http://<?php echo $serverIP; ?>:<?php echo $Port_Vietbot; ?>",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Accept": "*/*",
                "Accept-Language": "vi",
                "Cache-Control": "no-cache",
                "Content-Type": "application/json",
                "Pragma": "no-cache",
            },
            "data": JSON.stringify({
                "type": 2,
                "data": "set_system_volume",
                "action": "setup",
                "new_value": Math.round(value)
            }),
        };

        $.ajax(settings).done(function (response) {
            // Cập nhật lại giá trị trả về lên thẻ input và span
			if (typeof response.new_volume === "undefined") {
			response.new_volume = "..."
			}
			if (response.state === "Success") {
			    var audio = new Audio('assets/audio/tut_tut.mp3');
				var volumePercentage = Math.round(value) 
				audio.volume = volumePercentage / 100;
				audio.play();
				//console.log("oK");
			}

            const newVolume = response.new_volume;
            const oldVolume = response.old_volume;

            volumeValue.value = newVolume;
            volumePercentage.textContent = `${newVolume}`;

            //console.log(response.state);
        });
    }
</script>

	
<script>
//Volume Slide
    // Khởi tạo biến hover và update
    var hover = false;
    var update = true;

    // Bắt sự kiện khi con trỏ chuột hover vào thẻ input
    document.getElementById('volume_value').addEventListener('mouseenter', function() {
        hover = true;
        update = false;
    });

    // Bắt sự kiện khi con trỏ chuột rời khỏi thẻ input
    document.getElementById('volume_value').addEventListener('mouseleave', function() {
        hover = false;
        update = true;
    });


    // Bắt sự kiện khi con trỏ chuột hover vào thẻ input mobile
    document.getElementById('volume_value').addEventListener('touchstart', function() {
        hover = true;
        update = false;
    });
    // Bắt sự kiện khi con trỏ chuột rời khỏi thẻ input mobile
    document.getElementById('volume_value').addEventListener('touchend', function() {
        hover = false;
        update = true;
    });

    // Lắng nghe sự kiện message từ iframe con là multimedia
    window.addEventListener('message', function(event) {

        // Bắt sự kiện khi con trỏ chuột hover vào thẻ input
        document.getElementById('volume_value').addEventListener('mouseenter', function() {
            update = false; // Dừng cập nhật khi con trỏ chuột hover vào
            //console.log('Dừng cập nhật tự động');
        });
 
        // Bắt sự kiện khi con trỏ chuột rời khỏi thẻ input
        document.getElementById('volume_value').addEventListener('mouseleave', function() {
            update = true; // Cho phép cập nhật khi con trỏ chuột rời đi
            //console.log('Tiếp tục cập nhật tự động');
        });

        // Bắt sự kiện khi con trỏ chuột hover vào thẻ input trên mobile
        document.getElementById('volume_value').addEventListener('touchstart', function() {
            update = false; // Dừng cập nhật khi con trỏ chuột hover vào
            //console.log('Dừng cập nhật tự động');
        });

        // Bắt sự kiện khi con trỏ chuột rời khỏi thẻ input trên mobile
        document.getElementById('volume_value').addEventListener('touchend', function() {
            update = true; // Cho phép cập nhật khi con trỏ chuột rời đi
            //console.log('Tiếp tục cập nhật tự động');
        });

        // Xử lý dữ liệu nhận được
        var receivedData = event.data;

        if (!hover && update) {

            // Cập nhật giá trị âm lượng và hiển thị
            document.getElementById('volume_value').value = receivedData.volume;
            document.getElementById('volume_percentage').innerText = receivedData.volume;
        }

        //console.log(receivedData.volume);
    });
</script>

<script>
//Nút Mic
    var holdTimerMic;
    var isLongPressMic = false;

    function startTimerMic() {
        // Bắt đầu tính thời gian khi nút được nhấn
        holdTimerMic = setTimeout(function() {
            //console.log("Bạn đã nhấn giữ 3 giây");
			
            isLongPressMic = true; // Đánh dấu rằng người dùng đã nhấn giữ đủ lâu
            if (isLongPressMic) {
                wakeUpBotMic('long');
				alert("Đã thực thi tác vụ nhấn giữ Mic");
            }

        }, 3000); // Thời gian tính bằng mili giây (ở đây là 3 giây)
    }

    function stopTimerMic() {
        // Hủy tính thời gian khi nút được nhả ra
        clearTimeout(holdTimerMic);
    }

    function handleClickMic() {
        // Thực hiện hành động khi nhấn nút một lần
        if (!isLongPressMic) {
            wakeUpBotMic('short');
			//alert("Đã thực thi tác vụ nhấn nhả Mic");
        }
        // Đặt lại biến isLongPressMic về false sau khi nhấn nút
        isLongPressMic = false;
    }

    // Đánh thức bot
    function wakeUpBotMic(actionMic) {

        // Thực hiện các hành động cần thiết khi icon được nhấn
        // Ví dụ: Gửi yêu cầu AJAX để đánh thức Bot
        var settingsMic = {
            "url": "http://<?php echo $serverIP; ?>:<?php echo $Port_Vietbot; ?>",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            },
            "data": JSON.stringify({
                "type": 2,
                "data": "set_keypad",
                "keypad": "mic",
                "action": actionMic
            }),
        };

        $.ajax(settingsMic).done(function(response) {
            //console.log(response);
        });
    }
</script>
<script>
//Nút Tam Giác
    var holdTimer;
    var isLongPress = false;

    function startTimer() {
        // Bắt đầu tính thời gian khi nút được nhấn
        holdTimer = setTimeout(function() {
            //console.log("Bạn đã nhấn giữ 3 giây");
			
            isLongPress = true; // Đánh dấu rằng người dùng đã nhấn giữ đủ lâu
            if (isLongPress) {
                wakeUpBot('long');
				alert("Đã thực thi tác vụ nhấn giữ");
            }

        }, 3000); // Thời gian tính bằng mili giây (ở đây là 3 giây)
    }

    function stopTimer() {
        // Hủy tính thời gian khi nút được nhả ra
        clearTimeout(holdTimer);
    }

    function handleClick() {
        // Thực hiện hành động khi nhấn nút một lần
        if (!isLongPress) {
            wakeUpBot('short');
			//alert("Đã thực thi tác vụ nhấn nhả");
        }
        // Đặt lại biến isLongPress về false sau khi nhấn nút
        isLongPress = false;
    }

    // Đánh thức bot
    function wakeUpBot(action) {

        // Thực hiện các hành động cần thiết khi icon được nhấn
        // Ví dụ: Gửi yêu cầu AJAX để đánh thức Bot
        var settings = {
            "url": "http://<?php echo $serverIP; ?>:<?php echo $Port_Vietbot; ?>",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            },
            "data": JSON.stringify({
                "type": 2,
                "data": "set_keypad",
                "keypad": "wakeup",
                "action": action
            }),
        };

        $.ajax(settings).done(function(response) {
			
						if (response.response === "Đã kích hoạt nhấn phím Wakeup!") {
			    var audio = new Audio('assets/audio/ding.mp3');
				audio.volume = 1;
				audio.play();
				//console.log("oK");
			}
			
            //console.log(response);
        });
    }
</script>
</body>

</html>
