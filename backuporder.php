<?php
include('config/db_connect.php');

$childname = $email = $pickuptime;
$errors = array('email' => '', 'pickuptime' => '', 'childName' => '');

// Filters and then post
if (isset($_POST['submit'])) {

  if (empty($_POST['pickuptime'])) {
    $errors['pickuptime'] = 'Pick up time is required <br />';
  } else {
    $email = $_POST['pickuptime'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['pickuptime'] = 'pick up time must be valid';
    }
  }
  // if (empty($_POST['email'])) {
  //   $errors['email'] = 'email is required <br />';
  // } else {
  //   $email = $_POST['email'];
  //   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  //     $errors['email'] = 'email must be valid';
  //   }
  // }

  if (empty($_POST['childname'])) {
    $errors['childname'] =  'family name is required <br />';
  } else {
    $childname = $_POST['childname'];
    if (!preg_match('/^[a-zA-Z\s]+$/', $childname)) {
      $errors['childname'] = 'family name must be letters and space only  ';
    }
  }

  if (empty($_POST['childName'])) {
    $errors['childName'] = "child's name is required <br />";
  } else {
    $childName = $_POST['childName'];
    if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $childName)) {
      $errors['childName'] = "child's name must be letters and space only";
    }
  }

  // check for errors
  if (array_filter($errors)) {
    // echo "errors in form";
    echo "error";
  } else {

    // save data to database
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $childname = mysqli_real_escape_string($conn, $_POST['childname']);
    $childName = mysqli_real_escape_string($conn, $_POST['childName']);

    // create sql
    $sql = "INSERT INTO meals(name,childName,email) VALUES('$childname','$pickutime','$email')";
    // save to db
    if (mysqli_query($conn, $sql)) {

      header('Location: index.php');
    } else {
      echo 'query error: ' . mysqli_error($conn);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>



<section class="container grey-text">
  <h4 class="center">Pick Up Order</h4>
  <form action="add.php" class="white" method="POST">

    <!-- <label for="">Your Email</label>
    <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
    <div class="red-text"><?php echo $errors['email'] ?></div>

    <label for="">Family Name</label>
    <input type="text" name="name" autocomplete="family-name" value="<?php echo htmlspecialchars($childname) ?>">
    <div class="red-text"><?php echo $errors['name'] ?></div> -->

    <label for="">Children's Names (serprated by commas)</label>
    <input type="text" name="childName" value="<?php echo htmlspecialchars($childName) ?>">
    <div class="red-text"><?php echo $errors['childName'] ?></div>

    <!-- School attending -->
    <label for="">What school does the child attend? If not in school, specify age.</label>

    <div class="input-field col s12">
      <select name="school">
        <option value="" class="grey-text" disabled selected></option>
        <option value="1">OHS</option>
        <option value="2">OMS</option>
        <option value="3">OGS</option>
        <option value="3">2-5yrs old</option>
        <option value="3">5-10yrs old</option>
      </select>
    </div>

    <!-- Prefrences -->
    <label for="">Food Prefrences
      <p></p>

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

<!-- 
    <label for="">Short notes</label>
    <input type="text" name="childName" value="<?php echo htmlspecialchars($notes) ?>">
    <div class="red-text"><?php echo $errors['notes'] ?></div> -->


    <!-- Meals desired  -->
    <div type="text" class="input-field grey-text col s12">
      <p>
        Select which meals are desired?
        <select name="desired-meals">
          <option value="1"><label>Breakfast and Lunch</label> </option>
          <option value="2">Breakfast only</option>
          <option value="3">Lunch only</option>
        </select>
        <!-- <label>Select</label> -->
      </p>
    </div>

    </br>

    <!-- pick up time -->
    <div class="input-field col s12">
      <p>
        What time will you be picking up?
        <select name="pickup-time">
          <option value="" class="grey-text" disabled selected></option>
          <option value="1">7-9am</option>
          <option value="2">10-1pm</option>
          <option value="3">2-4pm</option>
        </select>
        <!-- <label>Select</label> -->
      </p>
    </div>

    <br>


    <!-- Week of -->
    Meals Are For Week Of... </br>Note: cut off is 8am Monday for the week<input value="" name="pickuptime" type="text" class="datepicker grey-text">
    </br></br>

    <!-- Add Child
    <div class="left">
      <label for="add1">
        <input type="button" value="Add Child" class="btn brand z-depth-0">
      </label>
    </div> -->

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

<!-- second version -->


<?php
include('config/db_connect.php');

// needs to be a get or post value from signup or users table. Probably a mysqli. 
$allowedMeals = 2;
$childname = $email = $pickuptime;
$errors = array('email' => '', 'pickuptime' => '', 'childName' => '');

// Filters and then post
if (isset($_POST['submit'])) {

  // if (empty($_POST['pickuptime'])) {
  //   $errors['pickuptime'] = 'Pick up time is required <br />';
  // } else {
  //   $email = $_POST['pickuptime'];
  //   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  //     $errors['pickuptime'] = 'pick up time must be valid';
  //   }
  // }
  // if (empty($_POST['email'])) {
  //   $errors['email'] = 'email is required <br />';
  // } else {
  //   $email = $_POST['email'];
  //   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  //     $errors['email'] = 'email must be valid';
  //   }
  // }

  // if (empty($_POST['childname'])) {
  //   $errors['childname'] =  'family name is required <br />';
  // } else {
  //   $childname = $_POST['childname'];
  //   if (!preg_match('/^[a-zA-Z\s]+$/', $childname)) {
  //     $errors['childname'] = 'family name must be letters and space only  ';
  //   }
  // }

  if (empty($_POST['childName'])) {
    $errors['childName'] = "child's name is required <br />";
  } else {
    $childName = $_POST['childName'];
    if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $childName)) {
      $errors['childName'] = "child's name must be letters and space only";
    }
  }

  // check for errors
  if (array_filter($errors)) {
    // echo "errors in form";
    echo "error";
  } else {

    // save data to database
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $childname = mysqli_real_escape_string($conn, $_POST['childname']);
    $childName = mysqli_real_escape_string($conn, $_POST['childName']);

    // create sql
    $sql = "INSERT INTO meals(name,childName,email) VALUES('$childname','$pickutime','$email')";
    // save to db
    if (mysqli_query($conn, $sql)) {

      header('Location: index.php');
    } else {
      echo 'query error: ' . mysqli_error($conn);
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<section class="container grey-text">
  <h4 class="center">Pick Up Order</h4>
  <form action="request.php" class="white grey-text" method="POST">
    <button class="allowed" id="allowed" style="display:none" value="<?php echo $allowedMeals ?>">
    </button>

    <div id="1" class="order1" style="display:none">
      <label for="">Child's Name</label>
      <input type="text" name="childName">
      <div class="red-text"><?php echo $errors['childName'] ?></div>

      <label for="">Meal Request #1</label>
      <div class="input-field col s12">
        <select name="meal-request">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="1">Standard</option>
          <option value="2">Vegetarian</option>
          <option value="3">Vegan</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="prefrence" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> value="Gluten Free">
          <span>Gluten Free</span>
        </label>
      </div>
        <!-- Meals desired  -->
        <div type="text" class="input-field grey-text col s12">
        <p>
          Select which meals are desired?
          <select name="desired-meals">
            <option value="1"><label>Breakfast and Lunch</label> </option>
            <option value="2">Breakfast only</option>
            <option value="3">Lunch only</option>
          </select>
          <!-- <label>Select</label> -->
        </p>
      </div>
      <br>
    </div>

    <div id="2" class="order2" style="display:none">
      <label for="">Child's Name</label>
      <input type="text" name="childName" value="<?php echo htmlspecialchars($childName) ?>">
      <div class="red-text"><?php echo $errors['childName'] ?></div>

      <label for="">Meal Request #2</label>
      <div class="input-field col s12">
        <select name="meal-request">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="1">Standard</option>
          <option value="2">Vegetarian</option>
          <option value="3">Vegan</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="prefrence" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> value="Gluten Free">
          <span>Gluten Free</span>
        </label>
      </div>
      <br>
    </div>

    <div id="3" class="order3" style="display:none">
      <label for="">Child's Name</label>
      <input type="text" name="childName" value="<?php echo htmlspecialchars($childName) ?>">
      <div class="red-text"><?php echo $errors['childName'] ?></div>
      <label for="">Meal Request #3</label>
      <div class="input-field col s12">
        <select name="meal-request">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="1">Standard</option>
          <option value="2">Vegetarian</option>
          <option value="3">Vegan</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="prefrence" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> value="Gluten Free">
          <span>Gluten Free</span>
        </label>
      </div>
      <br>
    </div>

    <div id="4" class="order4" style="display:none">
      <label for="">Child's Name</label>
      <input type="text" name="childName" value="<?php echo htmlspecialchars($childName) ?>">
      <div class="red-text"><?php echo $errors['childName'] ?></div>
      <label for="">Meal Request #4</label>
      <div class="input-field col s12">
        <select name="meal-request">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="1">Standard</option>
          <option value="2">Vegetarian</option>
          <option value="3">Vegan</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="prefrence" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> value="Gluten Free">
          <span>Gluten Free</span>
        </label>
      </div>
      <br>
    </div>

    <div id="5" class="order5" style="display:none">
      <label for="">Child's Name</label>
      <input type="text" name="childName" value="<?php echo htmlspecialchars($childName) ?>">
      <div class="red-text"><?php echo $errors['childName'] ?></div>
      <label for="">Meal Request #5</label>
      <div class="input-field col s12">
        <select name="meal-request">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="1">Standard</option>
          <option value="2">Vegetarian</option>
          <option value="3">Vegan</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="prefrence" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> value="Gluten Free">
          <span>Gluten Free</span>
        </label>
      </div>
      <br>
    </div>

    <!-- add meal button -->
    <div class="left">
      <input id="add" type="button" value="Add Meal" class="btn brand z-depth-0">
    </div>

    <!-- delete meal button
     <div class="right">
      <input id="add" type="button" style="display:none" value="Delete Meal" class="btn order1 orange z-depth-0">
    </div> -->


    <br>
    <br>

    <div id="1" class="order1 scale-transition" style="display:none">
      <!-- Meals desired 
      <div type="text" class="input-field grey-text col s12">
        <p>
          Select which meals are desired?
          <select name="desired-meals">
            <option value="1"><label>Breakfast and Lunch</label> </option>
            <option value="2">Breakfast only</option>
            <option value="3">Lunch only</option>
          </select>
          <label>Select</label> 
        </p>
      </div> -->

      <!-- pick up time -->
      <div class="input-field col s12">
        <p>
          What time will you be picking up? (Pick up is on Monday. Tuesday if a holiday falls on that monday.)
          <select name="pickup-time">
            <option value="" class="grey-text" disabled selected></option>
            <option value="1">7-9am</option>
            <option value="2">10-1pm</option>
            <option value="3">2-4pm</option>
          </select>
        </p>
      </div>
      <br>

      <!-- Week of -->
      Meals Are For Week Of... </br>Note: cut off is 8am Monday for the week<input value="" name="pickuptime" type="text" class="datepicker grey-text">
      </br></br>

      <!-- add reset button on otherside of add meal that turns everything back to display:none and empties the fields. Maybe just a refresh or something -->
      <!-- Submit -->
      <div class="right">
        <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
        <?php session_start();

        $_SESSION['name'] = $_POST['name']; ?>
      </div>
      </br></br>

    </div>

  </form>


</section>


<!-- Compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
<script>
  var date = new Date();
  var year = date.getFullYear();
  var month = date.getMonth();
  var day = date.getDate();
  var hour = date.getHours();
  var date = new Date(year, month, day, hour + 16);

  $(document).ready(function() {

    $('select').formSelect().css("color", "#010101");
    $('.datepicker').datepicker({
      minDate: date,
      // setDefaultDate: true,
      autoClose: true,
      disableDayFn: function(date) {
        if (date.getDay() == 1) // getDay() returns a value from 0 to 6, 1 represents Monday
          return false;
        else
          return true;
      },
      // closeOnSelect: true,
      onSet: function(ele) {
        if (ele.select) {
          this.close();
        }
      },
    });

    let order = 1
    let allowedMeals = parseInt( document.getElementById("allowed").value)+1

    $("#add").on('click', function(e) {
      if (order < allowedMeals) {
        $(`.order${order}`).css({
          display: "block"
        });
        order++
      }
      e.preventDefault();
      console.log(allowedMeals)

    });

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

<?php include('templates/footer.php'); ?>

</html>