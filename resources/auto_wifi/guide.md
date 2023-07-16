cd /home/pi/auto_wifi
chmod +x install-wifi-connect.sh
chmod +x start-wifi-connect.sh
chmod +x wifi-connect.service
sudo cp /home/pi/auto_wifi/wifi-connect.service /etc/systemd/system/wifi-connect.service
sudo systemctl enable wifi-connect.service
nohup bash ./install-wifi-connect.sh & tail -f nohup.out