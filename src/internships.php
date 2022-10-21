<?PHP
$path = '';
require_once("functions/basic_html_functions.php");
require_once("../config.php");
require_once("functions/database_functions.php");
require_once("functions/generalized_functions.php");

$fileName = "internships.php";
$table = new Table('internship', ['Internship ID','Student ID','Company ID','Title','Department','Experimental Learning','Work-based Learning','Term','SLE/Credit','Career Path','Mode','Rating','Wage Range','EMCS Network','Notes'], ['title']);
$table->addOptionsToCol('workBasedLearning',['Internship', 'SCARP', 'REU', 'Trade', 'Co-op', 'Field placement', 'Other']);
$table->addOptionsToCol('careerPath',['Yes','No','Maybe']);
$table->addOptionsToCol('mode',['Virtual', 'In person', 'Hybrid']);

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
  display_small_page_heading("Internships","");

  $table->display_page_navigation($fileName,"Internship",$page);
 

//Display appropriate page based on the $page var
  switch($page){
    case "search":
      $string = isset($_GET["search"])?$_GET["search"]:"";
      $records = $table->get_records_by_dispCols($string);
      $table->display_search_form($fileName,"Internship");
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
