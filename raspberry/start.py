#!/usr/bin/python
# -*- coding: utf-8 -*- 
# -*- coding: gb2312 -*- 
from libs import constant, global_vars
import init
import asyncio
from loop_process import loop
from callback_process import process
from api_process import app  # Import ứng dụng Quart từ api_process.py

async def main():
    # Tạo các tác vụ bất đồng bộ
    tasks = [
        asyncio.create_task(loop(process, False)),  # Chạy vòng lặp chính
        asyncio.create_task(app.run_task(host="0.0.0.0", port=constant.web_port))  # Chạy API server
    ]
    
    try:
        # Chờ các tác vụ hoàn thành mà không block
        await asyncio.gather(*tasks)
    except KeyboardInterrupt:
        print("Program interrupted by user. Cleaning up...")
        for task in tasks:
            task.cancel()  # Hủy các task đang chạy
        await asyncio.gather(*tasks, return_exceptions=True)  # Đợi các task bị hủy
    except Exception as e:
        print(f"Lỗi xảy ra: {e}")
    finally:
        print("Program exited cleanly.")

if __name__ == "__main__":
    asyncio.run(main())
