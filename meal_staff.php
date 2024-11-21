<?php
require_once('connect.php');
session_start();

if (!isset($_SESSION['ZK_ID'])) {
    header("Location: homepage.php?error=not_logged_in");
    exit();
}

$zookeeperID = $_SESSION['ZK_ID'];

// Query to fetch zookeeper data
$query = "SELECT * FROM meal,animal WHERE animal.A_ID = meal.A_ID AND ZK_ID = '$zookeeperID'";
// $query = "SELECT * FROM animal WHERE ZK_ID = '$zookeeperID'";
$query_zk = "SELECT * FROM zookeeper WHERE ZK_ID = '$zookeeperID'";
// Check if query execution was successful
$result = $mysqli->query($query);
if (!$result) {
    die("Query failed: " . $mysqli->error);
}
// $result_ani = $mysqli->query($query_ani);
// if (!$result_ani) {
//     die("Query failed: " . $mysqli->error);
// }
$result_zk = $mysqli->query($query_zk);
if (!$result_zk) {
    die("Query failed: " . $mysqli->error);
}
// $animal = $result_ani->fetch_assoc();
$zookeeper = $result_zk->fetch_assoc();
?>

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
                <th>Action</th></tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['Meal_code']}</td>
                            <td>{$row['A_ID']}</td>
                            <td>{$row['In_ID']}</td>
                            <td>{$row['Date']}</td>
                            <td>{$row['Time']}</td>
                            <td>
                                <a href='delete_meal.php?Meal_code={$row['Meal_code']}' class='delete-button'>Delete</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No ingredients found.</td></tr>";
            }
            ?>
        </table>
        <div class="add-button-container">
                <button onclick="window.location.href='form_add_meal_staff.php'" class="add-button">+</button>
        </div>            
           
    </div>

</body>
</html>
