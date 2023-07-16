#!/usr/bin/env bash

# export DBUS_SYSTEM_BUS_ADDRESS=unix:path=/host/run/dbus/system_bus_socket
# ^^^ this can cause barfing and isn't needed

# Choose a condition for running WiFi Connect according to your use case:

# 1. Is there a default gateway?
# ip route | grep default

# 2. Is there Internet connectivity?
# nmcli -t g | grep full

# 3. Is there Internet connectivity via a google ping?
# wget --spider http://google.com 2>&1

# 4. Is there an active WiFi connection?
sleep 30
iwgetid -r

if [ $? -eq 0 ]; then
	sudo systemctl start apache2.service
    printf 'Skipping WiFi Connect\n'
else
	sudo systemctl stop apache2.service
    printf 'Starting WiFi Connect\n'
    wifi-connect -s vietbot -g 192.168.4.1 -d 192.168.4.2,192.168.4.5
fi

# Start your application here.
