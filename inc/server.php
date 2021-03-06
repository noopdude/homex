<?php include "../config/dbinfo.inc" ?>
<?php
      session_start();

      //initializing variables

      $username = "";
      $email = "" ;

      $errors = array();

      // connect to // DEBUG:
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

      //$db = mysqli_connect('localhost', 'homex', 'Welcome2LIAN') or die("could not connect to the database") ;

      //Register users

      if(isset($_POST['reg_user'])){

            $username = mysqli_real_escape_string($db, $_POST['username']);
            $email = mysqli_real_escape_string($db, $_POST['email']);
            $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
            $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
            if(isset($_POST['home_name']) ){
              $home_name = mysqli_real_escape_string($db, $_POST['home_name']);
            }
            else {
              $home_name = NULL;
            }
            //form validation

            if(empty($username)) {array_push($errors, "Username is required");}
            if(empty($email)) {array_push($errors, "Email is required");}
            if(empty($password_1)) {array_push($errors, "Password is required");}
            if($password_1 != $password_2) {array_push($errors, "Passwords do not match");}


            //check db for existing user with same username or email

            $username_check_query = "SELECT * FROM homex.user WHERE username = '$username' or email = '$email' LIMIT 1  ";
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $results = mysqli_query($db, $username_check_query);
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $user = mysqli_fetch_assoc($results);

            if ($user ){
                if ($user['username'] == $username ){array_push($errors, "Username already taken");}
                if ($user['email'] == $email ){array_push($errors, "Email ID already registered");}

            }

            // Register the user if no errors

            if (count($errors) == 0){
                  $password = md5($password_1); // encrpt the password
                  $query = "INSERT INTO homex.user (username,email,password,status) VALUES ('$username', '$email', '$password', 'Active') ";
                  mysqli_query($db, $query);
                  $query = "UPDATE homex.homes set home_owner_username = '$username' where home_name = '$home_name' ";
                  mysqli_query($db, $query);
                  //$_SESSION['username'] = $username;
                  $_SESSION['success'] = "User Created Successfully";

                  //header('location: index.php');
            }

      }

      // Login user

      if(isset($_POST['login_user'])){

            $username = mysqli_real_escape_string($db, $_POST['username']);
            $password = mysqli_real_escape_string($db, $_POST['password']);

            if(empty($username)){
                array_push($errors, "Username is required");
            }

            if(empty($password)){
                array_push($errors, "Password is required");
            }

            if(count($errors) ==0 ){

                  $password = md5($password);
                  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

                  $query = "SELECT * FROM homex.user WHERE username = '$username' AND password = '$password' and status='Active'";
                  $results = mysqli_query($db, $query);

                  if(mysqli_num_rows($results)){

                      $_SESSION['username'] = $username;
                      $_SESSION['success'] = 'Logged in Successfully!';
                      while($row = $results->fetch_assoc()){
                          $admin_flag = $row["admin_flag"];
                          break;
                      }
                      //echo "Admin flag is $admin_flag";
                      $_SESSION['admin_flag'] = $admin_flag;
                      if($admin_flag == '1'){
                          $_SESSION['success'] = 'Admin Logged in Successfully!';
                          header('location: indexadmin.php');
                      }
                      else{
                          header('location: index.php');
                      }

                  }else{
                      array_push($errors, "Invalid User ID or Password");
                  }
            }
      }


?>
