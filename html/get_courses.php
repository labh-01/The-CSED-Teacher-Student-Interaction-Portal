
<?php    
include('../server_side/config.php');        
          $batch_id = $_REQUEST["q"];
		  $course = "select CourseName from course where BatchId = '$batch_id'";
		  $get_course = mysqli_query($db,$course) or die("Bad SQL: $course");
		  $row = mysqli_fetch_array($get_course))
			echo $row;
?>    