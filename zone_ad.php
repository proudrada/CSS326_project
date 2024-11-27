<?php
require_once('connect.php');
// Query to fetch zookeeper data
$query = "SELECT * FROM zone";
$query_admin = "SELECT * FROM admin";
$result = $mysqli->query($query);
// Check if query execution was successful
if (!$result) {
    die("Query failed: " . $mysqli->error);
}
$result_admin = $mysqli->query($query_admin);
// Check if query execution was successful
if (!$result_admin) {
    die("Query failed: " . $mysqli->error);
}
$admin = $result_admin->fetch_assoc();
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
    <nav>
        <a href="zookeeper_ad.php">Zookeeper</a>
        <a href="animal_ad.php">Animal</a>
        <a href="zone_ad.php" class="zone"><u>Zone</u></a>
        <a href="ingredient_ad.php">Ingredient</a>
        <a href="meal_ad.php">Meal</a>
        <!-- Admin Dropdown -->
        <div class="admin-dropdown">
            <button class="admin-btn"><?= $admin['Ad_name']; ?>▼</button>
                <div class="dropdown-content">
                    <a href="reset.php">Reset Password</a>
                    <a href="homepage.php">Log-out</a>
                    
                </div>
        </div>
    </nav>
    <!-- Banner with Navigation Links -->
    <div class="banner">
        <h1>Himalayan Zoo of Mount Olympus and Mount Liangshan</h1>
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
                    <p>Environment: {$row['Environment']}</p>
                    <p>Habitat: {$row['Habitat']}</p>
                    <p>Average temperature: {$row['Avg_temp']}</p>
                    <p>Relative Humidity: {$row['Relative_humidity']}%</p>
                    <a href='form_edit_zone.php?Zone_name={$row['Zone_name']}' class='edit-icon' title='Edit'>&#9998;</a>
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
