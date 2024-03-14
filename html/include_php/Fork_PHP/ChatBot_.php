<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
//include "../Configuration.php";
?>


<script src="../../assets/js/axios_0.21.1.min.js"></script>
 <link rel="stylesheet" href="../../assets/css/bootstrap-icons.css">
</head>

<body>
    <br/>
    <div class="chat-container">
        <div class="chat-wrapper">
            <div id="message-content" class="message-content">Chào <?php echo $MYUSERNAME; ?> mình là loa thông minh Vietbot!</div>
        </div>

        <div id="chatbox" class="container-fluid"></div>
        <form id="chat-form" class="chat-form">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    
				<!--	<span class="input-group-text" id="basic-addon1">Chỉ đọc: &nbsp;<input title="Chỉ đọc nội dung văn bản bạn đã nhập ra loa và sẽ không hiển thị trong giao diện chatbox" type="checkbox" class="form-check-input" id="message-type-checkbox">
					
					
					</span> -->
  <select id="message-type-checkbox" class="form-select">
  <option  selected value="3" title="Chế Độ Hỏi Đáp Ở Chatbox Không Phát Ra Loa">Hỏi Đáp</option>
  <option  value="2" title="Phát Nhạc, Podcast Ra Loa" data-podcastname="play_podcast">PodCast</option>
  <option value="1" title="TTS Chuyển Văn Bản Thành Giọng Nói Để Đọc Ra Loa">Chỉ Đọc</option>
</select>
                </div>
                <input type="text" class="form-control" id="user-input" class="chat-input" placeholder="Nhập văn bản, nội dung, tin nhắn..." aria-label="Recipient's username" aria-describedby="basic-addon2">


            
			  <div class="input-group-append">
                    <button type="submit" class="btn btn-success">Gửi</button>
                </div>
            </div>
        </form>

<center>
  <div class="btn-group-toggle chat-form-button" data-toggle="buttons">
  <label class="btn btn-secondary">
    <input type="checkbox" checked autocomplete="off" id="show-timestamp-checkbox"> Hiển thị thời gian
  </label>
  <button id="delete-all-button" class="btn btn-danger">Xóa tất cả tin nhắn</button>
</div></center>
    </div>
<script>
function getTimestamp() {
  const now = new Date();
  const hours = now.getHours().toString().padStart(2, '0');
  const minutes = now.getMinutes().toString().padStart(2, '0');
  const seconds = now.getSeconds().toString().padStart(2, '0');
  return `${hours}:${minutes}:${seconds}`;
}
  const RESPONSE_TIMEOUT = 23000; // Thời gian chờ phản hồi cuối (21 giây) để hiển thị thông báo
  const WAIT_MESSAGE_TIMEOUT = 7000; // Thời gian chờ hiển thị thông báo "Vui lòng chờ thêm" (7 giây)
  const WAIT_MESSAGE = 'Vui lòng chờ thêm...'; // Nội dung thông báo chờ phản hồi
  const TIMEOUT_MESSAGE = 'Có vẻ Vietbot đang không phản hồi, vui lòng thử lại!'; // Nội dung thông báo hết thời gian chờ
  const ERROR_MESSAGE_CONNECTION = 'Không kết nối được tới API Vietbot!';
  const chatbox = document.getElementById('chatbox');
  const chatForm = document.getElementById('chat-form');
  const userInput = document.getElementById('user-input');
  const deleteAllButton = document.getElementById('delete-all-button');
  const messageTypeCheckbox = document.getElementById('message-type-checkbox');
  let typingIndicator;
  let isBotReplying = false;
  let waitMessageTimer; // Biến đếm thời gian chờ hiển thị WAIT_MESSAGE
  let responseTimer; // Biến đếm thời gian chờ phản hồi
  chatForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    const userMessage = userInput.value;
    userInput.value = '';

    if (userMessage.trim() === '') {
      return;
    }
    // Lấy ra option được chọn trong select box của form
    const selectedOption = document.querySelector('#message-type-checkbox option:checked');
    // Kiểm tra xem option đã được chọn hay chưa
    if (selectedOption) {
        // Nếu option đã được chọn, kiểm tra xem có thuộc tính data-podcastname không
        const podcastName = selectedOption.getAttribute('data-podcastname');
        if (podcastName) {
            // Nếu có thuộc tính data-podcastname, hiển thị giá trị trong console.log
            //console.log('Data Podcast Name:', podcastName);
			userMessageee = podcastName;
        } else {
            // Nếu không có thuộc tính data-podcastname, thông báo lỗi hoặc thực hiện hành động khác tùy thuộc vào yêu cầu của bạn
            //console.log('Option được chọn nhưng không có thuộc tính data-podcastname.');
			userMessageee = userMessage;
			
        }
    } else {
        userMessageee = userMessage;
    }
	
    const messageType = parseInt(messageTypeCheckbox.value);
    // Kiểm tra kết nối tới API trước khi gửi yêu cầu để đưa ra thông báo
    try {
      const response = await axios.get('http://<?php echo $serverIP; ?>:<?php echo $Port_Vietbot; ?>');
      if (response.status === 200) {
        // Kết nối thành công, tiến hành gửi yêu cầu và xử lý câu trả lời
        displayMessage(userMessage, true);
        // Gửi yêu cầu tới API và xử lý câu trả lời như trước
        userInput.value = ''; // Xóa giá trị của userInput sau khi gửi
      }
    } catch (error) {
		displayMessage(userMessage, true);
      // Kết nối thất bại, hiển thị thông báo lỗi cho người dùng
     displayMessage(ERROR_MESSAGE_CONNECTION, false, true);
      return;
    }
	
