<?php
// Include the database connection file
require_once('connect.php');

// Start a session to manage user authentication
session_start();

// Check if the form has been submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user input
    $id = trim($_POST['id']); // Get the user/admin ID from the form
    $password = trim($_POST['password']); // Get the password from the form

    // Step 1: Check if the user is an admin
    $query_ad = "SELECT Ad_ID, Ad_Password FROM admin WHERE Ad_ID = ? AND Ad_Password = ?";
    $stmt_ad = $mysqli->prepare($query_ad); // Prepare the SQL statement
    $stmt_ad->bind_param("ss", $id, $password); // Bind user input to the query
    $stmt_ad->execute(); // Execute the query
    $result_ad = $stmt_ad->get_result(); // Get the result of the query

    // If an admin account matches the provided ID and password
    if ($result_ad->num_rows > 0) {
        $_SESSION['ADMIN_ID'] = $id; // Set session variable for admin
        header("Location: ZooKeeper_ad.php?name=admin"); // Redirect to the admin dashboard
        exit(); // Stop further execution
    }

    // Step 2: Check if the user is a zookeeper
    $query_zk = "SELECT ZK_ID, ZK_Password FROM zookeeper WHERE ZK_ID = ? AND ZK_Password = ?";
    $stmt_zk = $mysqli->prepare($query_zk); // Prepare the SQL statement
    $stmt_zk->bind_param("ss", $id, $password); // Bind user input to the query
    $stmt_zk->execute(); // Execute the query
    $result_zk = $stmt_zk->get_result(); // Get the result of the query

    // If a zookeeper account matches the provided ID and password
    if ($result_zk->num_rows > 0) {
        $_SESSION['ZK_ID'] = $id; // Set session variable for zookeeper
        header("Location: ZooKeeper_staff.php"); // Redirect to the zookeeper dashboard
        exit(); // Stop further execution
    }

    // Step 3: If neither admin nor zookeeper credentials match
    header("Location: homepage.php?error=invalid"); // Redirect back to homepage with an error
    exit(); // Stop further execution
} else {
    // If the request method is not POST, output a message
    echo "No data submitted.";
}
?>
