<?php

   session_start();
   include('./config.php');
   $error="";
   $user="";
   $role="";
   $email="";

   if($_SERVER["REQUEST_METHOD"] == "POST") {

      if(empty($_POST['user'])){
      $error="*UserId is required";
   }
   else{
      $user = test_input($_POST['user']);
   }


   if(empty($_POST['email'])){
      $error = "*Email is required";
   }
   else
   {
      $email = test_input($_POST['email']);
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
   {
      $sql = "SELECT Tname FROM teacher WHERE TID = '$user' and email = '$email'";
      $result = mysqli_query($db,$sql);      
      $count = mysqli_num_rows($result);

      if($count==1)
      {
      	$sql = "UPDATE teacher SET Password='$user' WHERE TID='$user'";
      	if(mysqli_query($db,$sql))
      	{
      		echo "<p> Password set to default";
      	}
      	else{
      		$error="Password is not set currently.";
      	}
      }
      else
      {
      	$error="Credentials not matched";
      }
   }
   else
   {
      $sql = "SELECT Sname FROM student WHERE RegNo = '$user' and email = '$email'";
       $result = mysqli_query($db,$sql);      
      $count = mysqli_num_rows($result);

      if($count==1)
      {
      	$sql = "UPDATE student SET Password='$user' WHERE RegNo='$user'";
      	if(mysqli_query($db,$sql))
      	{
      		echo "<p> Password set to default";
      	}
      	else{
      		$error="Password is not set currently.";
      	}
      }
      else
      {
      	$error="Credentials not matched";
      }
      }    
      // If result matched $myusername and $mypassword, table row must be 1 row
   echo $error;
   $_SESSION["error"] = $error;
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