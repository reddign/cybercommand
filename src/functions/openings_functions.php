<?PHP
function display_job_form($job=""){
    //Get all companies and students for use in company and student selectors
    $pdo = connect_to_db();
    $companies = $pdo->query("SELECT companyID,companyName FROM company ORDER BY companyName")->fetchAll();
    $students = $pdo->query("SELECT studentID,firstName,lastName FROM student ORDER BY lastName,firstName")->fetchAll();

    if($job==""){
        $formHTML = "<h2>Add Job</h2>";
        $job = [];
        $job["jobID"] = "";
        $job["companyID"] = "";
        $job["title"] = "";
        $job["description"] = "";
        $job["startdate"] = "";
        $job["enddate"] = "";
        $job["type"] = "";
        $job["semester"] = "";
        $job["studentID"] = "";
        $buttonString = "Add Job";
    }else{
        $formHTML = "<h2>Edit Job</h2>";
        $buttonString = "Edit Job";
    }
    echo '<form method=post action=openings.php>
        Job Title: <input name="title" type="text" value="'.$job["title"].'"><BR/>';
    echo '<label for="companyID">Company:</label>
        <select name="companyID" id="companyID">';
    echo '<option value="NONE"></option>';

    if(is_array($companies)) {
        foreach($companies as $company) {
            $selected = $company['companyID'] == $job['companyID'] ? " selected" : "";
            echo '<option value='.$company['companyID'].$selected.'>'.$company['companyName'].'</option>';
        }
        unset($company);
    }
    echo '</select><BR/>
        Start Date: <input name="startdate" type="date" value="'.$job["startdate"].'"><BR/>
        End Date: <input name="enddate" type="date" value="'.$job["enddate"].'"><BR/>
        Job Type: <input name="type" type="text" value="'.$job["type"].'"><BR/>
        Semester: <input name="semester" type="text" value="'.$job["type"].'"><BR/>';
    echo '<label for="studentID">Student:</label>
        <select name="studentID" id="studentID">';
    echo '<option value="NONE"></option>';

    if(is_array($students)) {
        foreach($students as $student) {
            $selected = $student['studentID'] == $job['studentID'] ? " selected" : "";
            echo '<option value='.$student['studentID'].$selected.'>'.$student['firstName'].' '.$student['lastName'].'</option>';
        }
        unset($student);
    }
    echo '</select><BR/>
        Description: <BR/><textarea style="width:60%;" rows="5" name="description" type="text">'.$job["description"].'</textarea><BR/>
        <input name="jobID" type="hidden"  value="'.$job["jobID"].'">
        <input name="page" type="hidden" value="save">
        <input type="submit" value="'.$buttonString.'">
    </form>';
}
/* Nav Bar */
function display_openings_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="openings.php?page=search" class="selected">Search Jobs</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="openings.php?page=add">Add Jobs</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}
function get_job($jid){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM job_opportunity WHERE jobID=:jid");
    $stmt->execute([':jid' => $jid]); 
    $job = $stmt->fetch(PDO::FETCH_ASSOC);
   
    return $job;
} 
function get_job_by_name($word){
    if($word==""){
        return get_all_openings_from_db();
    }
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM job_opportunity WHERE title like :title ORDER BY title");
    $stmt->execute([':title' => "%".$word."%"]);
    $data = [];
    while($job =  $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $job;
    } 
    
    return $data;
}    
function get_all_openings_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM job_opportunity order by title")->fetchAll();
    return $data;
}
/* Search Bar*/
function display_search_form(){
    echo '<h2>Search For A Job Opening By Title:</h2><form method=get action="openings.php">
        Enter Job Opening: <input name="search" type="text" autofocus>
        <input job="page" type="hidden" value="search">
        <input type="submit" value="Search">
    </form><br/><br/>';

}
function display_job_list($data=null){
    if(!is_array($data)){
        echo "";
        return;
    }
    foreach ($data as $row) {
            echo "<a href='openings.php?page=job&jid=".$row['jobID']."'>";
            echo $row['title']."<br />\n";
            echo "</a>";
    }
}
function display_job_info($job){
    if(!is_array($job)){
        echo "Job Information not found";
        return;
    }

    //Get student and company names if they exist
    $pdo = connect_to_db();
    if(isset($job['studentID']) && $job['studentID'] != 0) {
        $stmt = $pdo->prepare("SELECT * FROM student WHERE studentID=:sid");
        $stmt->execute([':sid' => $job['studentID']]); 
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    if(isset($job['companyID']) && $job['companyID'] != 0) {
        $stmt = $pdo->prepare("SELECT * FROM company WHERE companyID=:cid");
        $stmt->execute([':cid' => $job['companyID']]); 
        $company = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Print job info
    echo "<h4><b>Title:</b> ".$job['title']."</h4>\n";
    echo "<h4><b>Company:</b> ";
    if(isset($company)) 
        echo $company['companyName'];
    echo "</h4>\n";
    echo "<h4><b>Start Date:</b> ".($job['startdate'] != '0000-00-00' ? date('m/d/Y', strtotime($job['startdate'])) : '')."</h4>\n";
    echo "<h4><b>End Date:</b> ".($job['enddate'] != '0000-00-00' ? date('m/d/Y', strtotime($job['enddate'])) : '')."</h4>\n";
    echo "<h4><b>Job Type:</b> ".$job['type']."</h4>\n";
    echo "<h4><b>Student:</b> ";
    if(isset($student))
        echo $student['firstName']." ".$student['lastName'];
    echo "</h4>\n";
    echo "<h4><b>Semester:</b> ".$job['semester']."</h4>\n";
    echo "<h4><b>Description:</b> ".$job['description']."</h4>\n";
    echo "<a href='openings.php?page=edit&jid=".$job['jobID']."'> Edit Info </a>\n";
}
function process_job_form_data($arrayData){
    $jid = $arrayData["jobID"];
    if($jid==""){
        addJob($arrayData);
    }else{
        editJob($arrayData);
    }
    
}
function addJob($job){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("INSERT INTO job_opportunity (companyID,title,description,startdate,enddate,type,semester,studentID) VALUES (:companyID,:title,:description,:startdate,:enddate,:type,:semester,:studentID)");
    $stmt->execute([':companyID' => $job['companyID'],':title' => $job['title'],':description' => $job['description'],':startdate' => $job['startdate'],':enddate' => $job['enddate'],':type' => $job['type'],':semester' => $job['semester'],':studentID' => $job['studentID']]);
    $jid = $pdo->lastInsertId();
    header("location:openings.php?page=job&jid=".$jid."&message=Job Added");
  
}
function editJob($job){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("UPDATE job_opportunity SET companyID = :companyID, title = :title, description = :description, startdate = :startdate, enddate = :enddate, type = :type, semester = :semester, studentID = :studentID WHERE jobID=:jobID");
    $stmt->execute([':companyID' => $job['companyID'],':title' => $job['title'],':description' => $job['description'],':startdate' => $job['startdate'],':enddate' => $job['enddate'],':type' => $job['type'],':semester' => $job['semester'],':studentID' => $job['studentID'], 'jobID' => $job['jobID']]);
    header("location:openings.php?page=job&jid=".$job['jobID']."&message=Job Updated");
}