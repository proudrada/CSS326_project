<?php
require_once('connect.php');
// Query to fetch zookeeper data
$query = "SELECT * FROM zookeeper";
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
    <link rel="stylesheet" href="style_ZooKeep.css">
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
        <!-- Admin Dropdown -->
        <div class="admin-dropdown">
            <button class="admin-btn">Admin_1 ▼</button>
            <div class="dropdown-content">
                <a href="homepage.html">Log-out</a>
            </div>
        </div>
    </div>

    <div class="topic">
        <h1>Zookeeper</h1>
    </div>

    <!-- Cards Container -->
    <div class="cards-container">
        <?php
        if ($result->num_rows > 0) {
            // Loop through each row in the result set
            while ($row = $result->fetch_assoc()) {
                // Calculate age
                $dob = $row['ZDate_of_birth'];
                if (!empty($dob)) {
                    $dobDate = new DateTime($dob);
                    $now = new DateTime();
                    $age = $now->diff($dobDate)->y; 
                } else {
                    $age = "N/A";
                }

                // Concatenate first name and last name
                $fullName = $row['ZKFName'] . ' ' . $row['ZKLName'];

                echo "
                <div class='card'>
                    <button class='close-btn' title='Close'>X</button>
                    <img src='{$row['image_path']}' alt='{$row['ZKFName']}' class='profile-img'>
                    <h2>{$fullName}</h2>
                    <p>Zookeeper ID: <span contenteditable='true'>{$row['ZK_ID']}</span></p>
                    <p>Date of birth: <span contenteditable='true'>{$row['ZDate_of_birth']}</span></p>
                    <p>Sex: <span contenteditable='true'>{$row['ZSex']}</span></p>
                    <p>Salary: <span contenteditable='true'>\${$row['Salary']}</span></p>
                    <p>Animal ID: <span contenteditable='true'>{$row['A_ID']}</span></p>
                    <p>Age: <span contenteditable='true'>{$row['age']}</span></p>
                    <a href='#' class='edit-icon' title='Edit'>&#9998;</a>
                </div>";
            }
        } else {
            echo "<p>No zookeepers found.</p>";
        }
        // Free result set
        $result->free();
        ?>
    </div>


    <div class="add-button-container">
        <button onclick="window.location.href='add_zookeep.php'" class="add-button">+</button>
    </div>
</body>
</html>
