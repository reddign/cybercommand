<?PHP
$path = '';

require_once("functions/basic_html_functions.php");
require_once("../config.php");
require_once("functions/database_functions.php");
require_once("functions/generalized_functions.php");
require_once("functions/import_functions.php");
require_once("functions/tables.php");

$page = isset($_GET["page"])?$_GET["page"]:"export";
$tables = getTableNameDict();

if(isset($_POST)) {
    //If the user has requested an export, generate a csv file and make them download it
    if(isset($_POST["tableSelect"]) && array_key_exists($_POST["tableSelect"], $tables)){
        $filePath = exportToCSV($_POST["tableSelect"]);
        if($filePath != NULL)
            header("location:".$filePath);  //Start actual download
        exit;
    }
}
//Headers
require("includes/header.php");
display_small_page_heading("Data Exporter");

//Page navigation
echo '<h4><div style="margin-top:5px;margin-bottom:45px;">';
echo '<a href="import.php?page=export"'.($page == "export" ? ' class="selected"' : '').'>Export</a>';
echo ' | ';
echo '<a href="import.php?page=import"'.($page == "import" ? ' class="selected"' : '').'>Import</a>';
echo '<div></h4>';

switch($page) {
    case "export":
        echo "<p>Select which table to download from:</p>";
        echo "<form id='tableForm' method='POST' action='import.php'>";
        echo "<select id='tableSelect' name='tableSelect'>";

        foreach($tables as $tableName => $displayName) {
        echo "<option value='".$tableName."'>".$displayName."</option>";
        }
        unset($displayName);
        echo "</select>";
        echo "<input style='margin-left: 2em;' type='submit' value='Download'>";
        echo "</form>";
        echo "<p><i>Please note that the exporting process may take some time.</i></p>";
        break;
    case "import":
        echo '<form action="import.php" method="post" enctype="multipart/form-data">
            <input type="file" id="myFile" name="myFile"><BR/>
            <input type="submit">
            </form>';
        break;
}


require("includes/footer.php");
?>