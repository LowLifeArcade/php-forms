<?php 

  session_start();

  if ($_SERVER['QUERY_STRING'] == 'noname') {
    // unset($_SESSION['name']);
    session_unset();
  }

  $sessionName = $_SESSION['name'] ?? 'Guest';

?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <style class="text/css">
    .brand{
      background: #cbb09c !important;
    }
    .brand-text{
      color: #cbb09c !important;
    }
    form{
      max-width: 460px;
      margin: 20px auto;
      padding: 20px;
    }
    ul.dropdown-content.select-dropdown li span {
    color: #cbb09c; /* no need for !important :) */
}
</style>
</head>
<body class="grey lighten-4">
  <nav class="white z-depth-0">
    <div class="container">
      <label class="left brand-logo brand-text">Oak Park Meals</label>
      <ul id="nav-mobile" class="right hide-on-small-and-down">
        <li class="grey-text"></li>
        <!-- <li><a href="request.php" class="btn brand z-depth-0">Weekly Request</a></li> -->
        <!-- <li><a href="#" class="btn brand z-depth-0">Add Pizza</a></li>
        <li><a href="#" class="btn brand z-depth-0">Add Pizza</a></li> -->
      </ul>
    </div>
  </nav>