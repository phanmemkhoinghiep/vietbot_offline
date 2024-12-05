import asyncio
import libs
import global_vars
import constant
from loop_process import loop,playback_loop
#STT
if constant.stt_mode=='vietbot':
    from stt_process import stt_process    

elif constant.stt_mode=='gSTT':
    from tts_process import gg_stt_process          
    
elif constant.stt_mode=='gg_cloud':
    from tts_process import ggcloud_stt_process          

#TTS
from tts_process import tts_process 

#Import Text process lib
try:
    if constant.user_level==1:
        from text_process import text_process #Data Process                   
    elif constant.user_level==2:
        from custom_text_process import text_process #Data Process    
except:
    from text_process import text_process        
 

async def process(not_back_to_loop):
    """Xử lý chính."""
    # Kiểm tra kiểu của depth
    if not not_back_to_loop:
        await loop(process)
        return
    if depth >= 10:
        libs.logging("left", "ĐÃ ĐẠT ĐẾN GIỚI HẠN LẶP", "red")
        libs.reboot_os()
        return
    libs.logging("left", "ĐÃ KÍCH HOẠT, CHỜ LỆNH", "green")
    global_vars.player2.play_sound('START')                        
    try:
        global_vars.led.set_state("THINK")
        data = stt_process(global_vars.mic_stream)
        data = data.lower()
        global_vars.last_request = data
    except Exception as e:
        libs.logging("left", f"Không nhận dạng được lệnh: {e}", "red")
        await loop(process)
        return   
    answer = None
    answer = text_process(data)
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
            
async def playback_process(not_back_to_loop):
    if not not_back_to_loop:
        await playback_loop(playback_process)
        return
    global_vars.player1.pause()
    libs.logging("left", "PLAYBACK MODE, ĐÃ KÍCH HOẠT, CHỜ LỆNH", "green")
    global_vars.player2.play_sound('START')                        
    try:
        global_vars.led.set_state("THINK")
        data = stt_process(global_vars.mic_stream)
        data = data.lower()
        global_vars.last_request = data
    except Exception as e:
        libs.logging("left", f"Không nhận diện được lệnh: {e}", "red")
        global_vars.player1.pause()
        await playback_loop(playback_process)
        return

    answer = None
    answer = text_process(data)
    global_vars.last_answer = answer[0]
    libs.logging('left', answer[0], 'green')
    if answer[1] is None:
        global_vars.player1.play_insert_media(await tts_process(answer[0], True))           
    else:
        global_vars.player1.stop()
        global_vars.player1.play_media(await tts_process(answer[0], True), True)
        global_vars.player1.play_media(answer[1], False)
    await playback_loop(playback_process)
    return

