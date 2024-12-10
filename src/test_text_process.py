import time
import logging
import datetime
# from termcolor import colored
from text_process import text_process

# Cấu hình logging, bật log cấp độ DEBUG để thấy chi tiết hơn
logging.basicConfig(level=logging.DEBUG, format='%(asctime)s - %(message)s')

def process():
    try:
        # Nhập câu hỏi từ người dùng
        data = 'Bây giờ là mấy giờ'
        logging.debug(f"Đã nhận câu hỏi: {data}")
        
        # Ghi lại thời gian hiện tại
        current_time = datetime.datetime.today().strftime("%d/%m/%Y %H:%M:%S")
        # print(colored(f'{current_time} {data}', 'blue'))

        # Đo thời gian xử lý
        logging.debug("Bắt đầu đo thời gian xử lý...")
        time_start = time.perf_counter()

        # Gọi hàm text_process và lấy kết quả
        try:
            result = text_process(data)
            logging.debug(f"Kết quả trả về từ text_process: {result}")
            
            if isinstance(result, tuple) or isinstance(result, list):
                answer = result[0]
                logging.debug(f"Đã lấy câu trả lời: {answer}")
            else:
                answer = result
                logging.debug(f"Kết quả trả về không phải list/tuple, dùng trực tiếp: {answer}")
        except Exception as e:
            logging.error(f"Lỗi khi gọi hàm text_process: {str(e)}")
            # print(colored(f"Xảy ra lỗi khi xử lý dữ liệu: {str(e)}", 'red'))
            # break  # Thoát khỏi vòng lặp khi gặp lỗi

        # Đo thời gian hoàn thành
        time_finish = time.perf_counter()
        logging.debug(f"Thời gian xử lý: {time_finish - time_start:.4f} (s)")

        # In kết quả trả về
        # print(colored(f'{current_time} {answer}', 'green'))
        
        # Logging thời gian phản hồi
        # logging.info(colored(f'Thời gian phản hồi: {time_finish - time_start:.4f} (s)', 'magenta'))

    except KeyboardInterrupt:
        # Xử lý khi người dùng ngắt chương trình
        current_time = datetime.datetime.today().strftime("%d/%m/%Y %H:%M:%S")
        # print(colored(f'{current_time} Ngắt chương trình', 'yellow'))
        logging.info("Ngắt chương trình bởi người dùng (KeyboardInterrupt)")

    except Exception as e:
        # Xử lý các lỗi khác
        current_time = datetime.datetime.today().strftime("%d/%m/%Y %H:%M:%S")
        # print(colored(f'{current_time} Lỗi chương trình: {str(e)}', 'red'))
        logging.error(f"Lỗi: {str(e)}")

if __name__ == '__main__':
    process()
