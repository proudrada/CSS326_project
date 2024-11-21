<?php
require_once('connect.php');
session_start();

if (!isset($_SESSION['ZK_ID'])) {
    header("Location: homepage.php?error=not_logged_in");
    exit();
}

$zookeeperID = $_SESSION['ZK_ID'];

// Query to fetch zookeeper data
$query = "SELECT * FROM animal WHERE ZK_ID = '$zookeeperID'";
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
    <title>Animal Dashboard</title>
    <link rel="stylesheet" href="style_animal.css">
</head>
<body>
    <?php
    // Include a common header or navigation file if needed
    ?>
    <!-- Banner with Navigation Links -->
    <div class="banner">
        <h1>Himalayan Zoo of Mount Olympus and Mount Liangshan</h1>
        <nav>
            <a href="zookeeper_staff.php">Zoo Keeper</a>   
            <a href="animal_staff.php">Animal</a>
            <a href="zone_ad.php">Zone</a>
            <a href="ingredient_ad.php">Ingredient</a>
            <a href="meal_staff.php">Meal</a>
        </nav>
        <div class="admin-dropdown">
            <button class="admin-btn"><?= $zookeeper['ZKFName'] . "_" . $zookeeper['ZK_ID']; ?>▼</button>
            <div class="dropdown-content">
                <a href="homepage.php">Log-out</a>
            </div>
        </div>
    </div>

    <div class="topic">
        <h1>Animal</h1>
    </div>

    <!-- Cards Container -->
    <div class="cards-container">
        <?php
        if ($result->num_rows > 0) {
            // Loop through each row in the result set
            while ($row = $result->fetch_assoc()) {
                // Calculate age
                $dob = $row['ADate_of_birth'];
                if (!empty($dob)) {
                    $dobDate = new DateTime($dob);
                    $now = new DateTime();
                    $age = $now->diff($dobDate)->y; 
                } else {
                    $age = "N/A";
                }
                
                echo "
                <div class='card'>
                    <img src='{$row['image_path']}' alt='{$row['name']}' class='profile-img'>
                    <h2>{$row['A_name']}</h2>
                    <p>Animal ID: <span contenteditable='true'>{$row['A_ID']}</span></p>
                    <p>Date of birth: <span contenteditable='true'>{$row['ADate_of_birth']}</span></p>
                    <p>Species: <span contenteditable='true'>{$row['Species']}</span></p>
                    <p>Sex: <span contenteditable='true'>{$row['A_Sex']}</span></p>
                    <p>Zookeeper ID: <span contenteditable='true'>{$row['ZK_ID']}</span></p>
                    <p>Age: <span contenteditable='true'>$age</span></p>
                    <p>Zone: <span contenteditable='true'>{$row['Zone_name']}</span></p>
                </div>";
            }
        } else {
            echo "<p>No animals found.</p>";
        }
        ?>
    </div>

</body>
</html>
