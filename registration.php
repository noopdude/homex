<?php include('server.php') ?>

<!doctype html>
<html>
    <head>
        <title>Registration | Home-X</title>
    </head>
    <body>
        <link rel="stylesheet" href="./css/styles.css">
        <div class="container">

            <div class="header">
                <h2>Home-X | Register yourself</h2>
            </div>

            <?php if(!(isset($_SESSION['username']))) :  ?>

                <form action="registration.php" method="post">

                    <?php include('errors.php') ?>

                    <div>

                        <label for="username">Username:  </label>
                        <input type="text" name="username" required>

                    </div>

                    <div>

                        <label for="email">Email:  </label>
                        <input type="text" name="email" required>

                    </div>

                    <div>

                        <label for="password">Password:  </label>
                        <input type="password" name="password_1" required>

                    </div>

                    <div>

                        <label for="password">Confirm Password:  </label>
                        <input type="password" name="password_2" required>

                    </div>

                    <button type="submit" name="reg_user"> Submit </button>

                    <p>Already a user? <a href="login.php"><b>Log in</b></a> </p>

                </form>


            <?php else : ?>

                <?php header("location:index.php"); ?>

            <?php endif  ?>


        </div>
    </body>
</html>
