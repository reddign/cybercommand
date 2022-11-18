<?PHP
$path = '';
require("includes/header.php");
require_once("functions/basic_html_functions.php");
require_once("functions/database_functions.php");
require_once("functions/survey_functions.php");
?>

 <!-- Header -->
 <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b></b></h1>
    <h1 class="w3-xxxlarge w3-text- blue"><b>Student Survey</b></h1>
    <hr style="width:50px;border:5px solid blue" class="w3-round">
  </div>

<?php
$page = isset($_GET["page"])?$_GET["page"]:"login";
display_survey_page_navigation($page);

if(isset($_POST)) {
  print_r($_POST);
}

switch($page){
    case "login":
      display_survey_form();
      break;
    case "fall":
      student_survey_form();
      break;
    case "spring":
      student_survey_form();
      summer_survey_form();
      break;
  }
  
  



require("includes/footer.php");
