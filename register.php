<?php
include('config/db_connect.php');
require_once 'includes/functions.inc.php';


// filter submision for errors 

$numberOfStudents = $studentNames = $fullName = $email = $userPwd = $userCode;
$errors = array('numberOfStudents' => '', 'student-name1' => '', 'student-name2' => '', 'student-name3' => '', 'student-name4' => '', 'student-name5' => '', 'full-name' => '', 'email' => '', 'pwd' => '');

if (isset($_POST['submit'])) {
  $numberOfStudents = $_POST['numberOfStudents'];
  $studentNames = $_POST['student-name1'];
  $fullName = $_POST['full-name'];
  $email = $_POST['email'];
  $userPwd = $_POST['pwd'];
  $pwdRepeat = $_POST['pwdRepeat'];

  // empty inputs check and reg ex
  if (emptyInputRegister($numberOfStudents, $studentNames, $fullName, $email, $userPwd, $pwdRepeat) !== false) {
    header(("location: register.php?error=emptyinput"));
    exit();
  }

  if (invalidEmail($email) !== false) {
    header(("location: register.php?error=invalidemail"));
    exit();
  }

  if (pwdMatch($userPwd, $pwdRepeat) !== false) {
    header(("location: register.php?error=passwordsdontmatch"));
    exit();
  }

  // password param check (min req 8 char, 1 special, 1 cap) then hash password
  if (emailExists($conn, $email) !== false) {
    header(("location: register.php?error=usernametaken"));
    exit();
  }

  // if (empty($_POST['student-name1'])) {
  //   $errors['childname'] =  'student name is required <br />';
  // } else {
  //   $studentNames = $_POST['student-name1'];
  //   if (!preg_match('/^[a-zA-Z\s]+$/', $childname)) {
  //     $errors['student-name1'] = 'name must be letters and space only  ';
  //   }
  // }



  // do query to get dates of meal requests to compare against the post request and to deny them a repeat order for that week

  // empty filters and reg ex string fitlers


  // error check
  if (array_filter($errors)) {
    echo $errors;
  } else {

    // take userName and student names and extract a userCode with algorthim 
    $mr1 = mysqli_real_escape_string($conn, $_POST['student-name1']);
    $mr2 = mysqli_real_escape_string($conn, $_POST['student-name2']);
    $mr3 = mysqli_real_escape_string($conn, $_POST['student-name3']);
    $mr4 = mysqli_real_escape_string($conn, $_POST['student-name4']);
    $mr5 = mysqli_real_escape_string($conn, $_POST['student-name5']);

    // student name string 
    if (isset($_POST['student-name5'])) {

      $studentNames = $mr1 . ',' . $mr2  . ',' . $mr3 . ',' . $mr4 . ',' . $mr5;
    } elseif (isset($_POST['student-name4'])) {

      $studentNames = $mr1 . ',' . $mr2  . ',' . $mr3 . ',' . $mr4;
    } elseif (isset($_POST['student-name3'])) {

      $studentNames = $mr1 .  ',' . $mr2 .  ','  . $mr3;
    } elseif (isset($_POST['student-name2'])) {
      $studentNames = $mr1 . ',' . $mr2;
    } elseif (isset($_POST['student-name1'])) {
      $studentNames = $mr1;
    }

    // dummy data
    $userCode = 'xlr';

    // save data with escape strings
    $numberOfStudents = mysqli_real_escape_string($conn, $_POST['numberOfStudents']);
    $fullName = mysqli_real_escape_string($conn, $_POST['full-name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $userPwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    // $userCode = mysqli_real_escape_string($conn, $userCode);

    $sql = "INSERT INTO users (numberOfStudents,studentNames,userName,userEmail,userPwd,userCode) VALUES (?, ?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header('location: register.php?error=stmtfailed');
      exit();
    }

    $hashedPwd = password_hash($userPwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssss", $numberOfStudents, $studentNames, $fullName, $email, $hashedPwd, $userCode);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    // //  save for later bellow
    //  // save to db
    //  if (mysqli_query($conn, $sql)) {
    //   // this looks for last id made in meals table
    //   $orderId = $conn->insert_id;
    //   header('Location: request.php?id=' . $orderId);
    //   // header('Location: thankyou.php');
    // } else {
    //   echo 'query error: ' . mysqli_error($conn);
    // }


    // need to change this so id isn't a get
    $orderId = $conn->insert_id;
    // send to header with post so it changes the hidden field of user? Can i do that?

    // close connection

    mysqli_close($conn);
    header('Location: request.php?id=' . $orderId);
  }

  // header('Location: index.php');
}



?>

<?php include('templates/extheader.php'); ?>

<br>

<body class="grey lighten-4">
  <section class="register-form container grey-text border-radius-1">
    <h4 class="center">Meal Registration</h4>
    <form action="register.php" class="white" method="POST">
      <!-- <form action="includes/register.inc.php" class="white" method="POST"> -->


      <label class="select" for="">Number of Children Being Registered For Weekly Meal Service<br>(18 and under only)</label>
      <div class="input-field col s12 select">
        <select name="numberOfStudents">
          <option value="" disabled selected></option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </div>
      <div class="outputArea"></div>

      <!-- <div class="input-group">
        <label for="">Students Name and school they attend. If not in school specify age</label>
        <input type="text" name="student-name"> -->


      </div>
      <div class="input-group">
        <label for="">Parent's Full Name</label>
        <input type="text" name="full-name">
      </div>
      <div class="input-group">
        <label for="">Parent's Email</label>
        <input type="text" name="email">
      </div>
      <div></div>
      <div class="input-group">
        <label for="">Password</label>
        <input type="password" name="pwd">
      </div>
      <div class="input-group">
        <label for="">Confirm Password</label>
        <input type="password" name="pwdRepeat">
      </div>
      <br>
      <div class="input-group">
        <button type="submit" name="submit" class="btn z-depth-0">Register</button>
      </div>
      <p>
        Already registered? <a href="login.php">Log In</a>
      </p>
    </form>

    </form>
  </section>

  <?php include('templates/footer.php'); ?>
  <!-- Compiled and minified JavaScript -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

  <script>
    $(document).ready(function() {

      $('select').formSelect().css("color", "#010101");
      $("select").change(function() {
        var htmlString = "";
        var len = $("select").val();
        console.log(len)
        $num = 1
        for (var i = 0; i < len; i++) {
          htmlString += `<div class='input-group'><label for=''>Students Name and school they attend. If not in school specify age.</label><input type='text' name='student-name${$num}'>`
          $num++
        }
        $(document.querySelector('.outputArea')).append(htmlString);
        // hide select box somehow after chossing 
        console.log(htmlString)
        $(".select").css({
          display: "none"
        });
      });


      // let order = 1
      // let allowedMeals = parseInt(document.getElementById("allowed").value) + 1
      // $("#add").on('click', function(e) {
      //   if (order < allowedMeals) {
      //     $(`.order${order}`).css({
      //       display: "block"
      //     });
      //     order++
      //   }
      //   e.preventDefault();
      //   console.log(allowedMeals)

      // });

    });
  </script>


  </html>