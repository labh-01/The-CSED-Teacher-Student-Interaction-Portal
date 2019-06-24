<?php

   session_start();
   include('./config.php');
   $error="";
   $user="";
   $pswd="";
   $role="";
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {

      if(empty($_POST['batch'])){
      $error="*Please select batch name";
   }
   else{
      $b_name = test_input($_POST['batch']);
   }


   if(empty($_POST['course'])){
      $error = "*Please select course name";
   }
   else
   {
      $c_name = test_input($_POST['course']);
   }
   
   if(!isset($_POST['optrole']))
   {
      $error = "*Please select one task";
   }
   else{
      $role = $_POST['optrole'];
   }

 //echo $role;
if($error == "")
{
    $t_id = $_SESSION['TID'];
    
    $batch_id = "select BatchId from batch where BatchName = '$b_name'";
    $get_batch_id = mysqli_query($db,$batch_id) or die("Bad SQL: $batch_id");
    while ($row = mysqli_fetch_array($get_batch_id)) {
        $b_id = $row['BatchId'];
    }

   
    $course_id = "select CourseId from course where CourseName = '$c_name'";
    $get_course_id = mysqli_query($db,$course_id) or die("Bad SQL: $course_id");
    while ($row = mysqli_fetch_array($get_course_id)) {
        $c_id = $row['CourseId'];
    }

    $reg_no = "select RegNo from student where BatchId = '$b_id'";
    $get_reg_no = mysqli_query($db,$reg_no) or die("Bad SQL: $reg_no");

    if($role == "Add_Batch"){
      $get_tid = "Select TID from teaches where CourseId='$c_id' AND BatchId='$b_id'";
      $res = mysqli_query($db,$get_tid) or die("Bad SQL: $get_tid");
      $c= mysqli_num_rows($res);
      if($c!=0)
      {
        $error = "Same batch is already enrolled in the course by another teacher";

      }
    else{
        $add_teacher = "insert into teaches (TID,CourseId,BatchId) values ('$t_id','$c_id','$b_id')";
        $result = mysqli_query($db,$add_teacher);
    

      while ($row = mysqli_fetch_array($get_reg_no)) {
        $r_no = $row['RegNo'];
       
        $add_batch = "insert into enrolled (RegNo,TID,CourseId,mid,end) values ('$r_no','$t_id','$c_id',0,0)";
        $result = mysqli_query($db,$add_batch) or die ("Bad SQL: $add_batch") ;
        
        
        if($result){
		 
            echo "<script>alert('Batch is added to the course!')</script>";
            //echo "<script>window.open('../html/teacher_profile.php','_self')</script>";
            
        }
        else{
            echo "<script>alert('This batch is already added to this course.')</script>";
            //echo "<script>window.open('../html/teacher_profile.php','_self')</script>";
        }
      }
    }
      header("location:../html/teacher_profile.php"); 
  }
    else{
        $remove_teacher = "delete from teaches where TID='$t_id' and CourseId='$c_id' and BatchId='$b_id'";
        $result = mysqli_query($db,$remove_teacher);
        while ($row = mysqli_fetch_array($get_reg_no)) {
            $r_no = $row['RegNo'];
           
            $remove_batch = "delete from enrolled where RegNo='$r_no' and TID='$t_id' and CourseId='$c_id'";
            $result = mysqli_query($db,$remove_batch) ;
            
            
            if($result){
             
                echo "<script>alert('Batch is removed from the course!')</script>";
               // echo "<script>window.open('../html/teacher_profile.php','_self')</script>";
                
            }
            else{
                echo "<script>alert('This batch is already removed from this course.')</script>";
                //echo "<script>window.open('../html/teacher_profile.php','_self')</script>";
            }
          } 
          header("location:../html/teacher_profile.php");
    }

    
    
    
}
else{

    $_SESSION['add_batch_error'] = $error;
    header("location:../html/teacher_profile.php");

}
}
   
   function test_input($data) {
      global $db;
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     $data = mysqli_real_escape_string($db, $data);
     return $data;
   }
      
?>