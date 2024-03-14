import os
import pvporcupine
import re
import sys

def get_first_ppn_file(directory):
    for filename in os.listdir(directory):
        if filename.endswith(".ppn"):
            return filename
    return None

# Kiểm tra xem có tham số nào được truyền không
if len(sys.argv) > 1:
    # Lấy giá trị của tham số dòng lệnh thứ hai (index 1)
    key = sys.argv[1]
else:
    # Nếu không có tham số nào được truyền, yêu cầu người dùng nhập key
    key = input("Vui lòng nhập key Picovoice: ")

try:
    model_path = '/home/pi/vietbot_offline/src/hotword/vi'
    ppn_file = get_first_ppn_file(model_path)
    # print(ppn_file)
    vietnamese_porcupine = pvporcupine.create(
        access_key=key,
        keyword_paths=[f'{model_path}/{ppn_file}']
    )
    print('Token Picovoice Hợp Lệ, Bạn đang sử dụng Tiếng Việt')

except pvporcupine.PorcupineInvalidArgumentError as e:
    # Trích xuất thông tin từ dòng thông báo lỗi
    language_regex = re.compile(r'File belongs to `(?P<language>.*?)` while model file \(.*?\) belongs to `(?P<model_language>.*?)`')
    match = language_regex.search(str(e))

    try:
    # Kiểm tra xem có kết quả không
        if match:
        # Trích xuất thông tin từ kết quả
            model_path = '/home/pi/vietbot_offline/src/hotword/eng'
            ppn_file = get_first_ppn_file(model_path)
            eng_porcupine = pvporcupine.create(
                access_key=key,
                keyword_paths=[f'{model_path}/{ppn_file}']
            )
            print('Token Picovoice Hợp Lệ, Bạn đang sử dụng Tiếng Anh')
        elif 'Failed to parse AccessKey' in str(e):
            print(f"Lỗi, Token Picovoice không hợp lệ hoặc bị khóa\n Hãy kiểm tra lại")
        else:
        # Xử lý PorcupineInvalidArgumentError khác
            print(f"Có lỗi xảy ra khi kiểm tra mã Token: {e}")
    except pvporcupine.PorcupineInvalidArgumentError as f:
            access_key_error_regexx = re.compile(r'Failed to parse AccessKey `(?P<access_key>.*?)`')
            access_key_matchh = access_key_error_regexx.search(str(f))
            if access_key_matchh:
                access_key_valuee = access_key_matchh.group('access_key')
                print(f"Lỗi, Token Picovoice không hợp lệ hoặc bị khóa\n Hãy kiểm tra lại")
            else:
        # Xử lý PorcupineInvalidArgumentError khác
                print(f"Có lỗi xảy ra khi kiểm tra mã Token: {f}")
