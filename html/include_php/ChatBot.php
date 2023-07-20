<?php
//Code By: Vũ Tuyển
//Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../Configuration.php";
?>
<!-- Code By: Vũ Tuyển
Facebook: https://www.facebook.com/TWFyaW9uMDAx  -->
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $MYUSERNAME; ?> ChatBot</title>
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <style>
    body {
      display: flex;
      justify-content: center;
   /*   align-items: center; */
    /*  height: 100vh;*/  
    background-color: #d2d8bb;
    }

    .chat-container {
      max-width: 70%;
      width: 550px;
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
      padding: 10px;
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
      0% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
      100% { transform: translateY(0); }
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
      background-color: #ffc107;
      font-style: italic;
    }
.chat-wrapper {
  background-color: #f0f0f0;
  padding: 10px;
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
    <div id="chatbox" class="container-fluid">
	
	</div>

    <form id="chat-form" class="chat-form">


<div class="input-group mb-3">
 <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Chỉ đọc: &nbsp;<input title="Chỉ đọc nội dung văn bản bạn đã nhập ra loa và sẽ không hiển thị trong dao diện chatbox" type="checkbox" class="form-check-input" id="message-type-checkbox"></span>
  </div>


 <input type="text" class="form-control" id="user-input" class="chat-input" placeholder="Nhập tin nhắn..." aria-label="Recipient's username" aria-describedby="basic-addon2">
  <div class="input-group-append">
   <button type="submit" class="btn btn-success">Gửi</button>
  </div>
</div>
 
	  
    </form>
    <button id="delete-all-button" class="btn btn-danger">Xóa tất cả tin nhắn</button>
  </div>

  <script>
    const chatbox = document.getElementById('chatbox');
    const chatForm = document.getElementById('chat-form');
    const userInput = document.getElementById('user-input');
    const deleteAllButton = document.getElementById('delete-all-button');
    const messageTypeCheckbox = document.getElementById('message-type-checkbox');

    let isBotReplying = false;

    chatForm.addEventListener('submit', async (event) => {
      event.preventDefault();

      const userMessage = userInput.value;
      userInput.value = '';

      if (userMessage.trim() === '') {
        return;
      }

      const messageType = messageTypeCheckbox.checked ? 1 : 2;

      displayMessage(userMessage, true);

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
    displayTypingIndicator();

    const response = await axios.post(url, data, { headers });

    isBotReplying = false;
    removeTypingIndicator();

    displayMessage(response.data.answer, false);
  } catch (error) {
    console.error(error);

    // Hiển thị tin nhắn lỗi khi không kết nối được tới server trong vòng 10 giây
    setTimeout(() => {
      if (isBotReplying) {
        isBotReplying = false;
        removeTypingIndicator();
        displayMessage('Lỗi! không kết nối được tới loa thông minh Vietbot, hãy đảm bảo loa đang hoạt động', false);
      }
    }, 12000);
  }
});
    const displayMessage = (message, isUserMessage, isTimeoutMessage = false) => {
      const messageElement = document.createElement('div');
      messageElement.classList.add('message');

      if (isUserMessage) {
        messageElement.classList.add('user-message');
      } else {
        messageElement.classList.add('bot-message');
      }

      const messageContent = document.createElement('div');
      messageContent.classList.add('message-content');
      messageContent.textContent = message;

      const deleteButton = document.createElement('button');
      deleteButton.classList.add('delete-button');
      deleteButton.innerHTML = '&times;';
      deleteButton.addEventListener('click', () => {
        messageElement.remove();
      });

      messageElement.appendChild(messageContent);
      messageElement.appendChild(deleteButton);
      chatbox.appendChild(messageElement);

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
    };

    const removeTypingIndicator = () => {
      const typingIndicator = document.querySelector('.typing-indicator');
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
