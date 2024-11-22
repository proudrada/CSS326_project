<?php
require_once('connect.php');

// SQL query to fetch joined data from animal, zookeeper, and zone tables
$query = "SELECT zookeeper.ZKFName AS zookeeper_name,
                 animal.A_name AS animal_name,
                 animal.species,
                 zone.Zone_name,
                 zone.Avg_temp,
                 zone.Habitat,
                 zone.Environment,
                 zone.Relative_humidity
          FROM animal, 
          JOIN zookeeper ON animal.ZK_ID = zookeeper.ZK_ID
          JOIN zone ON animal.Zone_name = zone.Zone_name";

// Execute the query
$result = $mysqli->query($query);

// Check if query execution was successful
if (!$result) {
    die("Query failed: " . $mysqli->error);
}

// Fetch the results and display
while ($row = $result->fetch_assoc()) {
    echo "Zookeeper: " . $row['zookeeper_name'] . "<br>";
    echo "Animal Name: " . $row['animal_name'] . "<br>";
    echo "Species: " . $row['species'] . "<br>";
    echo "Zone: " . $row['zone_name'] . "<br>";
    echo "Average Temperature: " . $row['avg_temp'] . "°C<br>";
    echo "Habitat: " . $row['habitat'] . "<br>";
    echo "Environment: " . $row['environment'] . "<br>";
    echo "Humidity: " . $row['humidity'] . "%<br><br>";
}

// Close the connection
$mysqli->close();
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
    <div class="banner">
        <h1>Himalayan Zoo of Mount Olympus and Mount Liangshan</h1>
        <nav>
            <a href="ZooKeeper_staff.php">Zoo Keeper</a>
            <a href="animal_staff.php">Animal</a> 
            <a href="zone_staff.php">Zone</a>   
            <a href="ingredient_staff.php">Ingredient</a> <!--waiting for ingredient_staff page -->
            <a href="meal_staff.php">Meal</a> <!--waiting for meal_staff page -->
        </nav>
        <div class="staff-dropdown">
            <button class="staff-btn"><?= $zookeeper['staff _name']; ?>▼</button>
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
