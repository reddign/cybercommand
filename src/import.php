<?PHP
$path = '';

require_once("functions/basic_html_functions.php");
require_once("../config.php");
require_once("functions/database_functions.php");
require_once("functions/generalized_functions.php");
require_once("functions/tables.php");

$page = isset($_GET["page"])?$_GET["page"]:"export";

if(isset($_POST)) {
    //If the user has requested an export, generate a csv file and make them download it
    if(isset($_POST["tableSelect"]) && array_key_exists($_POST["tableSelect"], $tables)){
        //Get data from database
        $table = getTable($_POST["tableSelect"]);
        $data = $table->get_all_records_from_db();
        
        //Create csv file and write to it
        if (!file_exists('export')) {
            mkdir('export', 0777, true);
        }
        $fp = fopen('export/'.$tables[$table->name].'.csv', 'w');
        if($fp == NULL) {
            echo 'Error: Failed to create new csv file. Please try again.';
            exit;
        }
        $dispNames = [];
        $fkTables = [];
        foreach($table->columns as $column) {
            if(!$column->pk)
                $dispNames[] = $column->dispName;
            if($column->fk) {
                $fkTables[$column->name] = $table->getFKTable($column->name);
            }
        }

        fputcsv($fp, $dispNames);
        foreach ($data as $tableRow) {
            $row = [];
            foreach($table->columns as $column) {
                if($column->pk)
                    continue;

                $type = $column->datatype;

                if(!isset($tableRow[$column->name]) && substr_compare($type, "TINYINT",0,7,true) !== 0) {
                    $row[] = "";
                    continue;
                }
                if($column->fk) {
                    $fkTable = $fkTables[$column->name];
                    $fkRecord = $fkTable->get_record($tableRow[$column->name]);
                    if(!is_array($fkRecord)) {
                        $row[] = "";
                        continue;
                    }

                    $dc = $fkTable->dispColumns;
                    $dispName = "";
                    for($i=0; $i <  count($dc); $i++) {
                        if($i !== 0) {
                            $dispName .= ' ';
                        }
                        $dispName .= $fkRecord[$dc[$i]];
                    }
                    
                    //TODO LINK FKs
                    $row[] = $dispName;
                    continue;
                }

                // Check data type to see if the output must be modified to be human-readable
                if(substr_compare($type, "DATE",0,4,true) == 0) {
                    $row[] = date('m/d/Y', strtotime($tableRow[$column->name]));
                }
                else if(substr_compare($type, "TIME",0,4,true) == 0) {
                    $row[] = date('g:iA', strtotime($tableRow[$column->name]));
                }
                else if(substr_compare($type, "TINYINT",0,7,true) == 0) {
                    $row[] = $tableRow[$column->name] == 1 ? "YES" : "NO";
                }
                else { 
                    $row[] = $tableRow[$column->name];
                }
            }
            fputcsv($fp, $row);
        }
        unset($fields);
        fclose($fp);
        //var_dump($data);
        //echo "<BR/><a href='import.php'>Back</a>";
        header("location:export/".$tables[$table->name].".csv");  //Start actual download
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
}


require("includes/footer.php");
?>