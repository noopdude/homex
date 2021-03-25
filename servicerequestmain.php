<?php include "./config/dbinfo.inc" ?>

<?php
      session_start();
      //$_SESSION['statusvalue'] = "open";
      if (!isset($_GET['pageno'])){
        //echo '<script type="text/javascript">','popup();', '</script>'  ;
        //unset($_SESSION['statusvalue']);
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
          <title>Service Requests | Home-X</title>
          <link rel="stylesheet" href="./css/styles.css">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
          <script type="text/javascript">
            function popup(){
              alert("page no not set");
            }
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
              <form class="" id="form" action="servicerequestmain.php" method="POST">
                    <?php
                      if(isset($_POST['status_select']) OR isset($_SESSION['statusvalue'])){

                          if (!isset($_POST['status_select'])){
                                $status = $_SESSION['statusvalue'];
                          }else{
                                $status = htmlentities($_POST['status']);
                                $_SESSION['statusvalue'] = htmlentities($_POST['status']);
                          }

                          $username =  $_SESSION['username'];

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

                          if($_SESSION['admin_flag']==1) {
                              $total_pages_sql = "SELECT COUNT(*) FROM homex.service_request WHERE status = '$status'" ;
                          }
                          else{
                              $total_pages_sql = "SELECT COUNT(*) FROM homex.service_request WHERE status = '$status' and username =  '$username'";
                          }
                          $result = mysqli_query($db,$total_pages_sql);
                          $total_rows = mysqli_fetch_array($result)[0];
                          $total_pages = ceil($total_rows / $no_of_records_per_page);
                          if($_SESSION['admin_flag']==1) {
                              $sql = "SELECT * FROM homex.service_request WHERE status = '$status' ORDER BY created_dt DESC LIMIT $offset, $no_of_records_per_page ";
                          }
                          else{
                              $sql = "SELECT * FROM homex.service_request WHERE status = '$status' AND username= '$username' ORDER BY created_dt DESC LIMIT $offset, $no_of_records_per_page ";
                          }
                          $res_data = mysqli_query($db,$sql);

                          echo "<table>";
                          echo "<th>Summary</th>";
                          echo "<th>Created Date</th>";
                          echo "<th>Status</th>";
                          echo "<th>Created By</th>";
                          echo "<th>Remarks</th>";
                          echo "<th>Select</th>";
                          while($row = mysqli_fetch_array($res_data)){
                              echo "<tr><td>" . $row["summary"] . "</td><td>" .$row["created_dt"] . "</td><td>" .$row["status"] . "</td><td>" .$row["username"] . "</td><td>" .$row["remarks"] . "</td><td><input type=\"checkbox\" name=\"srlist[]\" value=\"" .$row["sr_id"] . "\"></td> </tr>" ;
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
                    <input type="text" name="sr_id_list" id="sr_id_list" style="display: none" value="">

                    <?php if($_SESSION['statusvalue'] == "open" ) :  ?>
                      <div class = "row" id="remarksdiv" style="display:none" >
                          <div class="col-25">
                            <label for="remarks">Closure Remarks:  </label>
                          </div>
                          <div class="col-75">
                            <textarea id="desc" name="remarks" placeholder="Please provide closure comments.." style="height:200px"></textarea>
                          </div>
                      </div>
                        <input type="submit" class="button" style="margin: 10px" name="close_sr" value="Close the Request/s" >
                    <?php else : ?>
                      <div class = "row" id="remarksdiv" style="display:none" >
                          <div class="col-25">
                            <label for="remarks">Re-open Remarks:  </label>
                          </div>
                          <div class="col-75">
                            <textarea id="desc" name="remarks" placeholder="Please provide reopen comments.." style="height:200px"></textarea>
                          </div>
                      </div>
                        <input type="submit" class="button" name="reopen_sr" value="Re-Open the Request/s" >
                    <?php endif ?>
              </form>
          </div>

          <div class="footer">
          <p>Home-X Beta Version | Engineered by LIAN | Powered by AWS</p>
          </div>
          <script type="text/javascript">

                document.getElementById('form').addEventListener('click', function (e) {
                    if (e.target.type === 'checkbox') {
                          var element = document.getElementById("sr_id_list");
                          if (e.target.checked == true){
                                document.getElementById("remarksdiv").style.display = "";
                                if (document.getElementById("sr_id_list").value == ""){
                                    document.getElementById("sr_id_list").value =  e.target.id;
                                }
                                else{
                                    document.getElementById("sr_id_list").value = document.getElementById("sr_id_list").value + "," + e.target.id;
                                }
                          }
                          else{
                                if (document.querySelectorAll('input[type="checkbox"]:checked').length < 1){
                                    document.getElementById("remarksdiv").style.display = "none";
                                }
                                document.getElementById("sr_id_list").value = document.getElementById("sr_id_list").value.replace(e.target.id,"");
                          }
                    }
                }
                );

          </script>
          <?php
                if(isset($_POST['close_sr'])){
                      $remarks = htmlentities($_POST['remarks']);
                      $username = $_SESSION['username'];
                      $sr_close_list = $_POST['srlist'];
                      $arrayLength =  count($sr_close_list);

                      if (strlen($remarks) AND $arrayLength > 0 ){
                            CloseSR($db, $sr_close_list, $remarks, $username);
                      }
                }
                if(isset($_POST['reopen_sr'])){
                      $remarks = htmlentities($_POST['remarks']);
                      $username = $_SESSION['username'];
                      $sr_close_list = $_POST['srlist'];
                      $arrayLength =  count($sr_close_list);

                      if (strlen($remarks) AND $arrayLength > 0 ){
                            ReOpenSR($db, $sr_close_list, $remarks, $username);
                      }
                }
            ?>
      </body>
</html>
<?php

function CloseSR($db, $sr_close_list, $remarks, $username) {

        $errors = array();
        $i = 0;
        $arrayLength =  count($sr_close_list);
        $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        while ($i < $arrayLength)
        {
              $query = "UPDATE homex.service_request SET status = 'closed', remarks = '$remarks' WHERE sr_id IN('$sr_close_list[$i]')";
              mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
              if(!mysqli_query($db, $query)) {
                  array_push($errors, "Error closing the Ticket: $sr_close_list[$i] ");
              }
              else{
                  //echo "<h3>Thank you! Selected Service requests have been closed</h3>";
              }
              $i++;
        }
        if (count($errors) == 0){
              echo "<h3>Thank you! Selected Service requests have been closed</h3>";
        }
        else{
              echo "Some records failed to update";
        }
        mysqli_close($db);
}

function ReOpenSR($db, $sr_close_list, $remarks, $username) {
      $errors = array();
      $i = 0;
      $arrayLength =  count($sr_close_list);
      $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
      while ($i < $arrayLength)
      {
            $query = "UPDATE homex.service_request SET status = 'open', remarks = '$remarks' WHERE sr_id IN('$sr_close_list[$i]')";
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            if(!mysqli_query($db, $query)) {
                array_push($errors, "Error closing the Ticket: $sr_close_list[$i] ");
            }
            else{
                //echo "<h3>Thank you! Selected Service requests have been closed</h3>";
            }
            $i++;
      }
      if (count($errors) == 0){
            echo "<h3>Thank you! Selected Service requests have been Re-ppened</h3>";
      }
      else{
            echo "Some records failed to update";
      }
      mysqli_close($db);

}
?>
