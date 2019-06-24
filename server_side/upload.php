<?php


session_start();
include('../server_side/config.php');
$tid = $_SESSION['TID'];

$status_upload = 0;


$error="";
$title="";
$doc_type="";
$end_date="";
$msg = "";
$batch="";
$course="";



 if($_SERVER["REQUEST_METHOD"] == "POST")
 {
        
            if(!isset($_POST['doc_type']))
                $error = "*Please Select the document type";
            else
            {
                $doc_type=$_POST['doc_type'];
            }

            if($doc_type=='Assignment')
            {
                if(empty($_POST['EndDate']))
                    $error = "*Please select a due date for Assignment";
                else
                    $end_date=$_POST['EndDate'];
            }


            if(empty($_POST['title']))
                $error="*Please select a title for document";
            else
                $title = $_POST['title'];

            if(empty($_POST['batch']))
                $error = "*Please select a specefic batch and course";
            else
                $batch = $_POST['batch'];


            if(empty($_POST['course']))
                $error = "*Please select a specefic course";
            else
                $course = $_POST['course'];


}
if($doc_type=='Assignment')
{
    $target_dir = "uploads/";
}
else
{
    $target_dir = "notices/";
}

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
    $batch = test_input($batch);
    $course = test_input($course);

    $path = realpath($target_dir.$_FILES["fileToUpload"]["name"]);
    $path = "..".stristr($path, "\server_side");
    $path = addslashes($path);
    $start_date=date('Y-m-d');
    $doc_id=$tid.$batch.$course.$title.strval(rand(1,10000));

    if($doc_type=='Assignment'){

    $insert_assignment = "Insert into assignment(AssignID, ATitle, path ,SDate,EDate) values ('$doc_id','$title','$path','$start_date','$end_date')";

    if(mysqli_query($db, $insert_assignment) === TRUE)
        $msg =  "Assignment inserted perfectly.";
    else
        $error = "check your database";
    }
    else
    {
        $insert_notice = "Insert into notice(noticeId, NTitle, Sdate, path) values ('$doc_id','$title','$start_date','$path')";

        if(mysqli_query($db,$insert_notice)=== TRUE)
            $msg =  "New notice inserted perfectly";
        else
            $error =  "Check your database 2";
    }


    $batch_id = "Select BatchId from batch where BatchName= '$batch'";
    $get_batch = mysqli_query($db,$batch_id) or die("Bad SQL: $course");
    $row = mysqli_fetch_array($get_batch);
    $batchid = $row['BatchId'];

    $course_id = "select CourseId from course where CourseName = '$course'";
    $get_course = mysqli_query($db, $course_id) or die("Bad SQL: $course_id");
    $row = mysqli_fetch_array($get_course);
    $cid = $row['CourseId']; 
    echo $course_id.$cid.$course;


    $assign = "Insert into assigns (TID, AssignId, course, BatchId) values ('$tid','$doc_id','$cid','$batchid')";
        if(mysqli_query($db, $assign) === TRUE)
        $msg =  "Assignment inserted perfectly 2.";

    else $error = " some error in uploading ";

}
$_SESSION["upload_error"] = $error;
$_SESSION["upload_msg"] = $msg;

header("location:../html/upload_document.php");
 
   function test_input($data) {
      global $db;
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     $data = mysqli_real_escape_string($db, $data);
     return $data;
   }

?>