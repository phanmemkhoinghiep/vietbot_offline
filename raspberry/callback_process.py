from lib_process import asyncio, print_out,random,reboot_os, global_vars, constant,re
from loop_process import loop,playback_loop
#STT
if constant.stt_mode=='stt_vietbot':
    from stt_process import stt_process    

elif constant.stt_mode=='stt_gg_free':
    from gg_stt_process import stt_process          
    
elif constant.stt_mode=='stt_gg_cloud':
    from ggcloud_stt_process import stt_process          

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
 

 

async def process(not_back_to_loop, depth=0):
    """Xử lý chính."""
    # Kiểm tra kiểu của depth
    if not not_back_to_loop:
        await loop(process)
        return
    print_out("left", "ĐÃ KÍCH HOẠT, CHỜ LỆNH", "cyan")
    global_vars.player2.play_sound('START')                        
    try:
        global_vars.led.set_state("THINK")
        data = await stt_process()
        print_out('right','HUMAN: '+data,'magenta')
        if not data.strip():
            # Ghi log và gọi các lệnh khác khi data là chuỗi rỗng
            print_out("left", "Không nhận dạng được lệnh: Không nói gì", "red")
            await loop(process)
            return
        data = data.lower()
        global_vars.last_request = data
    except Exception as e:
    answer = None
    try:
        # Xử lý câu trả lời
        answer = text_process(data)
        global_vars.last_answer = answer[0]
        print_out('left', answer[0], 'green')
        # Xử lý câu trả lời
        if answer[1] is None:
            global_vars.player1.play_media(await tts_process(answer[0], True), True)
            if global_vars.conversation:
                await process(True,depth=depth+1)
            else:
                await loop(process)
                return
        global_vars.player1.play_media(await tts_process(answer[0], True), True)
        global_vars.player1.play_media(answer[1], False)
        await playback_loop(playback_process)
        return
    except Exception as e:
        print_out("left", f"Lỗi xử lý text process: {e}", "red")
        await loop(process)
        return                    
async def playback_process(not_back_to_loop):
    if not not_back_to_loop:
        await playback_loop(playback_process)
        return
    global_vars.player1.pause()
    print_out("left", "PLAYBACK MODE, ĐÃ KÍCH HOẠT, CHỜ LỆNH", "cyan")
    global_vars.player2.play_sound('START')                        
    try:
        global_vars.led.set_state("THINK")
        data = await stt_process()
        print_out('right','HUMAN: '+data,'magenta')
        if not data.strip():
            # Ghi log và gọi các lệnh khác khi data là chuỗi rỗng
            print_out("left", "Không nhận dạng được lệnh: Không nói gì", "red")
            global_vars.player1.pause()
            await playback_loop(playback_process)
            return
        data = data.lower()
        global_vars.last_request = data
    except Exception as e:
        # print_out("left", f"Không nhận dạng được lệnh: {e}", "red")
        print_out("left", f"Không nhận dạng được lệnh", "red")
        global_vars.player1.pause()
        await playback_loop(playback_process)
        return
    answer = None
    try:
        # Xử lý câu trả lời
        answer = text_process(data)
        global_vars.last_answer = answer[0]
        print_out('left', answer[0], 'green')
        if answer[1] is None:
            global_vars.player1.play_insert_media(await tts_process(answer[0], True))           
        global_vars.player1.stop()
        global_vars.player1.play_media(await tts_process(answer[0], True), True)
        global_vars.player1.play_media(answer[1], False)
        await playback_loop(playback_process)
        return
    except Exception as e:
        print_out("left", f"Lỗi xử lý text process: {e}", "red")
        await playback_loop(playback_process)
        return        
