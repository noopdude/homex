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
        <title>Service Requests | Home-X</title>
    </head>

    <body>
        <link rel="stylesheet" href="./css/styles.css">



        <!--if the user logs in print information about him -->

        <?php if(isset($_SESSION['username'])) :  ?>
            <h1>Home-X | Manage Service Requests | Logged in : <strong><?php echo $_SESSION['username']; ?> </strong> </h1>
            <!--<h3>Welcome <strong><?php echo $_SESSION['username']; ?> </strong> </h3>-->

                <h2>Create a Service Request</h2>
                <form action="servicerequest.php" method="POST">

                <input type="text" name="SUMMARY" maxlength="45" size="30" />

                <input type="text" name="ISSUE_DESCRIPTION" maxlength="1000" size="60" />

                <input type="submit" name="submit_sr" value="Submit" onclick="AddIssue()" />

                </form>
                <?php
                    if(isset($_POST['submit_sr'])){
                        /* Connect to MySQL and select the database. */
                        $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

                        /* If input fields are populated, add a row to the SUPPORT_REQUESTS table. */
                        $summary = htmlentities($_POST['SUMMARY']);
                        $description = htmlentities($_POST['ISSUE_DESCRIPTION']);
                        $username = $_SESSION['username'];


                        if (strlen($summary) || strlen($description)) {
                                CreateSR($db, $summary, $description, $username);
                            }
                    }

                ?>

        <?php endif ?>
          <p> <a href="index.php"><b>Home-X Home</b></a> </p>
    </body>
</html>


<?php

/* Add a Support request/Issue to the table. */
function CreateSR($db, $summary, $description, $username) {


//   $n = mysqli_real_escape_string($db, $summary);
//   $a = mysqli_real_escape_string($db, $description);
//   $l = mysqli_real_escape_string($db, $username);

$query = "INSERT INTO homex.service_request (summary, description,status,username) VALUES ('$summary', '$description', 'open', '$username');";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if(!mysqli_query($db, $query)) {
  echo("<p>Error creating the Ticket.</p>");
}
else{
  echo "<br><br><br><br>";
  echo "<h3>Thank you! Your request has been submitted</h3>";

}

}
?>
