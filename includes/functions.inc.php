<?php 

function emptyInputRegister($numberOfStudents, $studentNames, $fullName, $email, $userPwd, $pwdRepeat){
  $result = 'true';
  if (empty($studentNames) || empty($numberOfStudents) || empty($fullName) || empty($email) || empty($userPwd)|| empty($pwdRepeat)) {
    $result = true;
  } else {
    if (!preg_match('/^[a-zA-Z\s]+$/', $numberOfStudents) ||!preg_match('/^[a-zA-Z\s]+$/', $studentNames) ||!preg_match('/^[a-zA-Z\s]+$/', $fullName) ||!preg_match('/^[a-zA-Z\s]+$/', $email) ||!preg_match('/^[a-zA-Z\s]+$/', $userPwd) ||!preg_match('/^[a-zA-Z\s]+$/', $pwdRepeat)) {
      $errors['student-name1'] = 'must be letters and space only  ';
    }
    $result = false;
  }
  return $result;
}


function invalidUid($userName){
  $result = 'true';
  // confused think this one over
  if (!preg_match("/^[a-zA-Z0-9\s]*$/", $userName)) {
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

function pwdMatch($userPwd, $pwdRepeat) {
  $result = 'true';
  if ($userPwd !== $pwdRepeat) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function emailExists($conn, $email) {
  $sql = "SELECT * FROM users WHERE userEmail = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: register.php?error=emailinuse");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $email );
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

// not used
function createUser($conn, $fullName, $email, $userPwd) {

  $sql = "INSERT INTO meals (userName, userEmail, userPwd) VALUES (?, ?, ?);";

  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../register.php?error=stmtfailed2");
    exit();
  }

  $hashedPwd = password_hash($userPwd, PASSWORD_DEFAULT);

  mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $hashedPwd);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  header("location: ../index.php?error=none");

}
