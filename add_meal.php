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
        <form action="process.php" method="POST">
            <label for="meal_code">Meal Code</label>
            <input type="text" id="meal_code" name="meal_code" required>

            <label for="Animal_ID">Animal ID</label>
            <input type="text" id="Animal_ID" name="Animal_ID" required>

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
