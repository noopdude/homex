<?php include "./config/dbinfo.inc" ?>

<?php
      session_start();
      //$_SESSION['user_statusvalue'] = "open";
      if (!isset($_GET['pageno'])){
        //echo '<script type="text/javascript">','popup();', '</script>'  ;
        //unset($_SESSION['user_statusvalue']);
      }
      if(isset($_SESSION['username']) AND $_SESSION['admin_flag'] == 1) {

      }
      else{
            $_SESSION['msg'] = "You must be logged in to view this page";
            header("location:login.php");
      }
?>
<!doctype html>
<html>
    <head>
          <title>User Account Management | Home-X</title>
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
                var status = document.getElementById("user_statusvalue");
                $_SESSION['user_statusvalue'] = status.value;
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
              <h1>Home-X | Manage Users | Logged in : <strong><?php echo $_SESSION['username']; ?> </strong> </h1>
              <h2>My Homes</h2>
              <form class="statusform" action="usermain.php" method="POST">
                  <label for="status">Please Choose Status</label>
                  <select name="status" id="user_statusvalue">
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                  </select>
                  <input type="submit" class="button" name="user_status_select" style="margin: 10px" value="Search" onclick="setstatus()" >
              </form>
              <?php if($_SESSION['admin_flag']==1) :  ?>
                  <a href="registration.php" class="buttonxl">Create a new User</a>
              <?php endif  ?>
              <form class="" name="userform" id="form" action="usermain.php" method="POST">
                    <?php
                      if(isset($_POST['user_status_select']) OR isset($_SESSION['user_statusvalue'])){

                        if (!isset($_POST['user_status_select'])){
                              $status = $_SESSION['user_statusvalue'];
                        }else{
                              $status = htmlentities($_POST['status']);
                              $_SESSION['user_statusvalue'] = htmlentities($_POST['status']);
                        }
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

                          $total_pages_sql = "SELECT COUNT(*) FROM homex.user WHERE status = '$status'" ;

                          $result = mysqli_query($db,$total_pages_sql);
                          $total_rows = mysqli_fetch_array($result)[0];
                          $total_pages = ceil($total_rows / $no_of_records_per_page);

                          $sql = "SELECT * FROM homex.user WHERE status = '$status' ORDER BY username ASC LIMIT $offset, $no_of_records_per_page ";

                          $res_data = mysqli_query($db,$sql);

                          echo "<table id=\"usertable\">";
                          echo "<th>User Name</th>";
                          echo "<th>Email</th>";
                          echo "<th>Admin Flag</th>";
                          echo "<th>Status</th>";


                          while($row = mysqli_fetch_array($res_data)){


                              echo    "
                                           <tr>
                                               <td> <input type=\"text\" name=\"usernamelist[]\" value=\"" .$row['username']. "\"></td>
                                               <td> <input type=\"text\" name=\"email[]\" value=\"" .$row['email']. "\"></td>
                                               <td> <input type=\"number\" name=\"admin_flag[]\" value=\"" .$row['admin_flag']. "\"></td>
                                               <td> <input type=\"text\" name=\"status[]\" value=\"" .$row['status']. "\"></td>
                                           </tr>
                                       ";

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

                    <input type="submit" class="button" style="float: right; margin-top: 10px" name="update_user" value="Update" >
              </form>
          </div>

          <div class="footer">
          <p>Home-X Beta Version | Engineered by LIAN | Powered by AWS</p>
          </div>
          <?php
                if(isset($_POST['update_user'])){
                      $usernamelist = $_POST['usernamelist'];
                      $status = $_POST['status'];
                      $email = $_POST['email'];
                      $admin_flag_list = $_POST['admin_flag'];

                      $username = $_SESSION['username'];
                      $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

                      $arrayLength =  count($email);

                      if ( $arrayLength > 0 ){
                            UpdateUser($db,$usernamelist, $status, $email, $admin_flag_list, $username );
                      }
                      echo "<script> location.replace(\"usermain.php\"); </script>";
                }

          ?>
      </body>
</html>
<?php
function UpdateUser($db,$usernamelist, $status, $email, $admin_flag_list, $username ) {

        $errors = array();
        $i = 0;
        $arrayLength =  count($status);
        $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        while ($i < $arrayLength)
        {
            //echo $usernamelist[$i];
              if (empty(trim($admin_flag_list[$i]))){$admin_flag_list[$i] = 0;}

              $query = "UPDATE homex.user SET status = '$status[$i]', email = '$email[$i]' ,admin_flag = $admin_flag_list[$i] WHERE username = '$usernamelist[$i]' ";
              //echo $query;
              mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
              if(!mysqli_query($db, $query)) {
                  array_push($errors, "Error updating user: $username[$i] ");
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
