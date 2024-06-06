<h1>CfA Billedramme Page</h1>


<h2>Follow the instructions when first setting up Raspberry Pi OS.</h2>

Requirements:<br>
1: Raspberry pi 4 or newer<br>
2: SD card formated with Raspberry Pi OS with <strong>desktop 64-bit</strong> (link to how it is done [here](https://projects.raspberrypi.org/en/projects/raspberry-pi-setting-up/2))<br>
<em>Note: Don't use 32-bit as it won't work</em><br>
3: Wi-fi or ethernet connection<br>
4: A display on which the content will be shown<br>

To install:
After formatting SD card with OS, insert it into the raspberry pi, and boot it up by plugging it in, then follow the set up instructions.

When you are on the desktop, open the terminal by clicking the terminal button in the top left.
```bash
sudo apt update
sudo apt install apache2 -y
cd /var/www
sudo git clone https://github.com/GustavZJ/slideshow.git
cd slideshow
```
You will now run sudo bash install.sh <br>
After everything has installed, you will get instructions on how to setup passwords in the terminal <br>
<em>Note: No characters are shown doing typing of passwords</em>
```bash
sudo bash install.sh

sudo raspi-config
```
Go to system options<br>
Go to hostname<br>
Choose your local domain<br>
Select Finish<br>
Select reboot<br>

To access go to (Domain name).local


If you ever lose your password go to the place in this readme, that explains how you run install.sh. <em>WARNING: This will undo any config changes you have made.</em>


<h2>How to use admin</h2>
<em>Note: The site is made as a school project and is therefore in danish.</em>
1: Click <em>Adminside</em> on the website <br>
You will now be prompted to login. <br>
2: Login as admin with your password. (See section on running install to reset password if you lose it.) <br>
Now you're in. <br>
<h2>Config</h2>
To change config click on <em>Configside</em> <br>
When the page has loaded you can change settings, and click <em>Opdater config</em> <br> <br>

<h2>Picture Managing</h2> <br>
To remove pictures click <em>Billedemanager</em> <br>
Click the picture to select them. Click the button labeled <em>Slet</em> To remove them. <br>
The red button labeled <em>Slet alt</em> deletes all the pictures.