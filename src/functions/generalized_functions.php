<?php
require("../config.php");
require("functions/database_functions.php");

/*$pdo = connect_to_db();
$data = $pdo->query("DESCRIBE INTERNSHIP")->fetchAll();
for($i=0; $i < count($data); $i++) {
    foreach($data[$i] as $key => $value) {
        if(gettype($key) == 'integer')
            continue;
        echo $key." => ".$value.'<BR/>';
    }
    echo '<BR/>';
}*/

class Column {
    public $name;
    public $dispName;
    public $datatype;
    public $pk;
    public $fk;
    public $searchable;
    
    public function __construct($name, $dispName, $datatype, $pk=false, $fk=false, $searchable=false) {
    	$this->name = $name;
        $this->dispName = $dispName;
        $this->datatype = $datatype;
        $this->pk = $pk;
        $this->fk = $fk;
        $this->searchable = $searchable;
    }
    
    public function getLabelStr() {
    	return '<label for="'.$this->name.'">'.$this->dispName.': </label>';
    }
}

class Table {
	public $name;
	public $columns;
    public $dispColumns; //ie name, title, etc.
    
    // Creates a table object that mirrors the table with the same name in the database
    // Requires dispNames array as more human friendly column names
    // dispColumns array is an array of all column names that are name, title, etc.
    public function __construct($tableName, $dispNames, $dispColumns) {
    	$this->name = $tableName;
        $this->columns = array();
        $this->dispColumns = $dispColumns;
        $pdo = connect_to_db();
        $data = $pdo->query("DESCRIBE ".$tableName.";")->fetchAll();
        
        // Get column information from database
        for($i=0; $i < count($data); $i++) {
        	$colInfo = $data[$i];
        	$column = new Column($colInfo['Field'], $dispNames[$i], $colInfo['Type'], $colInfo['Key']=="PRI", $colInfo['Key']=="MUL", false);
            array_push($this->columns, $column);
        }
    }
    
    public function getDispName() {
    	return ucwords($this->name);
    }
	public function getPrimaryKey() {
    	foreach($this->columns as $column) {
        	if($column->pk)
            	return $column;
        }
    }
}
// Name: Display Form Function
// Params:
//  - table: Table object that represents the layout of a sql table
//  - fileName: Name of the file to submit form to
//  - data: Array of prior data if editing an item
//
// Description: Displays a form that allows the user to input all fields for a row in the specified table
function display_form($table, $fileName, $data=null){
    if($data == null){
        $formHTML = "<h2>Add ".$table->getDispName()."</h2>";
        $data = [];
        foreach($table->columns as $column) {
        	$data[$column->name] = "";
        }
        //$checked = "";
        $buttonString = "Add ".$table->getDispName();
    }else{
        $formHTML = "<h2>Edit ".$table->getDispName()."</h2>";
        //$checked = ($internship["alumni"]==1)? " checked " : "";
        $buttonString = "Edit ".$table->getDispName();
    }
    echo '<form method=post action='.$fileName.'>';
    foreach($table->columns as $column) {
    	// Primary Key is a hidden value
        if($column->pk) {
        	echo '<input name="'.$column->name.'" type="hidden"  value="'.$data[$column->name].'">';
            continue;
        }
        if($column->fk) {
        	echo 'FOREIGN KEY NOT IMPLEMENTED YET<BR/>';
            continue;
        }
    	// Check data type to see what html input must be used
        $type = $column->datatype;
        echo $column->getLabelStr();
        if(substr_compare($type, "INT",0,3,true) == 0) {
        	echo '<input type="number" name="'.$column->name.'" id="'.$column->name.'" value="'.$data[$column->name].'"><BR/>';
        }
        else if(substr_compare($type, "DATE",0,4,true) == 0) {
            echo '<input type="date" name="'.$column->name.'" id="'.$column->name.'" value="'.$data[$column->name].'"><BR/>';
        }
        else if(substr_compare($type, "TINYINT",0,7,true) == 0) {
        	$checked = ($data[$column->name] == 1) ? " checked" : "";
            echo '<input type="checkbox" name="'.$column->name.'" id="'.$column->name.'" value="1"'.$checked.'"><BR/>';
        }
        else if(substr_compare($type, "VARCHAR",0,7,true) == 0) { 
        	$numChars = (int) (substr($type,0,strlen($type)-8));
            $width = ($numChars > 50) ? 200 : 100;
            $height = ceil($numChars / 100) * 15;
            
            echo '<input type="text" name="'.$column->name.'" id="'.$column->name.'" value="'.$data[$column->name].'" width="'.$width.'px" height="'.$height.'px"><BR/>';
        }
    }
    echo '<input name="page" type="hidden" value="save">
        <input type="submit" value="'.$buttonString.'">
    </form>';
}
// Display Links to Add and Search pages
function display_page_navigation($fileName, $pageName, $currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="'.$fileName.'?page=search"'.($currentPage == "search" ? ' class="selected"' : '').'>Search</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="'.$fileName.'?page=add"'.($currentPage == "add" ? ' class="selected"' : '').'>Add '.$pageName.'</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}
// Display a text box for searching
function display_search_form($fileName, $pageName){
    echo '<h2>Search for a '.$pageName.'</h2><form method=get action="'.$fileName.'">
        <label for="search">Enter Search text:</label> <input id="name" name="search" type="text" autofocus>
        <input name="page" type="hidden" value="search">
        <input type="submit" value="Search">
    </form><br/><br/>';

}

