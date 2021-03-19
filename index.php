<?php

session_start();

if(isset($_SESSION['username'])){



}
else{

  $_SESSION['msg'] = "You must be logged in to view this page";
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
    <h1>Welcome to Home-X!</h1>

    <?php if(isset($_SESSION['success'])) :   ?>

      <div>
          <h3>
              <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);

               ?>
          </h3>

      </div>


    <?php endif ?>

    <!--if the user logs in print information about him -->

    <?php if(isset($_SESSION['username'])) :  ?>

      <h3>Welcome <strong><?php echo $_SESSION['username']; ?> ! </strong> </h3>


      <a href="servicerequest.php">Service Requests</a><br>
      <a href="payments.php">Payments</a><br>
      <a href="inbox.php">Inbox</a><br>
      <a href="news.php">Announcements, News and Updates</a>
      <br><br><br>
      <strong> <a href="index.php?logout='1'">Log Out</a> </strong>

    <?php else : ?>

    <p> <strong> <a href="login.php"><b>Log in</b></a> </strong> </p>

    <?php endif  ?>

    </header>


  </body>
</html>
