import pyqrcode
import png
from pyqrcode import QRCode
import sys

domain = sys.argv[1]
url = pyqrcode.create(domain)
url.png("/var/www/slideshow/src/picture/qrcode.png", scale=10)
url.svg("/var/www/slideshow/src/picture/qrcode.svg", scale=10)



