<?php 

  include('config/db_connect.php');

  // query for all people's meals
  $sql = 'SELECT special, name, id FROM meals ORDER BY created_at';

  // make query get result
  $result = mysqli_query($conn, $sql);

  // fetch resulting rows as array
  $meals = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // free memory up
  mysqli_free_result($result);
  
  // close connection
  mysqli_close($conn);

  // explode(',', $meals[1]['special']);

?>

<!DOCTYPE html>
<html lang="en">

  <?php include('templates/header.php'); ?>

  <h4 class="center grey-text">meals</h4>
  <div class="container">
    <div class="row">

    <?php foreach ($meals as $meal) : ?>
      
      <div class="col s6 md3">
        <div class="card z-depth-0">
          <div class="card-content center">
            <h6><?php echo htmlspecialchars($meal['name']); ?></h6>
             <ul>
               <?php foreach (explode(',', $meal['special']) as $special): ?>
                 <li><?php echo htmlspecialchars($special) ?></li>
               <?php endforeach ?>
             </ul>
            </div>
            <div class="card-action right-align">
              <a href="#" class="brand-text">more info</a>
            
          </div>
        </div>
      </div>

    <?php endforeach; ?>

    <!-- <?php if (count($meals)>=2): ?>
      oh hai
    <?php endif ?> -->

    </div>
  </div>

  <?php include('templates/footer.php'); ?>


</html>