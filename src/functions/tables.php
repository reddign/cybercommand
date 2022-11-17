<?PHP
require_once(__DIR__."/generalized_functions.php");

function getTableNameDict() {
    return ['coaching'=>'Coaching Sessions','company'=>"Companies",'first_destination'=>'First Destinations','internship'=>'Work-Based Learning Experiences','meeting'=>'Meetings','student'=>'Blue Jays'];
}

// Returns a table object for the given table
function getTable($name) {
    switch($name) {
    case 'coaching':
        $coachingTable = new Table('coaching', ['Coaching ID','Blue Jay','Date','Visit Type','For Coursework','Mode','Reason','Position Type','Follow Up Tasks', 'Deadline', 'Notes'], ['studentID', 'date']);
        $coachingTable->addOptionsToCol('positionType',['Internship', 'Employment', 'REU', 'Graduate School', 'Other']);
        $coachingTable->addOptionsToCol('mode',['Virtual', 'In person', 'Other']);
        $coachingTable->fileName = "coaching.php";
        return $coachingTable;
    
    case 'company':
        $companyTable = new Table('company', ['Company ID','Company Name','Company ID','Address Line 1','Address Line 2','City','State','Zip','Phone Number','Company Domain','Majors/Concentrations','Engagement Level','Etown Priority Partner','Notes'], ['companyName']);
        $companyTable->addOptionsToCol('engagementLevel',['Lead', 'Beginning', 'Developing', 'Strategic', 'Other']);
        $companyTable->fileName = "companies.php";
        return $companyTable;

    case 'contact':
        $contactTable = new Table('contact', ['Contact ID','Company','First Name','Last Name','Alumni','Job Title','Contact Type','Email','Phone Number','Primary Contact','Company Domain','Industry','Notes'], ['firstName','lastName']);
        $contactTable->addOptionsToCol('contactType',['Employer', 'Community partner', 'Higher ed','Other']);
        $contactTable->fileName = "contacts.php";
        return $contactTable;

    case 'first_destination':
        $first_destinationTable = new Table('first_destination', ['First Destination ID','Company','BLue Jay','Title','Location','Salary Range','Offer Date','What are you doing after graduation','In EMCS Network','Did you intern at this company?','Relationship to Major(s) and Minor(s)','Matches Career Path','Department','Notes'], ['title']);
        $first_destinationTable->fileName = "first_destinations.php";
        return $first_destinationTable;

    case 'internship':
        $internshipTable = new Table('internship', ['Internship ID','Blue Jay','Company','Title','Department','Work-based Learning','Term','SLE/Credit','Career Path','Mode','Rating','Wage Range','EMCS Network','Notes'], ['title']);
        $internshipTable->addOptionsToCol('workBasedLearning',['Internship', 'SCARP', 'REU', 'Trade', 'Co-op', 'Field placement', 'Other']);
        $internshipTable->addOptionsToCol('careerPath',['Yes','No','Maybe']);
        $internshipTable->addOptionsToCol('mode',['Virtual', 'In person', 'Hybrid']);
        $internshipTable->fileName = "internships.php";
        return $internshipTable;

    case 'meeting':
        $meetingTable = new Table('meeting', ['Meeting ID','Meeting Type','Date','Company','Contact','Etown Contact','Notes','Tasks','Task Deadline'], ['meetingType','date']);
        $meetingTable->addOptionsToCol('meetingType', ['Virtual meeting', 'Phone call', 'On-campus meeting', 'Off-site meeting', 'Campus event']);
        $meetingTable->fileName = "meetings.php";
        return $meetingTable;

    case 'student':
        $studentTable = new Table('student', ['Student ID','First Name','Last Name','Email','Phone Number','Student ID','Grad Year','Alumni','Volunteer','First Gen','Gender','URM','Department','Primary Major','Concentration','Other Majors','Minors','Current Employer', 'Position Title','Notes'], ['firstName','lastName']);
        $studentTable->addOptionsToCol('gender', ['Female', 'Male', 'Non-binary', 'Trans', 'Prefer not to answer', 'Other']);
        $studentTable->fileName = "students.php";
        return $studentTable;

    default:
        return NULL;
    }
}
?>