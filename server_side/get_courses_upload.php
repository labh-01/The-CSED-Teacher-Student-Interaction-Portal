
<?php    
session_start();
include('../server_side/config.php');
$tid = $_SESSION['TID'];        
          $batch_name = $_REQUEST["q"];
		  $batch_id = "select BatchId from batch where BatchName = '$batch_name'";
		  $get_batch = mysqli_query($db,$batch_id) or die("Bad SQL: $batch_id");
         
         while($row = mysqli_fetch_array($get_batch)){
            
            $b_id = $row['BatchId'];

            $course_id="Select Distinct CourseId from teaches where BatchId='$b_id' and TID = '$tid'";
            
            $get_course_id = mysqli_query($db,$course_id) or die("Bad SQL: $course_id");
           

            while($row=mysqli_fetch_array($get_course_id)){
               $course = $row['CourseId'];
               $course_name = "select Distinct CourseName from course where CourseId = '$course'";
               $get_course = mysqli_query($db,$course_name) or die("Bad SQL: $course_name");
               while($row = mysqli_fetch_array($get_course)){
                     echo $row['CourseName'].',';
               }
            }
            
                     
      }
      ?>    