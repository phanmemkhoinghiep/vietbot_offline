import libs
import global_vars
import constant
from loop_process import loop,playback_loop
#STT
if constant.stt_mode=='stt_vietbot': #Chọn STT Vietbot
    from stt_process import stt_process    

elif constant.stt_mode=='stt_gg_free': #Chọn STT Google Free
    from gg_stt_process import stt_process          
    
elif constant.stt_mode=='stt_gg_cloud': #Chọn STT Google CLoud
    from gg_cloud_process import stt_process                  

#TTS
from tts_process import tts_process 

#Import Text process lib
try:
    if constant.user_level==1:
        from text_process import text_process #Sử dụng xử lý text mặc định
    elif constant.user_level==2:
        from custom_text_process import text_process ##Sử dụng xử lý text custom, tự code
except:
    from text_process import text_process        
 

async def process(not_back_to_loop): #Hàm xử lý khi không phát nhạc
    """Xử lý chính."""
    if not not_back_to_loop:
        await loop(process)
        return
    libs.logging("left", "ĐÃ KÍCH HOẠT, CHỜ LỆNH", "green")
    global_vars.player2.play_sound('START')                        
    try:
        global_vars.led.set_state("THINK")
        data = stt_process(global_vars.mic_stream) #Đọc text từ luồng stream thông qua STT
        data = data.lower()
        global_vars.last_request = data
    except Exception as e:
        libs.logging("left", f"Không nhận dạng được lệnh: {e}", "red")
        await loop(process)
        return   
    answer = None
    answer = text_process(data) #Trả về 2 giá trị, text và link
    global_vars.last_answer = answer[0]
    libs.logging('left', global_vars.last_answer, 'green')
    if answer[1] is None:
        global_vars.player1.play_media(await tts_process(answer[0], True), True)
        if global_vars.conversation:
            await process(True)
        else:
            await loop(process)
            return
    else:
        global_vars.player1.play_media(await tts_process(answer[0], True), True)
        global_vars.player1.play_media(answer[1], False)
        await playback_loop(playback_process)
        return
            
async def playback_process(not_back_to_loop):#Hàm xử lý khi đang phát nhạc
    if not not_back_to_loop:
        await playback_loop(playback_process)
        return
    global_vars.player1.pause()
    libs.logging("left", "PLAYBACK MODE, ĐÃ KÍCH HOẠT, CHỜ LỆNH", "green")
    global_vars.player2.play_sound('START')                        
    try:
        global_vars.led.set_state("THINK")
        data = stt_process(global_vars.mic_stream) #Đọc text từ luồng stream thông qua STT
        data = data.lower()
        global_vars.last_request = data
    except Exception as e:
        libs.logging("left", f"Không nhận diện được lệnh: {e}", "red")
        global_vars.player1.pause()
        await playback_loop(playback_process)
        return

    answer = None
    answer = text_process(data) #Trả về 2 giá trị, text và link
    global_vars.last_answer = answer[0]
    libs.logging('left', answer[0], 'green')
    if answer[1] is None:
        global_vars.player1.play_insert_media(await tts_process(answer[0], True))  #Chèn câu trả lời vào trước nhạc đang phát rồi phát         
    else:
        global_vars.player1.stop()
        global_vars.player1.play_media(await tts_process(answer[0], True), True) #Phát câu trả lời
        global_vars.player1.play_media(answer[1], False) #Phát nhạc mới
    await playback_loop(playback_process)
    return

