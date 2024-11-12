<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingredient Management</title>
    <link rel="stylesheet" href="style_ingredient.css">
</head>
<body>
    <!-- Banner with Navigation Links -->
    <div class="banner">
        <h1>Himalayan Zoo of Mount Olympus and Mount Liangshan</h1>
        <nav>
            <a href="zookeeper_ad.html">Zoo Keeper</a>
            <a href="animal_ad.html">Animal</a>
            <a href="zone_ad.html">Zone</a>
            <a href="ingredient_ad.php">Ingredient</a>
            <a href="meal_ad.php">Meal</a>
        </nav>
        <!-- <div class="admin">
        <div class="admin-dropdown">
            <button class="admin-btn">Admin_1 ▼</button>
            <div class="dropdown-content">
                <a href="homepage.html">Log-out</a>
            </div>
        </div> -->
    </div>

    <div class="topic">
        <h1>Ingredient</h1>
    </div>

    <!-- Ingredient Table -->
    <div class="content">
        <table>
            <tr class="head">
                <th>Ingredient ID</th>
                <th>Ingredient Type</th>
                <th>Ingredient Amount</th>
                <th>Expiration Date</th>
                <th>Action</th>
            </tr>
            <?php
            // Example PHP loop to generate rows (replace with actual database data)
            $ingredients = [
                ['id' => 'F001', 'type' => 'Type A', 'amount' => '500g', 'expiry' => '12/12/2023'],
                ['id' => 'F002', 'type' => 'Type B', 'amount' => '300g', 'expiry' => '15/01/2024'],
                ['id' => 'F003', 'type' => 'Type C', 'amount' => '250g', 'expiry' => '20/02/2024'],
                ['id' => 'F004', 'type' => 'Type D', 'amount' => '400g', 'expiry' => '10/03/2024']
            ];
            foreach ($ingredients as $ingredient) {
                echo "<tr>
                        <td>{$ingredient['id']}</td>
                        <td>{$ingredient['type']}</td>
                        <td>{$ingredient['amount']}</td>
                        <td>{$ingredient['expiry']}</td>
                        <td>
                            <button class='delete-button'>Delete</button>
                            <button class='edit-button'>Edit</button>
                        </td>
                      </tr>";
            }
            ?>
        </table>
        <div class="add-button-container">
            <button class="add-button">+</button>
        </div>
    </div>
</body>
</html>
