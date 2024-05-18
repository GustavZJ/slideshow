message=$(git log -1)
readme=$(cat README.md)
touch message.txt

echo $message >> message.txt

echo $readme >> message.txt

cat message.txt