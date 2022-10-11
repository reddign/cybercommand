<?PHP
$path = '';
require("../config.php");
require("includes/header.php");
require("functions/basic_html_functions.php");
require("functions/database_functions.php");
require("functions/openings_functions.php");

//Sets the page value for display
$page = isset($_GET["page"])?$_GET["page"]:"search";
//If a form post lead the user here, we process the posted data in a function
if(isset($_POST) && isset($_POST["page"]) && $_POST["page"]=="save"){
  process_job_form_data($_POST);
  exit;
}
//otherwise we display the page

display_page_heading("Job Openings","");
display_openings_navigation("Openings");

switch($page){
  case "search":
    $string = isset($_GET["search"])?$_GET["search"]:"";
    $jobs = get_job_by_name($string);
    display_search_form();
    display_job_list($jobs);
    break;
  case "add":
    display_job_form();
    break;
  case "edit":
    $jid = isset($_GET["jid"])?$_GET["jid"]:"";
    $job = get_job($jid);
    display_job_form($job);
    break;
  case "job":
    $jid = isset($_GET["jid"])?$_GET["jid"]:"";
    $job = get_job($jid);
    display_job_info($job);
    break;

}

require("includes/footer.php");
