<?php
include('config/db_connect.php');

$name = $email = $special;
$errors = array('email' => '', 'name' => '', 'special' => '');

if (isset($_POST['submit'])) {
  // echo htmlspecialchars($_POST['email <br />']);
  // echo htmlspecialchars($_POST['name <br />']);
  // echo htmlspecialchars($_POST['special <br />']);

  if (empty($_POST['email'])) {
    $errors['email'] = 'An email is required <br />';
  } else {
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'email must be valid';
    }
  }

  if (empty($_POST['name'])) {
    $errors['name'] =  'name required <br />';
  } else {
    $name = $_POST['name'];
    if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
      $errors['name'] = 'name must be letters and space only  ';
    }
  }

  if (empty($_POST['special'])) {
    $errors['special'] = 'special required <br />';
  } else {
    $special = $_POST['special'];
    if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $special)) {
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
    <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
    <div class="red-text"><?php echo $errors['email'] ?></div>

    <label for="">Family Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($name) ?>">
    <div class="red-text"><?php echo $errors['name'] ?></div>

    <label for="">Special Requests (separated by comma:)</label>
    <input type="text" name="special" value="<?php echo htmlspecialchars($special) ?>">
    <div class="red-text"><?php echo $errors['special'] ?></div>


    </br>

    <!-- Prefrences -->
    <label for="">Prefrences
      </br>

      <div>

        <label for="opt1">
          <input id="opt1" type="radio" class="with-gap" name="prefrence" <?php if (isset($prefrence) && $prefrence == "Vegan") echo "checked"; ?> value="Vegan">
          <span>Vegan&nbsp;&nbsp;&nbsp;</span>
        </label>

        <label for="opt2">
          <input id="opt2" type="radio" name="prefrence" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Vegetarian") echo "checked"; ?> value="Vegetarian">
          <span>Vegetarian&nbsp;&nbsp;&nbsp;</span>
        </label>

        <label for="opt3">
          <input id="opt3" type="radio" name="prefrence" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> value="Gluten Free">
          <span>Gluten Free</span>
        </label>
      </div>
    </label>
    <br>

    <!-- pick up time -->
    <div class="input-field col s12">
      <p>
        What time will you be picking up?
        <select name="time">
          <option value="" class = "grey-text" disabled selected></option>
          <option value="1">7-9am</option>
          <option value="2">10-1pm</option>
          <option value="3">2-4pm</option>
        </select>
        <!-- <label>Select</label> -->
      </p>
    </div>

    </br>

    <!-- Week of -->
    Meals Are For Week Of... <input value="" type="text" class="datepicker grey-text">
</br></br>

    <!-- Add Child -->
    <div class="left">
      <label for="add1">
        <input type="button" value="Add Child" class="btn brand z-depth-0">
      </label>
    </div>

    <!-- Submit -->
    <div class="right">
      <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
      <?php session_start();

      $_SESSION['name'] = $_POST['name']; ?>
    </div>
    </br></br>

  </form>
</section>

<?php include('templates/footer.php'); ?>


</html>