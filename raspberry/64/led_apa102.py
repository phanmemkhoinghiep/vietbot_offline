# !/usr/bin/python
# -*- coding: utf-8 -*-
#-*-coding:gb2312-*-
import lib_process
file_name = '/tmp/led_'+ str(lib_process.uuid.uuid4()) + '.json'    
    
RGB_MAP = { 'rgb': [3, 2, 1], 'rbg': [3, 1, 2], 'grb': [2, 3, 1],
            'gbr': [2, 1, 3], 'brg': [1, 3, 2], 'bgr': [1, 2, 3] }
            
class APA102:


    """
    Driver for APA102 LEDS (aka "DotStar").

    (c) Martin Erzberger 2016-2017

    My very first Python code, so I am sure there is a lot to be optimized ;)

    Public methods are:
     - set_pixel
     - set_pixel_rgb
     - show
     - clear_strip
     - cleanup

    Helper methods for color manipulation are:
     - combine_color
     - wheel

    The rest of the methods are used internally and should not be used by the
    user of the library.

    Very brief overview of APA102: An APA102 LED is addressed with SPI. The bits
    are shifted in one by one, starting with the least significant bit.

    An LED usually just forwards everything that is sent to its data-in to
    data-out. While doing this, it remembers its own color and keeps glowing
    with that color as long as there is power.

    An LED can be switched to not forward the data, but instead use the data
    to change it's own color. This is done by sending (at least) 32 bits of
    zeroes to data-in. The LED then accepts the next correct 32 bit LED
    frame (with color information) as its new color setting.

    After having received the 32 bit color frame, the LED changes color,
    and then resumes to just copying data-in to data-out.

    The really clever bit is this: While receiving the 32 bit LED frame,
    the LED sends zeroes on its data-out line. Because a color frame is
    32 bits, the LED sends 32 bits of zeroes to the next LED.
    As we have seen above, this means that the next LED is now ready
    to accept a color frame and update its color.

    So that's really the entire protocol:
    - Start by sending 32 bits of zeroes. This prepares LED 1 to update
      its color.
    - Send color information one by one, starting with the color for LED 1,
      then LED 2 etc.
    - Finish off by cycling the clock line a few times to get all data
      to the very last LED on the strip

    The last step is necessary, because each LED delays forwarding the data
    a bit. Imagine ten people in a row. When you yell the last color
    information, i.e. the one for person ten, to the first person in
    the line, then you are not finished yet. Person one has to turn around
    and yell it to person 2, and so on. So it takes ten additional "dummy"
    cycles until person ten knows the color. When you look closer,
    you will see that not even person 9 knows its own color yet. This
    information is still with person 2. Essentially the driver sends additional
    zeroes to LED 1 as long as it takes for the last color frame to make it
    down the line to the last LED.
    """
    # Constants
    MAX_BRIGHTNESS = 31 # Safeguard: Set to a value appropriate for your setup
    LED_START = 0b11100000 # Three "1" bits, followed by 5 brightness bits

    def __init__(self, num_led, global_brightness=MAX_BRIGHTNESS,
                 order='rgb', bus=0, device=1, max_speed_hz=8000000):
        self.num_led = num_led  # The number of LEDs in the Strip
        order = order.lower()
        self.rgb = RGB_MAP.get(order, RGB_MAP['rgb'])
        # Limit the brightness to the maximum if it's set higher
        if global_brightness > self.MAX_BRIGHTNESS:
            self.global_brightness = self.MAX_BRIGHTNESS
        else:
            self.global_brightness = global_brightness

        self.leds = [self.LED_START,0,0,0] * self.num_led # Pixel buffer
        self.spi = lib_process.spidev.SpiDev()  # Init the SPI device
        self.spi.open(bus, device)  # Open SPI port 0, slave device (CS) 1
        # Up the speed a bit, so that the LEDs are painted faster
        if max_speed_hz:
            self.spi.max_speed_hz = max_speed_hz

    def clock_start_frame(self):
        """Sends a start frame to the LED strip.

        This method clocks out a start frame, telling the receiving LED
        that it must update its own color now.
        """
        self.spi.xfer2([0] * 4)  # Start frame, 32 zero bits


    def clock_end_frame(self):
        """Sends an end frame to the LED strip.

        As explained above, dummy data must be sent after the last real colour
        information so that all of the data can reach its destination down the line.
        The delay is not as bad as with the human example above.
        It is only 1/2 bit per LED. This is because the SPI clock line
        needs to be inverted.

        Say a bit is ready on the SPI data line. The sender communicates
        this by toggling the clock line. The bit is read by the LED
        and immediately forwarded to the output data line. When the clock goes
        down again on the input side, the LED will toggle the clock up
        on the output to tell the next LED that the bit is ready.

        After one LED the clock is inverted, and after two LEDs it is in sync
        again, but one cycle behind. Therefore, for every two LEDs, one bit
        of delay gets accumulated. For 300 LEDs, 150 additional bits must be fed to
        the input of LED one so that the data can reach the last LED.

        Ultimately, we need to send additional numLEDs/2 arbitrary data bits,
        in order to trigger numLEDs/2 additional clock changes. This driver
        sends zeroes, which has the benefit of getting LED one partially or
        fully ready for the next update to the strip. An optimized version
        of the driver could omit the "clockStartFrame" method if enough zeroes have
        been sent as part of "clockEndFrame".
        """
        # Round up num_led/2 bits (or num_led/16 bytes)
        for _ in range((self.num_led + 15) // 16):
            self.spi.xfer2([0x00])


    def clear_strip(self):
        """ Turns off the strip and shows the result right away."""

        for led in range(self.num_led):
            self.set_pixel(led, 0, 0, 0)
        self.show()


    def set_pixel(self, led_num, red, green, blue, bright_percent=100):
        """Sets the color of one pixel in the LED stripe.

        The changed pixel is not shown yet on the Stripe, it is only
        written to the pixel buffer. Colors are passed individually.
        If brightness is not set the global brightness setting is used.
        """
        if led_num < 0:
            return  # Pixel is invisible, so ignore
        if led_num >= self.num_led:
            return  # again, invisible

        # Calculate pixel brightness as a percentage of the
        # defined global_brightness. Round up to nearest integer
        # as we expect some brightness unless set to 0
        brightness = lib_process.ceil(bright_percent*self.global_brightness/100.0)
        brightness = int(brightness)

        # LED startframe is three "1" bits, followed by 5 brightness bits
        ledstart = (brightness & 0b00011111) | self.LED_START

        start_index = 4 * led_num
        self.leds[start_index] = ledstart
        self.leds[start_index + self.rgb[0]] = red
        self.leds[start_index + self.rgb[1]] = green
        self.leds[start_index + self.rgb[2]] = blue


    def set_pixel_rgb(self, led_num, rgb_color, bright_percent=100):
        """Sets the color of one pixel in the LED stripe.

        The changed pixel is not shown yet on the Stripe, it is only
        written to the pixel buffer.
        Colors are passed combined (3 bytes concatenated)
        If brightness is not set the global brightness setting is used.
        """
        self.set_pixel(led_num, (rgb_color & 0xFF0000) >> 16,
                       (rgb_color & 0x00FF00) >> 8, rgb_color & 0x0000FF,
                        bright_percent)


    def rotate(self, positions=1):
        """ Rotate the LEDs by the specified number of positions.

        Treating the internal LED array as a circular buffer, rotate it by
        the specified number of positions. The number could be negative,
        which means rotating in the opposite direction.
        """
        cutoff = 4 * (positions % self.num_led)
        self.leds = self.leds[cutoff:] + self.leds[:cutoff]


    def show(self):
        """Sends the content of the pixel buffer to the strip.

        Todo: More than 1024 LEDs requires more than one xfer operation.
        """
        self.clock_start_frame()
        # xfer2 kills the list, unfortunately. So it must be copied first
        # SPI takes up to 4096 Integers. So we are fine for up to 1024 LEDs.
        self.spi.xfer2(list(self.leds))
        self.clock_end_frame()


    def cleanup(self):
        """Release the SPI device; Call this method at the end"""

        self.spi.close()  # Close SPI port

    @staticmethod
    def combine_color(red, green, blue):
        """Make one 3*8 byte color value."""

        return (red << 16) + (green << 8) + blue


    def wheel(self, wheel_pos):
        """Get a color from a color wheel; Green -> Red -> Blue -> Green"""

        if wheel_pos > 255:
            wheel_pos = 255 # Safeguard
        if wheel_pos < 85:  # Green -> Red
            return self.combine_color(wheel_pos * 3, 255 - wheel_pos * 3, 0)
        if wheel_pos < 170:  # Red -> Blue
            wheel_pos -= 85
            return self.combine_color(255 - wheel_pos * 3, 0, wheel_pos * 3)
        # Blue -> Green
        wheel_pos -= 170
        return self.combine_color(0, wheel_pos * 3, 255 - wheel_pos * 3)


    def dump_array(self):
        """For debug purposes: Dump the LED array onto the console."""

        print(self.leds)

class ALEXA(object):
    def __init__(self, show=None, number=12):
        self.pixels_number = number
        self.pixels = [0] * 4 * number

        if not show or not callable(show):
            def dummy(data):
                pass
            show = dummy

        self.show = show
        self.stop = False

    def wakeup(self, direction=0):
        position = int((direction + 15) / (360 / self.pixels_number)) % self.pixels_number

        pixels = [0, 0, 0, 24] * self.pixels_number
        pixels[position * 4 + 2] = 48

        self.show(pixels)

    def listen(self):
        pixels = [0, 0, 0, 24] * self.pixels_number

        self.show(pixels)

    def think(self):
        pixels  = [0, 0, 12, 12, 0, 0, 0, 24] * self.pixels_number

        while not self.stop:
            self.show(pixels)
            lib_process.time.sleep(0.2)
            pixels = pixels[-4:] + pixels[:-4]

    def speak(self):
        step = 1
        position = 12
        while not self.stop:
            pixels  = [0, 0, position, 24 - position] * self.pixels_number
            self.show(pixels)
            lib_process.time.sleep(0.01)
            if position <= 0:
                step = 1
                lib_process.time.sleep(0.4)
            elif position >= 12:
                step = -1
                lib_process.time.sleep(0.4)

            position += step

    def off(self):
        self.show([0] * 4 * 12)

class GOOGLE_HOME(object):
    def __init__(self, show=None):
        self.basis = lib_process.numpy.array([0] * 4 * 12)
        self.basis[0 * 4 + 1] = 2
        self.basis[3 * 4 + 1] = 1
        self.basis[3 * 4 + 2] = 1
        self.basis[6 * 4 + 2] = 2
        self.basis[9 * 4 + 3] = 2

        self.pixels = self.basis * 24

        if not show or not callable(show):
            def dummy(data):
                pass
            show = dummy

        self.show = show
        self.stop = False

    def wakeup(self, direction=0):
        position = int((direction + 15) / 30) % 12

        basis = lib_process.numpy.roll(self.basis, position * 4)
        for i in range(1, 25):
            pixels = basis * i
            self.show(pixels)
            lib_process.time.sleep(0.005)

        pixels =  lib_process.numpy.roll(pixels, 4)
        self.show(pixels)
        lib_process.time.sleep(0.1)

        for i in range(2):
            new_pixels = lib_process.numpy.roll(pixels, 4)
            self.show(new_pixels * 0.5 + pixels)
            pixels = new_pixels
            lib_process.time.sleep(0.1)

        self.show(pixels)
        self.pixels = pixels

    def listen(self):
        pixels = self.pixels
        for i in range(1, 25):
            self.show(pixels * i / 24)
            lib_process.time.sleep(0.01)

    def think(self):
        pixels = self.pixels

        while not self.stop:
            pixels = lib_process.numpy.roll(pixels, 4)
            self.show(pixels)
            lib_process.time.sleep(0.2)

        t = 0.1
        for i in range(0, 5):
            pixels = lib_process.numpy.roll(pixels, 4)
            self.show(pixels * (4 - i) / 4)
            lib_process.time.sleep(t)
            t /= 2

        self.pixels = pixels

    def speak(self):
        pixels = self.pixels
        step = 1
        brightness = 5
        while not self.stop:
            self.show(pixels * brightness / 24)
            lib_process.time.sleep(0.02)

            if brightness <= 5:
                step = 1
                lib_process.time.sleep(0.4)
            elif brightness >= 24:
                step = -1
                lib_process.time.sleep(0.4)

            brightness += step

    def off(self):
        self.show([0] * 4 * 12)

class CUSTOM_1(object):
    def __init__(self, show=None):
        self.pixels = [0] * 4 * 12

        if not show or not callable(show):
            def dummy(data):
                pass
            show = dummy

        self.show = show
        self.stop = False

    def effect(self):
        position = 0
        while not self.stop:
            self.pixels = [0] * 4 * 12
            self.pixels[position * 4 + 2] = 48
            self.show(self.pixels)
            position = (position + 1) % 12
            lib_process.time.sleep(0.1)

    def off(self):
        self.show([0] * 4 * 12)

class LEDEffect2(object):
    def __init__(self, show=None):
        self.pixels = [0] * 4 * 12
        self.position = 0

        if not show or not callable(show):
            def dummy(data):
                pass
            show = dummy

        self.show = show
        self.stop = False

    def effect(self):
        while not self.stop:
            self.pixels[self.position * 4 + 2] = 48
            self.show(self.pixels)
            self.pixels[self.position * 4 + 2] = 0
            self.position = (self.position + 1) % 12
            lib_process.time.sleep(0.1)

    def off(self):
        self.show([0] * 4 * 12)

class CUSTOM_2(object):
    def __init__(self, show=None):
        self.pixels = [0] * 4 * 12
        self.position = 0

        if not show or not callable(show):
            def dummy(data):
                pass
            show = dummy

        self.show = show
        self.stop = False

    def effect(self):
        while not self.stop:
            self.pixels = [0] * 4 * 12
            self.pixels[self.position * 4 + 2] = 48
            self.show(self.pixels)
            self.position = (self.position + 1) % 12
            lib_process.time.sleep(0.2)

    def off(self):
        self.show([0] * 4 * 12)

class FastRotateEffect(object):
    def __init__(self, show=None):
        self.pixels = [0] * 4 * 12
        self.position = 0

        if not show or not callable(show):
            def dummy(data):
                pass
            show = dummy

        self.show = show
        self.stop = False

    def effect(self):
        while not self.stop:
            self.pixels = [0] * 4 * 12
            self.pixels[self.position * 4 + 2] = 48
            self.show(self.pixels)
            self.position = (self.position + 1) % 12
            lib_process.time.sleep(0.05)

    def off(self):
        self.show([0] * 4 * 12)

class Led():
    def __init__(self,config_data):
        led_type =config_data['smart_config']['led']['type']
        if led_type =='ReSpeaker 2-Mics Pi HAT':
            number_led = 3
        elif led_type =='ReSpeaker 4-Mics Pi HAT':
            number_led = 12        
        elif led_type =='APA102':
            number_led=config_data['smart_config']['led']['number_led']                
        self.number_led=number_led        
        self.dev = APA102(num_led=number_led)            
        self.power = lib_process.LED(5)
        self.power.on()
        self.queue = lib_process.queue.Queue()
        self.thread = lib_process.threading.Thread(target=self._run)
        self.thread.daemon = True
        self.thread.start()
        self.last_direction = None
    def wakeup(self, direction=0):
        self.last_direction = direction
        def f():
            self.pattern.wakeup(direction)
        self.put(f)
        state_data = {'led': 'WAKEUP'}
        with open(file_name, 'w') as output_config:
            lib_process.json.dump(state_data, output_config)
    def listen(self):
        if self.last_direction:
            def f():
                self.pattern.wakeup(self.last_direction)
            self.put(f)
        else:
            self.put(self.pattern.listen)
        state_data = {'led': 'LISTEN'}
        with open(file_name, 'w') as output_config:
            lib_process.json.dump(state_data, output_config)
    def think(self):
        self.put(self.pattern.think)
        state_data = {'led': 'THINK'}
        with open(file_name, 'w') as output_config:
            lib_process.json.dump(state_data, output_config)
    def speak(self):
        self.put(self.pattern.speak)
        state_data = {'led': 'SPEAK'}
        with open(file_name, 'w') as output_config:
            lib_process.json.dump(state_data, output_config)
    def off(self):
        self.put(self.pattern.off)
        state_data = {'led': 'OFF'}
        with open(file_name, 'w') as output_config:
            lib_process.json.dump(state_data, output_config)        

    def mute(self):
        self.put(self.pattern.off)
        state_data = {'led': 'MUTE'}
        with open(file_name, 'w') as output_config:
            lib_process.json.dump(state_data, output_config)

    def put(self, func):
        self.pattern.stop = True
        self.queue.put(func)

    def _run(self):
        while True:
            func = self.queue.get()
            self.pattern.stop = False
            func()

    def show(self, data):
        for i in range(self.number_led):
            self.dev.set_pixel(i, int(data[4*i + 1]), int(data[4*i + 2]), int(data[4*i + 3]))

        self.dev.show()

    def volume_change(self, volume1,volume2): 
        pass
            
    def set_state(self, state):
        state_data = {'led': state}
        with open(file_name, 'w') as output_config:
            lib_process.json.dump(state_data, output_config)
        if state=='OFF':
            self.off()        
        elif state =='WAKEUP':
            self.wakeup()        
        elif state =='MUTE':
            self.mute()        
        elif state =='LISTEN':
            self.listen()
        elif state =='THINK':
            self.think()
        elif state =='SPEAK':
            self.speak()
    def get_state(self):
        with open(file_name) as state_json:
            state_data = lib_process.json.load(state_json)
        state=state_data['led']
        return state     
