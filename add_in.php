<?php
require_once('connect.php');
session_start();

$code = isset($_SESSION['ZK_ID']) ? $_SESSION['ZK_ID'] : null;

// Check if $code exists before querying
if ($code) {
    // Check if user is an admin
    $ad_query = $mysqli->query("SELECT * FROM admin WHERE Ad_ID = '$code'");
    if ($ad_query && $ad_query->num_rows > 0) {
        $ad_result = $ad_query->fetch_assoc();
    } else {
        $ad_result = null;
    }

    // Check if user is a zookeeper only if not detected as admin
    if (!$ad_result) {
        $zk_query = $mysqli->query("SELECT * FROM zookeeper WHERE ZK_ID = '$code'");
        $zk_result = ($zk_query && $zk_query->num_rows > 0) ? $zk_query->fetch_assoc() : null;
    } else {
        $zk_result = null;
    }
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input values
    $ingredient_id = $mysqli->real_escape_string($_POST['ingredient_id']);
    $ingredient_type = $mysqli->real_escape_string($_POST['ingredient_type']);
    $ingredient_amount = $mysqli->real_escape_string($_POST['ingredient_amount']);
    $expiration_date = $mysqli->real_escape_string($_POST['expiration_date']);

    // SQL query to insert the data into the ingredient table
    $query = "INSERT INTO ingredient (In_ID, In_type, In_amount, Expiration_date) 
              VALUES ('$ingredient_id', '$ingredient_type', '$ingredient_amount', '$expiration_date')";

    // Execute the query
    if ($mysqli->query($query) === TRUE) {
        if ($ad_result) { // Admin role detected
            header("Location: ingredient_ad.php?message=success");
            exit();
        } elseif ($zk_result) { // Zookeeper role detected
            header("Location: ingredient_staff.php?message=success");
            exit();
        }
    } else {
        // Display an error message
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}
?>
