<?PHP
$path = '';
require_once("functions/basic_html_functions.php");
require_once("../config.php");
require_once("functions/database_functions.php");
require_once("functions/accounts_functions.php");

require("includes/header.php");


display_small_page_heading("Account Manager","");

if($_SESSION['permissionLevel'] < 10) {
    echo "You do not have permission to view this page";
}

if($_SESSION['permissionLevel'] >= 10 && isset($_POST["userIDToDelete"])) {
    deleteAccount($_POST["userIDToDelete"]);
    echo "<p>Account Deleted</p>";
}
else if($_SESSION['permissionLevel'] >= 10 && isset($_POST["addAccount"])) {
    if($_POST['permissionLevel'] == "") {
        $_POST['permissionLevel'] = 0;
    }
    createAccount($_POST);
    echo "<p>Account Added</p>";
}

$page = isset($_GET["page"])?$_GET["page"]:"view";
switch($page) {
    case "view":
    default:
        displayAllAccounts();
        echo "<a href='manage_accounts.php?page=add'><button type='button'>Add New Account</button></a>";
        break;
    case "add":
        display_account_form();
        break;
}


require("includes/footer.php");
?>