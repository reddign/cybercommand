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
?>