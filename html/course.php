<?php 
session_start();
include('../server_side/config.php');
$c=$_GET['c'];
$tid= $_SESSION['TID'.$c];
$c_id= $_SESSION['CourseId'.$c];
$c_name= $_SESSION['CourseName'.$c];
$t_name= $_SESSION['Tname'.$c];
$b_id= $_SESSION['BatchId'.$c];
$regno = $_SESSION['RegNo'];
$sid="";

$msg = "";
$error="";
?>
<html>
  <head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  type="text/css" href="../css/style.css">
    <link rel="stylesheet"  type="text/css" href="../css/star.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

      <link rel="stylesheet" href="../css/login.css">

  <script>

$(document).ready(function(){
    $('#myModal').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        var url = "../server_side/upload_sol.php?";
        url = url+rowid;
        console.log(url);
        document.getElementById("uploadFrm").action=url;

     });
});
  </script>

  <style>
    .sidenav {
    width: 25%;
    position: relative;
    z-index: 1;
    height:100%;
    background: #eee;
    overflow-x: hidden;
    padding: 8px;
    margin-top:10px;
    float:left;
    border-radius:6px;
    padding:8px 0;
  }

  .maindiv {
    width: 73%;
    position: relative;
    z-index: 1;
    height:100%;
  
    overflow-x: hidden;
    padding: 8px;
    margin-top:10px;
    float:right;
    border-radius:6px;
  }
  
    </style>
  </head>
 
  <body>


    <nav class="navbar navbar-light bg-info">

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


          <span>Logged in: <b class="badge badge-success" style="font-size: 17px"><?php echo  $_SESSION['Sname']; ?></b> | </span>

          <?php
           } 
          else{
                  echo "<script>alert('You are logged out!Please login...')</script>";
                  header("location:../html/login.html");
                }  
          ?> 
        <a href="../server_side/logout.php" class="badge badge-warning" style="font-size: 17px">Logout</a>
        <br/>

       <span class="badge badge-light" style="font-size: 20px;margin-top:20px;">
       <?php echo $c_name;?> | <?php echo $t_name;?> 
      </span>

            </div>
            </div>
        
    </nav>

  <div class="container" style="margin-top: 20px;">
  
   <div class="container bg-info" style="border-radius:6px; height:70px;">
       <?php
       $marks="Select mid,end from enrolled where RegNo='$regno' and TID='$tid' and CourseId='$c_id'";
       $get_marks=mysqli_query($db,$marks);
       $row = mysqli_fetch_array($get_marks);
       ?>
      <span class="badge badge-light" style="font-size: 20px;margin-top:20px;"><?php echo "Mid-Sem: ".$row['mid']; ?> </span>
      <span class="badge badge-light" style="font-size: 20px;margin-top:20px;"><?php echo "End-Sem: ".$row['end']; ?> </span>
           
      <button id="myBtn" class="btn btn-dark col-sm-2" style="float:right;margin-top:15px;">Rate</button>

<!-- The Modal -->
<div id="RateModal" class="modal">
    <div class="modal-dialog modal-md">
  
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h5>Rate <?php echo $t_name?> for <?php echo $c_name?></h5>
      <span class="close">&times;</span>
    </div>
    <div class="stars">
      <form action="" method="post">
        <input class="star star-5" id="star-5" type="radio" name="star" value="5"/>
        <label class="star star-5" for="star-5"></label>
        <input class="star star-4" id="star-4" type="radio" name="star" value="4"/>
        <label class="star star-4" for="star-4"></label>
        <input class="star star-3" id="star-3" type="radio" name="star" value="3"/>
        <label class="star star-3" for="star-3"></label>
        <input class="star star-2" id="star-2" type="radio" name="star" value="2"/>
        <label class="star star-2" for="star-2"></label>
        <input class="star star-1" id="star-1" type="radio" name="star" value="1"/>
        <label class="star star-1" for="star-1"></label>
        <button type="submit" name="submit" class="btn btn-outline-dark col-sm-4" style="margin-left: 80px">Rate</button>
      </form>

      <?php

if(isset($_POST['submit'])){
if(isset($_POST['star'])){
$rating =(int)$_POST['star'];

//echo "<script type='text/javascript'>alert('You rated : $rating')</script>";

$rate = "select Rate from rating where studentId='$sid' and TID='$tid' and courseId='$c_id'";
$result = mysqli_query($db,$rate) or die("Bad SQL: $rate");
$rowcount = mysqli_num_rows($result);

if($rowcount)
{
//$row = mysqli_fetch_array($result);
//$pr_rating = $row['Rate'];
//echo "Previous Rating : ".$pr_rating;
$rate = "update rating set Rate='$rating' where studentId='$sid' and TID='$tid' and courseId='$c_id'";
$result = mysqli_query($db,$rate) or die("Bad SQL: $rate");
if($result){
echo "<script type='text/javascript'>alert('You rated : $rating')</script>";

}
else{
echo "<script>alert('Could not rate...try again!!!')</script>";

}
}
else{
$rate = "insert into rating (studentId,TID,courseId,Rate) values ('$sid','$tid','$c_id','$rating')";
$result = mysqli_query($db,$rate) or die("Bad SQL: $rate");
if($result){
echo "<script type='text/javascript'>alert('You rated : $rating')</script>";

}
else{
echo "<script>alert('Could not rate...try again!!!')</script>";

}
}


}
else{
echo "<script type='text/javascript'>alert('Please select any rating');</script>";
}
}
      ?>
    </div>
    
  </div>

