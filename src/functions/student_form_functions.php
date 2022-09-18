<?PHP
function display_student_form($student=""){

    if($student==""){
        $formHTML = "<h2>Add Student</h2>";
        $student = [];
        $student["studentID"] = "";
        $student["lastName"] = "";
        $student["firstName"] = "";
        $student["gradYear"] = "";
        $student["alumni"] = "";
        $checked = "";
        $buttonString = "Add Student";
    }else{
        $formHTML = "<h2>Edit Student</h2>";
        $checked = ($student["alumni"]==1)? " checked " : "";
        $buttonString = "Edit Student";
    }
    echo '<form method=post action=students.php>
        First Name:<input name="first_name" type="text" value="'.$student["firstName"].'"><BR/>
        Last Name:<input name="last_name" type="text" value="'.$student["lastName"].'"><BR/>
        Grad Year:<input name="grad_year" type="text" value="'.$student["gradYear"].'"><BR/>
        <input name="sid" type="hidden"  value="'.$student["studentID"].'">
        <input name="page" type="hidden" value="save">
        alumni<input name="alumni" type="checkbox" value="1" '.$checked.'><BR/>
        <input type="submit" value="'.$buttonString.'">
    </form>';

}
function display_student_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="students.php?page=search" class="selected">Search</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="students.php?page=add">Add Student</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}
function display_search_form(){
    echo '<h2>Search for a student by Name</h2><form method=get action="students.php">
        <label for="search">Enter Student Name:</label> <input id="name" name="search" type="text" autofocus>
        <input name="page" type="hidden" value="search">
        <input type="submit" value="Search">
    </form><br/><br/>';

}

function display_student_list($data=null){
    if(!is_array($data) || sizeof($data) == 0){
        echo "No matching students found";
        return;
    }
    foreach ($data as $row) {
            echo "<a href='students.php?page=student&sid=".$row['studentID']."'>";
            echo $row['firstName']." ".$row['lastName']."<br />\n";
            echo "</a>";
    }
}

function display_student_info($student){
    if(!is_array($student)){
        echo "Student Information not found";
    }
    echo "<h4><b>Name:</b> ".$student['firstName']." ".$student['lastName']."</h4>";
    echo "<h4><b>Grad Year:</b> ".$student['gradYear']."</h4>";
    echo "<h4><b>Alumni:</b> ".($student['alumni']?"YES":"NO")."</h4>";
    echo "<a href='students.php?page=edit&sid=".$student['studentID']."'> Edit Info </a><BR/>";
    
    # Survey info here? And if no survey has been taken by the student, maybe a button here that would send the student an email directing them to take the survey.
    # See the email function in survey_fuctions.php
}

function get_student($sid){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM student WHERE studentID=:sid");
    $stmt->execute([':sid' => $sid]); 
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
   
    return $student;
} 
function get_student_by_name($word){
    if($word==""){
        return get_all_students_from_db();
    }
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM student WHERE concat(firstName, ' ', lastName) LIKE :name ORDER BY lastName,firstName");
    $stmt->execute([':name' => "%".$word."%"]);
    $data = [];
    while($student =  $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $student;
    } 
    
    return $data;
}    
function get_all_students_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM student ORDER BY lastName,firstName")->fetchAll();
    return $data;
}
function process_student_form_data($arrayData){
    $sid = $arrayData["sid"];
    if($sid==""){
        addStudent($arrayData);
    }else{
        editStudent($arrayData);
    }
    
}
function addStudent($arrayData){
    $last_name = $arrayData["last_name"];
    $first_name = $arrayData["first_name"];
    $gradYear = $arrayData["grad_year"];
    $alumni = isset($arrayData["alumni"])?1:0;
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("insert into student (firstName,lastName,gradYear,alumni) VALUES (:first,:last,:gradYr,:alum)");
    $stmt->execute([':first' => $first_name, ":last"=> $last_name, ":gradYr"=>$gradYear,":alum"=>$alumni]);
    $sid = $pdo->lastInsertId();
    header("location:students.php?page=student&sid=".$sid."&message=Student Added");
  
}
function editStudent($arrayData){
    $last_name = $arrayData["last_name"];
    $first_name = $arrayData["first_name"];
    $gradYear = $arrayData["grad_year"];
    $alumni = $arrayData["alumni"];
    $sid = $arrayData["sid"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("update student  set firstName = :first, lastName = :last, gradYear = :gradYr,alumni=:alum where studentID=:sid");
    $stmt->execute([':first' => $first_name, ":last"=> $last_name, ":gradYr"=>$gradYear,":alum"=>$alumni,":sid"=>$sid]);
    header("location:students.php?page=student&sid=".$sid."&message=Student Updated");
}