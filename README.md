CfA Billedramme Page

To install:
```
sudo apt update
sudo apt install git apache2
cd /var/www
sudo git clone https://github.com/GustavZJ/slideshow.git
cd slideshow
sudo bash install.sh
```
Run the next command and follow the instructions, 'uploader' is the default username
```
sudo htpasswd -c /etc/apache2/.htpasswd uploader
```

Requirements:<br>
1: git<br>
2: apache2