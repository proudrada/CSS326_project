<?php
require_once('connect.php');
// Query to fetch zookeeper data
$query = "SELECT * FROM animal";
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
            <a href="zookeeper_ad.php">Zoo Keeper</a>   
            <a href="animal_ad.php">Animal</a>
            <a href="zone_ad.php">Zone</a>
            <a href="ingredient_ad.php">Ingredient</a>
            <a href="meal_ad.php">Meal</a>
        </nav>
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
                    <p>Age: <span contenteditable='true'>{$row['age']}</span></p>
                    <p>Zone: <span contenteditable='true'>{$row['Zone_name']}</span></p>
                    <a href='#' class='edit-icon' title='Edit'>&#9998;</a>
                </div>";
            }
        } else {
            echo "<p>No animals found.</p>";
        }
        ?>
    </div>

    
    <div class="add-button-container">
        <button onclick="window.location.href='add_ani.php'" class="add-button">+</button>
    </div>
</body>
</html>