// Get all records in the provided table
function get_all_records_from_db($table){
    $pdo = connect_to_db();
	$dc = $table->dispColumns;
    $sql = "SELECT * FROM ".$table->name." ORDER BY " . $dc[count($dc)-1];
    for($i=count($dc)-2; $i >= 0; $i--) {
    	$sql .= ",".$dc[$i];
    }
    $data = $pdo->query($sql.";")->fetchAll();
    return $data;
}

// Get the one record with the specified id
function get_record($table, $id){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM ".$table->name." WHERE ".$table->getPrimaryKey()->name."=:id");
    $stmt->execute([':id' => $id]); 
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
   
    return $record;
}

// Searches for records with display columns(name, title) that match $word
function get_records_by_dispCols($table, $word){
    if($word==""){
        return get_all_records_from_db($table);
    }
    $sql = "";
    $dc = $table->dispColumns;
    if(count($table->dispColumns) == 1) {
    	$sql = "SELECT * FROM ".$table->name." WHERE ".$dc[0]." LIKE :word ORDER BY ".$table->dispColumns[0].";";
    }
    else {
    	$sqlpt1 = "SELECT * FROM ".$table->name." WHERE concat(".$table->dispColumns[0];
        $sqlpt2 = ") LIKE :word ORDER BY ".$dc[count($dc)-1];
        for($i=1; $i <  count($dc); $i++) {
        	$sqlpt1 .= ", ' ', ".$dc[$i];
            $sqlpt2 .= ",".$dc[count($dc)-1-$i];
        }
        $sql = $sqlpt1.$sqlpt2.";";
    }
    
    $pdo = connect_to_db();
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':word' => "%".$word."%"]);
    $data = [];
    while($record =  $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $record;
    } 
    
    return $data;
}    

// Displays a list of records that link to the page for that record
function display_record_list($table, $fileName, $data=null){
    if(!is_array($data) || sizeof($data) == 0){
        echo "No matching ".$table->name."s found";
        return;
    }
    foreach ($data as $row) {
            echo "<a href='".$fileName."?page=display&id=".$row[$table->getPrimaryKey()->name]."'>";
            $dc = $table->dispColumns;
            $dispName = $row[$dc[0]];
            for($i=1; $i <  count($dc); $i++) {
            	$dispName .= " ".$row[$dc[$i]];
            }
            if(trim($dispName) == "")
                echo "Unnamed<BR/>";
            else
                echo $dispName."<BR/>";
            echo "</a>";
    }
}

