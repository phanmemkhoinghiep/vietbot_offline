# !/usr/bin/python
# -*- coding: utf-8 -*-
#-*-coding:gb2312-*-
#Processing
import libs
file_name = '/tmp/led_'+ str(libs.uuid.uuid4()) + '.json'    
class Pixels_4:     
    TIMEOUT = 8000
    def __init__(self, dev,wakeup_color,muted_color):
        self.dev = dev
        self.wakeup_color=wakeup_color
        self.muted_color=muted_color        
    def hex_to_rgb(self,hex):
      self.hex=hex
      rgb = []
      for i in (0, 2, 4):
        decimal = int(hex[i:i+2], 16)
        rgb.append(decimal)
      return rgb[0],rgb[1],rgb[2]

    def write(self, cmd, data=[0]):
        self.dev.ctrl_transfer(
            libs.usb.util.CTRL_OUT | libs.usb.util.CTRL_TYPE_VENDOR | libs.usb.util.CTRL_RECIPIENT_DEVICE,
            0, cmd, 0x1C, data, self.TIMEOUT)
    def trace(self):
        self.write(0)
    def mono(self, color):
        self.write(1, [(color >> 16) & 0xFF, (color >> 8) & 0xFF, color & 0xFF, 0])
    def set_color(self, rgb=None, r=0, g=0, b=0):
        if rgb:
            self.mono(rgb)
        else:
            self.write(1, [r, g, b, 0])
    def set_brightness(self, brightness):
        self.write(0x20, [brightness])
    def set_color_palette(self, a, b):
        self.write(0x21, [(a >> 16) & 0xFF, (a >> 8) & 0xFF, a & 0xFF, 0, (b >> 16) & 0xFF, (b >> 8) & 0xFF, b & 0xFF, 0])
    def set_vad_led(self, state):
        self.write(0x22, [state])
    def volume_change(self, volume1,volume2):
        self.write(0x23, [volume1])
        libs.time.sleep(2)
        self.write(0x23, [volume2])        
        libs.time.sleep(2)
    def change_pattern(self, pattern=None):
        print('Not support to change pattern')
    def close(self):
        """
        close the interface
        """
        libs.usb.util.dispose_resources(self.dev)
    def off(self):
        self.mono(0)
    def listen(self,direction=None):
        self.write(1, [self.hex_to_rgb(self.wakeup_color)[0], self.hex_to_rgb(self.wakeup_color)[1], self.hex_to_rgb(self.wakeup_color)[2], 0])
    wakeup = listen
    def think(self):
        self.write(5)
    wait = think
    def mute(self,direction=None):
        self.write(1, [self.hex_to_rgb(self.muted_color)[0], self.hex_to_rgb(self.muted_color)[1], self.hex_to_rgb(self.muted_color)[2], 0])
    def spin(self):
        self.write(4)
    speak = spin
    def show(self, data):
        self.write(6, data)
    customize = show

class Led():
    def __init__(self,config_data):
        wakeup_color=config_data['smart_config']['led']['wakeup_color']                
        muted_color=config_data['smart_config']['led']['muted_color']        
        def find(vid=0x2886, pid=0x0018):
            dev = libs.usb.core.find(idVendor=vid, idProduct=pid)
            if not dev:
                return
            return Pixels_4(dev,wakeup_color)
        pixels_4=find()            
        self.pixels_4=pixels_4
    def volume_change(self,volume11,volume12):        
        self.volume11=volume11
        self.volume12=volume12        
        volume1=self.volume11
        volume2=self.volume12        
        self.pixels_4.volume_change(round(volume1/10)-1,round(volume2/10)-1)
    def off(self):
        self.pixels_4.off()
    def wakeup(self):
        self.pixels_4.wakeup()        
    def mute(self):
        self.pixels_4.mute()        
    def listen(self):
        self.pixels_4.listen()   
    def think(self):
        self.pixels_4.think()   
    def speak(self):
        self.pixels_4.speak()        
    def set_state(self, state):
        state_data = {'led': state}
        with open(file_name, 'w') as output_config:
            libs.json.dump(state_data, output_config)
        if state=='OFF':
            self.pixels_4.off()
        elif state =='WAKEUP':
            self.pixels_4.wakeup()        
        elif state =='MUTE':
            self.pixels_4.mute()        
        elif state =='LISTEN':
            self.pixels_4.listen()   
        elif state =='THINK':
            self.pixels_4.think()   
        elif state =='SPEAK':
            self.pixels_4.speak()        
    def get_state(self):
        with open(file_name) as state_json:
            state_data = libs.json.load(state_json)
        state=state_data['led']
        return state     