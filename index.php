<?php

session_start();

if(isset($_SESSION['username'])){



}
else{

  $_SESSION['msg'] = "You must be logged in to view this page";
  header("location : login.php");

}

if(isset($_GET['logout'])){

  session_destroy();
  unset($_SESSION['username']);
  header("location : login.php");

}

?>
<!doctype html>
<html>
  <head>
    <title>Home-X Home Page</title>
  </head>

  <body>

    <h1>Welcome to Home-X home page</h1>

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

      <h3>Welcome <strong><?php echo $_SESSION['username']; ?> </strong> </h3>

      <h1>Hello </h1>
      <a href="service_request.php">Raise a Support Request</a>
      <a href="payments.php">Make a Payment Request</a>
      <a href="inbox.php">View your Reminders and take actions</a>
      <a href="news.php">View announcements, news and updates</a>
      <br><br><br>
      <a href="index.php?logout='1'">Log Out</a>

    <?php else : ?>

    <p> <a href="login.php"><b>Log in</b></a> </p>

    <?php endif  ?>

    </header>


  </body>
</html>
