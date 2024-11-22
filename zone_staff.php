<?php
require_once('connect.php');
session_start();

if (!isset($_SESSION['ZK_ID'])) {
    header("Location: homepage.php?error=not_logged_in");
    exit();
}

$zookeeperID = $_SESSION['ZK_ID'];

// Query to fetch zookeeper data
$query = "SELECT * FROM zone, animal WHERE animal.Zone_name = zone.Zone_name AND ZK_ID = '$zookeeperID'";

$query_zk = "SELECT * FROM zookeeper WHERE ZK_ID = '$zookeeperID'";
$result = $mysqli->query($query);
// Check if query execution was successful
if (!$result) {
    die("Query failed: " . $mysqli->error);
}
$result_zk = $mysqli->query($query_zk);
// Check if query execution was successful
if (!$result_zk) {
    die("Query failed: " . $mysqli->error);
}
$zookeeper = $result_zk->fetch_assoc();
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
            <a href="Zookeeper_staff.php">Zoo Keeper</a>
            <a href="animal_staff.php">Animal</a>
            <a href="zone_staff.php">Zone</a>
            <a href="ingredient_ad.php">Ingredient</a>
            <a href="meal_ad.php">Meal</a>
        </nav>
         <!-- Admin Dropdown -->
         <div class="admin-dropdown">
            <button class="admin-btn"><?= $zookeeper['ZKFName'] . "_" . $zookeeper['ZK_ID']; ?>▼</button>
            <div class="dropdown-content">
                <a href="homepage.php">Log-out</a>
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
