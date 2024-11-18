<?php
require_once('connect.php');
// Fetch zookeeper data for the dropdown
$query = "SELECT In_ID FROM ingredient";
$result = $mysqli->query($query);
if (!$result) {
    die("Query failed: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Ingredient</title>
    <link rel="stylesheet" href="style_add_meal.css">
</head>
<body>
    <div class="container">
        <h1>Create New Meal</h1>
        <form action="add_meal.php" method="POST">
            <label for="meal_code">Meal Code</label>
            <input type="text" id="meal_code" name="meal_code" required>

            <label for="Animal_ID">Animal ID</label>
            <input type="text" id="Animal_ID" name="Animal_ID" required>

            <label for="Ingredient_ID">Ingredient ID</label>
            <select type="drop-down" id="Ingredient_ID" name="Ingredient_ID" required>
                <option value="" disabled selected>Select Ingredient</option>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"{$row['In_ID']}\">{$row['In_ID']}</option>";
                }
                ?>
            </select>

            <label for="Date">Date</label>
            <input type="date" id="Date" name="Date" required>

            <label for="Time">Time</label>
            <input type="time" id="Time" name="Time" required>

            <div class="buttons">
                <button type="button" onclick="window.location.href='meal_ad.php'" class="cancel-button">Cancel</button>
                <button type="submit" class="add-button">Add Ingredient</button>
            </div>
        </form>
    </div>
</body>
</html>
