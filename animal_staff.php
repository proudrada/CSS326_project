<?php
// Start the session at the top of the script
session_start();

// Debug: Check if the session variable 'ZK_ID' is set
echo "<pre>";
var_dump($_SESSION);  // Display the entire session contents
echo "</pre>";

// Check if 'ZK_ID' exists in the session
if (!isset($_SESSION['ZK_ID'])) {
    // If ZK_ID is not found in the session, show an error message
    echo "Zookeeper ID not found. Please go back to the homepage.";
    exit();
} else {
    // If ZK_ID exists, store it in a variable
    $zookeeperID = $_SESSION['ZK_ID'];

    // Here you would connect to your database and fetch Zookeeper data
    // For example, assuming a connection `$conn` is already established:
    require_once('connect.php');

    // SQL query to fetch Zookeeper info based on the ZK_ID
    $sql_zookeeper = "SELECT * FROM zookeeper WHERE ZK_ID = ?";
    $stmt_zookeeper = $conn->prepare($sql_zookeeper);
    $stmt_zookeeper->bind_param("s", $zookeeperID);
    $stmt_zookeeper->execute();
    $result_zookeeper = $stmt_zookeeper->get_result();
    
    // If no Zookeeper found, show an error
    if ($result_zookeeper->num_rows === 0) {
        echo "Zookeeper not found.";
        exit();
    }

    // Fetch the Zookeeper data
    $zookeeper = $result_zookeeper->fetch_assoc();

    // SQL query to fetch animals managed by the Zookeeper
    $sql = "SELECT * FROM animal WHERE ZK_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $zookeeperID);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animals Managed by Zookeeper</title>
</head>
<body>
    <div class="banner">
        <h1>Himalayan Zoo of Mount Olympus and Mount Liangshan</h1>
        <nav>
            <a href="ZooKeeper_staff.php">Zoo Keeper</a>   
            <a href="animal_staff.php">Animal</a>
            <a href="zone_ad.php">Zone</a>
            <a href="ingredient_ad.php">Ingredient</a>
            <a href="meal_ad.php">Meal</a>
        </nav>
        <div class="admin-dropdown">
            <button class="admin-btn"><?= htmlspecialchars($zookeeper['ZKFName']) . "_" . htmlspecialchars($zookeeper['ZK_ID']); ?> ▼</button>
            <div class="dropdown-content">
                <a href="homepage.php">Log-out</a>
            </div>
        </div>
    </div>

    <div class="topic">
        <h1>Animal</h1>
    </div>

    <h1>Animals Under Zookeeper ID: <?php echo htmlspecialchars($zookeeperID); ?></h1>
    <div class="animal-container">
        <?php
        if ($result->num_rows > 0) {
            // Display animals managed by this Zookeeper
            while ($row = $result->fetch_assoc()) {
                echo "  <div class='animal-card'>
                            <button class='close-btn' title='Close'>X</button>
                            <h2>" . htmlspecialchars($row['A_name']) . "</h2>
                            <p><strong>Date of Birth:</strong> " . htmlspecialchars($row['ADate_of_birth']) . "</p>
                            <p><strong>Species:</strong> " . htmlspecialchars($row['Species']) . "</p>
                            <p><strong>Sex:</strong> " . htmlspecialchars($row['A_Sex']) . "</p>
                        </div>";
            }
        } else {
            echo "<p>No animals found for this Zookeeper ID.</p>";
        }

        $stmt->close();
        $stmt_zookeeper->close();
        $conn->close();
        ?>
    </div>

    <div class="add-button-container">
        <button onclick="window.location.href='form_add_ani.php'" class="add-button">+</button>
    </div>
</body>
</html>
