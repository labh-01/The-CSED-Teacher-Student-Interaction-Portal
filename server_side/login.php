<?php

   session_start();
   include('./config.php');
   $error="";
   $user="";
   $pswd="";
   $role="";
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {

      if(empty($_POST['user'])){
      $error="*UserId is required";
   }
   else{
      $user = test_input($_POST['user']);
   }


   if(empty($_POST['pswd'])){
      $error = "*Password is required";
   }
   else
   {
      $pswd = test_input($_POST['pswd']);
   }

   if(!isset($_POST['optrole']))
   {
      $error = "*Please select your role";
   }
   else{
      $role = $_POST['optrole'];
   }


if($error == "")
{
   if($role == "Teacher")
      $sql = "SELECT Tname FROM teacher WHERE TID = '$user' and Password = '$pswd'";
   else
      $sql = "SELECT Sname FROM student WHERE RegNo = '$user' and Password = '$pswd'";


      $result = mysqli_query($db,$sql);      
      $count = mysqli_num_rows($result);
      $row = mysqli_fetch_array($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1 ){
        if( $role== "Teacher") {
         $_SESSION['TID'] = $user;
         $_SESSION['Tname'] = $row['Tname'];
        header("location:../html/teacher_profile.php");
         
      }
      else {
        $_SESSION['RegNo']=$user;
        $_SESSION['Sname'] = $row['Sname'];
         header("location:../html/student_profile.php");
      }
   }
   else {
         $error = "*Credentials not matched...";
      }
   }
            $_SESSION["error"] = $error;
            if($error !=""){

          header("location:../html/login.php");
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