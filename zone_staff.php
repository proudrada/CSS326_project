<?php
require_once('connect.php');
session_start();

if (!isset($_SESSION['ZK_ID'])) {
    header("Location: homepage.php?error=not_logged_in");
    exit();
}

$zookeeperID = $_SESSION['ZK_ID'];

// Query to get the Zone names related to the animals for the logged-in zookeeper
$query = "SELECT DISTINCT zone.* FROM zone 
          JOIN animal ON animal.Zone_name = zone.Zone_name 
          WHERE animal.ZK_ID = '$zookeeperID'";

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
    <title>Zone Dashboard</title>
    <link rel="stylesheet" href="style_zone.css">
</head>
<body>
    <!-- Banner with Navigation Links -->
    <nav>
        <a href="zookeeper_staff.php">Your profile</u></a>
        <a href="animal_staff.php">Animal</a>
        <a href="zone_staff.php" class="zone"><u>Zone</u></a>
        <a href="ingredient_staff.php">Ingredient</a>
        <a href="meal_staff.php">Meal</a>
        <!-- Admin Dropdown -->
        <div class="admin-dropdown">
            <button class="admin-btn"><?= $zookeeper['ZKFName'] . "_" . $zookeeper['ZK_ID']; ?>▼</button>
            <div class="dropdown-content">
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
        // Check if there are any zones related to the animals
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='card'>
                    <img src='{$row['image_path']}' alt='{$row['Zone_name']}' class='profile-img'>
                    <h2>{$row['Zone_name']}</h2>
                    <p>Environment: <span contenteditable='true'>{$row['Environment']}</span></p>
                    <p>Habitat: <span contenteditable='true'>{$row['Habitat']}</span></p>
                    <p>Average temperature: <span contenteditable='true'>{$row['Avg_temp']}</span></p>
                    <p>Relative Humidity: <span contenteditable='true'>{$row['Relative_humidity']}%</span></p>
                </div>";
            }
        } else {
            echo "<p>No zones found.</p>";
        }
        ?>
    </div>
</body>
</html>
