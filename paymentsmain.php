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
              <h1>Home-X | Manage Payment Requests | Logged in : <strong><?php echo $_SESSION['username']; ?> </strong> </h1>
              <h2>My Payment Requests</h2>
              <form class="statusform" action="paymentsmain.php" method="POST">
                  <label for="status">Please Choose Status</label>
                  <select name="status" id="pr_statusvalue">
                  <option value="open">Open</option>
                  <option value="closed">Closed</option>
                  </select>
                  <input type="submit" class="button" name="status_select" style="margin: 10px" value="Search" onclick="setstatus()" >
              </form>
              <a href="payments.php" class="buttonxl">Place a New Payment Request</a>
              <form class="" id="form" action="paymentsmain.php" method="POST">
                    <?php
                      if(isset($_POST['status_select']) OR isset($_SESSION['pr_statusvalue'])){

                          if (!isset($_POST['status_select'])){
                                $status = $_SESSION['pr_statusvalue'];
                          }else{
                                $status = htmlentities($_POST['status']);
                                $_SESSION['pr_statusvalue'] = htmlentities($_POST['status']);
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
                              echo "Failed to connect to MySQL: " . mysqli_connect_error();
                              die();
                          }

                          if($_SESSION['admin_flag']==1) {
                              $total_pages_sql = "SELECT COUNT(*) FROM homex.payment_ack WHERE status = '$status'" ;
                          }
                          else{
                              $total_pages_sql = "SELECT COUNT(*) FROM homex.payment_ack WHERE status = '$status' and username =  '$username'";
                          }
                          $result = mysqli_query($db,$total_pages_sql);
                          $total_rows = mysqli_fetch_array($result)[0];
                          $total_pages = ceil($total_rows / $no_of_records_per_page);
                          if($_SESSION['admin_flag']==1) {
                              $sql = "SELECT * FROM homex.payment_ack WHERE status = '$status' ORDER BY created_dt DESC LIMIT $offset, $no_of_records_per_page ";
                          }
                          else{
                              $sql = "SELECT * FROM homex.payment_ack WHERE status = '$status' AND username= '$username' ORDER BY created_dt DESC LIMIT $offset, $no_of_records_per_page ";
                          }
                          $res_data = mysqli_query($db,$sql);

                          echo "<table>";
                          echo "<th>Payment Type</th>";
                          echo "<th>Payment Amount</th>";
                          echo "<th>Payment Date</th>";
                          echo "<th>Created Date</th>";
                          echo "<th>Status</th>";
                          echo "<th>Created By</th>";
                          echo "<th>Remarks</th>";
                          echo "<th>Select</th>";
                          while($row = mysqli_fetch_array($res_data)){


                              echo    "
                                           <tr>
                                               <td>".$row['payment_type']."</td>
                                               <td>".$row['payment_amount']."</td>
                                               <td>".$row['payment_dt']."</td>
                                               <td>".$row['created_dt']."</td>
                                               <td>".$row['status']."</td>
                                               <td>".$row['username']."</td>
                                               <td>".$row['remarks']."</td>
                                               <td><input type=\"checkbox\" name=\"prlist[]\" value=\"" .$row["payment_ack_id"] . "\"></td>
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
                    <input type="text" name="pr_id_list" id="pr_id_list" style="display: none" value="">

                    <?php if($_SESSION['pr_statusvalue'] == "open" ) :  ?>
                      <div class = "row" id="remarksdiv" style="display:none" >
                          <div class="col-25">
                            <label for="remarks">Closure Remarks:  </label>
                          </div>
                          <div class="col-75">
                            <textarea id="desc" name="remarks" placeholder="Please provide closure comments.." style="height:200px"></textarea>
                          </div>
                      </div>
                        <input type="submit" class="button" style="margin: 10px; float: right" name="close_pr" value="Close the Request/s" >
                    <?php else : ?>
                      <div class = "row" id="remarksdiv" style="display:none" >
                          <div class="col-25">
                            <label for="remarks">Re-open Remarks:  </label>
                          </div>
                          <div class="col-75">
                            <textarea id="desc" name="remarks" placeholder="Please provide reopen comments.." style="height:200px"></textarea>
                          </div>
                      </div>
                        <input type="submit" class="button" name="reopen_pr" style="margin: 10px; float: right"1 value="Re-Open the Request/s" >
                    <?php endif ?>
              </form>
          </div>

          <div class="container">
          <p>Home-X Beta Version | Engineered by LIAN | Powered by AWS</p>
          </div>
          <script type="text/javascript">

                document.getElementById('form').addEventListener('click', function (e) {
                    if (e.target.type === 'checkbox') {
                          var element = document.getElementById("pr_id_list");
                          if (e.target.checked == true){
                                document.getElementById("remarksdiv").style.display = "";
                                if (document.getElementById("pr_id_list").value == ""){
                                    document.getElementById("pr_id_list").value =  e.target.id;
                                }
                                else{
                                    document.getElementById("pr_id_list").value = document.getElementById("pr_id_list").value + "," + e.target.id;
                                }
                          }
                          else{
                                if (document.querySelectorAll('input[type="checkbox"]:checked').length < 1){
                                    document.getElementById("remarksdiv").style.display = "none";
                                }
                                document.getElementById("pr_id_list").value = document.getElementById("pr_id_list").value.replace(e.target.id,"");
                          }
                    }
                }
                );

          </script>
          <?php
                if(isset($_POST['close_pr'])){
                      $remarks = htmlentities($_POST['remarks']);
                      $username = $_SESSION['username'];
                      $pr_close_list = $_POST['prlist'];
                      $arrayLength =  count($pr_close_list);

                      if (strlen($remarks) AND $arrayLength > 0 ){
                            ClosePR($db, $pr_close_list, $remarks, $username);
                      }
                }
                if(isset($_POST['reopen_sr'])){
                      $remarks = htmlentities($_POST['remarks']);
                      $username = $_SESSION['username'];
                      $pr_close_list = $_POST['prlist'];
                      $arrayLength =  count($pr_close_list);

                      if (strlen($remarks) AND $arrayLength > 0 ){
                            ReOpenPR($db, $pr_close_list, $remarks, $username);
                      }
                }
            ?>
      </body>
</html>
<?php

function ClosePR($db, $pr_close_list, $remarks, $username) {

        $errors = array();
        $i = 0;
        $arrayLength =  count($pr_close_list);
        $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        while ($i < $arrayLength)
        {
              $query = "UPDATE homex.payment_ack SET status = 'closed', remarks = '$remarks' WHERE payment_ack_id IN('$pr_close_list[$i]')";
              mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
              if(!mysqli_query($db, $query)) {
                  array_push($errors, "Error closing the Ticket: $pr_close_list[$i] ");
              }
              else{
                  //echo "<h3>Thank you! Selected Payment Requests have been closed</h3>";
              }
              $i++;
        }
        if (count($errors) == 0){
              echo "<h3>Thank you! Selected Payment Requests have been closed</h3>";
        }
        else{
              echo "Some records failed to update";
        }
        mysqli_close($db);
}

function ReOpenPR($db, $pr_close_list, $remarks, $username) {
      $errors = array();
      $i = 0;
      $arrayLength =  count($pr_close_list);
      $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
      while ($i < $arrayLength)
      {
            $query = "UPDATE homex.payment_ack SET status = 'open', remarks = '$remarks' WHERE payment_ack_id IN('$pr_close_list[$i]')";
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            if(!mysqli_query($db, $query)) {
                array_push($errors, "Error closing the Ticket: $pr_close_list[$i] ");
            }
            else{
                //echo "<h3>Thank you! Selected Payment Requests have been closed</h3>";
            }
            $i++;
      }
      if (count($errors) == 0){
            echo "<h3>Thank you! Selected Payment Requests have been Re-ppened</h3>";
      }
      else{
            echo "Some records failed to update";
      }
      mysqli_close($db);

}
?>
