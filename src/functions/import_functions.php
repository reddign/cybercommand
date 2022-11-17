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

    echo '<form method="POST" action="import.php">';
    echo '<h2>Configure CSV Import</h2>';
    //Configuration for database records
    echo '<table id="recordSelection">';
    echo '<tr><th>Database Record Selection</th></tr>';
    echo '<tr><td><button form="" id="addTable">Add Option</button></td></tr>';
    echo '</table><BR/>';

    //Table for CSV columns
    echo '<table style="width: 50px;">';
    echo '<tr><th>CSV Column</th><th>Database Column</th></tr>';
    
    for($i = 0; $i < count($csv_columns); $i++) {
        echo '<tr>';
        echo '<td style="border: 2px solid black;">'.preg_replace($regex, "", $csv_columns[$i]).'</td>';
        echo '<td style="border: 2px solid black;">Table: <select class="chooseTable" id="chooseTable'.$i.'" name="chooseTable'.$i.'"><option></option></select><BR/>Column: <select class="chooseColumn" id="chooseColumn'.$i.'" name="chooseColumn'.$i.'"><option></option></select></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<input type="hidden" id="availableRecords" name="availableRecords" value={}>';
    echo '<input type="submit" value="Confirm Import">';
    echo '</form>';
    fclose($fp);
}

// Performs the final steps of the import including checking input and modifying the database
// Uses availRecs to determine how many/what types of queries must be made
// Uses chooseTableX and chooseColumnX variables to determine what data gets mapped to what
function completeImport($postData, $filePath) {
    $pdo = connect_to_db();
    $mapping = [];
    $availRecs = json_decode($postData["availableRecords"], true);
    $fp = fopen($filePath,'r');
    $numCols = count(fgetcsv($fp));
    $tableNameDict = getTableNameDict();
    $tables = [];
    foreach($tableNameDict as $tableName => $unusedVal) {
        $tables[$tableName] = getTable($tableName);
    }
    unset($tableName, $unusedVal);

    //Craft sql queries that will only be missing bound variables
    $queries = [];
    foreach($availRecs as $tableName => $options) {
        $sqlpt1 = "INSERT INTO ".$tableName." (";
        $sqlpt2 = ") VALUES (";
        $first = true;

        for($i = 0; $i < $numCols; $i++) {
            if($postData["chooseTable".$i] != $tableName)
                continue;
            
            $mapping[$i] = $tableName;
            $columnName = $postData["chooseColumn".$i];
            if(!validColumn($tables[$tableName], $columnName)) {
                echo "Error: Column name not found in table ".$tableName;
                exit;
            }
            if($first) {
                $first = false;
            }
            else {
                $sqlpt1 .= ',';
                $sqlpt2 .= ',';
            }
            $sqlpt1 .= $columnName;
            $sqlpt2 .= ":col".$i;
        }
        //Add sql to list of queries if there is at least one piece of data to be inserted
        if(!$first) {
            $queries[$tableName] = $pdo->prepare($sqlpt1.$sqlpt2.");");
        }
    }
    unset($tableName, $options);
    
    //Setup prototype for bound variable lists
    $boundVarsPrototype = [];
    foreach($queries as $tableName => $stmt) {
        $boundVarsPrototype[$tableName] = [];
    }
    unset($tableName, $stmt);

    while(!feof($fp)) {
        $csvRow = fgetcsv($fp);
        if(!is_array($csvRow))
            break;
        $boundVars = $boundVarsPrototype;
        for($i = 0; $i < $numCols; $i++) {
            if(!isset($mapping[$i]))
                continue;
            $boundVars[$mapping[$i]][":col".$i] = $csvRow[$i];
        }

        foreach($queries as $tableName => $stmt) {
            $stmt->execute($boundVars[$tableName]);
        }
        unset($tableName, $stmt);
    }
}
//Returns true if a column name is in fact in that table
function validColumn($table, $columnName) {
    return $table->getColumn($columnName) != NULL;
}
//TODO
//Function that converts human-readable data to database-friendly data
function convertData($data, $type) {
    if(substr_compare($type, "DATE",0,4,true) == 0) {
        $row[] = date('m/d/Y', strtotime($tableRow[$column->name]));
    }
    else if(substr_compare($type, "TIME",0,4,true) == 0) {
        //TODO
    }
    else if(substr_compare($type, "TINYINT",0,7,true) == 0) {
        return substr_compare($data,"YES",0,3,true) || ((int)$data) == 1;
    }
    return $data;
}
?>