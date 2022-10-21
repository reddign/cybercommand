<?PHP
$path = '';
require_once("functions/basic_html_functions.php");
require_once("../config.php");
require_once("functions/database_functions.php");
require_once("functions/generalized_functions.php");

$fileName = "contacts.php";
$table = new Table('contact', ['Contact ID','Company ID','First Name','Last Name','Job Title','Contact Type','Email','Phone Number','Primary Contact','Engagement Level','Etown Priority Partner','Company Domain','Industry','Major/Concentrations','Notes'], ['firstName','lastName']);
$table->addOptionsToCol('contactType',['Employer', 'Community partner', 'Higher ed','Other']);
$table->addOptionsToCol('engagementLevel',['Lead', 'Beginning', 'Developing', 'Strategic', 'Other']);

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
  display_small_page_heading("Industry Contacts","");

  $table->display_page_navigation($fileName,"Contact",$page);
 

//Display appropriate page based on the $page var
  switch($page){
    case "search":
      $string = isset($_GET["search"])?$_GET["search"]:"";
      $records = $table->get_records_by_dispCols($string);
      $table->display_search_form($fileName,"Contact");
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
