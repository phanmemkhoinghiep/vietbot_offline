<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../Configuration.php";
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $MYUSERNAME; ?> ChatBot</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<!-- CSS styles for the chat interface -->
<style>
    body {
        display: flex;
        justify-content: center;
        /*   align-items: center; */
        /*  height: 100vh;*/
        
        background-color: #d2d8bb;
		 
    }
    
        .chat-container {
            max-width: 100%;
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 70vh;
        }
    #chatbox {
        flex-grow: 1;
        overflow-y: auto;
        padding: 10px;
        overflow-x: hidden;
        z-index: 0;
    }
    
    .chat-form {
        display: flex;
      /*  padding: 10px; */ 
       background-color: #f0f0f0;
    }
        .chat-form-button {
		padding-bottom: 10px; 
        background-color: #f0f0f0;
    }
    .chat-input {
        flex-grow: 1;
        margin-right: 10px;
    }
    
    .chat-submit {
        flex-shrink: 0;
    }
    
    .message {
        display: flex;
        justify-content: flex-start;
        position: relative;
    }
    
    .user-message {
        justify-content: flex-end;
    }
    
    .message-content {
        padding: 5px;
        margin: 5px;
        border-radius: 5px;
    }
    
    .user-message .message-content {
        background-color: #89b8e7;
    }
    
    .bot-message .message-content {
        background-color: #cfbaba;
    }
    
    .typing-indicator {
        display: flex;
        align-items: center;
        margin: 5px;
        font-style: italic;
        color: gray;
    }
    
    .typing-indicator span {
        display: inline-block;
        margin-right: 5px;
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background-color: gray;
        animation: jump 1s infinite;
    }
    
    @keyframes jump {
        0% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-5px);
        }
        100% {
            transform: translateY(0);
        }
    }
    
    .delete-button {
        position: absolute;
        top: 50%;
        right: -20px;
        transform: translateY(-50%);
        background-color: transparent;
        border: none;
        outline: none;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    
    .delete-all-button {
        background-color: transparent;
        border: none;
        outline: none;
        cursor: pointer;
        margin-left: 10px;
    }
    
    .message:hover .delete-button,
    .delete-all-button:hover {
        opacity: 1;
    }
    
    .timeout-message {
        /*  background-color: #ffc107; */
        
        font-style: italic;
    }
    
    .chat-wrapper {
        background-color: #f0f0f0;
     /*   padding: 10px; */
    }
    
    .message-content {
        padding: 5px;
        margin: 5px;
        border-radius: 5px;
        background-color: #cfbaba;
        text-align: center;
    }
    
    @media (max-width: 768px) {
        .chat-container {
            max-width: 100%;
            width: 100%;
            height: 100vh;
            border-radius: 0;
        }
        #chatbox {
            height: calc(100vh - 110px);
        }
        .chat-form {
            flex-direction: column;
            padding: 5px;
            background-color: #f0f0f0;
        }
        .chat-input {
            margin-right: 0;
            margin-bottom: 5px;
        }
        .chat-submit {
            margin-top: 5px;
        }
        .delete-all-button {
            margin-top: 5px;
            margin-left: 0;
        }
    }
</style>
<script src="../assets/js/axios_0.21.1.min.js"></script>
</head>

<body>
    <br/>
    <div class="chat-container">
        <div class="chat-wrapper">
            <div id="message-content" class="message-content">Chào bạn mình là loa thông minh Vietbot!</div>
        </div>
		<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['root_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập (index.php)
    //header("Location: ./index.php");
	echo "<br/><center><h1>Có Vẻ Như Bạn Chưa Đăng Nhập!<br/><br>
	- Nếu Bạn Đã Đăng Nhập, Hãy Nhấn Vào Nút Dưới<br/><br/><a href='$PHP_SELF'><button type='button' class='btn btn-danger'>Tải Lại</button></a></h1>
	</center>";
    exit();
}
?>
        <div id="chatbox" class="container-fluid"></div>
        <form id="chat-form" class="chat-form">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    
				<!--	<span class="input-group-text" id="basic-addon1">Chỉ đọc: &nbsp;<input title="Chỉ đọc nội dung văn bản bạn đã nhập ra loa và sẽ không hiển thị trong giao diện chatbox" type="checkbox" class="form-check-input" id="message-type-checkbox">
					
					
					</span> -->
  <select id="message-type-checkbox" class="form-select">
  <option  selected value="4" title="Chế Độ Hỏi Đáp Ở Chatbox Không Phát Ra Loa">Hỏi Đáp</option>
  <option value="1" title="TTS Chuyển Văn Bản Thành Giọng Nói Để Đọc Ra Loa">Chỉ Đọc</option>
  <option value="2" title="Full Chức Năng">Full</option>
</select>
                </div>
                <input type="text" class="form-control" id="user-input" class="chat-input" placeholder="Nhập tin nhắn..." aria-label="Recipient's username" aria-describedby="basic-addon2">


            
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
	//1 = tts, 4 = hỏi đáp
    //const messageType = messageTypeCheckbox.checked ? 1 : 4;
	//parseInt chuyển đổi giá trị thành một số nguyên (integer) không nằm trong dấu nháy
    const messageType = parseInt(messageTypeCheckbox.value);

	   // Hiển thị giá trị đã chọn và giá trị đã nhập trong console
   // console.log("Giá trị đã chọn là: " + messageType);
    // console.log("Tin nhắn của người dùng là: " + userMessage);
	
    // Kiểm tra kết nối tới API trước khi gửi yêu cầu để đưa ra thông báo
    try {
      const response = await axios.get('http://<?php echo $serverIP; ?>:5000');
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
    const url = 'http://<?php echo $serverIP; ?>:5000/';
    const headers = {
      Accept: '*/*',
      'Accept-Language': 'vi',
      Connection: 'keep-alive',
      'Content-Type': 'application/json',
      DNT: '1',
      Origin: 'http://<?php echo $serverIP; ?>:5000',
      Referer: 'http://<?php echo $serverIP; ?>:5000/',
      'User-Agent':
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
    };
    const data = {
      type: messageType,
      data: userMessage,
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
      displayMessage(response.data.answer, false);
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
	  
	  //Nếu Giá trị là undefined
	if (typeof message === 'undefined') {
		message = 'Nội dung đã được đọc ra loa';
	    //return;
	}
	  //Nếu Giá trị là null
	if (message === null) {
		message = 'Không có dữ liệu';
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
  //const timestampElement = document.createElement('div');
 // timestampElement.classList.add('message-timestamp');
  //timestampElement.textContent = `[${timestamp}]`; // Bao gồm thời gian


  const messageContent = document.createElement('div');
  messageContent.classList.add('message-content');
   // Kiểm tra trạng thái của ô kiểm "show-timestamp-checkbox"
 if (showTimestampCheckbox.checked) {
	messageContent.textContent = `[${timestamp}] ${message}`; //  Thêm Hàm thời gian vào Chatbox khi được tích
  }else {
    messageContent.textContent = message; //nếu không được tích
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
</body>
</html>
