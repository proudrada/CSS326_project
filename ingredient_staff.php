<?php
require_once('connect.php');
// Query to fetch zookeeper data
$query = "SELECT * FROM ingredient";
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
    <title>Ingredient Management</title>
    <link rel="stylesheet" href="style_ingredient.css">
</head>
<body>
    <!-- Banner with Navigation Links -->
    <div class="banner">
        <h1>Himalayan Zoo of Mount Olympus and Mount Liangshan</h1>
        <nav>
            <a href="zookeeper_staff.php">Zoo Keeper</a>
            <a href="animal_staff.php">Animal</a>
            <a href="zone_staff.php">Zone</a>
            <a href="ingredient_staff.php">Ingredient</a>
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
        <h1>Ingredient</h1>
    </div>

    <!-- Ingredient Table -->
    <div class="content">
        <table>
            <tr class="head">
                <th>Ingredient ID</th>
                <th>Ingredient Type</th>
                <th>Ingredient Amount</th>
                <th>Expiration Date</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['In_ID']}</td>
                            <td>{$row['In_type']}</td>
                            <td>{$row['In_amount']} kg</td>
                            <td>{$row['Expiration_date']}</td>
                            <td>
                                <a href='delete_in.php?In_ID={$row['In_ID']}' class='delete-button'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No ingredients found.</td></tr>";
            }
            ?>
        </table>

        <div class="add-button-container">
            <button onclick="window.location.href='form_add_in.php'" class="add-button">+</button>
        </div>
    </div>
</body>
</html>
