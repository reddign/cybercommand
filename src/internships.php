<?PHP
$path = '';
require("functions/basic_html_functions.php");
require("functions/generalized_functions.php");

// 
$fileName = "internships.php";
$table = new Table('internship', ['Internship ID','Student ID','Department','Primary Major','Experimental Learning','Term','Company','Position of Study','SLE','Career Path','Mode','Rating','Wage Range','EMCS Network','Why did you add this column Chris'], ['company']);

//Sets the page value for display
$page = isset($_GET["page"])?$_GET["page"]:"search";
//If a form post lead the user here, we process the posted data in a function
if(isset($_POST) && isset($_POST["page"]) && $_POST["page"]=="save"){
  updateDatabase($table, $fileName, $_POST);
  exit;
}
//otherwise we display the page
require("includes/header.php");

  //page headings
  display_page_heading("Internships","");

  display_page_navigation($fileName,"Internship",$page);
 

  //TODO: update cases for companies
  switch($page){
    case "search":
      $string = isset($_GET["search"])?$_GET["search"]:"";
      $records = get_records_by_dispCols($table, $string);
      display_search_form($fileName,"Internship");
      display_record_list($table, $fileName, $records);
      break;
    case "add":
      display_form($table, $fileName);
      break;
    case "edit":
      $id = isset($_GET["id"])?$_GET["id"]:"";
      $record = get_record($table, $id);
      display_form($table, $fileName, $record);
      break;
    case "display":
      $id = isset($_GET["id"])?$_GET["id"]:"";
      $record = get_record($table, $id);
      display_record_info($table, $fileName, $record);
      break;

  }
  

require("includes/footer.php");
