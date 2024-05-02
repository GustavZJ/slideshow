<?php
foreach ($_POST['file'] as $file) {
    if (file_exists('../uploads/'.$file)) {
        unlink('../uploads/'.$file);
    }
header('location: imageManager.php');
exit();
}  