// Displays all fields for one record in a human-readable way
function display_record_info($table, $fileName, $record) {
	if(!is_array($record)) {
    	echo $table->getDispName()." Information not found";
        return;
    }
    foreach($table->columns as $column) {
    	//User doesn't need to see the id number
        if($column->pk)
        	continue;
            
        else if($column->fk) {
        	echo "Foreign key display not yet implemented<BR/>";
            continue;
        }
        //Make sure first and last name display together if they exist
        else if($column->name == 'firstName' && array_key_exists('lastName', $record)) {
        	echo "<h4><b>Name:</b> ".$record['firstName']." ".$record['lastName']."</h4>";
            continue;
        }
        else if($column->name == 'lastName' && array_key_exists('firstName', $record)) {
        	continue;
        }
        //Display column info with formatting depending on data type
        else {
       		if(substr_compare($column->datatype, "TINYINT",0,7,true) == 0) {
            	echo "<h4><b>".$column->dispName.":</b> ".($record[$column->name] ? "YES" : "NO")."</h4>";
            }
            else if(substr_compare($column->datatype, "DATE",0,7,true) == 0) {
            	//TODO - PRINT DATES NICELY
            	echo "<h4><b>".$column->dispName.":</b> ".$record[$column->name]."</h4>";
            }
        	else {
            	echo "<h4><b>".$column->dispName.":</b> ".$record[$column->name]."</h4>";
            }
        }
    }
    echo "<a href='".$fileName."?page=edit&id=".$record[$table->getPrimaryKey()->name]."'> Edit Info </a><BR/>";
}


// Name: Update Database
// Params:
//  - table: Table object that represents the layout of a sql table
//  - fileName: Name of the file to redirect to
//  - data: Array of data to send to database
//
// Description:
// 	Updates an existing record or adds a record to the database
// 	Redirects to a page displaying the record afterwards
function updateDatabase($table, $fileName, $data) {
	$pdo = connect_to_db();
   	$id = $data[$table->getPrimaryKey()->name];
    
    if($id == "") { //Add
    	$stmtpt1 = "INSERT INTO ".$table->name." (";
        $stmtpt2 = ") VALUES (";
        $boundParams = [];
        $firstNoComma = true;
        foreach($table->columns as $column) {
        	if($column->pk)
            	continue;
            
            if($firstNoComma) {
            	$firstNoComma = false;
            } else {
                $stmtpt1 .= ",";
                $stmtpt2 .= ",";
            }
            $name = $column->name;
            $stmtpt1 .= $name;
            $stmtpt2 .= ":" . $name;
            $boundParams[$name] = $data[$name];
        }
        $stmt = $pdo->prepare($stmtpt1.$stmtpt2.");");
        $stmt->execute($boundParams);
        $id = $pdo->lastInsertId();
    	header("location:".$fileName."?page=display&id=".$id."&message=".$table->getDispName()." Added");
    } 
    else { //Edit
    	$stmtpt1 = "UPDATE ".$table->name." SET ";
        $stmtpt2 = " WHERE ";
        $boundParams = [];
        $firstNoComma = true;
        foreach($table->columns as $column) {
        	$name = $column->name;
        	$boundParams[$name] = $data[$name];
        	if($column->pk) {
            	$stmtpt2 .= $name."=:".$name;
                continue;
			}
            
            if($firstNoComma) {
            	$firstNoComma = false;
            } else {
                $stmtpt1 .= ",";
            }
            $stmtpt1 .= $name."=:".$name;
        }
        $stmt = $pdo->prepare($stmtpt1.$stmtpt2.";");
        $stmt->execute($boundParams);
        header("location:".$fileName."?page=display&id=".$id."&message=".$table->getDispName()." Updated");
    }
}

?>