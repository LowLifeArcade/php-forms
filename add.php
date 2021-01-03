<?php 

  if(isset($_POST['submit'])){
    echo htmlspecialchars($_POST['email <br />']);
    echo htmlspecialchars($_POST['title <br />']);
    echo htmlspecialchars($_POST['ingredients <br />']);
  }

  if(empty($_POST['email'])){
    echo 'An email is required <br />';
  } else {
    $email = $_POST['email'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      echo 'email must be valid';
    }
  }

  if(empty($_POST['title'])){
    echo 'title required <br />';
  } else {
    $title = $_POST['title'];
    if(!preg_match('/^[a-zA-Z\s]+$', $title)){
      echo 'Title must be letters and space only  <br />';
    }
  }

  if(empty($_POST['ingredients'])){
    echo 'ingredients required <br />';
  } else {
    // $ingredients = $_POST['ingredients'];
    // if(!preg_match('/^[a-zA-Z\s]+$', $ingredients)){
    //   echo 'ingredients must be letters and space only  <br />';
    // }
  }


  // globals are $_
  // if(isset($_GET['submit'])){
  //   echo $_GET['email'];
  //   echo $_GET['title'];
  //   echo $_GET['ingredients'];
  // }
  // // globals are $_

?>

<!DOCTYPE html>
<html lang="en">

  <?php include('templates/header.php'); ?>

    <section class="container grey-text">
      <h4 class="center">Add a Pizza</h4>
      <form action="add.php" class="white" method="POST">
      <label for="">Your Email</label>
      <input type="text" name="email">
      <label for="">Pizzat Title</label>
      <input type="text" name="title">
      <label for="">Ingredients Icomma separated:</label>
      <input type="text" name="ingredients">
      <div class="center">
        <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
      </div>
      </form>
    </section>

  <?php include('templates/footer.php'); ?>


</html>