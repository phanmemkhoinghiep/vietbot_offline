#!/usr/bin/env python
# -*- coding: utf-8 -*-
#-*-coding:gb2312-*-

#Import Python Lib

import pvporcupine
import struct



import json
import vlc
import requests
import os.path
import datetime
import sys
import aiofiles
import aiohttp
# import logging
import importlib
import subprocess
import struct
#Lunar, Noted day Skill
import math
#Youtube Skill
import urllib
import pafy
import youtube_dl
import numpy
#History Skill, #Funny Story
import bs4
#Weather Skill
#Music
import os
# import concurrent.futures
#Youtube #Hass
#Speed Test
#News, Lottery skill
#Curency Rate, # Gold rate
import urllib3
#Wikipedia Skill 
#Random
import random
import usb.core
import usb.util
#Schedule Skill
import schedule
import time
#ZingMp3
import hashlib
import hmac
import hashlib
import shutil
import itertools
# import click
#Wakeupword
import numpy as np
# from openwakeword.model import Model
# import google.oauth2.credentials
import base64
import asyncio
import edge_tts
import pyaudio
import sounddevice
# import wave
import uuid    
import alsaaudio
import re
import argparse
import fcntl
import subprocess
# import imp
# import importlib
import threading
import socket
import colorsys
import queue
# import imp
# import youtube_dl
import spidev
#import as
import xml.etree.ElementTree as ET
import speech_recognition as sr
import xml.dom.minidom as minidom
import pathlib2 as pathlib
#From import
from multiprocessing import Manager,Process
from math import ceil
from gpiozero import LED  
from google.cloud import speech
from google.cloud import texttospeech                
# from flask_cors import CORS
from rpi_ws281x import *
# from flask import Flask, request, render_template, jsonify,send_from_directory
from gtts import gTTS
from fuzzywuzzy import fuzz   
from os import listdir
from html2text import HTML2Text
# from geopy.geocoders import Nominatim
from termcolor import colored
# Base
from gpiozero import Button
from fuzzywuzzy import process
from urllib.parse import quote
requests.packages.urllib3.disable_warnings(requests.packages.urllib3.exceptions.InsecureRequestWarning)
# import paho.mqtt.client as mqtt
import websocket
# import zeroconf
import google.generativeai as genai
from openai import OpenAI
# Bây giờ bạn có thể sử dụng thư viện websocket như thông thường
# Ví dụ: import websockets và sử dụng nó trong chương trình của bạn

#Import local file
# bits = struct.calcsize('P') * 8
# use_azure=False
# if bits == 64:
    # import azure.cognitiveservices.speech as speechsdk    
    # use_azure=True
#Import Vietbot Lib
import global_vars    
import global_constants

# # Giả sử global_constants và log_url đã được định nghĩa từ trước
# def print_console(color, data):
    # sys.stdout.write(color + datetime.datetime.today().strftime("%d/%m/%Y %H:%M:%S") + ' ' + data + global_constants.reset + "\n")

# def log_to_web(position, data, color):
    # try:
        # payload = {'position': position, 'data': datetime.datetime.today().strftime("%d/%m/%Y %H:%M:%S") + ' ' + data, 'color': color}
        # response = requests.post(log_url, json=payload)
        # if response.status_code == 200:
            # return True
        # else:
            # return False
    # except Exception as e:
        # sys.stdout.write(global_constants.red + 'Lỗi khi thực hiện log:' + str(e) + global_constants.reset + "\n")


# def print_out(position, data, color_name):
    # color_map = {
        # "red": global_constants.red,
        # "green": global_constants.green,
        # "yellow": global_constants.yellow,
        # "blue": global_constants.blue,
        # "magenta": global_constants.magenta,
        # "cyan": global_constants.cyan,
        # "white": global_constants.white,
    # }
    # color = color_map.get(color_name, global_constants.reset)  # Mặc định là reset nếu không tìm thấy màu

    # if global_constants.logging_type is None:
        # pass
    # elif global_constants.logging_type == 'console':
        # threading.Thread(target=print_console, args=(color, data)).start()
    # elif global_constants.logging_type == 'web':
        # threading.Thread(target=log_to_web, args=(position, data, color)).start()
    # elif global_constants.logging_type == 'both':
        # threading.Thread(target=print_console, args=(color, data)).start()
        # threading.Thread(target=log_to_web, args=(position, data, color)).start()


