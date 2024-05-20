import os

print("Hello!\nYou chose to enable email notifications.\nWarning!!!\nThis is an advanced feature, and there won't be a guide to use it.\nProceed at you own peril.\n\n")

email = input("Choose the gmail, that you want to use: ")
password = input("Input the special key from your account : ")
receiver = input("Who is the intended recipient?: ")


# This is obviously very safe... 
with open("/var/www/slideshow/nothing.here", "w") as file:
    file.write(f"{email}\n{password}\n{receiver}")

if not email or not password or not receiver:
        print("exiting because of missing info!")
        os.unlink("/var/www/slideshow/nothing.here")
        exit()
print("Testing...")
with open("/var/www/slideshow/nothing.here", "r") as file:
    lines = file.readlines()
    username = lines[0].strip()
    password = lines[1].strip()
    receiver = lines[2].strip()
    print(f"USERNAME={username}, PASSWORD={password}, RECIPIENT={receiver}")