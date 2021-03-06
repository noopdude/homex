<?php

session_start();

if($_SESSION['admin_flag']==1 ){


}
else{

  $_SESSION['msg'] = "You dont have privileges to view this page";
  header("location:login.php");

}

if(isset($_GET['logout'])){

  session_destroy();
  unset($_SESSION['username']);
  header("location:login.php");

}

?>
<!doctype html>
<html>
  <head>
    <title>Home-X | Home Page</title>
  </head>

  <body>
    <link rel="stylesheet" href="./css/styles.css">


    <?php if(isset($_SESSION['success'])) :   ?>

      <div>
          <h4>
              <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);

               ?>
          </h4>

      </div>


    <?php endif ?>

    <!--if the user logs in print information about him -->

    <?php if(isset($_SESSION['username'])) :  ?>



      <div class="container">
        <div class = "row">
            <div class="col-50">
              <a href="index.php"><img src="/img/logo.JPG" alt="logo" style="width:20%"></a>
            </div>
            <div class="col-50">
              <a href="index.php?logout='1'" class="button">Log Out</a>
            </div>
        </div>

        <h1>Welcome to Home-X Administrator Dashboard, <strong><?php echo $_SESSION['username']; ?> ! </strong></h1>
        <div class = "row">
            <div class="col-50">
              <a href="usermain.php" class="buttonxl">User Accounts</a>
            </div>
            <div class="col-50">
              <a href="homemain.php" class="buttonxl">Homes</a>
            </div>
        </div>
        <div class = "row">
            <div class="col-50">
              <a href="servicerequestmain.php" class="buttonxl">Service Requests</a>
            </div>
            <div class="col-50">
              <a href="paymentsmain.php" class="buttonxl">Payments</a>
            </div>
        </div>
        <div class = "row">
            <div class="col-50">
              <a href="inbox.php" class="buttonxl">Messaging</a>
            </div>
            <div class="col-50">
              <a href="news.php" class="buttonxl">News and Announcements</a>
            </div>
        </div>
        <div class = "row">
            <div class="col-50">
              <a href="bookings.php" class="buttonxl">Amenities Bookings</a>
            </div>
            <div class="col-50">
              <a href="dues.php" class="buttonxl">Dues</a>
            </div>
        </div>

      </div>
      <div class="container">
        <p>Home-X Beta Version | Engineered by LIAN | Powered by AWS</p>
      </div>
    <?php else : ?>

    <p> <strong> <a href="login.php"><b>Log in</b></a> </strong> </p>

    <?php endif  ?>

    </header>
  </body>
</html>
