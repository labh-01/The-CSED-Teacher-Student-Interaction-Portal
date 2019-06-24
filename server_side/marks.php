<?php
  session_start();
  include('./config.php');
  $c_id = $_GET['course'];
  $b_id = $_GET['batch'];
  $tid= $_SESSION['TID'];

    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {


    	$query = "SELECT student.RegNo from student JOIN enrolled on student.RegNo = enrolled.RegNo where enrolled.CourseId='$c_id' and student.BatchId='$b_id'";

    	$get_detail = mysqli_query($db,$query) or die('Bad SQL: $query') ;
    	$mid = "";
    	$end = "";

    	while ($row=mysqli_fetch_array($get_detail))
    	{
    		$regno = $row['RegNo'];
    		$mid = (int)$_POST['mid'.$regno];
    		$end = (int)$_POST['end'.$regno];


    		if(!empty($_POST['mid'.$regno]))
    		{
    			echo "hare krishna";
    			$q = "update enrolled set mid=$mid where RegNo='$regno' and TID='$tid' and CourseId='$c_id'";
    			$get_update=mysqli_query($db,$q);
    			echo $q;
    		}


    		if(!empty($_POST['end'.$regno]))
    		{
    			$q = "update enrolled set end=$end where RegNo='$regno' and TID='$tid' and CourseId='$c_id'";
    			echo $q;
    			$get_update=mysqli_query($db,$q);
    		}
    	}


    }
    header("location:../html/enrolled_detail.php?course=$c_id&batch=$b_id");
?>