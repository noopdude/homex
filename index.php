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

      <h3>Welcome <strong><?php echo $_SESSION['username']; ?> ! </strong> </h3>

      <div class="categories">
          <h2>Menu</h2>
          <ul>
            <li><a href="servicerequest.php">Service Requests</a></li>
            <li><a href="payments.php">Payments</a></li>
            <li><a href="inbox.php">Inbox</a></li>
            <li><a href="news.php">News and Announcements</a></li>
          </ul>
      </div>

    
      <br><br><br>
      <strong> <a href="index.php?logout='1'">Log Out</a> </strong>

    <?php else : ?>

    <p> <strong> <a href="login.php"><b>Log in</b></a> </strong> </p>

    <?php endif  ?>

    </header>


  </body>
</html>
