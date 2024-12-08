import wakeup_process
if __name__ == '__main__':
    wakewordDetector = wakeup_process.PorcupineManager()    
    if wakewordDetector.initialize() is False:
        print('Lỗi key Pico')                 
    print('CHỜ KÍCH HOẠT')                            
    while True:
        wakeup_detect = wakewordDetector.detect()
        if wakeup_detect:            
            print('Phát hiện keyword: '+wakeup_detect)      

