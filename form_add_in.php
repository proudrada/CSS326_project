<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Ingredient</title>
    <link rel="stylesheet" href="style_add_in.css">
</head>
<body>
    <div class="container">
        <h1>Create New Ingredient</h1>
        <form action="add_in.php" method="POST">
            <label for="ingredient_id">Ingredient ID</label>
            <input type="text" id="ingredient_id" name="ingredient_id" required>

            <label for="ingredient_type">Ingredient Type</label>
            <input type="text" id="ingredient_type" name="ingredient_type" required>

            <label for="ingredient_amount">Ingredient Amount</label>
            <input type="text" id="ingredient_amount" name="ingredient_amount" required>

            <label for="expiration_date">Expiration Date</label>
            <input type="date" id="expiration_date" name="expiration_date" required>

            <div class="buttons">
                <button type="button" onclick="window.location.href='ingredient_ad.php'" class="cancel-button">Cancel</button>
                <button type="submit" class="add-button">Add Ingredient</button>
            </div>
        </form>
    </div>
</body>
</html>