///////////////////////////
    const url = 'http://<?php echo $serverIP; ?>:<?php echo $Port_Vietbot; ?>/';
    const headers = {
      Accept: '*/*',
      'Accept-Language': 'vi',
      'Content-Type': 'application/json',
    };
    const data = {
      type: messageType,
      //ChatBox + TTS
      data: userMessageee,
	  
	  //PodCasst
	  name: userMessage,
	  player_type: "system"
    };

    try {
      isBotReplying = true;
      typingIndicator = displayTypingIndicator();
      // Đặt thời gian hiển thị thông báo "Vui lòng chờ thêm..."
      waitMessageTimer = setTimeout(() => {
        if (isBotReplying) {
          displayMessage(WAIT_MESSAGE, false, true);
        }
      }, WAIT_MESSAGE_TIMEOUT);

      // Đặt thời gian hiển thị thông báo "Có vẻ Vietbot đang không phản hồi, vui lòng thử lại!"
      responseTimer = setTimeout(() => {
        if (isBotReplying) {
          displayMessage(TIMEOUT_MESSAGE, false, true);
          removeTypingIndicator();
          isBotReplying = false;
        }
	const waitMessageElement = chatbox.querySelector('.timeout-message');
      if (waitMessageElement) {
        waitMessageElement.remove();
      }
      }, RESPONSE_TIMEOUT);
      const response = await axios.post(url, data, { headers });
      clearTimeout(waitMessageTimer); // Xóa thông báo "Vui lòng chờ thêm..." nếu đã hiển thị
      clearTimeout(responseTimer); // Xóa thông báo "Có vẻ Vietbot đang không phản hồi, vui lòng thử lại!" nếu đã hiển thị
      isBotReplying = false;
      removeTypingIndicator();
      // Xóa thông báo "Vui lòng chờ thêm..." nếu tồn tại trong chatbox
      const waitMessageElement = chatbox.querySelector('.timeout-message');
      if (waitMessageElement) {
        waitMessageElement.remove();
      }
      // Kiểm tra xem giá trị response.data.answer có tồn tại hay không
	if (response.data.answer !== undefined && response.data.answer !== null) {
		displayMessage(response.data.answer, false);
	} else {
		// Nếu không tồn tại, sử dụng giá trị response.data.response
		const responseString = response.data.response.toString();
		if (responseString.includes("https://cdn-ocs.ivie")) {
	//loại bỏ dấu phẩy trước https
	const modifiedResponse = responseString.replace(/,?\bhttps:\/\/cdn-ocs.ivie.*?\.mp3\b/g, '');
    // Hiển thị giá trị đã chỉnh sửa
    //console.log(responseString);
// Tách chuỗi từ dấu phẩy
const parts = responseString.split(',');


// Kiểm tra xem có ít nhất một phần tử sau khi tách
if (parts.length > 0) {
    // Gán phần tử đầu tiên cho biến showlinkpodcast
    const showlinkpodcast = parts[1].trim(); // Lưu ý rằng ta lấy phần tử thứ hai ở đây

    // Hiển thị message kèm phần tử <i>
    displayMessage(parts[0] + " | <i class='bi bi-broadcast-pin' onclick='handleBroadcastPinClick()' data-namebaihatpodcast = '"+modifiedResponse+"' data-urlpodcast='" + showlinkpodcast + "' title='Phát nhạc Podcast'></i>", false);
} else {
    // Nếu không tìm thấy phần tử sau khi tách chuỗi, hiển thị message mà không có phần tử <i>
    displayMessage(modifiedResponse, false);
}
    //displayMessage(modifiedResponse+" <i class='bi bi-broadcast-pin' onclick='handleBroadcastPinClick()' data-urlpodcast='"+showlinkpodcast+"' title='Phát nhạc Podcast'></i>", false);
	// Sử dụng phương thức match() với biểu thức chính quy để tìm tất cả các kết quả khớp với mẫu "https"

//else {
    //console.log("Không tìm thấy bất kỳ link https nào trong nội dung.");
//}
	
} else {
	displayMessage(response.data.response, false);
    //console.error("response.data.response không phải là chuỗi.");
}
		//displayMessage(response.data.response, false);
		//console.log("okkkk string");
	}
    } catch (error) {
      console.error(error);
      // Hiển thị thông báo lỗi
	  //nếu sau 30 giây vẫn đang chờ câu trả lời từ API  thì nó sẽ coi đó là một trường hợp lỗi và thực hiện các hành động để thông báo về lỗi cho người dùng
      setTimeout(() => {
        if (isBotReplying) {
          isBotReplying = false;
          removeTypingIndicator();
          displayMessage('Lỗi!, sự cố không xác định', false, true);
        }
      }, 30000);
    }
  });


