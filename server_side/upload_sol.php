<?php
session_start();
include('../server_side/config.php');
$sid = $_SESSION['RegNo'];
$a_id = $_GET['a_id'];
$tid = $_GET['tid'];
$c_id = $_GET['course'];
$c = $_GET['c'];
$status_upload = 0;


$error="";
$title="";
$msg = "";



 if($_SERVER["REQUEST_METHOD"] == "POST")
 {

            if(empty($_POST['title']))
                $error="*Please select a title for document";
            else
                $title = $_POST['title'];


}

$target_dir = "solutions/";

$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
    $error= "*Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $error = "*Sorry, your file is too large.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $error = "*Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} 
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $msg= "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $status_upload = 1;
    } else {
        $error = "*Sorry, there was an error uploading your file.";
    }
}


if($status_upload == 1)
{
    $path = realpath($target_dir.$_FILES["fileToUpload"]["name"]);
    $path = "..".stristr($path, "\server_side");
    
    $path = addslashes($path);
    
    $sub_date =date('Y-m-d');

    $sol = "INSERT INTO `subimission`(`studentId`, `AssignId`, `title`, `path`, `TID`, `SubDate`, `CourseId`) VALUES ('$sid', '$a_id','$title','$path','$tid', '$sub_date','$c_id')";

        if(mysqli_query($db, $sol) === TRUE)
        	$msg =  "Solution uploaded perfectly.";

    	else 
    		$error = " some error in uploading ";






}
$_SESSION["upload_error"] = $error;
$_SESSION["upload_msg"] = $msg;

header("location:../html/course.php?c=$c");
 


?>
