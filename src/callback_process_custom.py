import asyncio
import libs
import global_vars
import constant
from a_text_process import text_process #Def a_text_process để xử lý text, trả về text và link nhạc
from b_stt_process import stt_process #Def a_stt_process trả về text từ luồng mic stream, tự custom
from c_tts_process import tts_process #Def b_tts_process trả về đường dẫn file mp3 gen ra từ text, tự custom
async def process(not_back_to_loop, loop_func, depth=0):
    """Xử lý chính."""
    if not not_back_to_loop:
        await loop_func(process)
        return

    if depth >= 10:
        libs.logging("left", "ĐÃ ĐẠT ĐẾN GIỚI HẠN LẶP", "red")
        libs.reboot_os()
        return

    if str(global_vars.player1.get_state()) != "State.Playing": #Trường hợp đang không phát nhạc
        libs.logging("left", "ĐÃ KÍCH HOẠT, CHỜ LỆNH", "green")
        global_vars.player2.play_sound('START')                        
        try:
            global_vars.led.set_state("THINK")
            data = stt_process(global_vars.mic_stream) #Lấy text từ STT với luồng stream từ Mic
            data=data.lower()
            libs.logging('right',data, 'green')  
        except Exception as e:
            libs.logging("left", f"Không nhận dạng được lệnh: {e}", "red")
            await loop_func(process)
            return
        answer = None
            answer = text_process(data)
            global_vars.last_answer = answer[0]
            libs.logging('left',answer[0], 'green')  
            if answer[1] is None: #Không có link nhạc, chỉ có text trả lời
                global_vars.player1.play_media(await tts_process(answer[0], True), True) #Phát câu trả lời
            else: #Có cả link nhạc
                global_vars.player1.play_media(await tts_process(answer[0], True), True) #Phát câu trả lời
                global_vars.player1.play_media(answer[1], False) #Sau đó phát link nhạc
        if global_vars.conversation:
            process(True,loop_func,depth+1)
        else:
            await loop_func(process)
            return
    if str(global_vars.player1.get_state()) == "State.Playing": #Trường hợp phát nhạc
        global_vars.player1.pause()
        libs.logging("left", "PLAYBACK MODE, ĐÃ KÍCH HOẠT, CHỜ LỆNH", "green")
        global_vars.player2.play_sound('START')                        
        try:
            global_vars.led.set_state("THINK")
            data = stt_process(global_vars.mic_stream)   #Lấy text từ STT với luồng stream từ Mic
            data=data.lower()
            libs.logging('right',data, 'green')              
        except Exception as e:
            libs.logging("left", f"Không nhận diện được lệnh: {e}", "red")
            global_vars.player1.pause()
            await loop_func(process)
            return
        answer = None
        answer = text_process(data)
        global_vars.last_answer = answer[0]
        libs.logging('left',answer[0], 'green')                
        if answer[1] is None: #Không có link nhạc, chỉ có text trả lời
            global_vars.player1.play_insert_media(await tts_process(answer[0], True))   #Phát chèn câu trả lời, sau đó phát tiếp link nhạc đang phát
        else: #Có cả link nhạc
            global_vars.player1.play_media(await tts_process(answer[0], True), True) #Phát câu trả lời
            global_vars.player1.play_media(answer[1], False) #Sau đó phát tiếp link nhạc

        await loop_func(process)
        return
