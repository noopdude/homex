<?php include('server.php') ?>

<!doctype html>
<html>
    <head>
        <title>Registration | Home-X</title>
    </head>
    <body>
        <link rel="stylesheet" href="./css/styles.css">
        <div class="container">

            <?php if(!(isset($_SESSION['username']))) :  ?>

                <form action="registration.php" method="post">
                  <img src="/img/logo.JPG" alt="logo" style="width:20%">
                  <div class="header">
                      <h1>Home-X Building Management Portal | Sign Up</h1>
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

                    <br>
                    <button type="submit" class="button" name="reg_user"> Submit </button>

                    <p>Already a user? <a href="login.php"><b>Log in</b></a> </p>

                </form>



            <?php else : ?>

                <?php header("location:index.php"); ?>

            <?php endif  ?>


        </div>
        <div class="footer">
          <p>Home-X Beta Version. Powered by AWS</p>
        </div>
    </body>
</html>
