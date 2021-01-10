<?php 

function emptyInputRegister($name, $email, $pwd, $pwdRepeat){
  $result = 'true';
  if (empty($name) || empty($email) || empty($pwd)|| empty($pwdRepeat)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}


function invalidUid($name){
  $result = 'true';
  if (!preg_match("/^[a-zA-Z0-9]*$/", $name)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function invalidEmail($email){
  $result = 'true';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
  $result = 'true';
  if ($pwd !== $pwdRepeat) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function emailExists($conn, $email, $name) {
  $sql = "SELECT * FROM meals WHERE userEmail = ? OR userName = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../register.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ss", $name, $email );
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($resultData)) {
    return $row;
  } else {
    $result = false;
    return $result;
  }

  mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $pwd) {
  $sql = "INSERT INTO meals (userName, userEmail, userPwd) VALUES (?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../register.php?error=stmtfailed2");
    exit();
  }

  $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

  mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPwd);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  header("location: ../index.php?error=none");

}
