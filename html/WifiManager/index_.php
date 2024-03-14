<!--
Code By: Vũ Tuyển
Facebook: https://www.facebook.com/TWFyaW9uMDAx
-->

<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/css/bootstrap-icons.css">
	<link rel="stylesheet" href="../assets/css/loading.css">
    <style>
        body,
        html {
            background-color: #d2d8bb;
          /*  overflow-x: hidden;
             Ẩn thanh cuộn ngang */
            
            max-width: 100%;
            /* Ngăn cuộn ngang trang */
        }
            ::-webkit-scrollbar {
        width: 13px;
    }
    
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        -webkit-border-radius: 10px;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        -webkit-border-radius: 10px;
        border-radius: 10px;
        background: rgb(251, 255, 7);
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
    }
		</style>
		  <script src="../assets/js/ajax_jquery_3.6.0_jquery.min.js"></script>
</head>
<body><br/>
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
<center>
<!-- <button onclick="getWifiInfo()">Lấy thông tin Wi-Fi</button> -->
<div id="wifiInfoResult"></div>


<button id="loadWifiButton" class="btn btn-primary">Danh Sách Wifi Đã Kết Nối</button>
<button id="scanWifiButton" class="btn btn-secondary">Quét Mạng Wifi</button>
<a href="index.php"><button type="submit" class="btn btn-danger">Làm Mới</button></a>
</center>
<hr/>
<div id="hienthiketqua"></div>

