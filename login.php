<?php include('server.php') ?>
<!doctype html>
<html>
    <head>
        <title>Login | Home-X</title>
    </head>
    <body>
        <link rel="stylesheet" href="./css/styles.css">
        <?php if(!(isset($_SESSION['username']))) :  ?>
            <div class="login">

                <img src="./img/logo.jpg" alt="logo" style="width:20%">

                <div class="header">
                    <h1>Home-X | Log In</h1>

                </div>

                <form action="login.php" method="post">

                    <?php include('errors.php') ?>
                    <div>

                        <label for="username">Username:  </label>
                        <input type="text" name="username" required>

                    </div>
                    <br>
                    <div>

                        <label for="password">Password:  </label>
                        <input type="password" name="password" required>

                    </div>
                    <br>
                    <button type="submit" class="button" name="login_user"> Log In </button>

                    <p>Not a user? <a href="registration.php"><b>Register Here</b></a> </p>

                </form>

            </div>
        <?php else : ?>

            <?php header("location:index.php"); ?>

        <?php endif  ?>
    </body>
</html>
