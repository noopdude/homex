<?php include('server.php') ?>

<!doctype html>
<html>
    <head>
        <title>User Account Management | Home-X</title>
    </head>
    <body>
        <link rel="stylesheet" href="./css/styles.css">
        <div class="container">
            <a href="index.php"><img src="/img/logo.JPG" alt="logo" style="width:20%"></a>
            <?php if(isset($_SESSION['admin_flag']) ) :  ?>

                <form action="registration.php" method="post">

                  <div class="header">
                      <h1>Home-X Building Management Portal | Create User Account</h1>
                  </div>

                    <?php include('errors.php') ?>

                    <div class = "row">
                        <div class="col-25">
                          <label for="username">Username:  </label>
                        </div>
                        <div class="col-75">
                          <input type="text" class="textfield" name="username" required>
                        </div>
                    </div>

                    <br>
                    <div class = "row">
                        <div class="col-25">
                          <label for="email">Email:  </label>
                        </div>
                        <div class="col-75">
                          <input type="text" class="textfield" name="email" required>
                        </div>
                    </div>

                    <br>
                    <div class = "row">
                        <div class="col-25">
                          <label for="password">Password:  </label>
                        </div>
                        <div class="col-75">
                          <input type="password" class="textfield" name="password_1" required>
                        </div>
                    </div>

                    <br>
                    <div class = "row">
                        <div class="col-25">
                          <label for="password">Confirm Password:  </label>
                        </div>
                        <div class="col-75">
                          <input type="password" class="textfield" name="password_2" required>
                        </div>
                    </div>
                    <div class = "row">
                      <div class="col-25">
                        <label for="apartmentno">Apartment/House No:  </label>
                      </div>
                      <div class="col-25">

                        <?php

                          $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);;
                          //mysql_select_db('homex');

                          $sql = "SELECT home_name FROM homex.homes order by home_name asc";
                          mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                          $result = mysqli_query($db,$sql);

                          echo "<select name='home_name'>";
                          while ($row = mysqli_fetch_array($result)) {
                              echo "<option value='" . $row['home_name'] . "'>" . $row['home_name'] . "</option>";
                          }
                          echo "</select>";

                          ?>
                      </div>
                    </div>


                    <br>
                    <button type="submit" class="button" name="reg_user"> Submit </button>


                </form>



            <?php else : ?>

                <?php header("location:index.php"); ?>

            <?php endif  ?>


        </div>
        <div class="footer">
          <p>Home-X Beta Version | Engineered by LIAN | Powered by AWS</p>
        </div>        
    </body>
</html>
