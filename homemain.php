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
          <script src="/js/homex.js"></script>
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
              <?php if($_SESSION['admin_flag'] ==1) :  ?>
                  <a href="homes.php" class="buttonxl">Create a new Home</a>
              <?php endif  ?>
              <form class="" name="homeform" id="form" action="homemain.php" method="POST">
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

                          if($_SESSION['admin_flag']==1) {
                              $total_pages_sql = "SELECT COUNT(*) FROM homex.homes" ;
                          }
                          else{
                              $total_pages_sql = "SELECT COUNT(*) FROM homex.homes WHERE home_owner_username =  '$username'";
                          }
                          $result = mysqli_query($db,$total_pages_sql);
                          $total_rows = mysqli_fetch_array($result)[0];
                          $total_pages = ceil($total_rows / $no_of_records_per_page);
                          if($_SESSION['admin_flag']==1) {
                              $sql = "SELECT * FROM homex.homes ORDER BY home_name ASC LIMIT $offset, $no_of_records_per_page ";
                          }
                          else{
                              $sql = "SELECT * FROM homex.homes WHERE home_owner_username= '$username' ORDER BY home_name ASC LIMIT $offset, $no_of_records_per_page ";
                          }
                          $res_data = mysqli_query($db,$sql);

                          echo "<table id=\"hometable\">";
                          echo "<th>Home Name</th>";
                          echo "<th>Home Type</th>";
                          echo "<th>Status</th>";
                          echo "<th>Home Owner</th>";
                          echo "<th>Maintenance Dues</th>";
                          echo "<th>Other Dues</th>";
                          while($row = mysqli_fetch_array($res_data)){
                            if($_SESSION['admin_flag']==1 ){

                                echo    "
                                             <tr>
                                                 <td> <input type=\"text\" name=\"home_name[]\" value=\"" .$row['home_name']. "\"></td>
                                                 <td>".$row['home_type']."</td>
                                                 <td> <input type=\"text\" name=\"home_status[]\" value=\"" .$row['status']. "\"></td>
                                                 <td> <input type=\"text\" name=\"home_owner_username[]\" value=\"" .$row['home_owner_username']. "\"></td>
                                                 <td> <input type=\"number\" name=\"maintenance_dues[]\" value=\"" .$row['maintenance_dues']. "\"></td>
                                                 <td> <input type=\"number\" name=\"other_dues[]\" value=\"" .$row['other_dues']. "\"></td>
                                             </tr>
                                         ";

                            }
                            else{
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
                    <?php if($_SESSION['admin_flag']==1) :  ?>
                        <input type="submit" class="button" style="float: right; margin-top: 10px" name="update_home" value="Update" >
                    <?php endif  ?>
              </form>
          </div>

          <div class="container">
          <p>Home-X Beta Version | Engineered by LIAN | Powered by AWS</p>
          </div>
          <?php
                if(isset($_POST['update_home'])){
                          $home_name = $_POST['home_name'];
                          $home_status = $_POST['home_status'];
                          $home_owner_username = $_POST['home_owner_username'];
                          $maintenance_dues = $_POST['maintenance_dues'];
                          $other_dues = $_POST['other_dues'];
                          $username = $_SESSION['username'];
                          $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

                          $arrayLength =  count($home_owner_username);

                          if ( $arrayLength > 0 ){
                                UpdateHome($db,$home_name, $home_status, $home_owner_username, $maintenance_dues, $other_dues, $username );
                          }
                          echo "<script> location.replace(\"homemain.php\"); </script>";

                }
          ?>
      </body>
</html>
<?php
function UpdateHome($db, $home_name, $home_status,  $home_owner_username,$maintenance_dues,$other_dues,$username ) {

        $errors = array();
        $i = 0;
        $arrayLength =  count($home_status);
        $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        while ($i < $arrayLength)
        {

              if (empty(trim($maintenance_dues[$i]))){$maintenance_dues[$i] = 0;}
              if (empty(trim($other_dues[$i]))){$other_dues[$i] = 0;}

              $query = "UPDATE homex.homes SET status = '$home_status[$i]', home_owner_username = '$home_owner_username[$i]' , maintenance_dues = $maintenance_dues[$i] , other_dues = $other_dues[$i] WHERE home_name = '$home_name[$i]' ";
              //echo $query;
              mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
              if(!mysqli_query($db, $query)) {
                  array_push($errors, "Error updating Home: $home_name[$i] ");
              }
              else{
                  //echo "<h3>Thank you! Selected Payment Requests have been closed</h3>";
              }
              $i++;
        }
        if (count($errors) == 0){
              echo "<h3>Thank you! Changes have been applied</h3>";
        }
        else{
              echo "Some records failed to update";
        }
        mysqli_close($db);
}
function UpdateDues($db, $home_name, $maintenance_dues,$other_dues,$username ) {

        $errors = array();
        $i = 0;
        $arrayLength =  count($home_name);
        $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        while ($i < $arrayLength)
        {

              if (empty(trim($maintenance_dues[$i]))){$maintenance_dues[$i] = 0;}
              if (empty(trim($other_dues[$i]))){$other_dues[$i] = 0;}

              $query = "UPDATE homex.homes SET  maintenance_dues = $maintenance_dues[$i] , other_dues = $other_dues[$i] WHERE home_name = '$home_name[$i]' ";
              //echo $query;
              mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
              if(!mysqli_query($db, $query)) {
                  array_push($errors, "Error updating Home: $home_name[$i] ");
              }
              else{
                  //echo "<h3>Thank you! Selected Payment Requests have been closed</h3>";
              }
              $i++;
        }
        if (count($errors) == 0){
              echo "<h3>Thank you! Changes have been applied</h3>";
        }
        else{
              echo "Some records failed to update";
        }
        mysqli_close($db);
}
 ?>
