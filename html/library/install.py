import importlib
import subprocess
import time

# Mã màu ANSI
GREEN = '\033[92m'
YELLOW = '\033[93m'
RED = '\033[91m'
RESET = '\033[0m'

#đặt auto_confirm=False Không tự động xác nhận tùy theo phiên bản pip
def install_library(library_name, version=None, auto_confirm=False):
    try:
        importlib.import_module(library_name)
        print(f"{GREEN} + {library_name} đã được cài đặt.{RESET}")
    except ImportError:
        print(f"{YELLOW} + {library_name} chưa được cài đặt. Đang cài đặt thư viện...{RESET}")
        try:
            install_command = ['pip', 'install']
            if auto_confirm:
                install_command.append('-y')
            if version:
                install_command.append(f'{library_name}=={version}')
            else:
                install_command.append(library_name)

            subprocess.run(install_command)
            
            print(f"{GREEN} - {library_name} đã được cài đặt thành công.{RESET}")
        except Exception as e:
            print(f"{RED} - Lỗi khi cài đặt thư viện {library_name}: {e}{RESET}")

def read_libraries_from_file(file_path):
    libraries = {}
    with open(file_path, 'r') as file:
        for line in file:
            line = line.strip()
            if line and not line.startswith("#"):
                parts = line.split('==')
                library = parts[0].strip()
                version = parts[1].strip() if len(parts) > 1 else None
                libraries[library] = version
    return libraries

if __name__ == "__main__":
    libraries_to_install = read_libraries_from_file('libraries_pip_to_install.txt')

    for library, version in libraries_to_install.items():
        install_library(library, version)  # auto_confirm=True by default
        time.sleep(1)  # Nghỉ 1 giây giữa mỗi lần cài đặt thư viện