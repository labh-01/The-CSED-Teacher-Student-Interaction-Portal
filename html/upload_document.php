<html>

	<head>
		<meta charset="utf-8">

	  <meta name="viewport" content="width=device-width, initial-scale=1">

	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	  
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	    <link rel="stylesheet" href="../css/login.css">
	    <link rel="stylesheet" href="../css/upload.css">
	    
  </head>



	<body>
		<?php 
			session_start();
			include('../server_side/config.php');
			$tid = $_SESSION['TID'];

		?>

		<div>
		<nav class="navbar navbar-light bg-info">
			<div class="container">
				<div class="col-md-1"></div>
	  
			  <div class='clearfix'>
			  	<img src="..\images\logo.png" alt="MNNIT" />
			  </div>
			  <p class="navbr-text col-lg-auto h4" style='text-align: center'>
			  	Computer Science & Engineering Department <br />
			  	Motilal Nehru National Institute of Technology Allahabad <br />
			  	Prayagraj-211004
			  </p>
			  <div class="col-md-1"></div>
			  </div>
		</nav>
	</div>



	<div>
		<div class="col-md-1"></div>
		
		<div class ="flex container mt-4 col-sm-5" id="bx">

			<form action="../server_side/upload.php" method="post" enctype="multipart/form-data" class="form-horizontal">
			   
			   <div style="margin-top: 10px">
			   	<label for="file-upload" class="custom-file-upload" style="margin-left: 25px">
    				Select File to upload:
				</label>
				  <input type="file" name="fileToUpload" id="fileToUpload" style="margin-left: 15px">
				</div>


				<div class="form-inline form-group mb-2" style="margin-top: 15px">
			    <label class="col-form-label col-sm-2">Title:</label>
			    <input type="text" name="title" placeholder="Title of document" class="form-control col-sm-10"><br>
			    </div> 



			    <div class="form-check" style="margin-top: 15px">

			    <input type="radio" name="doc_type" value="Notice" onclick="javascript:showDate();" id="notice" class="form-check-input"> 
			    <label class="form-check-label">Notice</label>
				</div>

				<div class="form-check form-check-inline">
		  			<input type="radio" name="doc_type" value="Assignment" onclick="javascript:showDate();" id="assignment" class="form-check-input"> 
		  			<label class="form-check-label">Assignment </label>

		  			<div id="EndDate" style="visibility: hidden; margin-left:165px;" class="form-group col-sm-6">
		  				<input type="date" name="EndDate" class="form-control ">
		  			</div>
	  			</div>

	  			<div class="form-group"> 

			           <select name='batch' id='batch' onchange="selectCourse(this)"  style="margin-left:0px" class="custom-select col-md-5"> 
						  <option>Select Batch</option>
			               <?php 
			               $batch = "select DISTINCT BatchId from teaches where TID = '$tid' ";
			               $get_batch = mysqli_query($db,$batch) or die("Bad SQL: $batch");
			               while($row = mysqli_fetch_array($get_batch)){
			                    $b_id = $row['BatchId'];
			                    $batch_name = "select BatchName from batch where BatchId = '$b_id'";
			                    $get_batch_name = mysqli_query($db,$batch_name) or die("Bad SQL: $batch_name");
			                    while ($row = mysqli_fetch_array($get_batch_name)) {
			                        $b_name = $row['BatchName'];
			                    }
			                ?>
						   <option><?php echo $b_name?></option>
			               <?php }?>
					   </select>

				
					   <select name='course' id='course'  style="margin-left:70px" class="custom-select col-md-5">
						  <option>Select Course</option>
					   </select>
			  
	 
	    		</div>


	   			<div class="form-group">
			    <input type="submit" value="Upload file" name="submit" class="form-control btn btn-info"><br>
				</div>


			</form>


				<div class="error">
					<?php
					if($_SESSION["upload_error"]!="")
						{
						echo $_SESSION["upload_error"]; 
						$_SESSION["upload_error"] = "";
						}
					?>
				</div>
				<div class="error">
					<?php
					if($_SESSION["upload_msg"]!="")
						{
						echo $_SESSION["upload_msg"];
						$_SESSION["upload_msg"] = "";
					 	}
					 ?>
				</div>
			</div>

		<div class="col-md-1"></div>
	</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
           <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  

		<script type="text/javascript">

			function showDate() {
			    if (document.getElementById('assignment').checked) {
			        document.getElementById('EndDate').style.visibility = 'visible';
			    } else {
			        document.getElementById('EndDate').style.visibility = 'hidden';
			    }
			};

			function selectCourse(batchName){
				  var batchname = batchName.value;
				  var xmlhttp = new XMLHttpRequest();
                 console.log(batchname);
			      xmlhttp.onreadystatechange = function() {
			      if (this.readyState == 4 && this.status == 200) {
					  var courses = this.responseText;
					var select = document.getElementById("course");
					var course_names = courses.split(",");
					console.log(course_names);
				    var l = course_names.length;
					$('#course').empty().append(new Option("Select Course", 0));
					for(var index=0;index<l-1;index++){
			            select.options[select.options.length] = new Option(course_names[index],course_names[index]);
			            console.log("Hiii:" + course_names[index] + ", "+index);
					}
				
			      }
			  };
				
				xmlhttp.open("GET", "../server_side/get_courses_upload.php?q="+batchname, true);
			    xmlhttp.send();
			};

		</script>

	</body>

</html>