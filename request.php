<?php
include('config/db_connect.php');

// query for all meals to show as receipts at top of page
$sql = 'SELECT orderId, mealAmount, mealVar, gf, pickupTime, pickupWeek FROM meals ORDER BY createdAt';

// make query get result
$result = mysqli_query($conn, $sql);

// fetch resulting rows as array
$meals = mysqli_fetch_all($result, MYSQLI_ASSOC);

// // free memory up
mysqli_free_result($result);


// HARD coded need to change from users table numberOfStudents amount allowed 
$allowedMeals = 5;

// initializing
$mealAmount = $mealVar = $glurenFree = $mealRequest = $glurenFree2 = $mealRequest2 = $glurenFree3 = $mealRequest3 = $glurenFree4 = $mealRequest4 = $glurenFree5 = $mealRequest5 = $pickupTime = $pickupWeek = $mealType;
$errors = array('meal-request' => '', 'meal-request2' => '', 'meal-request3' => '', 'meal-request4' => '', 'meal-request5' => '', 'gluten-free' => '', 'gluten-free2' => '', 'gluten-free3' => '', 'gluten-free4' => '', 'gluten-free5' => '', 'meal-request' => '', 'desired-meals' => '', 'pickup-time' => '', 'pickup-week' => '');

// Filters
if (isset($_POST['submit'])) {

  if (empty($_POST['meal-request'])) {
    $errors['meal-request'] = "choose meal type, ";
  } else {
    if (!preg_match('/^[a-zA-Z0-9_\s]+$/', $_POST['meal-request'])) {
      $errors['meal-request'] = "meal type is regular characters only ";
    }
  }

  if (empty($_POST['pickup-time'])) {
    $errors['pickup-time'] =  'choose pickup time, ';
  } else {
    $pickupTime = $_POST['pickup-time'];
    if (!preg_match('/^[a-zA-Z0-9_\s]+$/', $pickupTime)) {
      $errors['pickup-time'] = 'pickup time must be letters and spaces only ';
    }
  }

  if (empty($_POST['pickup-week'])) {
    $errors['pickup-week'] =  'choose pickup week ';
  } else {
    $pickupWeek = $_POST['pickup-week'];
    if (!preg_match('/^[a-zA-Z0-9,_\s]+$/', $pickupWeek)) {
      $errors['pickup-week'] = 'pickup week must be letters and spaces only ';
    }
  }

  // check for errors
  if (array_filter($errors)) {
    echo $errors['meal-request'], $errors['pickup-time'], $errors['pickup-week'];
  } else {

    // meal count
    if($_POST['meal-request']){
      $mealAmount = '_01';
    } 
    if($_POST['meal-request2']){
      $mealAmount = '_02';
    } 
    if($_POST['meal-request3']){
      $mealAmount = '_03';
    } 
    if($_POST['meal-request4']){
      $mealAmount = '_04';
    } 
    if($_POST['meal-request5']){
      $mealAmount = '_05';
    } 


    // fix standard meal string to empty 
    if ($_POST['meal-request'] === "ST") {
      $mr1 = '';
    } else {
      $mr1 = mysqli_real_escape_string($conn, $_POST['meal-request']);
    }

    if ($_POST['meal-request2'] === "ST") {
      $mr2 = '';
    } else {
      $mr2 = mysqli_real_escape_string($conn, $_POST['meal-request2']);
    }

    if ($_POST['meal-request3'] === "ST") {
      $mr3 = '';
    } else {
      $mr3 = mysqli_real_escape_string($conn, $_POST['meal-request3']);
    }

    if ($_POST['meal-request4'] === "ST") {
      $mr4 = '';
    } else {
      $mr4 = mysqli_real_escape_string($conn, $_POST['meal-request4']);
    }

    if ($_POST['meal-request5'] === "ST") {
      $mr5 = '';
    } else {
      $mr5 = mysqli_real_escape_string($conn, $_POST['meal-request5']);
    }

    // if (isset($_POST['meal-request5'])) {

      // // put meal-requests together like VG_VTGF_ST_
      //       $mealRequest = $_POST['meal-request'] . $_POST['gluten-free'] ."_".$_POST['meal-request2']  . $_POST['gluten-free2'] ."_". $_POST['meal-request3'] . $_POST['gluten-free3']  ."_". $_POST['meal-request4'] . $_POST['gluten-free4']  ."_". $_POST['meal-request5'] . $_POST['gluten-free5']  ."_";
      //   } elseif (isset($_POST['meal-request4'])) {

      // // put meal-requests together like VG_VTGF_ST_
      //       $mealRequest = $_POST['meal-request'] . $_POST['gluten-free'] ."_".$_POST['meal-request2']  . $_POST['gluten-free2'] ."_". $_POST['meal-request3'] . $_POST['gluten-free3']  ."_". $_POST['meal-request4'] . $_POST['gluten-free4']  ."_";
      //   } elseif (isset($_POST['meal-request3'])) {

      // // put meal-requests together like VG_VTGF_ST_
      //       $mealRequest = $_POST['meal-request'] . $_POST['gluten-free'] ."_".$_POST['meal-request2']  . $_POST['gluten-free2'] ."_". $_POST['meal-request3'] . $_POST['gluten-free3']  ."_";
      //   } elseif (isset($_POST['meal-request2'])) {

      //   // put meal-requests together like VG_VTGF_ST_
      //       $mealRequest = $_POST['meal-request'] . $_POST['gluten-free'] ."_".$_POST['meal-request2']  . $_POST['gluten-free2'] ."_";
      //   } else {
      //       $mealRequest = $_POST['meal-request'] . $_POST['gluten-free'] ."_";
      //   }




      // mealRequest string for code
    if (isset($_POST['meal-request5'])) {

      // put meal-requests together like VG_VTGF_ST_
      $mealRequest = $mr1 . $_POST['gluten-free'] . $mr2  . $_POST['gluten-free2'] . $mr3 . $_POST['gluten-free3'] . $mr4 . $_POST['gluten-free4'] . $mr5 . $_POST['gluten-free5']  . "_";

    } elseif (isset($_POST['meal-request4'])) {

      // put meal-requests together like VG_VTGF_ST_
      $mealRequest = $mr1 . $_POST['gluten-free'] . $mr2  . $_POST['gluten-free2'] . $mr3 . $_POST['gluten-free3'] . $mr4 . $_POST['gluten-free4']  . "_";

    } elseif (isset($_POST['meal-request3'])) {

      // put meal-requests together like VG_VTGF_ST_
      $mealRequest = $mr1 . $_POST['gluten-free'] . $mr2  . $_POST['gluten-free2'] . $mr3 . $_POST['gluten-free3']  ."_";

    } elseif (isset($_POST['meal-request2'])) {

      // put meal-requests together like VG_VTGF_ST_
      $mealRequest = $mr1 . $_POST['gluten-free'] . $mr2  . $_POST['gluten-free2'] ."_";

    } elseif (isset($_POST['meal-request'])) {
      $mealRequest = $mr1 . $_POST['gluten-free'];
    }
 

    

    // if stgf cap gf

    // db linkId == userId
    // save data to database
    $mealType = mysqli_real_escape_string($conn, $_POST['desired-meals']);
    $pickupTime = mysqli_real_escape_string($conn, $_POST['pickup-time']);
    $pickupWeek = mysqli_real_escape_string($conn, $_POST['pickup-week']);
    $linkId = mysqli_real_escape_string($conn, $_POST['userId']);
    if (isset($_POST['gluten-free'])) {
      $GF = 'yes';
    } else {
      $GF = 'no';
    }

    // create sql
    $sql = "INSERT INTO meals (mealAmount,mealVar,gf,mealType,pickupTime,pickupWeek,linkId) VALUES ('$mealAmount', '$mealRequest', '$GF', '$mealType', '$pickupTime', '$pickupWeek', '$linkId')";

    // $sql = "INSERT INTO meals (mealVar, linkId) VALUES ('$mealRequest', '$linkId')";
    // save to db
    if (mysqli_query($conn, $sql)) {
      // this looks for last id made in meals table
      $orderId = $conn->insert_id;
      header('Location: thankyou.php?id=' . $orderId);
      // header('Location: thankyou.php');
    } else {
      echo 'query error: ' . mysqli_error($conn);
    }
  }


  // close connection
  mysqli_close($conn);
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

      <div class="col s6 md3 grey-text">
        <div class="card z-depth-2">
          <div class="card-content center">
            <label for="">Your Request for</label>
            <h6><?php echo htmlspecialchars($meal['pickupWeek']); ?></h6>
            <ul>
              <label for="">Pickup between</label>

              <?php foreach (explode(',', $meal['pickupTime']) as $details) : ?>
                <li><?php echo htmlspecialchars($details) ?></li>
              <?php endforeach ?>

              <!-- <li><?php //echo htmlspecialchars($meal['mealAmount']) 
                        ?> </li> -->
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

<section class="container grey-text ">

  <form action="request.php" class="" method="POST">
    <input name="userId" value="2" type="hidden">
    <button class="allowed" id="allowed" style="display:none" value="<?php echo $allowedMeals ?>">
    </button>

    <div id="1" class="order1" style="display:none">

      <label for="">Meal Request #1</label>
      <div class="input-field col s12">
        <select name="meal-request">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="ST">Standard</option>
          <option value="Vt">Vegetarian</option>
          <option value="Vg">Vegan (lunch only)</option>
        </select>
        <div class="red-text"><?php echo $errors['meal-request'] ?>
        </div>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="gluten-free" class="with-gap <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> " value="Gf">
          <span>Gluten Free (lunch only)</span>
        </label>
      </div>
      <br>
    </div>

    <div id="2" class="order2" style="display:none">
      <label for="">Meal Request #2</label>
      <div class="input-field col s12">
        <select name="meal-request2">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="ST">Standard</option>
          <option value="Vt">Vegetarian</option>
          <option value="Vg">Vegan (lunch only)</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="gluten-free2" class="with-gap <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> " value="Gf">
          <span>Gluten Free (lunch only)</span>
        </label>
      </div>
      <br>
    </div>

    <div id="3" class="order3" style="display:none">
      <label for="">Meal Request #3</label>
      <div class="input-field col s12">
        <select name="meal-request3">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="ST">Standard</option>
          <option value="Vt">Vegetarian</option>
          <option value="Vg">Vegan (lunch only)</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="gluten-free3" class="with-gap <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> " value="Gf">
          <span>Gluten Free (lunch only)</span>
        </label>
      </div>
      <br>
    </div>

    <div id="4" class="order4" style="display:none">
      <label for="">Meal Request #4</label>
      <div class="input-field col s12">
        <select name="meal-request4">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="ST">Standard</option>
          <option value="Vt">Vegetarian</option>
          <option value="Vg">Vegan (lunch only)</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="gluten-free4" class="with-gap <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> " value="Gf">
          <span>Gluten Free (lunch only)</span>
        </label>
      </div>
      <br>
    </div>

    <div id="5" class="order5" style="display:none">
      <label for="">Meal Request #5</label>
      <div class="input-field col s12">
        <select name="meal-request5">
          <option value="" disabled selected>Select Meal Type...</option>
          <option value="ST">Standard</option>
          <option value="Vt">Vegetarian</option>
          <option value="Vg">Vegan (lunch only)</option>
        </select>
      </div>
      <div class="">
        <label>
          <input type="checkbox" name="gluten-free5" class="with-gap <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> " value="Gf">
          <span>Gluten Free (lunch only)</span>
        </label>
      </div>
      <br>
    </div>

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
          Select which meals are desired? <br>(All Vegan and Gluten Free options will be lunch only)
          <select name="desired-meals">
            <option value="BL"><label>Breakfast and Lunch</label> </option>
            <option value="BO">Breakfast only</option>
            <option value="LO">Lunch only</option>
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
            <option value="7 to 9am">7am to 9am</option>
            <option value="11 to 1pm">11pm to 1pm</option>
            <option value="4 to 6pm">4pm to 6pm</option>
          </select>
        </p>
      </div><?php echo $errors['pickup-time'] ?>

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
      $('form').addClass('z-depth-2')
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