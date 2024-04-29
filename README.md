CfA Billedramme Page
Follow the instructions when first setting up Raspberry Pi OS.

Requirements:<br>
1: Raspberry pi 4 or newer<br>
2: SD card formated with Raspberry Pi OS with desktop 64-bit<br>
3: Wi-fi or ethernet connection<br>
4: A display on which the content will be shown<br>
5: apache2

To install:
```
sudo apt update
sudo apt install apache2 -y
cd /var/www
sudo git clone https://github.com/GustavZJ/slideshow.git
cd slideshow
sudo bash install.sh
```
Run the next command and follow the instructions, 'uploader' is the default username. <br>
Afterwards run the command again without the parameter -c and the username should be admin [DON'T USE -c!]<br>
Note: No characters are shown doing typing of password
```
sudo htpasswd -c /etc/apache2/.htpasswd uploader
sudo htpasswd /etc/apache2/.htpasswd admin
sudo raspi-config
```
Go to system options<br>
Go to hostname<br>
Choose your local domain<br>
Select Finish<br>
Select reboot<br>
