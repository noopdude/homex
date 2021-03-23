<?php include('server.php') ?>
<!doctype html>
<html>
    <head>
        <title>Login | Home-X</title>
    </head>
    <body>
        <link rel="stylesheet" href="./css/styles.css">
        <?php if(!(isset($_SESSION['username']))) :  ?>
            <div class="container">

                <form action="login.php" method="post">
                  <img src="/img/logo.JPG" alt="logo" style="width:20%">

                  <div class="header">
                      <h1>Home-X Building Management Portal | Log In</h1>

                  </div>

                    <?php include('errors.php') ?>
                    <div class = "row">
                        <div class="col-25">
                          <label for="username">Username:</label>
                        </div>
                        <div class="col-75">
                          <input type="text" name="username" required>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-25">
                            <label for="password">Password:  </label>
                        </div>
                        <div class="col-75">
                          <input type="password" name="password" required>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <button type="submit" style="float: right" class="button" name="login_user"> Log In </button>
                    </div>



                </form>

            </div>
        <?php else : ?>

            <?php header("location:index.php"); ?>

        <?php endif  ?>
        <div class="footer">
          <p>Home-X Beta Version | Engineered by LIAN | Powered by AWS</p>
        </div>
    </body>
</html>
