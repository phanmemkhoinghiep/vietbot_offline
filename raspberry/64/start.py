#!/usr/bin/pythonf
# -*- coding: utf-8 -*-
# -*- coding: gb2312 -*-
from lib_process import constant, global_vars, asyncio
import init
from loop_process import loop
from callback_process import process
# from api_process import run_task  # Sử dụng hàm run_task đã sửa 
from api_process import app  # Import ứng dụng Quart từ api_process.py
async def main():
    # Run tasks
    tasks = [
        asyncio.create_task(loop(process)),  # Vòng lặp chính
        asyncio.create_task(app.run_task(host="0.0.0.0", port=constant.web_port)),  # API server task
        
    ]
    try:
        # Gather tasks and wait for completion
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
