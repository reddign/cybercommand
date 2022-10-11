<?PHP
$path = '';
require_once("functions/basic_html_functions.php");
require_once("../config.php");
require_once("functions/database_functions.php");
require_once("functions/generalized_functions.php");

$fileName = "first_landings.php";
$table = new Table('first_landings', ['First Landing ID','Company ID','Student ID','Title','Location','Salary','Offer Date','What are you doing after graduation','In EMCS Network','Did you intern at this company?','Relationship to Major(s) and Minor(s)','Matches Career Path','Department','Notes'], ['title']);

//Sets the page value for display
$page = isset($_GET["page"])?$_GET["page"]:"search";
//If a form post lead the user here, we process the posted data in a function
if(isset($_POST) && isset($_POST["page"]) && $_POST["page"]=="save"){
  $table->updateDatabase($fileName, $_POST);
  exit;
}
//otherwise we display the page
require("includes/header.php");

  //page headings
  display_small_page_heading("First Landings","");

  $table->display_page_navigation($fileName,"First Landing",$page);
 

//Display appropriate page based on the $page var
  switch($page){
    case "search":
      $string = isset($_GET["search"])?$_GET["search"]:"";
      $records = $table->get_records_by_dispCols($string);
      $table->display_search_form($fileName,"First Landing");
      $table->display_record_list($fileName, $records);
      break;
    case "add":
      $table->display_form($fileName);
      break;
    case "edit":
      $id = isset($_GET["id"])?$_GET["id"]:"";
      $record = $table->get_record($id);
      $table->display_form($fileName, $record);
      break;
    case "display":
      $id = isset($_GET["id"])?$_GET["id"]:"";
      $record = $table->get_record($id);
      $table->display_record_info($fileName, $record);
      break;

  }
  

require("includes/footer.php");
