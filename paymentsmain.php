<?php include "./config/dbinfo.inc" ?>
<?php

    session_start();

    if(isset($_SESSION['username'])){



    }
    else{

    $_SESSION['msg'] = "You must be logged in to view this page";
    header("location:login.php");

    }


?>
<!doctype html>
<html>
    <head>
        <title>Payments | Home-X</title>
    </head>

    <body>
        <link rel="stylesheet" href="./css/styles.css">



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

                <h1>Home-X | Manage Payment Requests | Logged in : <strong><?php echo $_SESSION['username']; ?> </strong> </h1>
            <!--<h3>Welcome <strong><?php echo $_SESSION['username']; ?> </strong> </h3>-->


                <h2>My Payment Requests</h2>
                <form class="statusform" action="paymentsmain.php" method="post">

                  <label for="open">Open</label>
                  <input type="radio" name="status" value="open" required>
                  <label for="closed">Closed</label>
                  <input type="radio" name="status" value="closed">
                  <br>
                  <input type="submit" class="button" name="status_select" value="Search">

                </form>
                <a href="payments.php" class="buttonxl">Place a New Payment Request</a>

                  <?php

                  if(isset($_POST['status_select'])){

                  $status = htmlentities($_POST['status']);

                  $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
                  $username = $_SESSION['username'];
                  $query = "SELECT payment_type, payment_amount,payment_dt, created_dt, status FROM homex.payment_ack WHERE username= '$username' and status = '$status' ORDER BY created_dt DESC";
                  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                  $results = $db->query($query);

                  if ($results->num_rows >0){
                    echo "<table>";
                      echo "<th>Payment Type</th>";
                      echo "<th>Payment Amount</th>";
                      echo "<th>Payment Date</th>";
                      echo "<th>Created Date</th>";
                      echo "<th>Status</th>";
                    while($row = $results->fetch_assoc()){
                      //echo $row["summary"];

                      echo "<tr><td>" . $row["payment_type"] . "</td><td>" .$row["payment_amount"] . "</td><td>" .$row["payment_dt"] . "</td><td>" .$row["created_dt"] ."</td><td>" .$row["status"] ."</td></tr>" ;
                    }
                    echo "</table>";

                  }
                  else{

                  }

                }
                   ?>




              </div>
              <div class="footer">
                <p>Home-X Beta Version | Engineered by LIAN | Powered by AWS</p>
              </div>

        <?php endif ?>

    </body>
</html>
