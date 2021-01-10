<div class="input-field col s12">
      <select name="meal-request">
        <option value="1">Standard</option>
        <option value="2">Vegetarian</option>
        <option value="3">Vegan</option>
      </select>
    </div>

      <div>
        <label for="opt3">
          <input id="opt3" type="checkbox" name="prefrence" class="with-gap" <?php if (isset($prefrence) && $prefrence == "Gluten Free") echo "checked"; ?> value="Gluten Free">
          <span>Gluten Free</span>
        </label>
      </div>
    <br>

    <!-- <div class="left">
        <input type="button" value="Add Meal" class="btn brand z-depth-0"><?php include('templates/addmeal.php'); ?>
    </div>
    <br>
    <br> -->