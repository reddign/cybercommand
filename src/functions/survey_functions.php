<?PHP

// TODO: tests if logged in as student or teacher/admin 
// which allows for hiding the email button from students
function login_checker($role) {
    if($role == "admin"){

    }
    else if ($role == "teacher"){

    }
    else if ($role == "student"){

    }
    else {

    }
}

/*  TODO: I imagine the students.php page will display student survey information if it exists. 
    Student entries lacking in survey information would likely be the best place to have a button 
    saying something like 'Email this student the survey form.'Additionally this button should only 
    be visibile/usable by someone with priveleged access to the site.

    Also, it looks like we're currently only storing students' full names in the DB. Since not all student emails
    follow the standard format of last name first initial @etown.edu. We will need to have these emails in the database in
    order to be able to send
*/


// called to send email to students who have not taken the survey
function email_survey_send($student_email,$link) {
$to = $student_email;
$name = ""; # TODO Get name from DB via email, or get email from DB via name.
$subject = "Student Interest Survey";
$code = 0; # TODO generate access code, store it with the student DB entry?
$txt = "Dear $name, \n\nYou have not completed your student interest survey. Please follow this link ($link)
and complete the survey. Your access code is $code. \n\nThank you.\n Etown EMCS Department";

mail($to,$subject,$txt);
}

/*
// checks for valid code
function code_checker($Code) {
    for(i=0; i < count($Code); i++) {
        if ($Code = $Code[i]){
            return true;
        }
    }
    echo "CODE IS INVALID!!!"
    return false;
}

*/
function display_survey_form($student_survey=""){

    $formHTML = "<h2>Add Student</h2>";
    $student_survey = [];
    $student_survey["studentFirst"]= "";
    $student_survey["studentLast"]= "";
    $student_survey["studentID"] = "";
    $student_survey["gradYear"] = "";
    $student_survey["primMajor"] = "";
    $student_survey["concentration"] = "";
    $student_survey["company"] = "";
    $student_survey["title"] = "";
    $student_survey["timeFrame"] = "";


    $student_survey["surveyID"] = "";
    $student_survey["interests"] = "";
    $student_survey["careerGoals"] = "";
    
    $buttonString = "Submit Survey";
    
    echo '<form  method=post action=survey.php>
        First Name: <input style="margin-bottom:10px" name="studentFirst" type="text" value="'.$student_survey["studentFirst"].'"><BR/>
        Last Name: <input style="margin-bottom:10px" name="studentLast" type="text" value="'.$student_survey["studentLast"].'"><BR/>
        Student ID #: <input style="margin-bottom:10px" name="studentID" type="text" value="'.$student_survey["studentID"].'"><BR/>
        Graduation Year: <input style="margin-bottom:10px" name="gradYear" type="text" value="'.$student_survey["gradYear"].'"><BR/>
        Primary Major: <input style="margin-bottom:10px" name="primMajor" type="text" value="'.$student_survey["primMajor"].'"><BR/>
        Concentration: <input style="margin-bottom:10px" name="concentration" type="text" value="'.$student_survey["concentration"].'"><BR/>
        What type of work-based learning experience did you complete over the summer? <select> 
        <option value = "--Select--">--Select--</option>
        <option value = "Internship">Internship</option>
        <option value = "SCARP">SCARP</option>
        <option value = "REU">REU</option>
        <option value = "Trade Employment">Trade Employment</option>
        <option value= "Student Teaching">Student Teaching</option>
        <option value = "Other">Other</option>
        <option value = "None">None</option>
        </select><BR/>
        What was the Company/ School that you did the work-based learning experience with? <input style="margin-bottom:10px" name="company" type="text" value="'.$student_survey["company"].'"><BR/>
        What was your job title or the REU study name? <input style="margin-bottom:10px" name="title" type="text" value="'.$student_survey["title"].'"><BR/>
        What was the timeframe that you completed this experience?  <input style="margin-bottom:10px" name="timeFrame" type="text" value="'.$student_survey["timeFrame"].'"><BR/>
        Why did you choose to take this opportunity? <select>
        <option value = "--Select--">--Select--</option>
        <option value = "For credit">For credit</option>
        <option value = "Zero credit but listed on my transcript/resume">Zero credit but listed on my transcript/resume</option>
        <option value = "For a Signature learning experience">For a Signature learning experience</option>
        <option value = "Through Wings of Success Program (Career Services)">Through Wings of Success Program (Career Services)</option>
        <option value = "For Credit for Student Teaching">For Credit for Student Teaching</option>
        <option value = "Not for Credit or SLE">Not for Credit or SLE</option>
        <option value = "Other">Other</option>
        </select><BR/>
        Did this experience align to your desired career path? <select>
        <option value = "--Select--">--Select--</option>
        <option value = "Yes">Yes</option>
        <option value = "No">No</option>
        <option value = "Maybe">Maybe</option>
        </select><BR/>
        Was this experience virtual or in-person? <select>
        <option value = "--Select--">--Select--</option>
        <option value = "Virtual">Virtual</option>
        <option value = "In-person">In-person</option>
        <option value = "Hybrid">Hybrid</option>
        </select><BR/>
        Rate this experience on a scale of 0 to 5 (0 being poor and 5 being excellent): <input style="margin-bottom:10px" name="rate" type="number" value="'.$student_survey["rate"].'"><BR/>


        <BR/><BR/><BR/>Survey Code: <input style="margin-bottom:10px" name="surveyID" type="text" value="'.$student_survey["surveyID"].'"><BR/>
        Interests: <input style="margin:10px" name="interests" type="text" value="'.$student_survey["interests"].'"><BR/>
        Career Goals: <input style="margin:10px" name="careerGoals" type="text" value="'.$student_survey["careerGoals"].'"><BR/>
        Student ID: <input style="margin:10px" name="studentID" type="text" value="'.$student_survey["studentID"].'"><BR/>
        <input style="margin:10px" name="page" type="hidden" value="Submit Survey">
        <input style="margin:10px" type="submit" value="'.$buttonString.'">
    </form>';

}
function addSurvey($arrayData){
    $
    $surveyID = $arrayData["surveyID"];
    $interests = $arrayData["interests"];
    $careerGoals = $arrayData["careerGoals"];
    $sid = $arrayData["studentID"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("insert into student_survey (surveyID,interests,careerGoals,studentID) VALUES (:surv,:inter,:caree,:stu)");
    $stmt->execute([':surv' => $surveyID, ":inter"=> $interests, ":caree"=>$careerGoals,":stu"=>$studentID]);
    $sid = $pdo->lastInsertId();
    header("location:survey.php?page=survey&sid=".$sid."&message=Survey Accepted");
  
}

function display_survey_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="survey.php?page=add">Take Survey</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="survey.php?page=search" class="selected">View Results</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}

?>