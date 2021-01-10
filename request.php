<?php
include('config/db_connect.php');

// open orders

// setup user for sql query first somehow so that the query only returns the users meals not everyones

// query for all meals
$sql = 'SELECT mealAmount, mealVar, gf, pickupTime, pickupWeek FROM meals ORDER BY createdAt';

// make query get result
$result = mysqli_query($conn, $sql);

// fetch resulting rows as array
$meals = mysqli_fetch_all($result, MYSQLI_ASSOC);

// // free memory up
mysqli_free_result($result);

// // close connection
mysqli_close($conn);

// // explode(',', $meals[1]['special']);

// /open orders

// needs to be a get or post value from signup or users table. Probably a mysqli. 
$allowedMeals = 5;

// initializing
$mealVar = $glurenFree = $mealRequest = $pickupTime = $pickupDate = $mealType;
$errors = array('meal-request' => '', 'gluten-free' => '', 'meal-request' => '', 'desired-meals' => '', 'pickup-time' => '', 'pickup-week' => '');

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

  //  potentially use the else if for note field where parent can put special notes
  if (empty($_POST['meal-request'])) {
    $errors['meal-request'] = "required field";
  } else {
    $mealRequest = $_POST['meal-request'];
    // [a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/'
    if (!$mealRequest) {
      $errors['meal-request'] = "regular characters only";
    } else {
      if ($_POST['meal-request'] == 'Vegerian') {
        $mealVar = 'VT';
      } else if ($_POST['meal-request'] == 'Vegan (lunch only)') {
        $mealVar = 'VG';
      } else if (($_POST['meal-request'] == 'Standard')) {
        $mealVar = 'RG';
      }
    }
  }

  // check for errors
  if (array_filter($errors)) {
    // echo "errors in form";
    // echo "error";
    // $block = 'display:block';
    ?>
    <script>document.querySelectorAll(".order1").css({
          display: "block"
        });</script>
    <?php 
  } else {

    // // save data to database
    // $mealRequest = mysqli_real_escape_string($conn, $_POST['meal-request']);
    // $GF = mysqli_real_escape_string($conn, $_POST['gluten-free']);
    // $mealType = mysqli_real_escape_string($conn, $_POST['desired-meals']);
    // $pickupTime = mysqli_real_escape_string($conn, $_POST['pickup-time']);
    // $pickupDate = mysqli_real_escape_string($conn, $_POST['pickup-week']);
    

    // // create sql
    // $sql = "INSERT INTO meals(mealVar,gf,mealType,pickupTime,pickupWeek) VALUES('$mealRequest', '$GF', $mealType '$pickuTime','$pickupDate')";
    // // save to db
    // if (mysqli_query($conn, $sql)) {

    //   header('Location: index.php');
    // } else {
    //   echo 'query error: ' . mysqli_error($conn);
    // }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>
<h4 class="center grey-text">Open Meal Requests</h4>

<!-- open orders -->
<div class="container">
  <div class="row">

    <?php foreach ($meals as $meal) : ?>

      <div class="col s6 md3">
        <div class="card z-depth-0">
          <div class="card-content center">
            <label for="">Your Order for</label>
            <h6><?php echo htmlspecialchars($meal['pickupWeek']); ?></h6>
            <ul>
              <?php foreach (explode(',', $meal['pickupTime']) as $special) : ?>
                <li><?php echo htmlspecialchars($special) ?></li>
              <?php endforeach ?>
              <li><?php echo htmlspecialchars($meal['mealAmount']) ?> meals</li>
            </ul>
          </div>
          <div class="card-action right-align">
            <a class="brand-text" href="details.php?id=<?php echo $meal['orderId'] ?>">more info</a>

          </div>
        </div>
      </div>

    <?php endforeach; ?>

    <!-- <?php if (count($meals) >= 2) : ?>
      oh hai
    <?php endif ?> -->

  </div>
</div>

<!-- order form -->

<section class="container grey-text">

  <form action="request.php" class="" method="POST">
    <button class="allowed" id="allowed" style="display:none" value="<?php echo $allowedMeals ?>">
    </button>

    <div id="1" class="order1" style="display:none">

      <!-- <label for="">Child's Name</label>
      <input type="text" name="childName">
      <div class="red-text"><?php //echo $errors['childName'] ?></div> -->

      <label for="">Meal Request #1</label>
      <div class="input-field col s12">
        <select name="meal-request">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="1">Standard</option>
          <option value="2">Vegetarian</option>
          <option value="3">Vegan (lunch only)</option>
        </select>
      <div class="red-text"><?php echo $errors['meal-request'] ?>
      </div>
        </div>

      <div class="">
        <label>
          <input type="checkbox" name="gluten-free" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> value="Gluten Free">
          <span>Gluten Free (lunch only)</span>
        </label>
      </div>
      <!-- Meals desired  -->
      <!-- <p>
        <label for="">Select which meals are desired?</label>
      <div type="text" class="input-field grey-text col s12">
          <select name="desired-meals">
            <option value="" disabled><label></label> </option>
            <option value="1" selected><label>Breakfast and Lunch</label> </option>
            <option value="2">Breakfast only</option>
            <option value="3">Lunch only</option>
          </select>
        </p>
      </div> -->
      <br>
    </div>

    <!-- <div id="2" class="order2" style="display:none">
      <label for="">Meal Request #2</label>
      <div class="input-field col s12">
        <select name="meal-request">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="1">Standard</option>
          <option value="2">Vegetarian</option>
          <option value="3">Vegan (lunch only)</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="prefrence" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> value="Gluten Free">
          <span>Gluten Free (lunch only)</span>
        </label>
      </div>
      <br>
    </div>

    <div id="3" class="order3" style="display:none">
      <label for="">Meal Request #3</label>
      <div class="input-field col s12">
        <select name="meal-request">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="1">Standard</option>
          <option value="2">Vegetarian</option>
          <option value="3">Vegan (lunch only)</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="prefrence" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> value="Gluten Free">
          <span>Gluten Free (lunch only)</span>
        </label>
      </div>
      <br>
    </div>

    <div id="4" class="order4" style="display:none">
      <label for="">Meal Request #4</label>
      <div class="input-field col s12">
        <select name="meal-request">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="1">Standard</option>
          <option value="2">Vegetarian</option>
          <option value="3">Vegan (lunch only)</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="prefrence" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> value="Gluten Free">
          <span>Gluten Free (lunch only)</span>
        </label>
      </div>
      <br>
    </div>

    <div id="5" class="order5" style="display:none">
      <label for="">Meal Request #5</label>
      <div class="input-field col s12">
        <select name="meal-request">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="1">Standard</option>
          <option value="2">Vegetarian</option>
          <option value="3">Vegan (lunch only)</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="prefrence" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> value="Gluten Free">
          <span>Gluten Free (lunch only)</span>
        </label>
      </div>
      <br>
    </div> -->

    <!-- add meal button -->
    <div id="add-meal-btn" class="center">
      <input id="add" type="button" value="Add Meal" class="btn brand z-depth-0">
    </div>

    <!-- delete meal button
     <div class="right">
      <input id="add" type="button" style="display:none" value="Delete Meal" class="btn order1 orange z-depth-0">
    </div> -->

    <div id="1" class="order1 scale-transition" style="display:none">

      <br>
      <br>
      <br>

      <!-- Meals desired  -->
      <div type="text" class="input-field grey-text col s12">
        <p>
          Select which meals are desired? <br>(Vegan and Gluten Free options will be lunch only)
          <select name="desired-meals">
            <option value="1"><label>Breakfast and Lunch</label> </option>
            <option value="2">Breakfast only</option>
            <option value="3">Lunch only</option>
          </select>
        </p>
      </div>
      <br>

      <!-- pick up time -->
      <div class="input-field col s12">
        <p>
          What time will you be picking up? <br>(Pick up is on Monday. Tuesday if a holiday falls on that monday.)
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
      Meals Are For Week Of... </br>Note: cut off is 8am Monday for the week<input value="" name="pickup-week" type="text" class="datepicker grey-text">
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
      autoClose: true,
      disableDayFn: function(date) {
        if (date.getDay() == 1) 
          return false;
        else
          return true;
      },

      onSet: function(ele) {
        if (ele.select) {
          this.close();
        }
      },
    });

    let order = 1
    let allowedMeals = parseInt(document.getElementById("allowed").value) + 1

    // $("#add").on('click', function(e) {

    //   $("#1").clone().appendTo("#1");

    // });
    

    $("#add").on('click', function(e) {
      if (order < allowedMeals) {
        $(`.order${order}`).css({
          display: "block"
        });
        order++
      }
      e.preventDefault();
      $("form").addClass('white grey-text')
      $("#add-meal-btn").addClass('left')
      console.log(allowedMeals)

    });

  });
</script>

<?php include('templates/footer.php'); ?>

</html>