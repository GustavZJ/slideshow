<?php
session_start();


// Set a session variable to indicate permission

$_SESSION['role'] = 'admin';

// Redirect to the target URL
header("Location: /admin/index.php");
exit();
