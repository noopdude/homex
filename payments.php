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
              <form action="payments.php" method="POST">
                <div class = "row">
                    <div class="col-50">
                      <a href="index.php"><img src="/img/logo.JPG" alt="logo" style="width:20%"></a>
                    </div>
                    <div class="col-50">
                      <a href="index.php?logout='1'" class="button">Log Out</a>
                    </div>
                </div>

                <h1>Home-X | Manage Payments Confirmations | Logged in : <strong><?php echo $_SESSION['username']; ?> </strong> </h1>
            <!--<h3>Welcome <strong><?php echo $_SESSION['username']; ?> </strong> </h3>-->

                <h2>Create a Payment Acknowledgement Request</h2>

                <div class = "row">
                    <div class="col-25">
                      <label for="PAYMENT_TYPE">Payment Type:  </label>
                    </div>
                    <div class="col-75">
                      <select name="PAYMENT_TYPE" class="dropdown" id="payment_type" required>
                        <option value="Monthly Maintenance">Monthly Maintenance</option>
                        <option value="Annual Maintenance">Annual Maintenance</option>
                        <option value="Cooking Gas">Cooking Gas</option>
                        <option value="Local Taxes">Local Taxes</option>
                        <option value="Other Payments">Other</option>
                      </select>
                    </div>
                </div>

                <div class = "row">
                    <div class="col-25">
                      <label for="PAYMENT_AMOUNT">Payment Amount:  </label>
                    </div>
                    <div class="col-75">
                      <input type="number" class="textfield" name="PAYMENT_AMOUNT" required>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-25">
                      <label for="PAYMENT_DATE">Payment Date:  </label>
                    </div>
                    <div class="col-75">
                      <input type="date" name="PAYMENT_DATE" required>
                    </div>
                </div>

                <div class = "row">
                    <div class="col-25">
                      <label for="REMARKS">Remarks:  </label>
                    </div>
                    <div class="col-75">
                      <textarea id="remarks" name="REMARKS" placeholder="Provide additional details if any.." style="height:200px"></textarea>
                    </div>
                </div>
                <!--input type="text" name="ISSUE_DESCRIPTION" maxlength="1000" size="60" /-->


                <input type="submit" class="button" name="submit_p" value="Submit" onclick="AddPayments()" />

                </form>
                </div>
                <div class="container">
                  <p>Home-X Beta Version | Engineered by LIAN | Powered by AWS</p>
                </div>
                <?php
                    if(isset($_POST['submit_p'])){
                        /* Connect to MySQL and select the database. */
                        $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

                        /* If input fields are populated, add a row to the SUPPORT_REQUESTS table. */
                        $paymenttype = htmlentities($_POST['PAYMENT_TYPE']);
                        $amount = htmlentities($_POST['PAYMENT_AMOUNT']);
                        $date = htmlentities($_POST['PAYMENT_DATE']);
                        $remarks = htmlentities($_POST['REMARKS']);
                        $username = $_SESSION['username'];


                        if (strlen($paymenttype)  && strlen($amount)) {
                                CreatePayment($db, $paymenttype, $amount, $date, $remarks, $username);
                            }
                    }

                ?>

        <?php endif ?>
    </body>
</html>


<?php

/* Add a Support request/Issue to the table. */
function CreatePayment($db, $paymenttype, $amount, $date, $remarks, $username) {


//   $n = mysqli_real_escape_string($db, $summary);
//   $a = mysqli_real_escape_string($db, $description);
//   $l = mysqli_real_escape_string($db, $username);

$query = "INSERT INTO homex.payment_ack (payment_type, payment_amount,payment_dt,remarks, status,username) VALUES ('$paymenttype', $amount, '$date', '$remarks','open', '$username');";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if(!mysqli_query($db, $query)) {
  echo("<p>Error creating the request.</p>");
}
else{
  echo "<br><br><br><br>";
  echo "<h3>Thank you! Your request has been submitted</h3>";

}

}
?>
