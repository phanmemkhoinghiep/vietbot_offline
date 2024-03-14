import pkgutil

def is_websocket_client_installed():
    return pkgutil.find_loader("websocket") is not None

if is_websocket_client_installed():
    print("Thư viện websocket-client đã được cài đặt.")
else:
    print("websocket-client_library_is_not_installed")
