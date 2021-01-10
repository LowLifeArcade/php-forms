<?php

if (isset($_POST["submit"])) {

  $name = $_POST["full-name"];
  $email = $_POST["email"];
  // $username = $_POST["uid"];
  $pwd = $_POST["pwd"];
  $pwdRepeat = $_POST["pwdRepeat"];

  require_once 'dbh.inc.php';
  // require_once '/config/db_connect.php';
  require_once 'functions.inc.php';

  if (emptyInputRegister($name, $email, $pwd, $pwdRepeat) !== false) {
    header(("location: ../register.php?error=emptyinput"));
    exit();
  }

  // if (invalidUid($username) !== false) {
  //   header(("location: ../register.php?error=invaliduid"));
  //   exit();
  // }

  if (invalidEmail($email) !== false) {
    header(("location: ../register.php?error=invalidemail"));
    exit();
  }

  if (pwdMatch($pwd, $pwdRepeat) !== false) {
    header(("location: ../register.php?error=passwordsdontmatch"));
    exit();
  }

  if (emailExists($conn, $name, $email) !== false) {
    header(("location: ../register.php?error=usernametaken"));
    exit();
  }

  // 8 character pwd

  createUser($conn, $name, $email, $pwd);

  
} else {
  header(("location: ../register.php"));
}
