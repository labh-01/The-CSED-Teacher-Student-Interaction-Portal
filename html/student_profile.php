
<?php 
session_start();
include('../server_side/config.php');
$b_id="";
$c_id="";
$cl_name="";
$t_id="";
?>
<html>
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script src="../script/javaScript.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  </head>


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
                if(isset($_SESSION['RegNo'])){

                  $sid = $_SESSION['RegNo'];
                  ?>
          <span>Logged in: <b class="badge badge-pill badge-success" style="font-size: 16px"><?php echo  $_SESSION['Sname']; ?></b> | </span>

          <?php
           } 
          else{
                  echo "<script>alert('You are logged out!Please login...')</script>";
                  header("location:../html/login.html");
                }  
          ?> 
          <a href="../server_side/logout.php" class="badge badge-pill badge-warning" style="font-size: 16px">Logout</a>
     </div>
    </div>
    </nav>
    <div id="side-menu" class="side-nav">
    <h5>Notices:</h5>

            <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
        <ul id="list-group">
        <?php
        
        $batch = "select BatchId from student where RegNo='$sid'";
        $get_batch_id = mysqli_query($db,$batch);
        while($row = mysqli_fetch_array($get_batch_id)){
            $b_id = $row['BatchId'];
        }

        $course="select CourseId from enrolled where RegNo='$sid'";
        $get_course_id = mysqli_query($db,$course);
        
       
        while($row = mysqli_fetch_array($get_course_id)){
          
          $c_id = $row['CourseId'];
          $get_notices="select AssignId from assigns where course = '$c_id' and BatchId = '$b_id'";
          $get_notice_id = mysqli_query($db,$get_notices);
          
         
          while($row = mysqli_fetch_array($get_notice_id)){
            
            $n_id = $row['AssignId'];
  
            $notice_detail="Select NTitle,Sdate, path from notice where noticeId= '$n_id'";
            
            $get_notice_detail = mysqli_query($db,$notice_detail);
            while($row=mysqli_fetch_array($get_notice_detail)){
               $notice = $row['NTitle'];
               $n_path = $row['path'];
               $n_date = $row['Sdate'];
               echo '<li style="cursor:pointer"><a href="'.$n_path.'" target="_blank">'.$notice.'</a> uploaded on '.$n_date.'</li><hr/>';
               
          }
        }

        }
      
         ?>
        </ul>
    </div>

    <div id="main">
       
        <h2 class="text-muted">Course Section:</h2>
        <div class="container ">
            <div class="row">
            <?php
                 $s_id = $_SESSION['RegNo'];
                 $s_name = $_SESSION['Sname'];
                 $c=1;

                 $course_id = "select Distinct CourseId from enrolled where RegNo = '$s_id'";
                 $get_course_id = mysqli_query($db,$course_id) or die("Bad SQL: $course_id");
                 while($row = mysqli_fetch_array($get_course_id)){
                    $c_id = $row['CourseId'];
                    $course_name = "select CourseName from course where CourseId = '$c_id' and BatchId = '$b_id'";
                    $get_course_name = mysqli_query($db,$course_name) or die("Bad SQL: $course_id");
                    while ($row = mysqli_fetch_array($get_course_name)) {
                        $cl_name = $row['CourseName'];
                    }
                    
                    $t_id = "select TID from teaches where CourseId = '$c_id' and BatchId = '$b_id'";
                    $get_t_id = mysqli_query($db,$t_id) or die("Bad SQL: $course_id");
                    while ($row = mysqli_fetch_array($get_t_id)) {
                        $t_id = $row['TID'];
                        $t_name = "select Tname from teacher where TID = '$t_id'";
                        $get_t_name = mysqli_query($db,$t_name) or die("Bad SQL: $course_id");
                        while ($row = mysqli_fetch_array($get_t_name)) {
                            $te_name = $row['Tname'];
                        }
                    }
                    $_SESSION['TID'.$c] = $t_id;
                    $_SESSION['CourseId'.$c] = $c_id;
                    $_SESSION['BatchId'.$c] = $b_id;
                    $_SESSION['Tname'.$c] = $te_name;
                    $_SESSION['CourseName'.$c] = $cl_name;
                    $url = "../html/course.php?c=".$c;
              ?>
                    

                    <div class="card " style="text-align:center; font-weight: bold; font-size: 20px; margin-left: 25px; border:2px solid gray;">
                    <div class="card-top bg-info" style="height: 50px">
                      <span style="color:white; padding: auto">
                       <?php                          
                          echo $te_name;
                         
                      ?>
                     </span>
                   </div>
                    <div class="card-body bg-light" style="height: 60px">
                      <div class="card-text">
                    <?php
                    echo '<a href='.$url.' class="text-dark"">'.$cl_name.'</a>';
                    ?>
                  </div>
                  </div>
                </div>
                   
              <?php  
              $c+=1; 
                }
              ?>
              
            </div>
        </div>
    </div>
    

</body>
</html>