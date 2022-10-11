<?php
require_once("../config.php");
require_once("functions/database_functions.php");
session_start();
$messageStr = "";

//Logout functionality
if(isset($_GET['logout'])) {
    session_destroy();
    session_start();
    $messageStr = "<h5 style='color: green;'>You have successfully signed out</h5>";
}

if(!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = false;
}

//Login form check
if(isset($_POST['login']) && !$_SESSION['loggedIn']) {
    $username = isset($_POST['email'])?$_POST["email"]:"";
    $password = isset($_POST['password'])?$_POST["password"]:"";
    $user = authorizeUser($username,$password);
    $_SESSION["loggedIn"] = is_array($user);
    if($_SESSION['loggedIn']) {
        $_SESSION['firstName'] = $user['firstName'];
        $_SESSION['lastName'] = $user['lastName'];
    }
    else if($username != "" || $password != "") {
        $messageStr = "<h5 style='color: red;'>Error: Invalid login</h5>";
    }
}
//Redirection for already logged in users
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    header("location:index.php");
    exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>ECMS Database</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins|Oswald">
<link rel ="stylesheet" href="<?php echo $path; ?>css/style.css">
</head>
<body>
    <div id="loginFormDiv" style="text-align: center; background-color: light_blue; margin-top: 10em;">
    <h1>Login to the EMCS Database</h1>
    <form id="loginForm" method=post action=login.php>
    Email: <input name="email" type="text" style="margin: 5px; width: 20em;"><BR/>
    Password: <input name="password" type="password" style="margin: 5px; width: 20em;"><BR/>
    <input type="hidden" name="login" value="login">
    <input type="submit" value="Submit" style="margin: 5px;"><BR/>
    </form>
    <?php echo $messageStr ?>
    </div>
</body>
</html>