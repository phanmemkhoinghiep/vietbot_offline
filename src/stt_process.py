#!/usr/bin/pythonf       
# -*- coding: utf-8 -*-
#-*-coding:gb2312-*-
#Processing
from libs import threading, websocket,time,json, logging,pyaudio
import constant
# Biến toàn cục để lưu kết quả cuối cùng
final_results = {"transcript": None, "transcript_normed": None}


def record_audio(stream, buffer, lock, ):
    """Ghi âm từ stream và lưu vào buffer."""
    # print("Đang thu âm...")
    stream.start_stream()
    start_time = time.perf_counter()
    try:
        while time.perf_counter() - start_time <= constant.stt_time_out:
            data = stream.read(constant.CHUNK, exception_on_overflow=False)
            with lock:
                buffer.append(data)
        # print("Quá trình thu âm hoàn thành.")
    except Exception as e:
        print(f"Lỗi trong quá trình thu âm: {e}")
    finally:
        stream.stop_stream()


 
def send_audio(ws, buffer, lock):
    """Gửi dữ liệu âm thanh từ buffer qua WebSocket."""
    start_time = time.perf_counter()
    # print("Đang gửi dữ liệu âm thanh...")
    try:
        while time.perf_counter() - start_time <= constant.stt_time_out:
            with lock:
                if buffer:
                    chunk = buffer.pop(0)
                    ws.send(chunk, opcode=websocket.ABNF.OPCODE_BINARY)
        # print("Đã gửi xong dữ liệu.")
    except websocket.WebSocketConnectionClosedException:
        pass
        # print("Kết nối WebSocket đã đóng.")
    except Exception as e:
        print(f"Lỗi khi gửi dữ liệu âm thanh: {e}")
    finally:
        ws.close()


def websocket_callbacks():
    """Tạo callback cho WebSocket."""
    def on_message(ws, message):
        global final_results
        try:
            data = json.loads(message)
            if 'result' in data and 'hypotheses' in data['result']:
                hypotheses = data['result']['hypotheses']
                for hypothesis in hypotheses:
                    transcript = hypothesis.get('transcript', '')
                    transcript_normed = hypothesis.get('transcript_normed', '')
                    # print(f"Transcript: {transcript}")
                    # print(f"Transcript (Normalized): {transcript_normed}")
                    final_results["transcript"] = transcript
                    final_results["transcript_normed"] = transcript_normed
        except json.JSONDecodeError as e:
            print(f"Lỗi khi giải mã JSON: {e}")

    def on_error(ws, error):
        print(f"Lỗi WebSocket: {error}")

    def on_close(ws, close_status_code, close_msg):
        # print(f"Kết nối WebSocket đã đóng. Mã trạng thái: {close_status_code}")
        # print(f"Kết quả cuối cùng: {final_results}")
        pass
    return on_message, on_error, on_close
 

def websocket_thread(buffer, lock):
    """Luồng WebSocket để gửi và nhận dữ liệu."""
    websocket.enableTrace(False)
    on_message, on_error, on_close = websocket_callbacks()
    ws = websocket.WebSocketApp(
        constant.STT_SOCKET_URL,
        on_message=on_message,
        on_error=on_error,
        on_close=on_close,
    )
    ws.on_open = lambda ws: threading.Thread(target=send_audio, args=(ws, buffer, lock)).start()
    ws.run_forever()


import asyncio



async def stt_process():
    pa = pyaudio.PyAudio()
    stream = pa.open(rate=constant.DEFAULT_AUDIO_SAMPLE_RATE,
                                     channels=constant.CHANNELS,
                                     format=pyaudio.paInt16,
                                     input=True,
                                     input_device_index=constant.mic_id,
                                     output_device_index=None,
                                     frames_per_buffer=constant.CHUNK)
    # Tạo buffer và lock
    audio_buffer = []
    buffer_lock = threading.Lock()
    # Ghi âm trong một luồng khác
    record_task = asyncio.to_thread(record_audio, stream, audio_buffer, buffer_lock)
    # Chạy WebSocket trong một luồng khác
    websocket_task = asyncio.to_thread(websocket_thread, audio_buffer, buffer_lock)
    # Chạy cả hai tác vụ đồng thời
    await asyncio.gather(record_task, websocket_task)
    # Trả về chuỗi kết quả cuối cùng
    result = final_results.get("transcript_normed")
    logging('right','HUMAN: '+result,'blue')                      
    stream.stop_stream()
    stream.close()
    pa.terminate()
    return result




if __name__ == "__main__":
    result = stt_process()
    print(f"Kết quả nhận được: {result}")
