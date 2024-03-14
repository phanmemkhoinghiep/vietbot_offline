import pychromecast
import json

# Lấy danh sách các thiết bị Chromecast trong mạng
chromecasts, browser = pychromecast.get_chromecasts()

# Tạo danh sách để lưu trữ thông tin về các thiết bị Chromecast
chromecasts_info = []

# Lặp qua từng thiết bị Chromecast và thêm thông tin của chúng vào danh sách
for data in chromecasts:
    chromecast_info = {
        "name": data.name,
        "model_name": data.model_name,
        "uuid": str(data.uuid),
        "manufacturer": data.cast_info.manufacturer,
        "ip_address": data.cast_info.host,
        "cast_type": data.cast_info.cast_type,
        "port": data.cast_info.port,
        "friendly_name": data.cast_info.friendly_name
    }
    chromecasts_info.append(chromecast_info)

# Chuyển đổi danh sách thành chuỗi JSON và in ra màn hình
print(json.dumps(chromecasts_info, indent=4))
