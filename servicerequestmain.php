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
          <link rel="stylesheet" href="./css/styles.css">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
          <script type="text/javascript">
            function setstatus(){
                var status = document.getElementById("statusvalue");
                $_SESSION['statusvalue'] = status.value;
            }
          </script>
    </head>
    <body>
          <div class="container">
              <div class = "row">
                  <div class="col-50">
                      <a href="index.php"><img src="/img/logo.JPG" alt="logo" style="width:20%"></a>
                  </div>
                  <div class="col-50">
                      <a href="index.php?logout='1'" class="button">Log Out</a>
                  </div>
              </div>
              <h1>Home-X | Manage Service Requests | Logged in : <strong><?php echo $_SESSION['username']; ?> </strong> </h1>
              <h2>My Service Requests</h2>
              <form class="statusform" action="servicerequestmain.php" method="POST">
                  <label for="status">Status</label>
                  <select name="status" id="statusvalue">
                  <option value="open">Open</option>
                  <option value="closed">Closed</option>
                  </select>
                  <input type="submit" class="button" name="status_select" value="Search" onclick="setstatus()" >
              </form>
              <a href="servicerequest.php" class="buttonxl">Place a New Service Request</a>
              <form class="" action="servicerequestmain.php" method="POST">
                    <?php
                          if(isset($_POST['status_select']) OR isset($_SESSION['statusvalue'])){

                              if (!isset($_POST['status_select'])){
                                    $status = $_SESSION['statusvalue'];
                              }else{
                                    $status = htmlentities($_POST['status']);
                                    $_SESSION['statusvalue'] = htmlentities($_POST['status']);
                              }
                          if (isset($_GET['pageno'])) {
                                $pageno = $_GET['pageno'];
                          } else {
                                $pageno = 1;
                          }
                          $no_of_records_per_page = 10;
                          $offset = ($pageno-1) * $no_of_records_per_page;

                          $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
                          // Check dbection
                          if (mysqli_connect_errno()){
                          echo "Failed to dbect to MySQL: " . mysqli_dbect_error();
                          die();
                          }

                          $total_pages_sql = "SELECT COUNT(*) FROM homex.service_request";
                          $result = mysqli_query($db,$total_pages_sql);
                          $total_rows = mysqli_fetch_array($result)[0];
                          $total_pages = ceil($total_rows / $no_of_records_per_page);
                          if(isset($_SESSION['admin_flag'])) {
                          $sql = "SELECT summary, created_dt,status, username FROM homex.service_request WHERE status = '$status' ORDER BY created_dt DESC LIMIT $offset, $no_of_records_per_page ";
                          }
                          else{
                          $sql = "SELECT summary, created_dt,status, username FROM homex.service_request WHERE status = '$status' AND username= '$username' ORDER BY created_dt DESC LIMIT $offset, $no_of_records_per_page ";
                          }
                          $res_data = mysqli_query($db,$sql);

                          echo "<table>";
                          echo "<th>Summary</th>";
                          echo "<th>Created Date</th>";
                          echo "<th>Status</th>";
                          echo "<th>Created By</th>";
                          echo "<th>Select</th>";
                          while($row = mysqli_fetch_array($res_data)){

                          //echo $row["summary"];

                          echo "<tr><td>" . $row["summary"] . "</td><td>" .$row["created_dt"] . "</td><td>" .$row["status"] . "</td><td>" .$row["username"] . "</td><td><input type=\"checkbox\" class=\"chk\" value=\"yes\">". "</td> </tr>" ;
                          }
                          echo "</table>";


                          mysqli_close($db);
                    }
                    ?>
                    <ul class="pagination">
                    <li><a href="?pageno=1">First</a></li>
                    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                    <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                    </li>
                    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                    <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                    </li>
                    <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                    </ul>
              </form>
          </div>

          <div class="footer">
          <p>Home-X Beta Version | Engineered by LIAN | Powered by AWS</p>
          </div>
    </body>
</html>
