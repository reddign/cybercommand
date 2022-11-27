<?PHP
$path = '';
require_once("functions/basic_html_functions.php");
require_once("../config.php");
require_once("functions/database_functions.php");

require("includes/header.php");

  //page headings
  display_small_page_heading("Profile Page","");
  
  if(isset($_POST["changepassword"]) && $_POST["changepassword"] == $_SESSION['firstName']) {
    $user = authorizeUser($_SESSION['email'],$_POST['origPassword']);
    if($user != false) {
         
    }
  }

  $page = isset($_GET["page"])?$_GET["page"]:"view";
  if($page == "view") {
?>


<div style= "text-align: right;">
        
<button>Edit Profile</button>
<button>View Profile</button>

</div>
<div style="height: 400px;">

First Name: <?PHP echo $_SESSION['firstName']?><BR/><BR/>
Last Name: <?PHP echo $_SESSION['lastName']?><BR/><BR/>
Email: <?PHP echo $_SESSION['email']?><BR/><BR/>
Permission Level: <?PHP echo  $_SESSION['permissionLevel']?><BR/><BR/>
<a href="profile.php?page=password"><button style="text-align: center;">Change Password</button></a>

<?PHP 
if  ($_SESSION['permissionLevel'] > 5){
        echo '<button style="text-align: right;">Create New Account</button>';
}
?>

</div>

<?PHP
  }
  else if($page == "password") {
    echo '<form method="POST" action="profile.php">';
    echo '<label for="origPassword">Old password: </label><input id="origPassword" name="origPassword" type="password"><BR/>';
    echo '<label for="newPassword1">New password: </label><input id="newPassword1" name="newPassword1" type="password"><BR/>';
    echo '<label for="newPassword2">Retype new password: </label><input id="newPassword2" name="newPassword2" type="password"><BR/>';
    echo '<input type="hidden" name="changepassword" value="'.$_SESSION['firstName'].'">';
    echo '<input type="submit" value="Change Password">';
    echo '</form>';
  }
require("includes/footer.php");
?>