<!-- ... -->
<script>
    function getWifiInfo() {
        $.ajax({
            type: "GET",
            url: "get_wifi_list.php", // Đường dẫn đến tập tin PHP xử lý
            data: {
                action: 'get_wifi_info'
            },
            success: function(data) {
                $("#wifiInfoResult").html(data); // Hiển thị kết quả trong div có id là wifiInfoResult
            },
            error: function() {
                alert("Đã có lỗi xảy ra trong quá trình lấy dữ liệu Wi-Fi.");
            }
        });
    }

    getWifiInfo();

    $(document).ready(function() {
        // Bắt sự kiện khi nút "Load WiFi List" được nhấn
        $("#loadWifiButton").click(function() {
            loadWifiList();
        });

        // Bắt sự kiện khi nút "Scan WiFi Networks" được nhấn
        $("#scanWifiButton").click(function() {
            scanWifiNetworks();
        });

        // Hàm để tải danh sách WiFi
        function loadWifiList() {
            $('#loading-overlay').show();
            $.ajax({
                url: 'get_wifi_list.php',
                type: 'GET',
                data: {
                    action: 'get_data'
                },
                success: function(response) {
                    $("#hienthiketqua").html(response);
                    attachDeleteHandlers(); // Gắn sự kiện xóa sau khi tải danh sách
                    attachConnectHandlers(); // Gắn sự kiện kết nối sau khi tải danh sách
                    attachKetNoiWiFiDaLuu();
                    attachShowPass();
                    $('#loading-overlay').hide();
                }
            });
        }

        // Hàm để quét mạng WiFi xung quanh
        function scanWifiNetworks() {
            $('#loading-overlay').show();
            $.ajax({
                url: 'get_wifi_list.php',
                type: 'GET',
                data: {
                    action: 'scan_wifi'
                },
                success: function(response) {
                    $("#hienthiketqua").html(response);
                    attachConnectHandlers(); // Gắn sự kiện kết nối sau khi quét mạng WiFi
                    attachDeleteHandlers();
                    attachShowPass();
                    $('#loading-overlay').hide();
                }
            });
        }

        // Hàm để gắn sự kiện xóa cho các nút xóa
        function attachDeleteHandlers() {
            $(".delete-button").click(function() {
                var wifiName = $(this).data('wifi-name');
                deleteWifi(wifiName);
            });
        }

        // Hàm để xóa WiFi
        function deleteWifi(wifiName) {
            // Sử dụng hộp thoại xác nhận
            var confirmDelete = confirm('Bạn có chắc chắn muốn xóa mạng WiFi "' + wifiName + '" không?');
            // Kiểm tra xem người dùng đã xác nhận xóa hay không
            if (confirmDelete) {
                $('#loading-overlay').show();
                $.ajax({
                    url: 'delete_wifi.php',
                    type: 'POST',
                    data: {
                        action: 'delete_wifi',
                        wifiName: wifiName
                    },
                    success: function(response) {
                        // Sau khi xóa, tải lại danh sách WiFi
                        loadWifiList();
                        $('#loading-overlay').hide();
                    }
                });
            }
            //else {
            // Người dùng đã hủy xác nhận xóa
            //alert('Xóa mạng WiFi đã được hủy.');
            //}
        }

        //Hiển thị mật khẩu
        function attachShowPass() {
            $(".show-matkhau").click(function() {
                var wifiName = $(this).data('wifi-name');
                passWifi(wifiName);
            });
        }

        // Hàm để hiển thị mật khẩu
        function passWifi(wifiName) {
            //console.log(wifiName);
            // Sử dụng hộp thoại xác nhận
            $('#loading-overlay').show();
            $.ajax({
                url: 'get_wifi_list.php',
                type: 'GET',
                data: {
                    action: 'get_password',
                    ssid: wifiName
                },
                success: function(response) {

                    $("#showPassWifi").html(response);

                    //alert(response);
                    $('#loading-overlay').hide();
                }
            });

            //else {
            // Người dùng đã hủy xác nhận xóa
            //alert('Xóa mạng WiFi đã được hủy.');
            //}
        }

        function attachKetNoiWiFiDaLuu() {

            $(".connect-wifi-da-luu").click(function() {
                var wifiName = $(this).data('wifi-name');
                connectWWifiDaLUU(wifiName);
            });
        }

        // Hàm để kết nối wifi đã lưu
        function connectWWifiDaLUU(wifiName) {
            $('#loading-overlay').show();

            // Thiết lập thời gian chờ là 30 giây (30000 milliseconds)
            var timeout = setTimeout(function() {
                alert('Hết thời gian chờ, hãy kiểm tra thiết bị ở kết nối wifi mới. Và khởi động lại thiết bị');
                $('#loading-overlay').hide();
            }, 35000);

            $.ajax({
                url: 'connect_wifi.php',
                type: 'POST',
                data: {
                    action: 'connect_wifi',
                    wifiName: wifiName
                },
                success: function(response) {
                    // Hủy bỏ thời gian chờ khi có phản hồi
                    clearTimeout(timeout);
                    if (response.indexOf("Connection successfully activated") !== -1) {
                        // Nếu chuỗi trả về có chứa "Connection successfully activated"
                        loadWifiList();
                        alert('Kết nối tới wifi "' + wifiName + '" thành công!');
                        getWifiInfo();
                    } else {
                        alert(response);
                        // console.log(response);
                    }
                    $('#loading-overlay').hide();
                }
            });
        }

        // Hàm để gắn sự kiện kết nối cho các nút kết nối
        function attachConnectHandlers() {
            $(".connect-end-save-button").click(function() {
                var ssid = $(this).data('wifi-ssid');
                var security = $(this).data('wifi-security');
                connectWifi(ssid, security);
            });
        }

        // Hàm để kết nối WiFi
        function connectWifi(ssid, security) {
            var baomat = security;
            // console.log(baomat);

            // Kiểm tra nếu biến baomat là null
            if (baomat === "") {
                // Sử dụng confirm thay vì prompt
                var confirmConnect = confirm('Mạng Không Được Bảo Mật\n Bạn có chắc chắn muốn kết nối tới mạng "' + ssid + '" không?');

                if (confirmConnect) {
                    // Thực hiện kết nối khi người dùng chọn OK
                    var password = "";
                    $('#loading-overlay').show();

                    // Thiết lập thời gian chờ là 30 giây (30000 milliseconds)
                    var timeout = setTimeout(function() {
                        alert('Hết thời gian chờ, hãy kiểm tra thiết bị ở kết nối wifi mới. Và khởi động lại thiết bị');
                        $('#loading-overlay').hide();
                    }, 40000);

                    $.ajax({
                        url: 'connect_wifi.php',
                        type: 'POST',
                        data: {
                            action: 'connect_and_save_wifi',
                            ssid: ssid,
                            password: password
                        },
                        success: function(response) {
                            // Hủy bỏ thời gian chờ khi có phản hồi
                            clearTimeout(timeout);
                            if (response.indexOf("Error: Connection activation failed: (7) Secrets were required") === 0) {
                                alert('Kết nối thất bại, mật khẩu không đúng hoặc thông tin bảo mật không đầy đủ.');
                            } else if (response.indexOf("successfully activated") !== -1) {
                                alert('Kết nối tới wifi ' + ssid + ' thành công.');
                                getWifiInfo();
                            } else {
                                alert(response);
                                // console.log(response);
                            }
                            $('#loading-overlay').hide();
                        }
                    });
                }
                //else {
                // Người dùng đã chọn Cancel trong confirm
                //alert('Bạn đã hủy bỏ kết nối.');
                //}
            } else if (baomat === "wifi_hidden") {

                // Hiển thị hộp thoại prompt để nhập tài khoản
                var tenwifian = prompt("Nhập tên Wifi:");

                // Kiểm tra nếu người dùng đã nhập tên tài khoản
                if (tenwifian !== null) {
                    // Hiển thị hộp thoại prompt để nhập mật khẩu
                    var matkhauan = prompt("Nhập mật khẩu Wifi:");

                    // Kiểm tra nếu người dùng đã nhập mật khẩu
                    if (matkhauan !== null) {
                        // Hiển thị thông báo với tên tài khoản và mật khẩu
                        //alert("Bạn đã nhập:\nTài khoản: " + tenwifian + "\nMật khẩu: " + matkhauan);
                        $('#loading-overlay').show();
                        // Thiết lập thời gian chờ là 30 giây (30000 milliseconds)
                        var timeout = setTimeout(function() {
                            alert('Hết thời gian chờ, hãy kiểm tra thiết bị ở kết nối wifi mới. Và khởi động lại thiết bị');
                            $('#loading-overlay').hide();
                        }, 40000);
                        $.ajax({
                            url: 'connect_wifi.php',
                            type: 'POST',
                            data: {
                                action: 'connect_and_save_wifi',
                                ssid: tenwifian,
                                password: matkhauan
                            },
                            success: function(response) {
                                // Hủy bỏ thời gian chờ khi có phản hồi
                                clearTimeout(timeout);
                                if (response.indexOf("Error: Connection activation failed: (7) Secrets were required") === 0) {
                                    alert('Kết nối thất bại, kiểm tra lại tên wifi và mật khẩu');
                                } else if (response.indexOf("successfully activated") !== -1) {
                                    alert('Kết nối tới wifi ẩn: "' + tenwifian + '" thành công.');
                                    getWifiInfo();
                                } else {
                                    alert(response);
                                    // console.log(response);
                                }
                                $('#loading-overlay').hide();
                            }
                        });
                    }
                    //else {
                    //alert("Bạn đã hủy nhập mật khẩu.");
                    //}
                }
                //else {
                //alert("Bạn đã hủy nhập tài khoản.");
                //}
            } else {
                // Biến baomat không phải là null, sử dụng prompt như bình thường
                var password = prompt('Nhập mật khẩu cho mạng ' + ssid + ':');

                // Kiểm tra nếu người dùng đã nhập mật khẩu
                if (password !== null) {
                    if (password.length >= 8 && password.length <= 32) {
                        $('#loading-overlay').show();
                        // Thiết lập thời gian chờ là 30 giây (30000 milliseconds)
                        var timeout = setTimeout(function() {
                            alert('Hết thời gian chờ, hãy kiểm tra thiết bị ở kết nối wifi mới. Và khởi động lại thiết bị');
                            $('#loading-overlay').hide();
                        }, 40000);
                        $.ajax({
                            url: 'connect_wifi.php',
                            type: 'POST',
                            data: {
                                action: 'connect_and_save_wifi',
                                ssid: ssid,
                                password: password
                            },
                            success: function(response) {
                                // Hủy bỏ thời gian chờ khi có phản hồi
                                clearTimeout(timeout);
                                if (response.indexOf("Error: Connection activation failed: (7) Secrets were required") === 0) {
                                    alert('Kết nối thất bại, mật khẩu không đúng hoặc thông tin bảo mật không đầy đủ.');
                                } else if (response.indexOf("successfully activated") !== -1) {
                                    alert('Kết nối tới wifi "' + ssid + '" thành công.');
                                    getWifiInfo();
                                } else {
                                    alert(response);
                                    // console.log(response);
                                }
                                $('#loading-overlay').hide();
                            }
                        });
                    } else {
                        alert('Mật khẩu phải từ 8 đến 32 ký tự.');
                    }
                }
                //else {
                //alert('Bạn đã hủy bỏ việc nhập mật khẩu.');
                // }
            }
        }
    });
</script>
<!-- ... -->


</body>
</html>
