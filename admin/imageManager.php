<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin</title>
        <meta name="Admin" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/src/scss/main.css">
	    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    </head>
    <body>
        <a href="/upload/index.html">Til upload-side</a>

        <?php
            if(isset($_GET['Submit'])) { 
                $name = $_GET['files'];
                if (isset($_GET['files'])) {
                    foreach ($name as $file){
                        rename('../uploads/cover6.jpg', 'delete/cover6.jpg');
                    }
                } else {
                    echo "You did not choose a file.";
                }
            }
        
            $html = "";
            $images = scandir('../uploads');
            $html .= '<div id="imageUploadCont">';
            $html .= '<div id="uploadedImagesCont">';
            $html .= '<form method="get>';
            foreach($images as $image) {
                if (is_file('../uploads/'.$image)) {
                    $html .= '<div class="imageCont">';
                    $html .= '<img style="max-height: 15svh" class="previewImage" src="../uploads/'.$image.'">';
                    $html .= '<input type="checkbox" name="files[]" value="'.$image.'"x>';
                    $html .= '</div>';
                }
            }
            $html .= '<button name="submit" value="true">Slet</button>';
            $html .= '</form>';
            $html .= '</div>';
            
            echo $html;
            // $dom = new DOMDocument('1.0', 'iso-8859-1');
            // Enable validate on parse 
            // $dom->validateOnParse = true; 
            // $dom->loadHTML($html);
            // $elements = $dom->getElementById('uploadedImagesCont');
        ?>
    </body>
</html>