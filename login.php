<?php
include('config/db_connect.php');

// filter submitsion for errors 

if($_POST['submit']) {

  // required email and password
  
  $sql = 'SELECT userId, userEmail FROM users;';
  
  $stmt = mysqli_stmt_init($conn);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My first PHP file</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <style class="text/css">
    .brand {
      background: #cbb09c !important;
    }

    .brand-text {
      color: #cbb09c !important;
    }

    form {
      max-width: 460px;
      margin: 20px auto;
      padding: 20px;
    }

    ul.dropdown-content.select-dropdown li span {
      color: #cbb09c;
      /* no need for !important :) */
    }
  </style>
</head>

<?php //include('templates/header.php'); ?>


 <br><br><br>

<body class="grey lighten-4">

  <section class="login-form container grey-text border-radius-1">
    <h4 class="center">Log In</h4>
    <form action="includes/login.inc.php" class="white" method="POST">
      <div class="input-group">
        <label for="">Email</label>
        <input type="text" name="email">
      </div>
      <div></div>
      <div class="input-group">
        <label for="">Password</label>
        <input type="password" name="pwd">
      </div>
      <br>
      <div class="input-group">
        <button type="submit" name="submit" class="btn brand z-depth-0">Log In</button>
      </div>
      <p>
        Not yet registered? <a href="register.php">Sign Up</a>
      </p>
    </form>
      
    </form>
  </section>

  <?php include('templates/footer.php'); ?>

</html>