from lib_process import threading,time,Color,PixelStrip,random,colorsys
state_data = 'OFF'
class Led():    
    def __init__(self,config_data):
        effect_mode=config_data['smart_config']['led']['effect_mode']    
        LED_COUNT =config_data['smart_config']['led']['number_led']                
        LED_BRIGHTNESS =config_data['smart_config']['led']['brightness']                
        LED_PIN =config_data['smart_config']['led']['led_gpio']                
        wakeup_color=config_data['smart_config']['led']['wakeup_color']                
        muted_color=config_data['smart_config']['led']['muted_color']        
        listen_effect=config_data['smart_config']['led']['listen_effect']
        think_effect=config_data['smart_config']['led']['think_effect']
        speak_effect=config_data['smart_config']['led']['speak_effect']

# Define LED strip parameters
        LED_FREQ_HZ = 800000
        LED_DMA = 10
        LED_INVERT = False
        LED_CHANNEL = 0
    # Create an instance of the LED strip
        # strip = Adafruit_NeoPixel(LED_COUNT,LED_PIN,LED_FREQ_HZ,LED_DMA,LED_INVERT,LED_BRIGHTNESS,LED_CHANNEL)
        strip = PixelStrip(LED_COUNT,LED_PIN,LED_FREQ_HZ,LED_DMA,LED_INVERT,LED_BRIGHTNESS,LED_CHANNEL,strip_type=None, gamma=None)
        self.wakeup_color=wakeup_color
        self.muted_color=muted_color
        self.listen_effect=listen_effect
        self.think_effect=think_effect
        self.speak_effect=speak_effect
        # Initialize the LED strip
        strip.begin()
        self.strip=strip       
        
        self.effect = None
        self.effect_lock = threading.Lock()        
        self.led_thread = threading.Thread(target=self.run_led_thread)
        self.led_thread.daemon = True
        self.led_thread.start()

    def hex_to_rgb(self,hex):
      self.hex=hex
      rgb = []
      for i in (0, 2, 4):
        decimal = int(hex[i:i+2], 16)
        rgb.append(decimal)
      return rgb[0],rgb[1],rgb[2]
      
    def wheel(self,pos):
        """Generate rainbow colors across 0-255 positions."""
        if pos < 85:
            return Color(pos * 3, 255 - pos * 3, 0)
        elif pos < 170:
            pos -= 85
            return Color(255 - pos * 3, 0, pos * 3)
        else:
            pos -= 170
            return Color(0, pos * 3, 255 - pos * 3)
            
    def colorWipe(self,Color, wait_ms=5):
        """Wipe Color across display a pixel at a time."""
        for i in range(self.strip.numPixels()):
            self.strip.setPixelColor(i, Color)
            self.strip.show()
            time.sleep(wait_ms / 300) 
            
    def effect_1(self,Color=Color(random.randint(0,255),random.randint(0,255),random.randint(0,255)), wait_ms=100):
        """Wipe Color across display a pixel at a time."""
        for i in range(self.strip.numPixels()):
            self.strip.setPixelColor(random.randint(0,self.strip.numPixels()-i), Color)
            self.strip.show()
            time.sleep(wait_ms / 300)         
            
    def effect_2(self, wait_ms=1, iterations=1):
        """Draw rainbow that uniformly distributes itself across all pixels."""
        for j in range(256 * iterations):
            for i in range(self.strip.numPixels()):
                self.strip.setPixelColor(i, self.wheel(
                    (int(i * 256 / self.strip.numPixels()) + j) & 255))
            self.strip.show()
            time.sleep(wait_ms / 300)                
    def effect_3(self,wait_ms=20):
        colors = []
        for i in range(self.strip.numPixels()):
            r, g, b = colorsys.hsv_to_rgb(i / float(self.strip.numPixels()), 1, 1)
            colors.append(Color(int(255 * r), int(255 * g), int(255 * b)))      
        for j in range(self.strip.numPixels()):
            for i in range(self.strip.numPixels()):
                self.strip.setPixelColor(i, colors[(i + j) % self.strip.numPixels()])
            self.strip.show()
            time.sleep(0.1)
    def effect_4(self):
        for i in range(16):
            pixel_index = random.randint(0, self.strip.numPixels() - 1)
            pixel_index = random.randint(0, self.strip.numPixels() - 1)
            self.strip.show()
            time.sleep(0.1)
            self.strip.setPixelColor(pixel_index, Color(0, 0, 0))  # Turn off the pixel
            self.strip.show()
            time.sleep(0.1)
    def _effect_handler(self, effect):                         
        if effect == 1:
            self.effect_1()
        elif effect == 2:
            self.effect_2()
        elif effect == 3:
            self.effect_3()
        elif effect == 4:
            self.effect_4()








    def _off(self): 
        self.colorWipe(Color(0,0,0))
    def _mute(self):
        self.colorWipe(Color(self.hex_to_rgb(self.muted_color)[0], self.hex_to_rgb(self.muted_color)[1], self.hex_to_rgb(self.muted_color)[2]))
    def _wakeup(self):
                    
                     
        self.colorWipe(Color(self.hex_to_rgb(self.wakeup_color)[0], self.hex_to_rgb(self.wakeup_color)[1], self.hex_to_rgb(self.wakeup_color)[2]))
    def _listen(self):
        self._effect_handler(self.listen_effect)
    def _think(self):
        self._effect_handler(self.think_effect)
    def _speak(self):
        self._effect_handler(self.speak_effect)
                                        
                                 
                 
                    
    def volume_change(self, volume1, volume2):
        current_state=self.get_state() #Get current state                                                         
        NUMLED1 = round(volume1 / 12)
        NUMLED2 = round(volume2 / 12)        
        for j in range(1):
            for q in range(1, NUMLED2 + 1):
                for i in range(q):
                    self.strip.setPixelColor(i, Color(random.randint(0,255),random.randint(0,255),random.randint(0,255)))
                self.strip.show()
                time.sleep(0.15)
                for i in range(q):
                    self.strip.setPixelColor(i, 0)
        self.set_state(current_state) #Restore the laste state
    def get_number_of_pixel(self):
        return self.strip.numPixels()
    def run_led_thread(self):
        while True:
            with self.effect_lock:
                if self.effect is not None:
                    if self.effect == "OFF":
                        self._off()
                    elif self.effect == "MUTE":
                        self._mute()
                    elif self.effect == "WAKEUP":
                        self._wakeup()                        
                    elif self.effect == "LISTEN":
                        self._listen()                        
                    elif self.effect == "THINK":
                        self._think()                        
                    elif self.effect == "SPEAK":
                        self._speak()                        
                    elif self.effect == 1:
                        self.effect_1()
                    elif self.effect == 2:
                        self.effect_2()
                    elif self.effect == 3:
                        self.effect_3()
                    elif self.effect == 4:
                        self.effect_4()                                          
                    self.strip.show()
            time.sleep(0.1)  # Đợi một chút để tránh quá tải CPU
    def set_state(self, new_state):
        global state_data  # Declare state_data as global
        state_data = new_state
        self.change_effect(new_state)
    def get_state(self):
        global state_data  # Declare state_data as global
        return state_data
    def change_effect(self, new_effect):
        with self.effect_lock:
            self.effect = new_effect                                                         
                        
                        

# if __name__ == '__main__':
    # import libs

    # led=Led(conf_data,True)
    # led.set_state('MUTE')
    # if led.get_state() =='MUTE':
        # print('sdfsdfda')

    
                 
                                                                                                                             
                        
    
                                                                                                                                