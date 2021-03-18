<?php
session_start();

//initializing variables

$username = "";
$email = "" ;

$errors = array();

// connect to // DEBUG:

$db = mysql_connect('localhost', 'homex', 'homex') or die("could not connect to the database") ;

//Register users

$username = mysqli_real_escape_string($db, $_POST['username']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$email = mysqli_real_escape_string($db, $_POST['password_1']);
$email = mysqli_real_escape_string($db, $_POST['password_2']);

//form validation

if(empty($username)) {array_push($errors, "Username is required")};
if(empty($email)) {array_push($errors, "email is required")};
if(empty($password_1)) {array_push($errors, "Password is required")};
if($password_1 != $password_2) {array_push($errors, "Passwords do not match")};


//check db for existing user with same username or email

$username_check_query = 'SELECT * FROM user WHERE username = '$username' or email = '$email' LIMIT 1  ';

$results = mysql_query();




 ?>
