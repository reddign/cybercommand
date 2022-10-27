<?PHP
$path = '';
require_once("functions/basic_html_functions.php");
require_once("../config.php");
require_once("functions/database_functions.php");
session_start();

require("includes/header.php");

  //page headings
  display_small_page_heading("Profile Page","");
  
?>

<div style= "text-align: right;">
        
        <button>Edit Profile</button>
        <button>View Profile</button>
</div>
<div style="height: 400px;">

        First Name: <?PHP echo $_SESSION['firstName']?>
        <br>
        <br>
  
  
        Last Name: <?PHP echo $_SESSION['lastName']?>
        <br>
        <br>
    
        Email: <?PHP echo $_SESSION['email']?>
        <br>
        <br>

        Permission Level: <?PHP echo  $_SESSION['permissionLevel']?>
        <br>
        <br>
        <button style="text-align: center;">Change Password</button>
        
        <?PHP if  ($_SESSION['permissionLevel'] > 5){
                echo '<button style="text-align: right;">Create New Account</button>';
        }
        ?>

    </div>

    <?PHP
    
    require("includes/footer.php");
    ?>
