


<?php
include('config/db_connect.php');

// 
if (isset($_POST['cancel'])) {
  $id_to_cancel = mysqli_real_escape_string($conn, $_POST['id_to_cancel']);

  $sql = "DELETE FROM meals WHERE meals = $id_to_cancel";

  if (mysqli_query($conn, $sql)) {
    // success
    header('Location: index.php');
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

  <h4 class="center grey-text">Thank you!</h4>
  <h5 class="center grey-text">your confirmation number is: <br>(Not yet made) </h5>

  <div class="container center">
    <?php if ($meal) : ?>
      <div class="" >
        <p><?php // echo htmlspecialchars($meal['mealTypes']); 
            ?></p>
        <p>pick up time <br><?php echo htmlspecialchars($meal['pickupTime']) ?><br>
        </p>
        <p>for the week of <br><?php echo htmlspecialchars($meal['pickupWeek']) ?></p>
        Please remember pick up day is<br>
        on <b>monday</b> except in the case of <br>
        holidays landing on monday in <br>
        which case pick up is on <b>tuesday</b><br>
        <!-- <p>ordered placed at:<br> <?php //echo htmlspecialchars($meal['createdAt']) 
                                        ?></p> -->
      </div>

      <form action="details.php" method="POST">
        <input type="hidden" name="id_to_cancel" value="<?php echo $meal['userId'] ?>">
        <input type="submit" name="cancel" value="Cancel Order" class="btn brand z-depth-0">
      </form>

      <!-- put edit form here-->

    <?php else : ?>
      <h4>No such order exists</h4>
    <?php endif; ?>
  </div>

  <?php include('templates/footer.php'); ?>

</body>

</html>