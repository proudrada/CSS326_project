<?php
require('connect.php');

$code = isset($_SESSION['ZK_ID']) ? $_SESSION['ZK_ID'] : null;

// Fetch admin and zookeeper data
$zk_id = $mysqli->query("SELECT * FROM zookeeper");
$ad_id = $mysqli->query("SELECT * FROM admin");

$zk_result = $zk_id ? $zk_id->fetch_assoc() : null;
$ad_result = $ad_id ? $ad_id->fetch_assoc() : null;

// Check if the ingredient ID is provided via GET
if (isset($_GET['In_ID'])) {
    // Use prepared statements to avoid SQL injection
    $ingredient_id = $_GET['In_ID'];
    $stmt = $mysqli->prepare("DELETE FROM ingredient WHERE In_ID = ?");
    
    if ($stmt) {
        // Bind the parameter and execute the statement
        $stmt->bind_param("s", $ingredient_id);
        
        if ($stmt->execute()) {
            if ($code == $ad_result['Ad_ID']) {
                header("Location: ingredient_ad.php?message=success");
            } elseif ($code == $zk_result['ZK_ID']) {
                header("Location: ingredient_staff.php?message=success");
            }
        } else {
            // Display an error message if execution fails
            echo "Error executing query: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Display an error message if statement preparation fails
        echo "Error preparing query: " . $mysqli->error;
    }
} else {
    echo "No ingredient ID specified.";
}
?>
