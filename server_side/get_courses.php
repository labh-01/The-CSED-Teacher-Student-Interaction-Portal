
<?php    
session_start();
include('../server_side/config.php');        
          $batch_name = $_REQUEST["q"];
		  $batch_id = "select BatchId from batch where BatchName = '$batch_name'";
		  $get_batch = mysqli_query($db,$batch_id) or die("Bad SQL: $course");
         
         while($row = mysqli_fetch_array($get_batch)){
            $b_id = $row['BatchId'];
            $course_name = "select CourseName from course where BatchId = '$b_id'";
            $get_course = mysqli_query($db,$course_name) or die("Bad SQL: $course");
            while($row = mysqli_fetch_array($get_course)){
                  echo $row['CourseName'].',';
            }
                     
      }
      ?>    