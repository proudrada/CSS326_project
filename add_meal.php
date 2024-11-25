<?php
require_once('connect.php');
session_start();

// Check if session variable exists
$role_code = isset($_SESSION['role']) ? $_SESSION['role'] : false;

// Fetch admin and zookeeper data
$zk_id = $mysqli->query("SELECT * FROM zookeeper");
$ad_id = $mysqli->query("SELECT * FROM admin");

$zk_result = $zk_id ? $zk_id->fetch_assoc() : null;
$ad_result = $ad_id ? $ad_id->fetch_assoc() : null;

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input values
    $meal_code = $mysqli->real_escape_string($_POST['meal_code']);
    $animal_id = $mysqli->real_escape_string($_POST['Animal_ID']);
    $ingredient_id = $mysqli->real_escape_string($_POST['Ingredient_ID']);
    $date = $mysqli->real_escape_string($_POST['Date']);
    $time = $mysqli->real_escape_string($_POST['Time']);

    // SQL query to insert data
    $query = "INSERT INTO meal (Meal_code, A_ID, In_ID, Date, Time) 
              VALUES ('$meal_code', '$animal_id', '$ingredient_id', '$date', '$time')";

    // Execute the query
    if ($mysqli->query($query) === TRUE) {
        // Redirect based on role
        if ($role_code == 'admin') {
            header("Location: meal_ad.php?message=success");
            exit();
        } elseif ($role_code == 'staff') {  
            header("Location: meal_staff.php?message=success");
            exit();
        } else {
            echo "User role not recognized.";
        }
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    } 
}
?>
