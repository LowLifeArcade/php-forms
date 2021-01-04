<?php 
  include('config/db_connect.php');

  if(isset($_POST['cancel'])){
    $id_to_cancel = mysqli_real_escape_string($conn, $_POST['id_to_cancel']);
  
    $sql = "DELETE FROM meals WHERE id = $id_to_cancel";

    if(mysqli_query($conn, $sql)){
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
    $sql = "SELECT * FROM meals WHERE id = $id";

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

<div class="container center">
  <?php if ($meal): ?>

    <h4><?php echo htmlspecialchars($meal['name']); ?></h4>
    <p>Created by: <?php echo htmlspecialchars($meal['email']); ?></p>
    <p><?php echo htmlspecialchars($meal['special']) ?></p>
    <p><?php echo htmlspecialchars($meal['created_at']) ?></p>

    <form action="details.php" method="POST">
      <input type="hidden" name="id_to_cancel" value="<?php echo $meal['id'] ?>">
      <input type="submit" name="cancel" value="Cancel Order" class="btn brand z-depth-0.1">
    </form>

  <?php else: ?>
    <h4>No such order exists</h4>
  <?php endif; ?>
</div>

<?php include('templates/footer.php'); ?>

</body>
</html>