<!doctype html>
<html>
  <head>
    <title>Login</title>
    </head>
  <body>
<div class="container">

    <div class="header">
        <h2>Login</h2>

    </div>

    <form action="login.php" method="post">
      <div>

        <label for="username">Username:  </label>
        <input type="text" name="username" value="">

      </div>

      <div>

        <label for="password">Password:  </label>
        <input type="text" name="password_1" value="">

      </div>


      <button type="submit" name="Submit"> Log In </button>

      <p>Not a user? <a href="registration.php"><b>Register Here</b></a> </p>

    </form>

</div>
  </body>
</html>
