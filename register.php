<?php

// filter submitsion for errors 
// required email and password

?>

<?php include('templates/extheader.php'); ?>

<br>
<body class="grey lighten-4">
  <section class="register-form container grey-text border-radius-1">
    <h4 class="center">Meal Registration</h4>
    <form action="includes/register.inc.php" class="white" method="POST">

      <label class="select" for="">Number of Children Being Registered For Weekly Meal Service<br>(18 and under only)</label>
      <div class="input-field col s12 select">
        <select name="numberOfStudents">
          <option value="" disabled selected></option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </div>
      <div class="outputArea" ></div>

      <!-- <div class="input-group">
        <label for="">Students Name and school they attend. If not in school specify age</label>
        <input type="text" name="student-name"> -->


      </div>
      <div class="input-group">
        <label for="">Parent's Full Name</label>
        <input type="text" name="full-name">
      </div>
      <div class="input-group">
        <label for="">Parent's Email</label>
        <input type="text" name="email">
      </div>
      <div></div>
      <div class="input-group">
        <label for="">Password</label>
        <input type="password" name="pwd">
      </div>
      <div class="input-group">
        <label for="">Confirm Password</label>
        <input type="password" name="pwdRepeat">
      </div>
      <br>
      <div class="input-group">
        <button type="submit" name="submit" class="btn z-depth-0">Register</button>
      </div>
      <p>
        Already registered? <a href="login.php">Log In</a>
      </p>
    </form>

    </form>
  </section>

  <?php include('templates/footer.php'); ?>
  <!-- Compiled and minified JavaScript -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

  <script>
    $(document).ready(function() {

      $('select').formSelect().css("color", "#010101");
      $("select").change(function() {
        var htmlString = "";
        var len = $("select").val();
        console.log(len)
        for (var i = 0; i < len; i++) {
          htmlString += "<div class='input-group'><label for=''>Students Name and school they attend. If not in school specify age.</label><input type='text' name='student-name'>"
        }
        $(document.querySelector('.outputArea')).append(htmlString);
        // hide select box somehow after chossing 
        console.log(htmlString)
        $(".select").css({
          display: "none"
        });
      });
      

      // let order = 1
      // let allowedMeals = parseInt(document.getElementById("allowed").value) + 1
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


  </html>