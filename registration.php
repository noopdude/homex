<!doctype html>
<html>
  <head>
    <title>Registration</title>
    </head>
  <body>
<div class="container">

    <div class="header">
        <h2>Register</h2>

    </div>

    <form action="registration.php" method="post">
      <div>

        <label for="username">Username:  </label>
        <input type="text" name="username" value="">

      </div>

      <div>

        <label for="email">Email:  </label>
        <input type="text" name="email" value="">

      </div>

      <div>

        <label for="password">Password:  </label>
        <input type="text" name="password_1" value="">

      </div>

      <div>

        <label for="password">Confirm Password:  </label>
        <input type="text" name="password_2" value="">

      </div>

      <button type="submit" name="Submit"> Submit </button>

      <p>Already a user? <a href="login.php"><b>Log in</b></a> </p>

    </form>

</div>
  </body>
</html>
