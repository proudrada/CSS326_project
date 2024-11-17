<?php
require_once('connect.php');
// Query to fetch zookeeper data
$query = "SELECT * FROM zone";
$result = $mysqli->query($query);
// Check if query execution was successful
if (!$result) {
    die("Query failed: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Dashboard</title>
    <link rel="stylesheet" href="style_zone.css">
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
        <h1>Zone</h1>
    </div>

    <!-- Cards Container -->
    <div class="cards-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='card'>
                    <img src='{$row['image_path']}' alt='{$row['ZName']}' class='profile-img'>
                    <h2>{$row['Zone_name']}</h2>
                    <p>Environment: <span contenteditable='true'>{$row['Environment']}</span></p>
                    <p>Habitat: <span contenteditable='true'>{$row['Habitat']}</span></p>
                    <p>Average temperature: <span contenteditable='true'>{$row['Avg_temp']}</span></p>
                    <p>Relative Humidity: <span contenteditable='true'>{$row['Relative_humidity']}%</span></p>
                    <a href='#' class='edit-icon' title='Edit'>&#9998;</a>
                </div>";
            }
        } else {
            echo "<p>No zones found.</p>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
