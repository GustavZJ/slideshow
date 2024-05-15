CfA Billedramme Page
Follow the instructions when first setting up Raspberry Pi OS.

Requirements:<br>
1: Raspberry pi 4 or newer (link to how it is done [here](https://projects.raspberrypi.org/en/projects/raspberry-pi-setting-up/2))<br>
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

```
You will now run sudo bash install.sh <br>
After everything has installed, you will get instructions on how to setup passwords in the terminal <br>
Note: No characters are shown doing typing of passwords
```
sudo bash install.sh

sudo raspi-config
```
Go to system options<br>
Go to hostname<br>
Choose your local domain<br>
Select Finish<br>
Select reboot<br>

To access go to (Domain name).local


If you ever lose your password go to the place in this readme, that explains how you run install.sh.