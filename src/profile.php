<?PHP
$path = '';
require_once("functions/basic_html_functions.php");
require_once("../config.php");
require_once("functions/database_functions.php");

require("includes/header.php");

  //page headings
  display_small_page_heading("Profile Page","");
  
?>
<div style= "text-align: right;">
        
        <button>Edit Profile</button>
        <button>View Profile</button>
</div>
<div style="height: 400px;">

        First Name: <br>
        <br>
  
  
        Last Name:<br>
        <br>
    
        Email:<br>
        <br>

        Permission Level: 
        <br>
        <br>
        <button style="text-align: center;">Change Password</button>
        <button style="text-align: right;">Create New Account</button>
    </div>

    <?PHP
    
    require("includes/footer.php");
    ?>
