<?PHP
$path = '';
require("../config.php");
require("functions/basic_html_functions.php");
require("functions/database_functions.php");
require("functions/companies_form_function.php");

//Sets the page value for display
$page = isset($_GET["page"])?$_GET["page"]:"search";
//If a form post lead the user here, we process the posted data in a function
if(isset($_POST) && isset($_POST["page"]) && $_POST["page"]=="save"){
  process_company_form_data($_POST);
  exit;
}
//otherwise we display the page
require("includes/header.php");

  //page headings
  display_page_heading("Companies","");

  display_company_page_navigation("Companies");
 

  //TODO: update cases for companies
  switch($page){
    case "search":
      $string = isset($_GET["search"])?$_GET["search"]:"";
      $companies = get_company_by_name($string);
      display_search_form();
      display_company_list($companies);
      break;
    case "add":
      display_company_form();
      break;
    case "edit":
      $cid = isset($_GET["cid"])?$_GET["cid"]:"";
      $company = get_company($cid);
      display_company_form($company);
      break;
    case "company":
      $cid = isset($_GET["cid"])?$_GET["cid"]:"";
      $company = get_company($cid);
      display_company_info($company);
      break;

  }
  

require("includes/footer.php");
