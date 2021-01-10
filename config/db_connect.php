<?php 

  // MySQLi or PDO learn PDO
  // connect tatabase
  $conn = mysqli_connect('localhost', 'sonny','12345', 'oak_park');

  //check conn
  if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
  }
