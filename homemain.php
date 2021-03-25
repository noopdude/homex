<?php include "./config/dbinfo.inc" ?>

<?php
      session_start();
      //$_SESSION['pr_statusvalue'] = "open";
      if (!isset($_GET['pageno'])){
        //echo '<script type="text/javascript">','popup();', '</script>'  ;
        //unset($_SESSION['pr_statusvalue']);
      }
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
          <title>Payment Requests | Home-X</title>
          <link rel="stylesheet" href="./css/styles.css">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
          <script type="text/javascript">
            function popup(){
              alert("page no not set");
            }
            function setstatus(){
                var status = document.getElementById("pr_statusvalue");
                $_SESSION['pr_statusvalue'] = status.value;
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
              <h1>Home-X | Manage Homes | Logged in : <strong><?php echo $_SESSION['username']; ?> </strong> </h1>
              <h2>My Homes</h2>
              <?php if(isset($_SESSION['admin_flag'])) :  ?>
                  <a href="homes.php" class="buttonxl">Create a new Home</a>
              <?php endif  ?>
              <form class="" id="form" action="homemain.php" method="POST">
                    <?php

                          $username =  $_SESSION['username'];

                          if (isset($_GET['pageno'])) {
                              $pageno = $_GET['pageno'];
                          } else {
                              $pageno = 1;
                          }
                          $no_of_records_per_page = 100;
                          $offset = ($pageno-1) * $no_of_records_per_page;

                          $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
                          // Check dbection
                          if (mysqli_connect_errno()){
                              echo "Failed to connect to MySQL: " . mysqli_connect_error();
                              die();
                          }

                          if(isset($_SESSION['admin_flag'])) {
                              $total_pages_sql = "SELECT COUNT(*) FROM homex.homes" ;
                          }
                          else{
                              $total_pages_sql = "SELECT COUNT(*) FROM homex.homes WHERE home_owner_username =  '$username'";
                          }
                          $result = mysqli_query($db,$total_pages_sql);
                          $total_rows = mysqli_fetch_array($result)[0];
                          $total_pages = ceil($total_rows / $no_of_records_per_page);
                          if(isset($_SESSION['admin_flag'])) {
                              $sql = "SELECT * FROM homex.homes ORDER BY home_name ASC LIMIT $offset, $no_of_records_per_page ";
                          }
                          else{
                              $sql = "SELECT * FROM homex.homes WHERE home_owner_username= '$username' ORDER BY home_name ASC LIMIT $offset, $no_of_records_per_page ";
                          }
                          $res_data = mysqli_query($db,$sql);

                          echo "<table>";
                          echo "<th>Home Name</th>";
                          echo "<th>Home Type</th>";
                          echo "<th>Status</th>";
                          echo "<th>Home Owner</th>";
                          echo "<th>Maintenance Dues</th>";
                          echo "<th>Other Dues</th>";
                          while($row = mysqli_fetch_array($res_data)){


                              echo    "
                                           <tr>
                                               <td>".$row['home_name']."</td>
                                               <td>".$row['home_type']."</td>
                                               <td>".$row['status']."</td>
                                               <td>".$row['home_owner_username']."</td>
                                               <td>".$row['maintenance_dues']."</td>
                                               <td>".$row['other_dues']."</td>
                                           </tr>
                                       ";

                          }
                          echo "</table>";
                          mysqli_close($db);

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
