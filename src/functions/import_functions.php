<?PHP
require_once("functions/tables.php");
function exportToCSV($tableName) {
    //Get data from database
    $table = getTable($tableName);
    if($table == NULL) {
        return NULL;
    }
    $data = $table->get_all_records_from_db();
    
    //Create csv file and write to it
    if (!file_exists('export')) {
        mkdir('export', 0777, true);
    }

    $tables = getTableNameDict();
    $filePath = 'export/'.$tables[$table->name].'.csv';

    $fp = fopen($filePath, 'w');
    if($fp == NULL) {
        echo 'Error: Failed to create new csv file. Please try again.';
        return NULL;
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
    return $filePath;
}

//Displays a reactive form that allows the user to import a csv file
function display_import_form($filePath) {
    $regex = "/(<([^>]+)>)/i";
    $fp = fopen($filePath,'r');
    if($fp == null) {
        die('Error: Failed to open file');
    }
    $csv_columns = fgetcsv($fp);

    $tableNames = getTableNameDict();
    $tables = [];
    foreach($tableNames as $key => $value) {
        $tables[$key] = getTable($key);
    }
    
    echo '<script>';
    echo 'let tableNames = '.json_encode($tableNames, JSON_HEX_TAG).';';
    echo 'let tables = '.json_encode($tables, JSON_HEX_TAG).';';
    echo 'console.log(tableNames);console.log(tables);';
    echo '</script>';
    echo '<script src="js/import.js"></script>';

    echo '<h2>Configure CSV Import</h2>';
    //Configuration for database records
    echo '<table id="recordSelection">';
    echo '<tr><th>Database Record Selection</th></tr>';
    /*echo '<tr><td><label for="tableSelect1">Table: </label><select id="tableSelect1" name="tableSelect1">';
    echo '<option value=""></option>';
    foreach($tableNames as $key => $value) {
        echo '<option value="'.$key.'">'.$value.'</option>';
    }
    echo '</select></td>';
    echo '<td>Record Selection:<BR/><input type="radio" id="createRadio1" name="recordOption1" value="create"><label for="createRadio1">Create new record</label>';
    echo '<BR/><input type="radio" id="updateRadio1" name="recordOption1" value="update"><label for="updateRadio1">Update existing record</label>';
    echo '<BR/><input type="radio" id="createupdateRadio1" name="recordOption1" value="createupdate"><label for="createupdateRadio1">Create or update record</label></td>';
    echo '<td></td></tr>';*/
    echo '<tr><td><button id="addTable">Add Option</button></td></tr>';
    echo '</table><BR/>';

    //Table for CSV columns
    echo '<table style="width: 50px;">';
    echo '<tr><th>CSV Column</th><th>Database Column</th></tr>';
    
    for($i = 0; $i < count($csv_columns); $i++) {
        echo '<tr>';
        echo '<td style="border: 2px solid black;">'.preg_replace($regex, "", $csv_columns[$i]).'</td>';
        echo '<td style="border: 2px solid black;">Table: <select class="chooseTable" id="chooseTable'.$i.'"><option></option></select><BR/>Column: <select class="chooseColumn" id="chooseColumn'.$i.'"><option></option></select></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<button>Confirm Import</button>';
    fclose($fp);
}
?>