const showTimestampCheckbox = document.getElementById('show-timestamp-checkbox');
// Thêm một trình nghe sự kiện để xử lý sự thay đổi của ô kiểm
showTimestampCheckbox.addEventListener('change', () => {
  // Bật/tắt lớp 'hide-timestamp' trên khung chat dựa vào trạng thái của ô kiểm
  chatContainer.classList.toggle('hide-timestamp', !showTimestampCheckbox.checked);
});

  const displayMessage = (message, isUserMessage, isTimeoutMessage = false) => {
	  //console.log(message);
	  //Nếu Giá trị là undefined
	if (typeof message === 'undefined') {
		//message = 'Nội dung trả về không được xác định';
		message = displayMessage(response.data.response, false);
	    //return;
	}
	  //Nếu Giá trị là null
	if (message === "Lỗi: argument of type 'NoneType' is not iterable") {
		message = 'Không tìm thấy nội dung phù hợp!';
	    //return;
	}
	
	if (message === null) {
		message = 'Không nhận được dữ liệu trả về';
	    //return;
	}
	
    const messageElement = document.createElement('div');
    messageElement.classList.add('message');

    if (isUserMessage) {
      messageElement.classList.add('user-message');
    } else {
      messageElement.classList.add('bot-message');
    }


  const timestamp = getTimestamp(); // Lấy thời gian
  const messageContent = document.createElement('div');
  messageContent.classList.add('message-content');
   // Kiểm tra trạng thái của ô kiểm "show-timestamp-checkbox"
 if (showTimestampCheckbox.checked) {
	messageContent.innerHTML = `[${timestamp}] ${message}`; //  Thêm Hàm thời gian vào Chatbox khi được tích
  }else {
    messageContent.innerHTML = message; //nếu không được tích
  }
    const deleteButton = document.createElement('button');
    deleteButton.classList.add('delete-button');
    deleteButton.innerHTML = '&times;';
    deleteButton.addEventListener('click', () => {
      messageElement.remove();
    });

    messageElement.appendChild(messageContent);
    messageElement.appendChild(deleteButton);

    // Nếu là tin nhắn "Vui lòng chờ thêm", chèn phía dưới tin nhắn hiện tại
    if (isTimeoutMessage) {
      const currentMessages = chatbox.querySelectorAll('.message');
      const lastMessage = currentMessages[currentMessages.length - 1];
      if (lastMessage) {
        lastMessage.insertAdjacentElement('afterend', messageElement);
      } else {
        chatbox.appendChild(messageElement);
      }
    } else {
      chatbox.appendChild(messageElement);
    }

    chatbox.scrollTop = chatbox.scrollHeight;

    if (isTimeoutMessage) {
      messageElement.classList.add('timeout-message');
    }
  };
  const displayTypingIndicator = () => {
    const typingIndicator = document.createElement('div');
    typingIndicator.classList.add('typing-indicator');

    for (let i = 0; i < 3; i++) {
      const dot = document.createElement('span');
      typingIndicator.appendChild(dot);
    }

    chatbox.appendChild(typingIndicator);

    chatbox.scrollTop = chatbox.scrollHeight;

    return typingIndicator;
  };

  const removeTypingIndicator = () => {
    if (typingIndicator) {
      typingIndicator.remove();
    }

    chatbox.scrollTop = chatbox.scrollHeight;
  };

  deleteAllButton.addEventListener('click', () => {
    chatbox.innerHTML = '';
  });
  </script>
  
 <script>
 //Phát nhạc podcast khi nahans vào icon
    function handleBroadcastPinClick() {
        // Lấy giá trị của thuộc tính dữ liệu 'data-urlpodcast' của phần tử
        var urlPodcast = document.querySelector('.bi-broadcast-pin').dataset.urlpodcast;
        var tetxNamePodcast = document.querySelector('.bi-broadcast-pin').dataset.namebaihatpodcast;
//console.log(urlPodcast);
// Định nghĩa URL và dữ liệu
const url = "http://<?php echo $serverIP; ?>:<?php echo $Port_Vietbot; ?>/";
const data = {
  type: 2,
  data: "play_music",
  link_type: "direct",
  link: urlPodcast
};

// Gửi yêu cầu AJAX sử dụng Axios
axios.post(url, data, {
  headers: {
    'Content-Type': 'application/json'
  },
  timeout: 0
})
.then(function (response) {
  if (response.data.state === "Success") {
	state_replace_podcast = response.data.state.replace("Success", "Đã phát Podcast: <b>" +tetxNamePodcast+ "</b>");
    displayMessage(state_replace_podcast, false);
  } else {
    displayMessage(response.data.state);
  }
  
})
.catch(function (error) {
  // Xử lý lỗi nếu có
  console.error(error);
});
    }
</script>



</body>
</html>
