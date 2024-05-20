print("Hello!\nYou chose to enable email notifications.\nWarning!!!\nThis is an advanced feature, and there won't be a guide to use it.\nProceed at you own peril.\n\n")

email = input("Choose the gmail, that you want to use: ")
password = input("Input the special key from your account : ")

# This is obviously very safe... 
with open("nothing.here", "w") as file:
    file.write(f"{email}\n{password}")

with open("nothing.here", "r") as file:
    lines = file.readlines()
    username = lines[0].strip()
    password = lines[1].strip()
    print(f"USERNAME={username}, PASSWORD={password}")