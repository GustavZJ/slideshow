import smtplib, ssl
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
import sys

with open("/var/www/slideshow/nothing.here", "r") as file:
    lines = file.readlines()
    sender_email = lines[0].strip()
    password = lines[1].strip()

receiver_email = sys.argv[1]

message = MIMEMultipart("alternative")
message["Subject"] = sys.argv[2]
message["From"] = sender_email
message["To"] = receiver_email

with open("/var/www/slideshow/message.html", "r") as file:
    html = file.read()
print(html)
# Create the plain-text and HTML version of your message
text = """\
Hi,
How are you?
Real Python has many great tutorials:
www.realpython.com"""
html = """\
<html>
  <body>
    <p>Hi,<br>
       How are you?<br>
       <a href="http://www.realpython.com">Real Python</a> 
       has many great tutorials.
    </p>
  </body>
</html>
"""

# Turn these into plain/html MIMEText objects
part1 = MIMEText(text, "plain")
part2 = MIMEText(html, "html")

# Add HTML/plain-text parts to MIMEMultipart message
# The email client will try to render the last part first
message.attach(part1)
message.attach(part2)

# Create secure connection with server and send email
context = ssl.create_default_context()
with smtplib.SMTP_SSL("smtp.gmail.com", 465, context=context) as server:
    server.login(sender_email, password)
    server.sendmail(
        sender_email, receiver_email, message.as_string()
    )