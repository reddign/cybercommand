<?PHP
//Make sure upload directory exists
if (!file_exists('upload')) {
    mkdir('upload', 0777, true);
}
if(!isset($_SESSION))
    session_start();

if(isset($_POST["file_upload"]) && isset($_FILES["csv_file"])) {
    if($_FILES["csv_file"]["type"] != "text/csv")
        exit;
    
    $filePath = $_FILES["csv_file"]["tmp_name"];
    $newFilePath = str_replace([" ","\t","\n","\r"],'','upload/'.$_SESSION['firstName'].'_'.$_SESSION['lastName'].'.csv');
    //Remove and replace file if already exists
    if(file_exists($newFilePath)) {
        unlink($newFilePath);
    }

    move_uploaded_file($_FILES["csv_file"]["tmp_name"], $newFilePath);
    if(isset($_GET['redirect'])) {
        //Security measure to redirect only to valid files
        switch($_GET['redirect']) {
            case 'import.php':
                header('location:import.php?page=import&filepath='.$newFilePath);
                exit;
            default:
                exit;
        }
    }
    exit;
}
?>