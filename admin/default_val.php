$fh = fopen('filename.txt','r');
while ($line = fgets($fh)) {
// <... Do your work with the line ...>
    // echo($line);
    }
    fclose($fh);