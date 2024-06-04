<!DOCTYPE html>
<html lang="dk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
    <script src="/src/js/login.js"></script>
    <link rel="stylesheet" href="src/scss/main.css">
	<link rel="icon" type="image/x-icon" href="/src/pictures/favicon.ico">
    <title>Log ind</title>
</head>
<body>
    <?php
    session_start();

    echo $_SESSION['role'];
    if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'uploader')) {
        header("Location: /landing.php");
    }
    ?>

    <h2>Log ind</h2>
    <form id="loginWrapper" method="get">
        <label for="password">Kodeord:</label>
        <div id="inputWrapper">
            <input type="password" id="password" name="password" placeholder="Indtast kodeord...">
            <input id="loginBtn" type="submit" value="Log ind">
        </div>
        <p id="loginText"></p>
    </form>
</body>
</html>