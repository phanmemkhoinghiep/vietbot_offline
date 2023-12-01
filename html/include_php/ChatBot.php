<?php
// Code By: Vũ Tuyển
// Facebook: https://www.facebook.com/TWFyaW9uMDAx
include "../Configuration.php";
?>
<!DOCTYPE html>
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
<?php	
if (isset($Web_UI_Login) && $Web_UI_Login === true) {
	if (!isset($_SESSION['root_id'])) {
		echo "<br/><center><h1>Có Vẻ Như Bạn Chưa Đăng Nhập!<br/><br>
		- Nếu Bạn Đã Đăng Nhập, Hãy Nhấn Vào Nút Dưới<br/><br/><a href='$PHP_SELF'><button type='button' class='btn btn-danger'>Tải Lại</button></a></h1>
		</center>";
		exit();
}
	include "Fork_PHP/ChatBot_.php";
	
	} else {
	   
	   include "Fork_PHP/ChatBot_.php";
	   
	   
	}
?>	
	
