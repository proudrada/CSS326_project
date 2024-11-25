<?php
require_once('connect.php');
// Query to fetch zookeeper data
$query = "SELECT * FROM zookeeper";
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
    <link rel="stylesheet" href="style_ZooKeep.css">
</head>
<body>
    <nav>
        <a href="zookeeper_ad.php" class="zk"><u>Zoo Keeper</u></a>
        <a href="animal_ad.php">Animal</a>
        <a href="zone_ad.php">Zone</a>
        <a href="ingredient_ad.php">Ingredient</a>
        <a href="meal_ad.php">Meal</a>
        <!-- Admin Dropdown -->
        <div class="admin-dropdown">
            <button class="admin-btn"><?= $admin['Ad_name']; ?>▼</button>
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
        <h1>Zookeeper</h1>
    </div>

    <!-- Cards Container -->
    <div class="cards-container">
        <?php
        if ($result->num_rows > 0) {
            // Loop through each zookeeper
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
                $zookeeper_id = $row['ZK_ID'];

                // Query to fetch animals assigned to this zookeeper
                $query_animal = "SELECT A_ID FROM animal WHERE ZK_ID = ?";
                $stmt_animal = $mysqli->prepare($query_animal);
                $stmt_animal->bind_param("s", $zookeeper_id);
                $stmt_animal->execute();
                $result_animal = $stmt_animal->get_result();

                // Initialize animal ID array
                $animal_ids = [];
                while ($animal_row = $result_animal->fetch_assoc()) {
                    $animal_ids[] = $animal_row['A_ID'];  // Store animal IDs
                }
                $animal_ids_str = implode(', ', $animal_ids);  // Convert array to comma-separated string

                echo "
                <div class='card'>
                    <a href='delete_zookeep.php?ZK_ID={$row['ZK_ID']}' class='close-btn' title='Close'>X</a> 
                    <img src='{$row['image_path']}' alt='{$row['ZKFName']}' class='profile-img'>
                    <h2>{$fullName}</h2>
                    <p>Zookeeper ID: <span contenteditable='true'>{$row['ZK_ID']}</span></p>
                    <p>Date of birth: <span contenteditable='true'>{$row['ZDate_of_birth']}</span></p>
                    <p>Sex: <span contenteditable='true'>{$row['ZSex']}</span></p>
                    <p>Salary: <span contenteditable='true'>\${$row['Salary']}</span></p>
                    <p>Animal ID(s): <span contenteditable='true'>{$animal_ids_str}</span></p>  <!-- Display Animal IDs -->
                    <p>Age: <span contenteditable='true'>{$age}</span></p>
                    <a href='from_edit_zookeep.php?ZK_ID={$row['ZK_ID']}' class='edit-icon' title='Edit'>&#9998;</a>
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
        <button onclick="window.location.href='form_add_zookeep.php'" class="add-button">+</button>
    </div>
</body>
</html>
