<?php include "./config/dbinfo.inc" ?>
<?php

    session_start();

    if($_SESSION['admin_flag']==1){



    }
    else{

        $_SESSION['msg'] = "You dont have privileges to view this page";
        header("location:index.php");

    }


?>
<!doctype html>
<html>
    <head>
        <title>Manage Homes | Home-X</title>
    </head>

    <body>
        <link rel="stylesheet" href="./css/styles.css">



        <!--if the user logs in print information about him -->

        <?php if($_SESSION['admin_flag']==1 ) :  ?>
            <div class="container">
              <form action="homes.php" method="POST">
                <div class = "row">
                    <div class="col-50">
                      <a href="index.php"><img src="/img/logo.JPG" alt="logo" style="width:20%"></a>
                    </div>
                    <div class="col-50">
                      <a href="index.php?logout='1'" class="button">Log Out</a>
                    </div>
                </div>

                <h1>Home-X | Manage Homes | Logged in : <strong><?php echo $_SESSION['username']; ?> </strong> </h1>
            <!--<h3>Welcome <strong><?php echo $_SESSION['username']; ?> </strong> </h3>-->

                <h2>Create a new Home</h2>

                <div class = "row">
                    <div class="col-25">
                      <label for="home_name">Home Name:  </label>
                    </div>
                    <div class="col-75">
                      <input type="text" name="home_name" maxlength="45" size="30" required>
                    </div>
                </div>

                <div class = "row">
                    <div class="col-25">
                      <label for="home_type">Home Type:  </label>
                    </div>
                    <div class="col-75">
                        <select name="home_type" id="home_type" required>
                        <option value="flat">Flat</option>
                        <option value="villa">Villa</option>
                        </select>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-25">
                      <label for="status">Status:  </label>
                    </div>
                    <div class="col-75">
                        <select name="status" id="status" required>
                        <option value="occupied">Occupied</option>
                        <option value="vaccant">Vaccant</option>
                        </select>
                    </div>
                </div>
                <div class = "row">
                  <div class="col-25">
                    <label for="home_owner_username">Home Owner:  </label>
                  </div>
                  <div class="col-25">

                    <?php

                      $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);;
                      //mysql_select_db('homex');

                      $sql = "SELECT username FROM homex.user where admin_flag is null order by username asc";
                      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                      $result = mysqli_query($db,$sql);

                      echo "<select name='home_owner_username' required>";
                      echo "<option disabled selected value> -- select an option -- </option>";
                      while ($row = mysqli_fetch_array($result)) {
                          echo "<option value='" . $row['username'] . "'>" . $row['username'] . "</option>";
                      }
                      echo "</select>";

                      ?>
                  </div>
                </div>

                <!--input type="text" name="ISSUE_DESCRIPTION" maxlength="1000" size="60" /-->


                <input type="submit" style="margin: 10px"class="button" name="submit_home" value="Submit" />

                </form>
              </div>
              <div class="footer">
                <p>Home-X Beta Version | Engineered by LIAN | Powered by AWS</p>
              </div>
                <?php
                    if(isset($_POST['submit_home'])){
                        /* Connect to MySQL and select the database. */
                        $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

                        /* If input fields are populated, add a row to the SUPPORT_REQUESTS table. */
                        $home_name = htmlentities($_POST['home_name']);
                        $home_type = htmlentities($_POST['home_type']);
                        $status = htmlentities($_POST['status']);
                        $home_owner_username = htmlentities($_POST['home_owner_username']);
                        $username = $_SESSION['username'];


                        if (strlen($home_name) || strlen($home_type)) {
                                CreateHome($db, $home_name, $home_type, $status, $home_owner_username);
                            }
                    }

                ?>

        <?php endif ?>

    </body>
</html>


<?php

/* Add a Support request/Issue to the table. */
function CreateHome($db, $home_name, $home_type, $status, $home_owner_username) {


//   $n = mysqli_real_escape_string($db, $summary);
//   $a = mysqli_real_escape_string($db, $description);
//   $l = mysqli_real_escape_string($db, $username);

$query = "INSERT INTO homex.homes (home_name, home_type,status,home_owner_username) VALUES ('$home_name', '$home_type', '$status', '$home_owner_username');";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if(!mysqli_query($db, $query)) {
  echo("<p>Error creating the Home.</p>");
}
else{
  echo "<br><br><br><br>";
  echo "<h3>Thank you! Home Created Successfully</h3>";

}

}
?>
