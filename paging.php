<html>
<head>
    <title>Pagination</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
      <form action="paging.php" method="POST">


    <?php

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;

        $conn=mysqli_connect("localhost","homex","Welcome2LIAN","homex");
        // Check connection
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $total_pages_sql = "SELECT COUNT(*) FROM homex.service_request";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT * FROM homex.service_request ORDER BY created_dt desc LIMIT $offset, $no_of_records_per_page ";
        $res_data = mysqli_query($conn,$sql);

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


        mysqli_close($conn);
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
</body>
</html>
