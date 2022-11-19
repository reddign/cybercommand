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
    $student_survey = [];
    $student_survey["surveyID"] = "";
    $student_survey["interests"] = "";
    $student_survey["careerGoals"] = "";
    $student_survey["studentID"] = "";
    $buttonString = "Submit Survey";

    echo '<form  method="post" action="survey.php">
        Survey Code: <input style="margin-bottom:10px" name="surveyID" type="text" value="'.$student_survey["surveyID"].'"><BR/>
        Interests: <input style="margin:10px" name="interests" type="text" value="'.$student_survey["interests"].'"><BR/>
        Career Goals: <input style="margin:10px" name="careerGoals" type="text" value="'.$student_survey["careerGoals"].'"><BR/>
        Student ID: <input style="margin:10px" name="studentID" type="text" value="'.$student_survey["studentID"].'"><BR/>
        <input style="margin:10px" name="page" type="hidden" value="Submit Survey">
        <input style="margin:10px" type="submit" value="'.$buttonString.'">';
}

function student_survey_form($student_survey=""){

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
    $student_survey["rate"] = "";  


    $student_survey["surveyID"] = "";
    $student_survey["interests"] = "";
    $student_survey["careerGoals"] = "";
    
    $buttonString = "Submit Survey";

    echo '<form  method="post" action="survey.php" id="surveyForm">
        First Name: <input style="margin-bottom:10px" name="firstName" type="text" value="'.$student_survey["studentFirst"].'"><BR/>
        Last Name: <input style="margin-bottom:10px" name="lastName" type="text" value="'.$student_survey["studentLast"].'"><BR/>
        Student ID #: <input style="margin-bottom:10px" name="studentID" type="number" value="'.$student_survey["studentID"].'"><BR/>
        Graduation Year: <input style="margin-bottom:10px" name="gradYear" type="number" value="'.$student_survey["gradYear"].'"><BR/>
        Primary Major: <input style="margin-bottom:10px" name="primaryMajor" type="text" value="'.$student_survey["primMajor"].'"><BR/>
        Concentration: <input style="margin-bottom:10px" name="concentration" type="text" value="'.$student_survey["concentration"].'"><BR/><BR/>
        What type of work-based learning experience did you complete?<br>
        <input type="radio" id="learnExp1" class="learnExp" name="workType" value="Internship" form="surveyForm">
            <label for="learnExp1">Internship</label><br>
        <input type="radio" id="learnExp2" class="learnExp" name="workType" value="SCARP" form="surveyForm">
            <label for="learnExp2">SCARP</label><br>
        <input type="radio" id="learnExp3" class="learnExp" name="workType" value="REU" form="surveyForm">
            <label for="learnExp3">REU</label><br>
        <input type="radio" id="learnExp4" class="learnExp" name="workType" value="Trade Employment" form="surveyForm">
            <label for="learnExp4">Trade Employment</label><br>
        <input type="radio" id="learnExp5" class="learnExp" name="workType" value="Student Teaching" form="surveyForm">
            <label for="learnExp5">Student Teaching</label><br>
        <input type="radio" id="learnExp6" class="learnExp" name="workType" value="Other" form="surveyForm">
            <label for="learnExp6">Other</label><br>    
        <input type="radio" id="learnExp7" class="learnExp" name="workType" value="None" form="surveyForm">
            <label for="learnExp7">None</label><br><br>

        <div id="hiddenDiv" class="nodisplay">
        What was the Company/ School that you did the work-based learning experience with? <input style="margin-bottom:10px" name="company" type="text" value="'.$student_survey["company"].'"><BR/>
        What was your job title or the REU study name? <input style="margin-bottom:10px" name="title" type="text" value="'.$student_survey["title"].'"><BR/>
        What was the timeframe that you completed this experience?  <input style="margin-bottom:10px" name="timeFrame" type="text" value="'.$student_survey["timeFrame"].'"><BR/>
        Did you complete this experience for credit or an SLE?(Check all that apply):<br><br>
        <input name="reason" type="checkbox" value="For credit" id="oppCheck1">
            <label for="oppCheck1">For Credit</label><br>
        <input name="reason" type="checkbox" value="Zero credit, but listed on my transcript" id="oppCheck2">
            <label for="oppCheck2">Zero credit, but listed on my transcript</label><br>
        <input name="reason" type="checkbox" value="For a Signature Learning Experience" id="oppCheck3">
            <label for="oppCheck3">For a Signature Learning Experience</label><br>
        <input name="reason" type="checkbox" value="Through Wings of Success Program (Career Services" id="oppCheck4">
            <label for="oppCheck4">Through Wings of Success Program (Career Services</label><br>
        <input name="reason" type="checkbox" value="For Credit for Student Teaching" id="oppCheck5">
            <label for="oppCheck5">For Credit for Student Teaching</label><br>
        <input name="reason" type="checkbox" value = "Not for Credit or SLE" id="oppCheck6">
            <label for="oppCheck6">Not for Credit or SLE</label><br>
        <input name="reason" type="checkbox" value = "Other" id="oppCheck7">
            <label for="oppCheck7">Other</label><br></br>
        
        Did this experience align to your desired career path? <select name="careerPath">
        <option value = "">--Select--</option>
        <option value = "Yes">Yes</option>
        <option value = "No">No</option>
        <option value = "Maybe">Maybe</option>
        </select><BR/><BR/>
        Was this experience virtual or in-person? <select name="mode">
        <option value = "--Select--">--Select--</option>
        <option value = "Virtual">Virtual</option>
        <option value = "In-person">In-person</option>
        <option value = "Hybrid">Hybrid</option>
        </select><BR/><BR/>
        Rate this experience on a scale of 0 to 5 (0 being poor and 5 being excellent): 
        <input style="margin-bottom:10px" name="rate" type="number" value="'.$student_survey["rate"].'"><BR/>
        Please choose the appropriate wage range for the experience:<br>
        <input type="radio" value="Unpaid" name = "wage" id="wageChoice1">
            <label for="wageChoice1">Unpaid</label><br>
        <input type="radio" value="$7.25-$10" name = "wage" id="wageChoice2">
            <label for="wageChoice2">$7.25-$10/ hour</label><br>
        <input type="radio" value="$10-$12" name = "wage" id="wageChoice3">
            <label for="wageChoice3">$10-$12/ hour</label><br>
        <input type="radio" value="$12-$15" name = "wage" id="wageChoice4">
            <label for="wageChoice4">$12-$15/ hour</label><br>
        <input type="radio" value="$15-$17" name = "wage" id="wageChoice5">
            <label for="wageChoice5">$15-$17/ hour</label><br>
        <input type="radio" value="$17-$20" name = "wage" id="wageChoice6">
            <label for="wageChoice6">$17-$20/ hour</label><br>
        <input type="radio" value="$20-$22" name = "wage" id="wageChoice7">
            <label for="wageChoice7">$20-$22/ hour</label><br>
        <input type="radio" value="More than $22" name = "wage" id="wageChoice8">
            <label for="wageChoice8">More than $22/ hour</label><br>
        <input type="radio" value="Stipend" name = "wage" id="wageChoice9">
            <label for="wageChoice9">Stipend</label><br>
        <input type="radio" value="Other" name = "wage" id="wageChoice10">
            <label for="wageChoice10">Other</label><br></br>

        Did anyone at the college help you with the process of obtaining this experience? (Check all that apply):</br>
        <input name="advisor" type="checkbox" id="adviorChoice1" value="Career Development Center">
            <label for="adviorChoice1">Career Development Center</label><br>
        <input name="advisor" type="checkbox" id="adviorChoice2" value="Ms. Zegers">
            <label for="adviorChoice2">Ms. Zegers</label><br>
        <input name="advisor" type="checkbox" id="adviorChoice3" value="Faculty Member">
            <label for="adviorChoice3">Faculty Member</label><br>
        <input name="advisor" type="checkbox" id="adviorChoice4" value="Fellow Etown Student">
            <label for="adviorChoice4">Fellow Etown Student</label><br>
        <input name="advisor" type="checkbox" id="adviorChoice5" value="Etown Alumni">
            <label for="adviorChoice5">Etown Alumni</label><br>
        <input name="advisor" type="checkbox" id="adviorChoice6" value="Field Placement Office">
            <label for="adviorChoice6">Field Placement Office</label><br>
        <input name="advisor" type="checkbox" id="adviorChoice7" value="Other">
            <label for="adviorChoice7">Other</label></br>
        <input name="advisor" type="checkbox" id="adviorChoice8" value="None">
            <label for="adviorChoice8">None</label></br></br>

        Are you completing this survey for a class assignment?
        <select name="classAssignment">
        <option value = "">--Select--</option>
        <option value = "Yes">Yes</option>
        <option value = "No">No</option>
        </select></br> <br>
        </div>
        <input id="submit" style="margin:10px" type="submit" value="'.$buttonString.'">

    </form>';

    echo "<script src='js/survey.js'></script>";

}

function summer_survey_form($student_survey=""){
    $student_survey = [];
    $student_survey["company"] = "";
    $student_survey["title"] = "";
    $student_survey["timeFrame"] = "";
    $student_survey["rate"] = "";
    $buttonString = "Submit Survey";

    echo '<form  method="post" action="survey.php" id="surveyForm2">
    What type of work-based learning experience are you planning on for this summer?:</br>
    <input type="radio" id="learnExp11" class="learningExp" name="summerWorkType" value="Internship" form="surveyForm">
        <label for="learnExp11">Internship</label><br>
    <input type="radio" id="learnExp12" class="learningExp" name="summerWorkType" value="SCARP" form="surveyForm">
        <label for="learnExp12">SCARP</label><br>
    <input type="radio" id="learnExp13" class="learningExp" name="summerWorkType" value="REU" form="surveyForm">
        <label for="learnExp13">REU</label><br>
    <input type="radio" id="learnExp14" class="learningExp" name="summerWorkType" value="Trade Employment" form="surveyForm">
        <label for="learnExp14">Trade Employment</label><br>
    <input type="radio" id="learnExp15" class="learningExp" name="summerWorkType" value="Student Teaching" form="surveyForm">
        <label for="learnExp15">Student Teaching</label><br>
    <input type="radio" id="learnExp16" class="learningExp" name="summerWorkType" value="Other" form="surveyForm">
        <label for="learnExp16">Other</label><br>    
    <input type="radio" id="learnExp17" class="learningExp" name="summerWorkType" value="None" form="surveyForm">
        <label for="learnExp17">None</label><br><br>

    <div id="hiddenDiv2" class="nodisplay">
    What is the Company/ School that you want to have the work-based learning experience with? <input style="margin-bottom:10px" name="company" type="text" value="'.$student_survey["company"].'"><BR/>
    What will be your job title or the REU study name? <input style="margin-bottom:10px" name="title" type="text" value="'.$student_survey["title"].'"><BR/>

    Did you complete this experience for credit or an SLE?(Check all that apply):<br><br>
        <input name="summerReason" type="checkbox" value="For credit" id="oppCheck11">
            <label for="oppCheck11">For Credit</label><br>
        <input type="checkbox" value="Zero credit, but listed on my transcript" id="oppCheck12">
            <label for="oppCheck12">Zero credit, but listed on my transcript</label><br>
        <input type="checkbox" value="For a Signature Learning Experience" id="oppCheck13">
            <label name="summerReason" for="oppCheck13">For a Signature Learning Experience</label><br>
        <input type="checkbox" value="Through Wings of Success Program (Career Services" id="oppCheck14">
            <label name="summerReason" for="oppCheck14">Through Wings of Success Program (Career Services</label><br>
        <input type="checkbox" value="For Credit for Student Teaching" id="oppCheck15">
            <label name="summerReason" for="oppCheck15">For Credit for Student Teaching</label><br>
        <input type="checkbox" value = "Not for Credit or SLE" id="oppCheck16">
            <label for="oppCheck16">Not for Credit or SLE</label><br>
        <input name="summerReason" type="checkbox" value = "Other" id="oppCheck17">
            <label for="oppCheck17">Other</label><br></br>

    Please choose the appropriate wage range for the experience:<br>
        <input type="radio" value="Unpaid" name = "summerWage" id="wageChoice11">
            <label for="wageChoice11">Unpaid</label><br>
        <input type="radio" value="$7.25-$10" name = "summerWage" id="wageChoice12">
            <label for="wageChoice12">$7.25-$10/ hour</label><br>
        <input type="radio" value="$10-$12" name = "summerWage" id="wageChoice13"
            <label for="wageChoice13">$10-$12/ hour</label><br>
        <input type="radio" value="$12-$15" name = "summerWage" id="wageChoice14">
            <label for="wageChoice14">$12-$15/ hour</label><br>
        <input type="radio" value="$15-$17" name = "summerWage" id="wageChoice15">
            <label for="wageChoice15">$15-$17/ hour</label><br>
        <input type="radio" value="$17-$20" name = "summerWage" id="wageChoice16">
            <label for="wageChoice16">$17-$20/ hour</label><br>
        <input type="radio" value="$20-$22" name = "summerWage" id="wageChoice17">
            <label for="wageChoice17">$20-$22/ hour</label><br>
        <input type="radio" value="More than $22" name = "summerWage" id="wageChoice18">
            <label for="wageChoice18">More than $22/ hour</label><br>
        <input type="radio" value="Stipend" name = "summerWage" id="wageChoice19">
            <label for="wageChoice19">Stipend</label><br>
        <input type="radio" value="Other" name = "summerWage" id="wageChoice20">
            <label for="wageChoice20">Other</label><br></br>

    Did anyone at the college help you with the process of obtaining this experience? (Check all that apply):</br>
    <input name="summerAdvisor" type="checkbox" id="adviorChoice1" value="Career Development Center">
        <label for="adviorChoice1">Career Development Center</label><br>
    <input name="summerAdvisor" type="checkbox" id="adviorChoice2" value="Ms. Zegers">
        <label for="adviorChoice2">Ms. Zegers</label><br>
    <input name="summerAdvisor" type="checkbox" id="adviorChoice3" value="Faculty Member">
        <label for="adviorChoice3">Faculty Member</label><br>
    <input name="summerAdvisor" type="checkbox" id="adviorChoice4" value="Fellow Etown Student">
        <label for="adviorChoice4">Fellow Etown Student</label><br>
    <input name="summerAdvisor" type="checkbox" id="adviorChoice5" value="Etown Alumni">
        <label for="adviorChoice5">Etown Alumni</label><br>
    <input name="summerAdvisor" type="checkbox" id="adviorChoice6" value="Field Placement Office">
        <label for="adviorChoice6">Field Placement Office</label><br>
    <input name="summerAdvisor" type="checkbox" id="adviorChoice7" value="Other">
        <label for="adviorChoice7">Other</label></br>
    <input name="summerAdvisor" type="checkbox" id="adviorChoice8" value="None">
        <label for="adviorChoice8">None</label></br></br>
    </div>
    <input type="hidden" name="surveyType" value="Spring">
    <input style="margin:10px" type="submit" value="'.$buttonString.'">
    
    </form>';
}

function addSurvey($arrayData){
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
    $navHTML .= '<a href="survey.php?page=login"'.($currentPage == 'login' ? 'class="selected"' : "").'>Take Survey</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="survey.php?page=fall"'.($currentPage == 'fall' ? 'class="selected"' : "").'>Fall Survey</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="survey.php?page=spring"'.($currentPage == 'spring' ? 'class="selected"' : "").'>Spring Survey</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}   

?>