</div>
</div>
    </div>

    <div class="container" >
     <div class="sidenav">
        <ul class="list-group" style="cursor: pointer;">
        <?php
        
        $get_notices="select AssignId from assigns where TID='$tid' and course='$c_id' and BatchId='$b_id'";
        $get_notice_id = mysqli_query($db,$get_notices);
        
       
        while($row = mysqli_fetch_array($get_notice_id)){
          
          $n_id = $row['AssignId'];

          $notice_detail="Select NTitle,Sdate, path from notice where noticeId= '$n_id'";
          
          $get_notice_detail = mysqli_query($db,$notice_detail);

          while($row=mysqli_fetch_array($get_notice_detail)){
             $notice = $row['NTitle'];
             $n_path = $row['path'];
             $n_date = $row['Sdate'];
             echo '<li style="cursor:pointer;"><a href="'.$n_path.'" target="_blank">'.$notice.'</a> uploaded on '.$n_date.'</li><hr>';
             
        }
      }
         ?>
        </ul>
      </div>
    </div>


    <div class="container">
       <div class="maindiv">
           <h3 class="text-muted">Assignments:</h3>

       <div class="row">
          <?php
             
             $assign_id = "select AssignId from assigns where TID = '$tid' and course = '$c_id' and BatchId = '$b_id'";
             $get_assign_id = mysqli_query($db,$assign_id) or die("Bad SQL: $assign_id");
              while ($row = mysqli_fetch_array($get_assign_id)) {
                    $a_id = $row['AssignId'];
                  
                  $assign = "select * from assignment where AssignID = '$a_id'";
                  $get_assign = mysqli_query($db,$assign) or die("Bad SQL: $get_assign");
                  
                  while ($row = mysqli_fetch_array($get_assign)) {

                  $title=$row['ATitle'];
                    $path = $row['path'];
                    $s_date = $row['SDate'];
                    $e_date = $row['EDate'];

                                       
                  ?>


            <?php 

            $sol = "SELECT title,path,SubDate FROM `subimission` where studentId='$regno' and TID='$tid' and CourseId='$c_id' and AssignId='$a_id' ORDER by SubDate DESC";
            $get_sol = mysqli_query($db, $sol) or die("Bad SQL: $sol");

            ?>

         

                <div class="col-sm-12" style="background-color:lavender;height:120px;margin-top:20px;border-radius:6px;">


                  <h5><?php echo $title; ?>
                  <?php
                   echo '<a href='.$path.' download><img src="../images/download.png"></img></a>';
                   ?>
                 </h5>

                 <span style="margin-top: 10px;font-weight: 500;">

                  <?php echo "Posted on: " .$s_date;    
                    echo "  | ";    
                   echo "Due date: " .$e_date; 
                   ?>
                 </span>

                   <br/>
            
              <button type="button" class="btn btn-outline-secondary btn-md" data-toggle="modal" data-target="#myModal" data-id="<?php echo "tid=$tid&course=$c_id&a_id=$a_id&c=$c"; ?>" style="margin-top: 10px">Upload Solution</button>
          

          <?php



         if(mysqli_num_rows($get_sol)> 0)
            {

              $row = mysqli_fetch_array($get_sol);
                 $sol_title = $row['title'];
                 $sol_path = $row['path'];
                 $sol_date = $row['SubDate'];
                 echo '<a href='.$sol_path.' download>'.$sol_title.'</a> submitted on '.$sol_date;
            }

             } 
  
             ?>
                </div>        

           <?php
         }


          ?>          

        
      </div>
        
         
       </div>
    </div>

  </div>     



  <div class="container">

 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" id="modalH">
          <span style="text-align: left">Upload Solution</span>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body bg-default" id="modalB">

      <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" id="uploadFrm">         
          

          <div id = "" >
       <div  class="form-inline form-group mb-2" style="margin-top: 10px">
          <label for="file-upload" class="custom-file-upload" style="margin-left: 25px">
            Select File to upload:
        </label>
          <input type="file" name="fileToUpload" id="fileToUpload" style="margin-left: 15px">
        </div>

        <div class="form-inline form-group mb-2" style="margin-top: 15px">
          <label class="col-form-label col-sm-2">Title:</label>
          <input type="text" name="title" placeholder="Title of Solution" class="form-control col-sm-10"><br>
          </div>

          <div class="form-group" style="margin-top: 5px ;float:right">
            <button type="submit" class="btn btn-info btn-md">Submit</button>
        </div>
        </div>
      </form>
      <span>
        <?php //echo $msg ?>
      </span>
 

        </div>
      </div>
      
    </div>
  </div>
  <script>

       var modal = document.getElementById("RateModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}



  </script> 

  </body>
</html>