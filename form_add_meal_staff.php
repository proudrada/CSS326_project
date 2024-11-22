<?php
require_once('connect.php');
// Fetch zookeeper data for the dropdown
$query_ingredients = "SELECT In_ID,In_type FROM ingredient";
$query_animals = "SELECT A_ID,A_name FROM animal";

// Execute both queries
$result_ingredients = $mysqli->query($query_ingredients);
if (!$result_ingredients) {
    die("Query for ingredients failed: " . $mysqli->error);
}

$result_animals = $mysqli->query($query_animals);
if (!$result_animals) {
    die("Query for animals failed: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Meal</title>
    <link rel="stylesheet" href="style_add_meal.css">
</head>
<body>
    <div class="container">
        <h1>Create New Meal</h1>
        <form action="add_meal.php" method="POST">
            <label for="meal_code">Meal Code</label>
            <input type="text" id="meal_code" name="meal_code" required>

            <label for="Animal_ID">Animal ID</label>
            <select type="drop-down" id="Animal_ID" name="Animal_ID" required>
                <option value="" disabled selected>Select Animal</option>
                <?php
                while ($row = $result_animals->fetch_assoc()) {
                    $A_ID = $row['A_ID'];
                    $A_name = $row['A_name'];
                    echo "<option value= '$A_ID'>$A_ID - $A_name</option>";
                }
                ?>
            </select>

            <label for="Ingredient_ID">Ingredient ID</label>
            <select type="drop-down" id="Ingredient_ID" name="Ingredient_ID" required>
                <option value="" disabled selected>Select Ingredient</option>
                <?php
                while ($row = $result_ingredients->fetch_assoc()) {
                    $In_ID = $row['In_ID'];
                    $In_type = $row['In_type'];
                    echo "<option value= '$In_ID'>$In_ID - $In_type</option>";
                }
                ?>
            </select>

            <label for="Date">Date</label>
            <input type="date" id="Date" name="Date" required>

            <label for="Time">Time</label>
            <input type="time" id="Time" name="Time" required>

            <div class="buttons">
                <button type="button" onclick="window.location.href='meal_staff.php'" class="cancel-button">Cancel</button>
                <button type="submit" class="add-button">Add Meal</button>
            </div>
        </form>
    </div>
</body>
</html>
