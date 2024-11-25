<?php
require_once('connect.php');
session_start();

// Initialize role variables and check for session variables
// $admin_code = isset($_SESSION['ADMIN_ID']) ? $_SESSION['ADMIN_ID'] : false;
// $zookeeper_code = isset($_SESSION['ZK_ID']) ? $_SESSION['ZK_ID'] : false;

$role_code = isset($_SESSION['role']) ? $_SESSION['role'] : false;

// Ensure both session variables don't exist simultaneously
// if ($admin_code && $zookeeper_code) {
//     $zookeeper_code = null; // let admin get priority
// }

// Initialize role results
// $ad_result = null;
// $zk_result = null;

// Check if admin is logged in
// if ($admin_code) {
//     $ad_query = $mysqli->query("SELECT * FROM admin WHERE Ad_ID = '$admin_code'");
//     if ($ad_query && $ad_query->num_rows > 0) {
//         // $ad_result = $ad_query->fetch_assoc();
//         $ad_result = $admin_code;
//     }
// }

// // Check if zookeeper is logged in
// if ($zookeeper_code) {
//     $zk_query = $mysqli->query("SELECT * FROM zookeeper WHERE ZK_ID = '$zookeeper_code'");
//     if ($zk_query && $zk_query->num_rows > 0) {
//         // $zk_result = $zk_query->fetch_assoc();
//         $zk_result = $zookeeper_code;
//     }
// }



// If no session is found for either, redirect to login page
// if (!$admin_code && !$zookeeper_code) {
//     header("Location: homepage.php"); // Redirect to login if not logged in
//     exit();
// }

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ingredient_id = $mysqli->real_escape_string(trim($_POST['ingredient_id']));
    $ingredient_type = $mysqli->real_escape_string(trim($_POST['ingredient_type']));
    $ingredient_amount = $mysqli->real_escape_string(trim($_POST['ingredient_amount']));
    $expiration_date = $mysqli->real_escape_string(trim($_POST['expiration_date']));

    // if (empty($ingredient_id) || empty($ingredient_type) || empty($ingredient_amount) || empty($expiration_date)) {
    //     echo "All fields are required.";
    //     exit();
    // }

    $query = "INSERT INTO ingredient (In_ID, In_type, In_amount, Expiration_date) 
                VALUES ('$ingredient_id', '$ingredient_type', '$ingredient_amount', '$expiration_date')";

    if ($mysqli->query($query) === TRUE) {
        // Redirect based on role
        if ($role_code == 'admin') {
            header("Location: ingredient_ad.php?message=success");
            exit();
        } elseif ($role_code == 'staff') {  
            header("Location: ingredient_staff.php?message=success");
            exit();
        } else {
            echo "User role not recognized.";
        }
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}
