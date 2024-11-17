<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingredient Management</title>
    <link rel="stylesheet" href="style_meal.css">
</head>
<body>
    <!-- Banner with Navigation Links -->
    <div class="banner">
        <h1>Himalayan Zoo of Mount Olympus and Mount Liangshan</h1>
        <nav>
            <a href="zookeeper_ad.php">Zoo Keeper</a>
            <a href="animal_ad.php">Animal</a>
            <a href="zone_ad.php">Zone</a>
            <a href="ingredient_ad.php">Ingredient</a>
            <a href="meal_ad.php">Meal</a>
        </nav>
        <div class="admin-dropdown">
            <button class="admin-btn">Admin_1 ▼</button>
            <div class="dropdown-content">
            <a href="homepage.html">Log-out</a>
            </div>
        </div>
    </div>
    
    <div class="topic">
        <h1>Meal</h1>
    </div>

    <!-- Ingredient Table -->
    <div class="content">
        <table>
            <tr class="head">
                <th>Meal Code</th>
                <th>Animal ID</th>
                <th>Ingredient ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
            <?php
            // Example PHP loop to generate rows (replace with actual database data)
            $meals = [
                ['code' => 'F001', 'id' => 'Type A', 'id' => 'Type A', 'date' => '500g', 'time' => '12/12/2023'],
                ['code' => 'F002', 'id' => 'Type B', 'id' => 'Type A','date' => '300g', 'time' => '15/01/2024'],
                ['code' => 'F001', 'id' => 'Type A', 'id' => 'Type A','date' => '500g', 'time' => '12/12/2023'],
                ['code' => 'F002', 'id' => 'Type B', 'id' => 'Type A','date' => '300g', 'time' => '15/01/2024'],
            ];
            foreach ($meals as $meal) {
                echo "<tr>
                        <td>{$meal['code']}</td>
                        <td>{$meal['id']}</td>
                        <td>{$meal['id']}</td>
                        <td>{$meal['date']}</td>
                        <td>{$meal['time']}</td>
                        <td>
                            <button class='delete-button'>Delete</button>
                            <button class='edit-button'>Edit</button>
                        </td>
                      </tr>";
            }
            ?>
        </table>
        <div class="add-button-container">
            <button onclick="window.location.href='add_meal.php'" class="add-button">+</button>
        </div>
    </div>
</body>
</html>
