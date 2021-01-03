<?php 
  $title = $email = $ingredients;
  $errors = array('email'=>'', 'title'=>'', 'ingredients'=>'');

  if(isset($_POST['submit'])){
    // echo htmlspecialchars($_POST['email <br />']);
    // echo htmlspecialchars($_POST['title <br />']);
    // echo htmlspecialchars($_POST['ingredients <br />']);
    
    if(empty($_POST['email'])){
      $errors['email']='An email is required <br />';
    } else {
      $email = $_POST['email'];
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email']= 'email must be valid';
      }
    }
    
    if(empty($_POST['title'])){
      $errors['title'] =  'title required <br />';
    } else {
      $title = $_POST['title'];
      if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
        $errors['title'] = 'Title must be letters and space only  ';
      }
    }
    
    if(empty($_POST['ingredients'])){
      $errors['ingredients'] = 'ingredients required <br />';
    } 
    else {
      $ingredients = $_POST['ingredients'];
      if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
          $error['ingredients'] = 'ingredients must be letters and space only';
        }
      }
      
      // globals are $_
      // if(isset($_GET['submit'])){
        //   echo $_GET['email'];
        //   echo $_GET['title'];
        //   echo $_GET['ingredients'];
        // }
        // // globals are $_
        
  }
?>

<!DOCTYPE html>
<html lang="en">

  <?php include('templates/header.php'); ?>

    <section class="container grey-text">
      <h4 class="center">Add a Pizza</h4>
      <form action="add.php" class="white" method="POST">
      <label for="">Your Email</label>
      <input type="text" name="email" value="<?php echo $email ?>" >
      <div class="red-text"><?php echo $errors['email'] ?></div>
      <label for="">Pizza Title</label>
      <input type="text" name="title" value="<?php echo $title ?>">
      <div class="red-text"><?php echo $errors['title'] ?></div>
      <label for="">Ingredients comma separated:</label>
      <input type="text" name="ingredients" value="<?php echo $ingredients ?>">
      <div class="red-text"><?php echo $errors['ingredients'] ?></div>
      <div class="center">
        <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
      </div>
      </form>
    </section>

  <?php include('templates/footer.php'); ?>


</html>