def print_out(position,data,color_name):
    color_map = {
        "red": global_constants.red,
        "green": global_constants.green,
        "yellow": global_constants.yellow,
        "blue": global_constants.blue,
        "magenta": global_constants.magenta,
        "cyan": global_constants.cyan,
        "white": global_constants.white,
    }    
    color = color_map.get(color_name, global_constants.reset)  # Mặc định là reset nếu không tìm thấy màu
    if global_constants.logging_type is None:
        pass
    elif global_constants.logging_type =='console':
        sys.stdout.write(color + datetime.datetime.today().strftime("%d/%m/%Y %H:%M:%S")+' '+data + global_constants.reset + "\n")
        # print(colored(datetime.datetime.today().strftime("%d/%m/%Y %H:%M:%S")+' '+data,color_name))
        
    elif global_constants.logging_type =='web':
        try:       
            payload = {'position': position, 'data':datetime.datetime.today().strftime("%d/%m/%Y %H:%M:%S") +' '+data,'color':color}
            response = requests.post(log_url, json=payload)        
            if response.status_code == 200:   
                return True
            else:
                return False
        except Exception as e:
            sys.stdout.write(global_constants.red + 'Lỗi khi thực hiện log:' +str(e) + global_constants.reset + "\n")
    elif global_constants.logging_type =='both':
        sys.stdout.write(color + datetime.datetime.today().strftime("%d/%m/%Y %H:%M:%S")+' '+data + global_constants.reset + "\n")
        if bot_mode=='rapid':
            pass
        else:
            try:       
                payload = {'position': position, 'data':datetime.datetime.today().strftime("%d/%m/%Y %H:%M:%S") +' '+data,'color':color}
                response = requests.post(log_url, json=payload)        
                if response.status_code == 200:   
                    return True
                else:
                    return False
            except Exception as e:
                sys.stdout.write(global_constants.red + 'Lỗi khi thực hiện log:' +str(e) + global_constants.reset + "\n")

# Check Webport
def reboot_os():
    try:
        subprocess.run(['sudo', 'reboot'])
    except Exception as e2:
        logging('left','Lỗi khi thực hiện reboot:' +str(e2),'red')        
        
def is_port_open(port):
    try:
        with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
            s.bind(('localhost', port))
        return False
    except OSError:
        return True        

# if is_port_open:
    # logging('left','Đã có ứng dụng sử dụng cổng: '+str(global_constants.web_port)+' hoặc bot đã chạy, tự động thoát','red')
    # sys.exit()            
            
bot_url = "https://raw.githubusercontent.com/phanmemkhoinghiep/vietbot_offline/version.json"
user_home_dir = os.path.expanduser("~")
# ui_state_path = os.path.join(user_home_dir, 'vietbot_offline', 'html', 'version.json')
# ui_state_path = os.path.join('/home/pi/vietbot_offline/html', 'version.json')
bot_current_ver='24-12-2024-01'
def bot_info():
    update_suggestion='đây là phiên bản mới nhất'
    running_times=''
    with open('state.json') as bot_json:
        bot_data = json.load(bot_json)
    running_count=bot_data['running_count'] #Update Running count
    if running_count ==0:
        running_times='chạy lần đầu tiên'
    else:
        running_times='chạy lần thứ ' +str(running_count)    
    bot_data['running_count'] = running_count+1
    bot_latest_ver=bot_current_ver
    hostname ='không xác định'
    ip_address='không xác định'
    wlan_interface = 'wlan0'
    serial_number='0000'    
    mac_address='0000'    
    try:                                      #Update latest version
        response1 = requests.get(bot_url)
        # response2 = requests.get(ui_url)
        if response1.status_code == 200:
            json_response1 = response1.json()
            # print(json_response)
            bot_latest_ver=json_response1['vietbot_version']['latest']  
        # if response2.status_code == 200:
            # json_response2 = response2.json()
            # ui_latest_ver=json_response2['ui_version']['latest']  
        hostname = socket.gethostname()     # Get the hostname
        sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
        ip_address = socket.inet_ntoa(fcntl.ioctl(
            sock.fileno(),
            0x8915,  # SIOCGIFADDR
            struct.pack('256s', wlan_interface[:15].encode())
        )[20:24])
        mac_address = fcntl.ioctl(
            sock.fileno(),
            0x8927,  # SIOCGIFHWADDR - Get hardware address
            struct.pack('256s', 'wlan0'.encode('utf-8')[:15])
        )[18:24]
        mac_address = ':'.join('%02x' % b for b in mac_address)
        sock.close()
        with open('/proc/cpuinfo', 'r') as f:
            for line in f:
                if line.startswith('Serial'):
                    _, serial_number = line.strip().split(':')
                    serial_number=serial_number.strip().replace('0000000','')
    except Exception as e1:
        logging('left','Lỗi khi lấy thông tin bot:' +str(e1),'red')    
    if bot_current_ver != bot_latest_ver:
        update_suggestion='đã có phiên bản mới của chương trình'
    elif bot_current_ver == bot_latest_ver:
        update_suggestion='phiên bản đang chạy là phiên bản mới nhất'
    else:
        pass
    bot_data['hostname'] = hostname
    bot_data['ip_address'] = ip_address    
    bot_data['vietbot_version']['current'] =bot_current_ver
    with open('state.json', 'w') as output_config:
        json.dump(bot_data, output_config)
    return bot_current_ver,bot_latest_ver,running_times,update_suggestion,serial_number,mac_address,ip_address,hostname

global_vars.bot_info=bot_info()
# is_pi01=True
# try:   
    # output = subprocess.check_output(["lscpu"]).decode("utf-8") # Chạy lệnh lscpu và chứa đầu ra trong một biến   
    # if not "CPU(s): 1" in output: # Kiểm tra xem đầu ra có chứa "CPU(s): 1" không
        # is_pi01 = False
# except subprocess.CalledProcessError as e:
    # pass

#Update AIO Board

