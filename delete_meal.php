<?php
require('connect.php');
session_start();

// Check if session variable exists
$code = isset($_SESSION['ZK_ID']) ? $_SESSION['ZK_ID'] : null;

// Fetch admin and zookeeper data
$zk_id = $mysqli->query("SELECT * FROM zookeeper");
$ad_id = $mysqli->query("SELECT * FROM admin");

$zk_result = $zk_id ? $zk_id->fetch_assoc() : null;
$ad_result = $ad_id ? $ad_id->fetch_assoc() : null;

// Check if the Meal_code is provided via GET
if (isset($_GET['Meal_code'])) {
    $meal_code = $_GET['Meal_code'];
    $stmt = $mysqli->prepare("DELETE FROM meal WHERE Meal_code = ?");

    if ($stmt) {
        // Bind the parameter and execute the statement
        $stmt->bind_param("s", $meal_code);

        if ($stmt->execute()) {
            // Redirect back with a success message
            if ($ad_result && $zk_result) {
                if ($code == $ad_result['Ad_ID']) {
                    header("Location: meal_ad.php?message=success");
                } elseif ($code == $zk_result['ZK_ID']) {
                    header("Location: meal_staff.php?message=success");
                }
            }
            exit();
        } else {
            echo "Error executing query: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing query: " . $mysqli->error;
    }
} else {
    echo "No meal code specified.";
}
?>
