<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin</title>
        <meta name="Admin" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/src/scss/main.css">
    </head>
    <body>
        <a href="/upload/index.html">Til upload-side</a>

        <?php 
            $images = scandir('../uploads');
            foreach($images as $image) {
                if (is_file($image)) {
                    echo '<img style="max-height: 15svh;" src="../uploads/'.$image.'">';
                }
            }
        ?>
    </body>
</html>