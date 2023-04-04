# !/usr/bin/python
# -*- coding: utf-8 -*-
#-*-coding:gb2312-*-
import time
# import imp
import sys
import json

import usb.core
import usb.util



class Pixels_4:      
    TIMEOUT = 8000
    def __init__(self, dev,off_mode,off_color,wakeup_mode,wakeup_color):
        self.dev = dev
        self.off_mode=off_mode
        self.off_color=off_color
        self.wakeup_mode=wakeup_mode
        self.wakeup_color=wakeup_color
    def hex_to_rgb(self,hex):
      self.hex=hex
      rgb = []
      for i in (0, 2, 4):
        decimal = int(hex[i:i+2], 16)
        rgb.append(decimal)
      return rgb[0],rgb[1],rgb[2]

    def write(self, cmd, data=[0]):
        self.dev.ctrl_transfer(
            usb.util.CTRL_OUT | usb.util.CTRL_TYPE_VENDOR | usb.util.CTRL_RECIPIENT_DEVICE,
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
    def set_volume(self, volume):
        self.write(0x23, [volume])
    def change_pattern(self, pattern=None):
        print('Not support to change pattern')
    def close(self):
        """
        close the interface
        """
        usb.util.dispose_resources(self.dev)
    def off(self):
        if self.off_mode==1:
            self.mono(0)
        elif self.off_mode==2:
            self.write(1, [self.hex_to_rgb(self.off_color)[0], self.hex_to_rgb(self.off_color)[1], self.hex_to_rgb(self.off_color)[2],0])
    def listen(self,direction=None):
        if self.wakeup_mode == 1:
            self.write(2)
        elif self.wakeup_mode==2:
            self.write(1, [self.hex_to_rgb(self.wakeup_color)[0], self.hex_to_rgb(self.wakeup_color)[1], self.hex_to_rgb(self.wakeup_color)[2], 0])
    wakeup = listen
    def think(self):
        self.write(5)
    wait = think
    def spin(self):
        self.write(4)
    speak = spin
    def show(self, data):
        self.write(6, data)
    customize = show

