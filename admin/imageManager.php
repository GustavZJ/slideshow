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
            $html = "";
            $images = scandir('../uploads');
            $html .= '<div id="uploadedImagesCont">';
            foreach($images as $image) {
                if (is_file('../uploads/'.$image)) {
                    $html .= '<div class="imageCont">';
                    $html .= '<img style="max-height: 15svh" class="previewImage" src="../uploads/'.$image.'">';
                    $html .= '<input type="checkbox">';
                    $html .= '</div>';
                }
            }
            $html .= '</div>';
            
            echo $html;
            $dom = new DOMDocument('1.0', 'iso-8859-1');
            // Enable validate on parse 
            $dom->validateOnParse = true; 
            $dom->loadHTML($html);
            $elements = $dom->getElementById('uploadedImagesCont');
            
            foreach($elements->childNodes as $child) {
                echo $child->nodeName;
            }

        //     if(array_key_exists('deleteBtn', $_POST)) { 
        //         deleteImages(); 
        //     }
        //     function deleteImages() {

        //     }
        ?>
         <!-- <form method="post">
             <input type="submit" name="deleteBtn" value="Slet billeder">
         </form> -->
    </body>
</html>