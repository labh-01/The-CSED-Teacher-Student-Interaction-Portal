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
                <button type="submit" name="submit" class="btn btn-outline-dark col-sm-4" style="margin-left: 10px">Rate</button>
              </form>

              <?php

if(isset($_POST['submit'])){
  if(isset($_POST['star'])){
    $rating =(int)$_POST['star'];
    echo gettype($rating);
    //echo "<script type='text/javascript'>alert('You rated : $rating')</script>";
   
    $rate = "select Rate from rating where studentId='$s_id' and TID='$tid' and courseId='$c_id'";
    $result = mysqli_query($db,$rate) or die("Bad SQL: $rate");
    $rowcount = mysqli_num_rows($result);
    echo $rowcount;
    if($rowcount)
    {
      //$row = mysqli_fetch_array($result);
      //$pr_rating = $row['Rate'];
      //echo "Previous Rating : ".$pr_rating;
      $rate = "update rating set Rate='$rating' where studentId='$s_id' and TID='$tid' and courseId='$c_id'";
      $result = mysqli_query($db,$rate) or die("Bad SQL: $rate");
      if($result){
        echo "<script type='text/javascript'>alert('You rated : $rating')</script>";
        
      }
      else{
        echo "<script>alert('Could not rate...try again!!!')</script>";
        
      }
    }
    else{
      $rate = "insert into rating (studentId,TID,courseId,Rate) values ('$s_id','$tid','$c_id','$rating')";
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