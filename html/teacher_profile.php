
<?php 
session_start();
include('../server_side/config.php');
$_SESSION["upload_error"] = "";
$_SESSION["upload_msg"] = "";
$_SESSION['add_batch_error'] = "";

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
  
 
 <script>
function selectCourse(batchName){
    var batchname = batchName.value;
    var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
      var courses = this.responseText;
    var select = document.getElementById("course");
    var course_names = courses.split(",");
      var l = course_names.length;
    $('#course').empty().append(new Option("Select Course", 0));
    for(var index=0;index<l-1;index++){
            select.options[select.options.length] = new Option(course_names[index],course_names[index]);
            console.log("Hiii:" + course_names[index] + ", "+index);
    }
  
      }
  
    };
  xmlhttp.open("GET", "../server_side/get_courses.php?q="+batchname, true);
    xmlhttp.send();
}
  </script>


    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
  
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
                if(isset($_SESSION['TID'])){

                  $tid = $_SESSION['TID'];
                  ?>
          <span>Logged in as : <b class="badge badge-pill badge-success" style="font-size: 17px"><?php echo  $_SESSION['Tname']; ?></b>|</span>

          <?php
           } 
          else{
            echo "<script>alert('You are logged out!Please login...')</script>";
            header("location:../html/login.html");
                }  
          ?> 
        <a href="../server_side/logout.php" class="badge badge-pill badge-warning" style="font-size: 17px">Logout</a>
            </div>
            </div>
        
    </nav>




    <div id="side-menu" class="side-nav">
      <h5>Notices:</h5>

            <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
          <ul class="list-group">

          <?php
        
          $get_notices="select AssignId from assigns where TID='$tid'";
          $get_notice_id = mysqli_query($db,$get_notices);
          
         
          while($row = mysqli_fetch_array($get_notice_id)){
            
            $n_id = $row['AssignId'];

            $notice_detail="Select NTitle,Sdate, path from notice where noticeId= '$n_id'";
            
            $get_notice_detail = mysqli_query($db,$notice_detail);

          ?>

            <?php 

            while($row=mysqli_fetch_array($get_notice_detail)){
               $notice = $row['NTitle'];
               $n_path = $row['path'];
               $n_date = $row['Sdate'];
               echo '<li class="list-group-item list-group-item-info"><a href="'.$n_path.'" target="_blank">'.$notice.'</a> uploaded on '.$n_date.'</li>';
               
          }
        }
           ?>

          
        </ul>
          
    </div>

<div id="main">
  <div >
        <form action="http://localhost/csed/server_side/add_batch.php" method="post">
          
          <div class="button-group">
           <select name='batch' id='batch' onchange="selectCourse(this)" style="margin:10px;" class="custom-select input-small col-sm-2"> 
        <option>Select Batch</option>

               <?php 
               $batch = "select DISTINCT BatchId from course";
               $get_batch = mysqli_query($db,$batch) or die("Bad SQL: $batch");
               while($row = mysqli_fetch_array($get_batch)){
                    $b_id = $row['BatchId'];
                    $batch_name = "select BatchName from batch where BatchId = '$b_id'";
                    $get_batch_name = mysqli_query($db,$batch_name) or die("Bad SQL: $course_id");
                    while ($row = mysqli_fetch_array($get_batch_name)) {
                        $b_name = $row['BatchName'];
                    }
                ?>
        
         <option><?php echo $b_name?></option>
               <?php }?>
       
       </select>
       
       <select name='course' id='course' style="margin:10px;" class="custom-select col-sm-2">
        <option>Select Course</option>
       </select>
           
        <div class="form-check form-check-inline">
         <input  class="form-check-input" type="radio" name="optrole"  value="Add_Batch">
         <label class=" form-check-label">Add Batch</label>
       </div>

       <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="optrole" value="Remove_Batch" style="margin-left:  20px">
        <label class="form-check-label">Remove Batch</label>
      </div>
          <button type="submit" name="submit" class="btn btn-outline-secondary col-sm-1" style="margin-left: 10px">Enter</button>
          <a href="../html/upload_document.php" class="btn btn-outline-secondary col-sm-2" style="margin-left:200px;">Upload Document</a>

        </form>

      </div>

 <hr/>
    </div>
       <h3 class="text-muted">Course Section:</h3>
        <div class="container ">
            <div class="row">

              <?php
                 $t_id = $_SESSION['TID'];
                 $t_name = $_SESSION['Tname'];
                 $course_id = "select CourseId,BatchId from teaches where TID = '$t_id'";
             $get_course_id = mysqli_query($db,$course_id) or die("Bad SQL: $course_id");
                 while($row = mysqli_fetch_array($get_course_id)){
                    
                    $c_id = $row['CourseId'];
                    $b_id = $row['BatchId'];
                    $course_name = "select CourseName from course where CourseId = '$c_id'";
                    $batch_name = "select BatchName from batch where BatchId = '$b_id'";
                    
                    $get_course_name = mysqli_query($db,$course_name) or die("Bad SQL: $course_id");
                    
                    while ($row = mysqli_fetch_array($get_course_name)) {
                        $c1_name = $row['CourseName'];
                    }

                    $get_batch_name = mysqli_query($db,$batch_name) or die("Bad SQL: $course_id");
                    while ($row = mysqli_fetch_array($get_batch_name)) {
                        $b_name = $row['BatchName'];
                    }

                  ?>
                <div class="card " style="text-align:center; font-weight: bold; font-size: 20px; margin-left: 25px; border:2px solid gray;">
                    <div class="card-top bg-info" style="height: 50px">
                      <span style="color:white; padding: auto">
                       <?php                          
                          echo $c1_name;
                          $url = "../html/enrolled_detail.php?course=".$c_id."&batch=".$b_id;
                      ?>
                     </span>
                   </div>
                    <div class="card-body bg-light" style="height: 60px">
                      <div class="card-text">
                    <?php
                    echo '<a href='.$url.' class="text-dark"">'.$b_name.'</a>';
                    ?>
                  </div>
                  </div>
                </div>

            <?php 
                 }
            ?>
                    

        
            </div>
        </div>
</div>
<div>
  <?php echo $_SESSION['add_batch_error']; ?>
</div>    



</body>
</html>