<?php
include('config/db_connect.php');

if (isset($_POST['cancel'])) {
  $id_to_cancel = mysqli_real_escape_string($conn, $_POST['id_to_cancel']);

  $sql = "DELETE FROM meals WHERE orderId = $id_to_cancel";

  if (mysqli_query($conn, $sql)) {
    // success
    header('Location: request.php');
  } {
    // failure
    echo 'query error: ' . mysqli_error($conn);
  }
}

// check GET request id param
if (isset($_GET['id'])) {
  $id = mysqli_real_escape_string($conn, $_GET['id']);

  // make sql
  $sql = "SELECT * FROM meals WHERE orderId = $id";

  // get query results
  $result = mysqli_query($conn, $sql);

  //  fetch result in array format
  $meal = mysqli_fetch_assoc($result);

  mysqli_free_result($result);
  mysqli_close($conn);
  // header('request.php')
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php include('templates/header.php'); ?>

  <section class="container grey-text">
    <div class="col s12 card center">
      <?php if ($meal) : ?>
        <div class="">
          <br>
          <h4><?php echo htmlspecialchars($meal['mealAmount']); ?> (number of) meals</h4>
          
          <p>
          For 
          <?php if(htmlspecialchars($meal['mealType']) === 'BL'){
            echo 'breakfast and lunch';
          } else if (htmlspecialchars($meal['mealType']) === 'BO') {
            echo 'breakfast only';
          } else if (htmlspecialchars($meal['mealType']) === 'LO') {
            echo 'lunch only';
          }
          ; ?></p>
          Pick up time:<br><?php echo htmlspecialchars($meal['pickupTime']) ?>
          
          <!-- <div class="card-content center"> -->
            <p>for the week of <br><?php echo htmlspecialchars($meal['pickupWeek']) ?></p>
            <!-- <br> -->
            <!-- <br> -->
            <h4>Important Note:</h4>
            Please remember pick up day is<br>
            on <b>monday</b> except when a <br>
            holiday lands on monday <br>
            making pick up day on <b>tuesday</b>.

            <form action="details.php" method="POST">
              <input type="hidden" name="id_to_cancel" value="<?php echo $meal['orderId'] ?>">
              <input type="submit" name="cancel" value="Cancel Order" class="btn brand z-depth-0">
            </form>
            <br>
          <!-- </div> -->
        </div>
    </div>
    <br>
  </section>
  <!-- put edit form here-->

<?php else : ?>
  <h4>No such order exists</h4>
<?php endif; ?>
</div>

<?php include('templates/footer.php'); ?>

</body>

</html>