<?php
session_start();
$docRoot = $_SERVER['DOCUMENT_ROOT'];

// Set a session variable to indicate permission

$_SESSION['role'] = 'admin';

// Redirect to the target URL
header("Location: $docRoot/admin/index.php");
exit();
