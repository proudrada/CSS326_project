<?php
require_once('connect.php');
// Query to fetch zookeeper data
$query = "SELECT * FROM animal";
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
    <title>Animal Dashboard</title>
    <link rel="stylesheet" href="style_animal.css">
</head>
<body>
    <?php
    // Include a common header or navigation file if needed
    ?>
    <!-- Banner with Navigation Links -->
    <nav>
        <a href="zookeeper_ad.php">Zoo Keeper</a>
        <a href="animal_ad.php" class="animal"><u>Animal</u></a>
        <a href="zone_ad.php">Zone</a>
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
                    <a href='delete_ani.php?A_ID={$row['A_ID']}' class='close-btn' title='Close'>X</a>
                    <img src='{$row['image_path']}' alt='{$row['name']}' class='profile-img'>
                    <h2>{$row['A_name']}</h2>
                    <p>Animal ID: {$row['A_ID']}</p>
                    <p>Date of birth: {$row['ADate_of_birth']}</p>
                    <p>Species: {$row['Species']}</p>
                    <p>Sex: {$row['A_Sex']}</p>
                    <p>Zookeeper ID: {$row['ZK_ID']}</p>
                    <p>Age: $age</p>
                    <p>Zone: {$row['Zone_name']}</p>
                    <a href='form_edit_ani.php?A_ID={$row['A_ID']}' class='edit-icon' title='Edit'>&#9998;</a>
                </div>";
            }
        } else {
            echo "<p>No animals found.</p>";
        }
        ?>
    </div>

    
    <div class="add-button-container">
        <button onclick="window.location.href='form_add_ani.php'" class="add-button">+</button>
    </div>
</body>
</html>
