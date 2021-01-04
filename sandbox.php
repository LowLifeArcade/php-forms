<?php 

//   sessions
if (isset($_POST['submit'])) {
  session_start();

  $_SESSION['name'] = $_POST['name'];

  echo $_SESSION['name'];

  header('Location: index.php');
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


<p>
What time will you be picking up?
<select name="formGender">
  <option value="">Select...</option>
  <option value="M">Male</option>
  <option value="F">Female</option>
</select>
</p>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>
  <input type="text" name="name">
  <input type="submit" name="submit" value="submit">
</form>
  
</body>
</html>