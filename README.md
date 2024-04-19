CfA Billedramme Page

To install:
```
sudo apt update
sudo apt install apache2 -y
cd /var/www
sudo git clone https://github.com/GustavZJ/slideshow.git
cd slideshow
sudo bash install.sh
```
Run the next command and follow the instructions, 'uploader' is the default username
Note: No characters are shown doing typing of password
```
sudo htpasswd -c /etc/apache2/.htpasswd uploader
sudo raspi-config
```
Go to system options<br>
Go to hostname<br>
Choose your local domain<br>
Select Finish<br>
Select reboot<br>

Requirements:<br>
1: Raspberry pi 4 or newer<br>
2: SD card formated with Raspberry Pi OS with desktop<br>
3: User must be named panda<br>
4: Wi-fi or ethernet connection<br>
5: A monitor<br>
6: apache2