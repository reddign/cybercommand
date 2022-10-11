<!DOCTYPE html>
<html lang="en">
<head>
<title>ECMS Database</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins|Oswald">
<link rel ="stylesheet" href="<?php echo $path; ?>css/style.css">
</head>
<?PHP
require_once("../config.php");
require_once("functions/database_functions.php");
session_start();
if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("location:login.php");
    exit;
}

include "navbar.php";
?>
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">