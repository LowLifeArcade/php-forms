<?php 
  include('config/db_connect.php');


  $name = $email = $special;
  $errors = array('email'=>'', 'name'=>'', 'special'=>'');

  if(isset($_POST['submit'])){
    // echo htmlspecialchars($_POST['email <br />']);
    // echo htmlspecialchars($_POST['name <br />']);
    // echo htmlspecialchars($_POST['special <br />']);
    
    if(empty($_POST['email'])){
      $errors['email']='An email is required <br />';
    } else {
      $email = $_POST['email'];
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email']= 'email must be valid';
      }
    }
    
    if(empty($_POST['name'])){
      $errors['name'] =  'name required <br />';
    } else {
      $name = $_POST['name'];
      if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
        $errors['name'] = 'name must be letters and space only  ';
      }
    }
    
    if(empty($_POST['special'])){
      $errors['special'] = 'special required <br />';
    } 
    else {
      $special = $_POST['special'];
      if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $special)){
          $errors['special'] = 'special must be letters and space only';
        }
      }
      
      // check for errors
      if (array_filter($errors)) {
        // echo "errors in form";
      } else {
        // save data to database
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $special = mysqli_real_escape_string($conn, $_POST['special']);

        // create sql
        $sql = "INSERT INTO meals(name,special,email) VALUES('$name','$special','$email')";
        // save to db
        if (mysqli_query($conn, $sql)) {
          
          header('Location: index.php');
        } else {
          echo 'query error: ' . mysqli_error($conn);
        }

        
      }

      // globals are $_
      // if(isset($_GET['submit'])){
        //   echo $_GET['email'];
        //   echo $_GET['name'];
        //   echo $_GET['special'];
        // }
        // // globals are $_
        
  }
?>

<!DOCTYPE html>
<html lang="en">

  <?php include('templates/header.php'); ?>

    <section class="container grey-text">
      <h4 class="center">Pick Up Information</h4>
      <form action="add.php" class="white" method="POST">
      <label for="">Your Email</label>
      <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>" >
      <div class="red-text"><?php echo $errors['email'] ?></div>
      <label for="">Family Name</label>
      <input type="text" name="name" value="<?php echo htmlspecialchars($name) ?>">
      <div class="red-text"><?php echo $errors['name'] ?></div>
      <label for="">Special Requests (separated by comma:)</label>
      <input type="text" name="special" value="<?php echo htmlspecialchars($special) ?>">
      <div class="red-text"><?php echo $errors['special'] ?></div>
      <div class="center">
        <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
        <?php session_start();

          $_SESSION['name'] = $_POST['name']; ?>  
      </div>
      </form>
    </section>

  <?php include('templates/footer.php'); ?>


</html>