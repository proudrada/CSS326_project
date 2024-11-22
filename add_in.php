<?php
require_once('connect.php');
session_start();

$code = isset($_SESSION['ZK_ID']) ? $_SESSION['ZK_ID'] : null;

$zk_id = $mysqli->query("SELECT * FROM zookeeper");
$ad_id = $mysqli->query("SELECT * FROM admin");

$zk_result = $zk_id ? $zk_id->fetch_assoc() : null;
$ad_result = $ad_id ? $ad_id->fetch_assoc() : null;

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
        if ($ad_result && $zk_result) {
            if ($code == $ad_result['Ad_ID']) {
                header("Location: ingredient_ad.php?message=success");
            } elseif ($code == $zk_result['ZK_ID']) {
                header("Location: ingredient_staff.php?message=success");
            }
        }
        exit();
    } else {
        // Display an error message
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}
?>
