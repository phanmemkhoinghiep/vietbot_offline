from quart import Quart, request, Response
from libs import asyncio, json
import global_vars
import constant
#TTS
from tts_process import tts_process  
# Import các module xử lý văn bản theo cấp độ người dùng
try:
    if constant.user_level == 1:
        from text_process import text_process  # Data Process
    elif constant.user_level == 2:
        from ai_text_process import text_process  # Data Process
    elif constant.user_level == 3:
        from custom_text_process import text_process  # Data Process
except:
    from text_process import text_process

def custom_jsonify(data, status=200):
    """Custom jsonify with ensure_ascii=False."""
    return Response(
        response=json.dumps(data, ensure_ascii=False),
        status=status,
        content_type="application/json; charset=utf-8" 
    )
# Khởi tạo ứng dụng Quart
app = Quart(__name__)

@app.route('/', methods=['GET'])
async def get_process():
    try:
        data = request.args.get('data')
        if data == 'bot_state':
            return custom_jsonify({
                'status': 'OK',
                'bot_current_version': global_vars.bot_info[0],
                'bot_latest_version': global_vars.bot_info[1],
                'ui_latest_version': global_vars.bot_info[3],
                'running_times': global_vars.bot_info[4],
                'serial': global_vars.bot_info[6],
                'hostname': global_vars.bot_info[9],
                "use_aio_board": global_vars.use_aio_board,
                'bot_state': global_vars.bot_state,
                'conversation_state': global_vars.conversation,
                'last_request': global_vars.last_request,
                'last_answer': global_vars.last_answer,
                'last_hotword_use': global_vars.last_hotword_use,                
                'volume': global_vars.player1.volume_get_sys(),
                'mic_block': global_vars.mic_block,
                "player": {
                 'player_state':global_vars.player1.get_state(),
                 'media_info':global_vars.player1.get_media()                 
                }
                })
        else:
            return custom_jsonify({'status': 'Failed', 'error': 'data không đúng'})
    except Exception as e:
        # return custom_jsonify({'status': 'Failed', 'error': str(e)})
        return custom_jsonify({'status': 'Failed', 'error': 'Cấu trúc request không đúng'})

@app.route('/', methods=['POST'])
async def post_process():
    payload = await request.get_json()
    try:
        data = payload['data'].lower()
        api_type = int(payload['type'])

        if api_type == 1:
            if str(global_vars.player1.get_state()) == 'State.Playing':
                global_vars.player1.pause()
                await asyncio.create_task(global_vars.play_insert_media(await tts_process(data, True)))
            else:
                await asyncio.create_task(global_vars.play_insert_media(await tts_process(data, True)))
            global_vars.last_answer = 'Phát TTS thành công'
            return custom_jsonify({'state': 'OK', 'response': global_vars.last_answer})

        elif api_type == 2:
            if data == 'play_direct_link':
                try:
                    song_link = payload['direct_link']
                    global_vars.player1.stop()
                    await asyncio.create_task(global_vars.player1.play_media(song_link, False))
                    global_vars.last_answer = 'Đã phát nhạc Direct link trên loa'
                    return custom_jsonify({'state': 'Success', 'response': global_vars.last_answer})
                except Exception as e:
                    return custom_jsonify({'state': 'Failed', 'response': f'Lỗi: {str(e)}'})

            elif data == 'set_player':
                action = payload['action']
                try:
                    if action == 'pause' and str(global_vars.player1.get_state()) == 'State.Playing':
                        global_vars.player1.pause()
                        global_vars.last_answer = 'Đã dừng System player thành công'
                    elif action == 'continue' and str(global_vars.player1.get_state()) == 'State.Paused':
                        global_vars.player1.resume()
                        global_vars.last_answer = 'Đã phát tiếp System player thành công'
                    elif action == 'stop':
                        global_vars.player1.stop()
                        global_vars.last_answer = 'Đã ngừng System player thành công'
                    return custom_jsonify({'state': 'Success', 'response': global_vars.last_answer})
                except Exception as e:
                    return custom_jsonify({'state': 'Failed', 'response': f'Lỗi: {str(e)}'})

            elif data == 'set_system_volume':
                action = payload['action']
                try:
                    if action == 'up':
                        global_vars.player2.vol_adjust('UP', False)
                    elif action == 'down':
                        global_vars.player2.vol_adjust('DOWN', False)
                    elif action == 'max':
                        global_vars.player2.vol_adjust('MAX', False)
                    elif action == 'min':
                        global_vars.player2.vol_adjust('MIN', False)
                    elif action == 'setup':
                        new_volume = payload['new_value']
                        global_vars.player2.vol_adjust(new_volume, False)
                    else:
                        return custom_jsonify({'state': 'Failed', 'response': 'Lệnh không đúng!'})
                    global_vars.last_answer = 'Đã thiết lập System volume thành công'
                    return custom_jsonify({'state': 'Success', 'response': global_vars.last_answer})
                except Exception as e:
                    return custom_jsonify({'state': 'Failed', 'response': f'Lỗi: {str(e)}'})

            else:
                return custom_jsonify({'state': 'Failed', 'response': 'Lệnh không đúng!'})

        else:
            return custom_jsonify({'state': 'Failed', 'response': 'api_type không đúng'})

    except Exception as e:
        return custom_jsonify({'state': 'Failed', 'error': str(e)})


if __name__ == '__main__':
    import asyncio
    print("Starting API Server directly...")
    asyncio.run(app.run_task(host="0.0.0.0", port=constant.web_port))