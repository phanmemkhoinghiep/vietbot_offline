import sys
import youtube_dl
import json

def get_youtube_mp3_link(video_url):
    ydl_opts = {'format': 'bestaudio', 'quiet': True}
    with youtube_dl.YoutubeDL(ydl_opts) as ydl:
        try:
            info = ydl.extract_info(video_url, download=False)
            mp3_link = info.get('formats', [{}])[0].get('url')
            if mp3_link:
                return mp3_link
            else:
                #print(json.dumps({"state": "Không tìm thấy thông tin định dạng audio."}))
                return None
        except youtube_dl.DownloadError as e:
            #print(json.dumps({"state": f"Lỗi khi tải thông tin: {e}"}))
            return None

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print(json.dumps({"state": "Vui lòng cung cấp đường dẫn URL của video YouTube."}))
    else:
        video_url = sys.argv[1]
        mp3_link = get_youtube_mp3_link(video_url)
        if mp3_link is not None:
            print(mp3_link)
