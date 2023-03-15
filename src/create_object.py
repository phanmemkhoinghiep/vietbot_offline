import json

obj = {}

obj['moment'] = []
obj['moment'].append({
    'value': 'bây giờ'
})
obj['moment'].append({
    'value': 'lúc này'
})
obj['moment'].append({
    'value': 'hiện tại'
})
obj['what_time'] = []
obj['what_time'].append({
    'value': 'mấy giờ'
})
obj['what_day'] = []
obj['what_day'].append({
    'value': 'ngày nào'
})
obj['what_day'].append({
    'value': 'ngày gì'
})
obj['what_day'].append({
    'value': 'ngày nhiêu'
})
obj['what_day'].append({
    'value': 'ngày mấy'
})
obj['what_month'] = []
obj['what_month'].append({
    'value': 'tháng nào'
})
obj['what_month'].append({
    'value': 'tháng gì'
})
obj['what_month'].append({
    'value': 'tháng nhiêu'
})
obj['what_month'].append({
    'value': 'tháng mấy'
})
obj['what_year'] = []
obj['what_month'].append({
    'value': 'năm nào'
})
obj['what_day'].append({
    'value': 'năm gì'
})
obj['yesterday'] = []
obj['yesterday'].append({
    'value': 'hôm qua'
})
obj['today'] = []
obj['today'].append({
    'value': 'hôm nay'
})
obj['today'].append({
    'value': 'ngày này'
})
obj['tomorrow'] = []
obj['tomorrow'].append({
    'value': 'ngày mai'
})
obj['tomorrow'].append({
    'value': 'hôm sau'
})
obj['next_day'] = []
obj['next_day'].append({
    'value': 'ngày kia'
})
obj['next_day'].append({
    'value': 'ngày mốt'
})
obj['this_week'] = []
obj['this_week'].append({
    'value': 'tuần này'
})
obj['next_week'] = []
obj['next_week'].append({
    'value': 'tuần tới'
})
obj['next_week'].append({
    'value': 'sang tuần'
})
obj['this_month'] = []
obj['this_month'].append({
    'value': 'tháng này'
})
obj['next_month'] = []
obj['this_month'].append({
    'value': 'tháng tới'
})
obj['next_month'].append({
    'value': 'sang tháng'
})
obj['this_year'] = []
obj['this_year'].append({
    'value': 'năm này'
})
obj['weather'] = []
obj['weather'].append({
    'value': 'thời tiết'
})
obj['weather'].append({
    'value': 'nắng mưa'
})
obj['weather'].append({
    'value': 'mưa nắng'
})
obj['news'] = []
obj['news'].append({
    'value': 'tin tức'
})
obj['news'].append({
    'value': 'báo'
})
obj['news'].append({
    'value': 'thời sự'
})
obj['news_data'] = []
obj['news_data'].append({       
    'name': 'lao động',
    'link': 'https://laodong.vn/rss/home.rss'    
})
obj['news_data'].append({       
    'name': 'việt nam net',
    'link': 'https://vietnamnet.vn/rss/thoi-su-chinh-tri.rss'    
})
obj['news_data'].append({       
    'name': 'thanh niên',
    'link': 'https://thanhnien.vn/rss/home.rss'    
})
obj['music'] = []
obj['music'].append({
    'value': 'nhạc'
})
obj['music'].append({
    'value': 'bài'
})
obj['network_speed'] = []
obj['network_speed'].append({
    'value': 'đường truyền'
})
obj['network_speed'].append({
    'value': 'tốc độ mạng'
})

