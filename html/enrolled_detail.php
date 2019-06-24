<?php 
session_start();
include('../server_side/config.php');

$tid= $_SESSION['TID'];
$course = $_GET['course'];
$batch = $_GET['batch'];

?>
<html>

	<head>

	<title>CSED</title>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="../script/javaScript.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 	 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
 	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">

	</head>
  <script>
    function latesubmission(){
      if(document.getElementById("main2").style.visibility == "hidden")
      document.getElementById("main2").style.visibility = "visible";
    else
      document.getElementById("main2").style.visibility = "hidden";
    }
  </script>


	<body>


<body>
    <nav class="navbar navbar-light bg-info">
        <span class="open-slide">
            <a href="#" onclick="openSlideMenu()">
                <svg width="50" height="50">
                    <path d="M20,20 40,20" stroke="#000" stroke-width="1"/>
                    <path d="M20,25 40,25" stroke="#000" stroke-width="1"/>
                    <path d="M20,30 40,30" stroke="#000" stroke-width="1"/>
                </svg>
            </a>
        </span>

          <div class="container">

              <div class='clearfix'>
                <img src="..\images\logo.png" alt="MNNIT" />
              </div>


            <p class="navbr-text col-lg-auto h4" style='text-align: center'>
	          Computer Science & Engineering Department <br />
	          Motilal Nehru National Institute of Technology Allahabad <br />
	          Prayagraj-211004
           </p>
            
         
            <div style="float:right;">
           <?php
                if(isset($_SESSION['TID'])){

                  $tid = $_SESSION['TID'];
            ?>

          <span class="badge badge-light" style="font-size: 17px">
          	<?php
          	$course_name="select CourseName from course where CourseId = '$course'";
          	$batch_name="select BatchName from batch where BatchId = '$batch'";


  	        $get_course_name = mysqli_query($db,$course_name) or die("Bad SQL: $course_id");
            
            while ($row = mysqli_fetch_array($get_course_name)) {
                $c1_name = $row['CourseName'];
            }

            $get_batch_name = mysqli_query($db,$batch_name) or die("Bad SQL: $course_id");
            while ($row = mysqli_fetch_array($get_batch_name)) {
                $b_name = $row['BatchName'];
            }
            echo $c1_name;
          	?>	
          	|
          	<?php
          	echo " ".$b_name;
          	 ?>
          		
          	</span><br/><br/>

          <span style="margin-left: 10px">Logged in as : <b class="badge badge-success" style="font-size: 17px"><?php echo  $_SESSION['Tname']; ?></b> |</span>
          

          <?php
           } 
          else{
                  echo "<script>alert('You are logged out!Please login...')</script>";
                  header("location:../html/login.html");
                }  
          ?> 
        <a href="../server_side/logout.php" class="badge badge-warning" style="font-size: 17px">Logout</a>

        <?php
          $sum = "select sum(Rate) as sum from rating where TID='$tid' and courseId='$course'";
          $get_sum = mysqli_query($db,$sum) or die("Bad SQL: $sum");
          $row = mysqli_fetch_array($get_sum);
          $s =(int) $row['sum'];
          $count = "select count(Rate) as count from rating where TID='$tid' and courseId='$course'";
          $get_count = mysqli_query($db,$count) or die("Bad SQL: $sum");
          $row = mysqli_fetch_array($get_count);
          $c = (int) $row['count'];
          if($c)
          {
            $avg = $s / $c;
          }
          else{
            $avg = "No rating yet.";
          }
         
        ?>
        
        <h5 class="text-dark" style="margin-left: 10px; margin-top:10px" >Rating out of 5: <b class="badge badge-success" style="font-size: 19px"><?php echo $avg; ?></b></h5>
            </div>
            </div>
        
    </nav>



    <div id="side-menu" class="side-nav">
      <h5>Uploaded Assignments :</h5>

            <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
          <ul class="list-group">

          <?php
        
          $get_notices="SELECT AssignId from assigns where TID='$tid' and course='$course' and BatchId='$batch' ";
          $get_notice_id = mysqli_query($db,$get_notices);
          
         
          while($row = mysqli_fetch_array($get_notice_id)){
            
            $a_id = $row['AssignId'];

            $assignment_detail="Select ATitle,path,SDate, EDate from assignment where AssignID= '$a_id'";
            
            $get_assignment_detail = mysqli_query($db,$assignment_detail);


            while($row=mysqli_fetch_array($get_assignment_detail)){
               $assignment = $row['ATitle'];
               $a_path = $row['path'];
               $as_date = $row['SDate'];
               $ae_date = $row['EDate'];

               echo '<li class="list-group-item list-group-item-info"><a href="'.$a_path.'" target="_blank">'.$assignment.'</a><br> uploaded on '.$as_date.' and due on '.$ae_date.'</li>';
               
          }
        }
           ?>

          
        </ul>
              <button type="button" class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#myModal" style="margin-top: 10px">Late Submission</button>

          
    </div>

    <div id="main">
    	<div>
        
        <form class="form-horizontal" action="../server_side/marks.php?course=<?php echo $course?>&batch=<?php echo $batch?>" method="post">
    		<h3 class="text-muted">Student Detail:
        <button type="submit" class="btn btn-outline-info col-sm-1">Update</button>

      </h3>
    	</div>
    	<div  class="table-responsive"style="margin:auto">
    		<table class="table table-bordered table-default" style="border:2px solid black; border-radius: 5px">
    		  
    		    <thead style="text-align: center"><tr>
			      <th scope="col">#</th>
			      <th scope="col">Name</th>
            
            <?php
              
          $get_notices="SELECT AssignId from assigns where TID='$tid' and course='$course' and BatchId='$batch' ";
          $get_notice_id = mysqli_query($db,$get_notices);
          
         
          while($row1 = mysqli_fetch_array($get_notice_id)){
            
            $a_id = $row1['AssignId'];

            $assignment_detail="Select ATitle from assignment where AssignID= '$a_id'";
            
            $get_assignment_detail = mysqli_query($db,$assignment_detail);


            while($row2=mysqli_fetch_array($get_assignment_detail)){
               $assignment = $row2['ATitle'];

               echo '<th scope="col">'.$assignment.'</th>';
               
          }
        }
            ?>
            <th scope="col">Marks</th>
			    </tr>
			  </thead>


			  <tbody style="text-align: center">




    	<?php
    	$query = "SELECT student.RegNo, student.Sname, enrolled.mid, enrolled.end from student JOIN enrolled on student.RegNo = enrolled.RegNo where enrolled.CourseId='$course' and student.BatchId='$batch' order by student.Sname";
    	$get_detail = mysqli_query($db,$query) ;
    	$c = 0;
    	while($row=mysqli_fetch_array($get_detail))
    	{
    		$c+=1;
    		$regNo = $row['RegNo'];
    		$name = $row['Sname'];
    		$mid = $row['mid'];
    		$end = $row['end'];

        ?>

            <tr>
            <th scope="row"><?php echo $c ?></th>
            <td><?php echo $name.' ( '.$regNo.' )' ?></td>

<?php 
         $get_notices="SELECT assignment.AssignID from assignment JOIN assigns on assignment.AssignID = assigns.AssignId where TID='$tid' and course='$course' and BatchId='$batch'  ";
          $get_notice_id = mysqli_query($db,$get_notices);
          
         
          while($row1 = mysqli_fetch_array($get_notice_id)){
            
            $a_id = $row1['AssignID'];
          
          $res = "SELECT title,path,SubDate FROM `subimission` where studentId='$regNo' and TID='$tid' and CourseId='$course' and AssignId='$a_id' ORDER by SubDate DESC" ;
          $get_res = mysqli_query($db, $res);
          $rows = mysqli_fetch_array($get_res);
         
         if(mysqli_num_rows($get_res)==0)
          echo '<td>Solution not submitted</td>';
        else
        {
          echo '<td><a href="'.$rows['path'].'" target="_blank" style="color:red;">'.$rows['title'].'</a><br/>Submitted on '.$rows['SubDate'].'</td>';
        }

        }
    	?>


        
        <td width="20%">
          <div class="form-inline form-group mb-2" >
          <label class="control-label" name="mid">Mid : </label>
          <input type="text" class="form-control col-sm-3" id="<?php echo 'mid'.$regNo?>" name="<?php echo 'mid'.$regNo?>" placeholder="<?php echo $mid ?>" style="margin-left: 5px" />
          
          <label class="control-label" name="end" style="margin-left: 10px">End : </label>
          <input type="text" class="form-control col-sm-3" id="<?php echo 'end'.$regNo?>" name="<?php echo 'end'.$regNo?>" placeholder="<?php echo $end ?>" style="margin-left: 5px" />
        </div>
        </td>      
	    </tr>
    	<?php
    }

    	?>

    </tbody>
  </form>
	</table>
	</div>
    </div>



      <div class="container">

 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" id="modalH">
          <span style="text-align: left">Late Submission</span>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body bg-default" id="modalB">

            <?php
              
          $get_notices="SELECT AssignId from assigns where TID='$tid' and course='$course' and BatchId='$batch' ";
          $get_notice_id = mysqli_query($db,$get_notices);
          
         
          while($row1 = mysqli_fetch_array($get_notice_id)){
            
            $a_id = $row1['AssignId'];

            $assignment_detail="Select ATitle, EDate from assignment where AssignID= '$a_id'";
            
            $get_assignment_detail = mysqli_query($db,$assignment_detail);


            while($row2=mysqli_fetch_array($get_assignment_detail)){
               $assignment = $row2['ATitle'];
               $edate = $row2['EDate'];

               echo '<h4 class="text-muted">'.$assignment.'</h4>';
               $query = "select enrolled.RegNo from enrolled where enrolled.RegNo NOT IN (select studentId from subimission where AssignId='$a_id' and SubDate<='$edate') and CourseId='$course'";
               $get_result = mysqli_query($db, $query);
               ?>
               <ol>
                <?php
               while($row = mysqli_fetch_array($get_result))
               {
                echo '<li>'.$row['RegNo'].'</li>';
               }
               ?>

               </ol>
               <?php
      }
        }
            ?>
 

        </div>
      </div>
      
    </div>
  </div>

	</body>
</html>