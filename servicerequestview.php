<?php include "./config/dbinfo.inc" ?>
<?php
    session_start();
    if(isset($_SESSION['username'])){

    }
    else{

    $_SESSION['msg'] = "You must be logged in to view this page";
    header("location:login.php");

    }
    if (isset($_GET['id'])){

    }
    else{
        //header("location:servicerequestmain.php");
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
            <div class="container">
              <form action="servicerequestview.php" method="POST">
                <div class = "row">
                    <div class="col-50">
                      <a href="index.php"><img src="/img/logo.JPG" alt="logo" style="width:20%"></a>
                    </div>
                    <div class="col-50">
                      <a href="index.php?logout='1'" class="button">Log Out</a>
                    </div>
                </div>

                <h1>Home-X | View Service Request | Logged in : <strong><?php echo $_SESSION['username']; ?> </strong> </h1>
            <!--<h3>Welcome <strong><?php echo $_SESSION['username']; ?> </strong> </h3>-->

                <h2>View Service Request</h2>
                <?php
                      if (isset($_GET['id'])){
                      $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
                      // Check dbection
                      if (mysqli_connect_errno()){
                          echo "Failed to connect to MySQL: " . mysqli_connect_error();
                          die();
                      }
                      $sr_id = $_GET['id'];
                      //echo $sr_id;
                      if ($_SESSION['admin_flag'] == 1)
                      {
                      $query = "SELECT * FROM homex.service_request WHERE sr_id = $sr_id";
                    }
                    else{
                      $username = $_SESSION['username'];
                      $query = "SELECT * FROM homex.service_request WHERE sr_id = $sr_id and username = '$username'";
                    }

                      $result = mysqli_query($db,$query);
                      $_SESSION['sr_view_id'] = $sr_id;

                      while($row = mysqli_fetch_array($result)){
                          $_SESSION['sr_view_status'] = $row['status'];


                          echo    "
                                    <div class = \"row\">
                                        <div class=\"col-25\">
                                          <label for=\"summary\">Summary:  </label>
                                        </div>
                                        <div class=\"col-75\">
                                          <input type=\"text\" value=\"" . $row['summary']. "\"name=\"summary\" maxlength=\"45\" size=\"30\" />
                                        </div>
                                    </div>

                                    <div class = \"row\">
                                        <div class=\"col-25\">
                                          <label for=\"issue_description\">Description:  </label>
                                        </div>
                                        <div class=\"col-75\">
                                          <textarea id=\"desc\" name=\"description\"  style=\"height:200px\">" . $row['description']. "</textarea>
                                        </div>
                                        <div class = \"row\">
                                            <div class=\"col-25\">
                                              <label for=\"created_date\">Created Date:  </label>
                                            </div>
                                            <div class=\"col-75\">
                                              <p>" . $row['created_dt'] ."</p>
                                            </div>
                                        </div>
                                        <div class = \"row\">
                                            <div class=\"col-25\">
                                              <label for=\"status\">Status:  </label>
                                            </div>
                                            <div class=\"col-75\">
                                              <p>" .$row['status']. "</p>
                                            </div>
                                        </div>
                                        <div class = \"row\">
                                            <div class=\"col-25\">
                                              <label for=\"remarks\">Remarks:  </label>
                                            </div>
                                            <div class=\"col-75\">
                                              <p>" .$row['remarks']. "</p>
                                            </div>
                                        </div>
                                    </div>
                                   ";

                      }

                      mysqli_close($db);

                if($_SESSION['sr_view_status'] == "open" ){
                echo "<input type=\"submit\" class=\"button\" name=\"submit_sr\" value=\"Update\" />";
              }
            }
                ?>
                </form>
              </div>
              <div class="footer">
                <p>Home-X Beta Version | Engineered by LIAN | Powered by AWS</p>
              </div>
                <?php
                    if(isset($_POST['submit_sr'])){
                        /* Connect to MySQL and select the database. */
                        $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

                        /* If input fields are populated, add a row to the SUPPORT_REQUESTS table. */
                        $summary = htmlentities($_POST['summary']);
                        $description = htmlentities($_POST['description']);
                        $username = $_SESSION['username'];


                        if (strlen($summary) || strlen($description)) {
                                UpdateSR($db, $summary, $description, $username);
                            }
                        //header("location:servicerequestview.php?id=$_SESSION['sr_view_id']");
                    }

                ?>

        <?php endif ?>

    </body>
</html>


<?php

/* Add a Support request/Issue to the table. */
function UpdateSR($db, $summary, $description, $username) {


//   $n = mysqli_real_escape_string($db, $summary);
//   $a = mysqli_real_escape_string($db, $description);
//   $l = mysqli_real_escape_string($db, $username);
$sr_id = $_SESSION['sr_view_id'];
//echo $sr_id;
$query = "UPDATE homex.service_request SET summary='$summary', description='$description' WHERE sr_id = $sr_id";
//echo $query;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if(!mysqli_query($db, $query)) {
  echo("<p>Error updating the Ticket.</p>");
}
else{
  echo "<br><br><br><br>";
  echo "<h3>Thank you! Your request has been updated</h3>";

}

}
?>