obj['all'] = []
obj['all'].append({
    'value': 'tất cả'
})
obj['all'].append({
    'value': 'hết cả'
})
obj['all'].append({
    'value': 'toàn bộ'
})
obj['single'] = []
obj['single'].append({
    'value': 'duy nhất'
})
obj['single'].append({
    'value': 'chỉ một'
})
obj['single'].append({
    'value': 'riêng mỗi'
})
obj['single'].append({
    'value': 'duy mỗi'
})
obj['single'].append({
    'value': 'mỗi một'
})
obj['single'].append({
    'value': 'duy nhất'
})
obj['light'] = []
obj['light'].append({
    'value': 'đèn'
})
obj['light'].append({
    'value': 'bóng điện'
})
obj['light'].append({
    'value': 'đèn điện'
})
obj['switch'] = []
obj['switch'].append({
    'value': 'công tắc'
})
obj['socket'] = []
obj['socket'].append({
    'value': 'ổ cắm'
})
obj['socket'].append({
    'value': 'ổ điện'
})
obj['fan'] = []
obj['fan'].append({
    'value': 'quạt'
})
obj['door'] = []
obj['door'].append({
    'value': 'cửa'
})    
obj['door'].append({
    'value': 'cổng'
})
obj['occupancy'] = []
obj['occupancy'].append({
    'value': 'pir'
})
obj['occupancy'].append({
    'value': 'chuyển động'
})
obj['curtain'] = []
obj['curtain'].append({
    'value': 'rèm'
})
obj['curtain'].append({
    'value': 'mành'
})
obj['curtain'].append({
    'value': 'màn'
})
obj['cover'] = []
obj['cover'].append({
    'value': 'cửa cuốn'    
})
obj['gate'] = []
obj['gate'].append({
    'value': 'cổng'    
})
obj['temperature'] = []
obj['temperature'].append({
    'value': 'nhiệt độ'    
})
obj['humidity'] = []
obj['humidity'].append({
    'value': 'độ ẩm'    
})
obj['script'] = []
obj['script'].append({
    'value': 'kịch bản'    
})
obj['automation'] = []
obj['automation'].append({
    'value': 'tự động'    
})
obj['unit'] = []
obj['unit'].append({
    'code': 'clients',    
    'name': 'kết nối'    
})
obj['unit'].append({
    'code': '%',    
    'name': 'phần trăm'    
})
obj['unit'].append({
    'code': 'MiB',    
    'name': 'mê bai'    
})
obj['unit'].append({
    'code': '°C',    
    'name': 'độ xê'    
})
obj['unit'].append({
    'code': 'min',    
    'name': 'phút'    
})
obj['unit'].append({
    'code': 's',    
    'name': 'giây'    
})
obj['unit'].append({
    'code': 'km/h',    
    'name': 'ki lô mét trên giờ'    
})
obj['unit'].append({
    'code': 'Hz',    
    'name': 'héc'    
})
obj['unit'].append({
    'code': 'V',    
    'name': 'vôn'    
})
obj['unit'].append({
    'code': 'A',    
    'name': 'am pe'    
})
obj['unit'].append({
    'code': 'kW',    
    'name': 'ki lô oát'    
})
obj['unit'].append({
    'code': 'Wh',    
    'name': 'oát giờ'    
})
obj['unit'].append({
    'code': 'kWh',    
    'name': 'kilo oát giờ'    
})
obj['unit'].append({
    'code': 'L',    
    'name': 'lít'    
})
obj['state'] = []
obj['state'].append({
    'value': 'trạng thái'
})
obj['state'].append({
    'value': 'thông số'
})
obj['radio'] = []
obj['radio'].append({
    'value': 'radio'
})
obj['radio'].append({
    'value': 'phát thanh'
})
obj['radio'].append({
    'value': 'đài'
})
obj['radio_data'] = []
obj['radio_data'].append({
    'name': 'vov1',
    'link': 'https://str.vov.gov.vn/vovlive/vov1vov5Vietnamese.sdp_aac/playlist.m3u8'        
})
obj['radio_data'].append({
    'name': 'vov2',
    'link': 'https://str.vov.gov.vn/vovlive/vov2.sdp_aac/playlist.m3u8'            
})
obj['radio_data'].append({
    'name': 'vov3',
    'link': 'https://str.vov.gov.vn/vovlive/vov3.sdp_aac/playlist.m3u8'   
})
obj['radio_data'].append({
    'name': 'vov giao thông hà nội',
    'link': 'https://str.vov.gov.vn/vovlive/vovGTHN.sdp_aac/playlist.m3u8'   
})
obj['radio_data'].append({
    'name': 'vov giao thông sài gòn',
    'link': 'https://str.vov.gov.vn/vovlive/vovGTHCM.sdp_aac/playlist.m3u8'    
})
obj['location'] = []
obj['location'].append({
    'value': 'địa điểm'
})
obj['location'].append({
    'value': 'khu vực'
})
obj['location'].append({
    'value': 'ở'
})
obj['location'].append({
    'value': 'tại'
})
obj['anniversary'] = []
obj['anniversary'].append({
    'value': 'kỉ niệm'
})
obj['anniversary'].append({
    'value': 'sự kiện'
})
obj['anniversary'].append({
    'value': 'ngày giỗ'
})
obj['anniversary_data'] = []
obj['anniversary_data'].append({
    'name':'tết dương lịch',
    'day': '01',
    'month': '01',
    'is_lunar_calendar': False
})
obj['anniversary_data'].append({
    'name':'tết âm lịch',
    'day': '01',
    'month': '01',
    'is_lunar_calendar': True
})
obj['anniversary_data'].append({
    'name':'thành lập đảng cộng sản việt nam',
    'day': '03',
    'month': '02',
    'is_lunar_calendar': False
})
obj['anniversary_data'].append({
    'name':'lễ tình nhân',
    'day': '14',
    'month': '02',
    'is_lunar_calendar': False
})
obj['anniversary_data'].append({
    'name':'quốc tế phụ nữ',
    'day': '08',
    'month': '03',
    'is_lunar_calendar': False
})
obj['anniversary_data'].append({
    'name':'giỗ Tổ',
    'day': '10',
    'month': '03',
    'is_lunar_calendar': True
})
obj['anniversary_data'].append({
    'name':'test code',
    'day': '22',
    'month': '04',
    'is_lunar_calendar': False
})
obj['anniversary_data'].append({
    'name':'giải phóng miền Nam',
    'day': '30',
    'month': '04',
    'is_lunar_calendar': False
})
obj['anniversary_data'].append({
    'name':'quốc tế lao động',
    'day': '01',
    'month': '05',
    'is_lunar_calendar': False
})
obj['anniversary_data'].append({
    'name':'quốc khánh',
    'day': '02',
    'month': '09',
    'is_lunar_calendar': False
})
obj['anniversary_data'].append({
    'name':'phụ nữ Việt Nam',
    'day': '20',
    'month': '10',
    'is_lunar_calendar': False
})
obj['anniversary_data'].append({
    'name':'Giáng Sinh',
    'day': '24',
    'month': '12',
    'is_lunar_calendar': False
})
obj['lunar_day'] = []
obj['lunar_day'].append({
    'value': 'lịch âm'
})
obj['lunar_day'].append({
    'value': 'mùng mấy'
})
obj['lunar_day'].append({
    'value': 'mồng mấy'
})
obj['lunar_day'].append({
    'value': 'âm lịch'
})
obj['history'] = []
obj['history'].append({
    'value': 'lịch sử'
})
obj['history'].append({
    'value': 'năm xưa'
})
obj['funny_story'] = []
obj['funny_story'].append({
    'value': 'truyện cười'
})
obj['funny_story'].append({
    'value': 'truyện cười'
})
obj['funny_story'].append({
    'value': 'truyện hài'
})
obj['event'] = []
obj['event'].append({
    'value': 'sự kiện'
})
obj['name_is'] = []
obj['name_is'].append({
    'value': 'tên là'
})
obj['name_is'].append({
    'value': 'có tên'
})
obj['name_is'].append({
    'value': 'với tên'
})
obj['end_of_request'] = []
obj['end_of_request'].append({
    'value': 'nhé'    
})
obj['end_of_request'].append({
    'value': 'ngay'    
})
obj['end_of_request'].append({
    'value': 'em nhé'    
})
obj['end_of_request'].append({
    'value': 'ngay nhé'    
})
obj['end_of_request'].append({
    'value': 'ngay nào'    
})
obj['end_of_request'].append({
    'value': 'cho anh'    
})
obj['end_of_request'].append({
    'value': 'cho anh nhé'    
})
obj['end_of_request'].append({
    'value': 'được không'    
})
obj['hvac_mode'] = []
obj['hvac_mode'].append({
    'value': 'nóng',
    'value_eng': 'heat'    
})
obj['hvac_mode'].append({
    'value': 'tuyết',
    'value_eng': 'cool'     
})
obj['hvac_mode'].append({
    'value': 'khô', 
    'value_eng': 'dry'       
})
obj['hvac_mode'].append({
    'value': 'tự động', 
    'value_eng': 'auto'       
})
obj['hvac_fan'] = []
obj['hvac_fan'].append({
    'value': 'mạnh',   
    'value_eng': 'high'   
})
obj['hvac_fan'].append({
    'value': 'trung bình',    
    'value_eng': 'medium'   
})
obj['hvac_fan'].append({
    'value': 'giữa',    
    'value_eng': 'middle'   
})
obj['hvac_fan'].append({
    'value': 'yếu',   
    'value_eng': 'low'   
})
obj['hvac_fan'].append({
    'value': 'phe phẩy',  
    'value_eng': 'both'  
})
obj['hvac_swing'] = []
obj['hvac_swing'].append({
    'value': 'đứng',  
    'value_eng': 'vertical'   
})
obj['hvac_swing'].append({
    'value': 'ngang',  
    'value_eng': 'horizontal'   
})
obj['hvac_swing'].append({
    'value': 'gật gù',
    'value_eng': 'both'  
})
obj['hvac_swing'].append({
    'value': 'kín',
    'value_eng': 'off'  
})
obj['hvac_temperature'] = []
obj['hvac_temperature'].append({
    'value': 'nhiệt'    
})
obj['hvac_temperature'].append({
    'value': 'độ'    
})
obj['fan_oscillate_on'] = []
obj['fan_oscillate_on'].append({
    'value': 'quay'
})
obj['fan_oscillate_on'].append({
    'value': 'xoay'
})
obj['fan_oscillate_on'].append({
    'value': 'đảo'
})
obj['fan_oscillate_off'] = []
obj['fan_oscillate_off'].append({
    'value': 'đứng'
})
obj['fan_oscillate_off'].append({
    'value': 'cố định'
})
obj['fan_increase_speed'] = []
obj['fan_increase_speed'].append({
    'value': 'mạnh hơn'
})
obj['fan_increase_speed'].append({
    'value': 'nhanh hơn'
})
obj['fan_increase_speed'].append({
    'value': 'tăng tốc'
})
obj['fan_decrease_speed'] = []
obj['fan_decrease_speed'].append({
    'value': 'yếu hơn'
})
obj['fan_decrease_speed'].append({
    'value': 'chậm hơn'
})
obj['fan_decrease_speed'].append({
    'value': 'giảm tốc'
})
obj['fan_percent'] = []
obj['fan_percent'].append({
    'value': '%'
})
obj['fan_preset_mode'] = []
obj['fan_preset_mode'].append({
    'value': 'chế độ thứ nhất',    
    'value_eng': 'level_1'   
})
obj['fan_preset_mode'].append({
    'value': 'chế độ thứ hai',    
    'value_eng': 'level_2'   
})
obj['fan_preset_mode'].append({
    'value': 'chế độ thứ ba',    
    'value_eng': 'level_3'   
})
obj['compare_percent'] = []
obj['compare_percent'].append({
    'music_compare': 80,
    'smarthome_compare': 80
})
obj['light_brightness'] = []
obj['light_brightness'].append({
    'value': 'độ sáng'    
})
obj['light_temperature'] = []
obj['light_temperature'].append({
    'value': 'nhiệt độ'    
})
obj['light_color_data'] = []
obj['light_color_data'].append({
    'name': 'xanh lá',    
    'R':0,
    'G':255,
    'B':0    
})
obj['light_color_data'].append({
    'name': 'xanh lam',    
    'R':0,
    'G':0,
    'B':255    
})
obj['light_color_data'].append({
    'name': 'đỏ',    
    'R':255,
    'G':0,
    'B':0    
})
obj['light_color_data'].append({
    'name': 'vàng',    
    'R':255,
    'G':255,
    'B':0    
})
obj['currency_rate'] = []
obj['currency_rate'].append({
    'value': 'tỷ giá'
})
obj['currency_rate'].append({
    'value': 'ngoại tệ'
})
obj['currency_rate_data'] = []
obj['currency_rate_data'].append({
    'name': 'đô la',
    'code': 'USD'    
})
obj['currency_rate_data'].append({
    'name': 'đôla',
    'code': 'USD'    
})
obj['currency_rate_data'].append({
    'name': 'ơ rô',
    'code': 'EUR'    
})    
obj['currency_rate_data'].append({
    'name': 'ơrô',
    'code': 'EUR'    
}) 
obj['currency_rate_data'].append({
    'name': 'bảng anh',
    'code': 'GBP'    
})
obj['gold_rate'] = []    
obj['gold_rate'].append({
    'value': 'giá vàng'
})
obj['gold_rate'].append({
    'value': 'vàng SJC'
})
obj['gold_rate'].append({
    'value': 'vàng miếng'
})
obj['gold_rate_data'] = []
obj['gold_rate_data'].append({
    'location': 'Hà Nội'
})
obj['gold_rate_data'].append({
    'location': 'Đà Nẵng'    
})
obj['gold_rate_data'].append({
    'location': 'Hồ Chí Minh'    
})
obj['gold_rate_data'].append({
    'location': 'Nha Trang'    
})
obj['gold_rate_data'].append({
    'location': 'Cà Mau'    
})
obj['gold_rate_data'].append({
    'location': 'Huế'    
})
obj['gold_rate_data'].append({
    'location': 'Bình Phước'    
})
obj['gold_rate_data'].append({
    'location': 'Miền Tây'    
})
obj['gold_rate_data'].append({
    'location': 'Biên Hòa'   
})
obj['gold_rate_data'].append({
    'location': 'Quảng Ngãi'    
})
obj['gold_rate_data'].append({
    'location': 'Long Xuyên'    
})
obj['gold_rate_data'].append({
    'location': 'Bạc Liêu'   
})
obj['gold_rate_data'].append({
    'location': 'Quy Nhơn'   
})
obj['gold_rate_data'].append({
    'location': 'Phan Rang'    
})
obj['gold_rate_data'].append({
    'location': 'Hạ Long'    
})
obj['gold_rate_data'].append({
    'location': 'Quảng Nam'
})
obj['lottery'] = []
obj['lottery'].append({
    'value': 'sổ xố'    
})
obj['lottery'].append({
    'value': 'vé số'    
})
obj['lottery_data'] = []
obj['lottery_data'].append({
    'location': 'miền nam',
    'link': 'https://xskt.com.vn/rss-feed/mien-nam-xsmn.rss'

})
obj['lottery_data'].append({
    'location': 'miền trung',
    'link': 'https://xskt.com.vn/rss-feed/mien-trung-xsmt.rss'
})
obj['lottery_data'].append({
    'location': 'miền bắc',    
    'link': 'https://xskt.com.vn/rss-feed/mien-bac-xsmb.rss'
})
obj['lottery_data'].append({
    'location': 'an giang',     
    'link': 'https://xskt.com.vn/rss-feed/an-giang-xsag.rss'
})
obj['lottery_data'].append({
    'location': 'bình dương',     
    'link': 'https://xskt.com.vn/rss-feed/binh-duong-xsbd.rss'
})
obj['lottery_data'].append({
    'location': 'bình định',
    'link': 'https://xskt.com.vn/rss-feed/binh-dinh-xsbdi.rss'
})
obj['lottery_data'].append({
    'location': 'bạc liêu',     
    'link': 'https://xskt.com.vn/rss-feed/bac-lieu-xsbl.rss'
})
obj['lottery_data'].append({
    'location': 'bình phước',     
    'link': 'https://xskt.com.vn/rss-feed/binh-phuoc-xsbp.rss'
})
obj['lottery_data'].append({
    'location': 'bến tre',   
    'link': 'https://xskt.com.vn/rss-feed/ben-tre-xsbt.rss'
})
obj['lottery_data'].append({
    'location': 'bình thuận',    
    'link': 'https://xskt.com.vn/rss-feed/binh-thuan-xsbth.rss'
})
obj['lottery_data'].append({
    'location': 'cà mau',  
    'link': 'https://xskt.com.vn/rss-feed/ca-mau-xscm.rss'
})
obj['lottery_data'].append({
    'location': 'cần thơ',    
    'link': 'https://xskt.com.vn/rss-feed/can-tho-xsct.rss'
})
obj['lottery_data'].append({
    'location': 'đắc lắc',    
    'link': 'https://xskt.com.vn/rss-feed/dac-lac-xsdlk.rss'
})
obj['lottery_data'].append({
    'location': 'đồng nai',
    'link': 'https://xskt.com.vn/rss-feed/dong-nai-xsdn.rss'
})
obj['lottery_data'].append({
    'location': 'đà nẵng',
    'link': 'https://xskt.com.vn/rss-feed/da-nang-xsdng.rss'
})
obj['lottery_data'].append({
    'location': 'đắc nông',     
    'link': 'https://xskt.com.vn/rss-feed/dac-nong-xsdno.rss'
})
obj['lottery_data'].append({
    'location': 'đồng tháp',     
    'link': 'https://xskt.com.vn/rss-feed/dong-thap-xsdt.rss'    
})
obj['lottery_data'].append({
    'location': 'gia lai',     
    'link': 'https://xskt.com.vn/rss-feed/gia-lai-xsgl.rss'    
})
obj['lottery_data'].append({
    'location': 'hồ chí minh',
    'link': 'https://xskt.com.vn/rss-feed/tp-hcm-xshcm.rss'    
})
obj['lottery_data'].append({
    'location': 'hậu giang',
    'link': 'https://xskt.com.vn/rss-feed/hau-giang-xshg.rss'    
})
obj['lottery_data'].append({
    'location': 'kiên giang',
    'link': 'https://xskt.com.vn/rss-feed/kien-giang-xskg.rss'    
})
obj['lottery_data'].append({
    'location': 'khánh hòa',
    'link': 'https://xskt.com.vn/rss-feed/khanh-hoa-xskh.rss'    
})
obj['lottery_data'].append({
    'location': 'con tum',
    'link': 'https://xskt.com.vn/rss-feed/kon-tum-xskt.rss'    
})
obj['lottery_data'].append({
    'location': 'long an',
    'link': 'https://xskt.com.vn/rss-feed/long-an-xsla.rss'    
})
obj['lottery_data'].append({
    'location': 'lâm đồng',
    'link': 'https://xskt.com.vn/rss-feed/lam-dong-xsld.rss'    
})
obj['lottery_data'].append({
    'location': 'ninh thuận',
    'link': 'https://xskt.com.vn/rss-feed/ninh-thuan-xsnt.rss'    
})
obj['lottery_data'].append({
    'location': 'phú yên',
    'link': 'https://xskt.com.vn/rss-feed/phu-yen-xspy.rss'    
})
obj['lottery_data'].append({
    'location': 'quảng bình',
    'link': 'https://xskt.com.vn/rss-feed/quang-binh-xsqb.rss'    
})
obj['lottery_data'].append({
    'location': 'quảng ngãi',
    'link': 'https://xskt.com.vn/rss-feed/quang-ngai-xsqng.rss'    
})
obj['lottery_data'].append({
    'location': 'quảng nam',
    'link': 'https://xskt.com.vn/rss-feed/quang-nam-xsqnm.rss'    
})
obj['lottery_data'].append({
    'location': 'quảng trị',
    'link': 'https://xskt.com.vn/rss-feed/quang-tri-xsqt.rss'    
})
obj['lottery_data'].append({
    'location': 'sóc trăng',
    'link': 'https://xskt.com.vn/rss-feed/soc-trang-xsst.rss'    
})
obj['lottery_data'].append({
    'location': 'tiền giang',
    'link': 'https://xskt.com.vn/rss-feed/tien-giang-xstg.rss'    
})
obj['lottery_data'].append({
    'location': 'tây ninh',
    'link': 'https://xskt.com.vn/rss-feed/tay-ninh-xstn.rss'    
})
obj['lottery_data'].append({
    'location': 'thừa thiên huế',
    'link': 'https://xskt.com.vn/rss-feed/thua-thien-hue-xstth.rss'    
})
obj['lottery_data'].append({
    'location': 'trà vinh',
    'link': 'https://xskt.com.vn/rss-feed/tra-vinh-xstv.rss'    
})
obj['lottery_data'].append({
    'location': 'vĩnh long',
    'link': 'https://xskt.com.vn/rss-feed/vinh-long-xsvl.rss'    
})
obj['lottery_data'].append({
    'location': 'vũng tàu',
    'link': 'https://xskt.com.vn/rss-feed/vung-tau-xsvt.rss'
})
with open('object.json', 'w') as outfile:
    json.dump(obj, outfile)
