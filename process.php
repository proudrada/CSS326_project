<?php
// Include the database connection file
require_once('connect.php');

// Start a session to manage user authentication
session_start();

// Check if the form has been submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user input
    $id = trim($_POST['id']);        // Get the user/admin ID from the form input
    $password = trim($_POST['password']); // Get the password from the form input

    // Step 1: Check if the user is an admin
    $query_ad = "SELECT Ad_ID, Ad_Password FROM admin WHERE Ad_ID = ?";
    $stmt_ad = $mysqli->prepare($query_ad); // Prepare the SQL statement for admin login
    $stmt_ad->bind_param("s", $id);         // Bind the ID to the query
    $stmt_ad->execute();                    // Execute the query
    $result_ad = $stmt_ad->get_result();    // Fetch the query result

    if ($result_ad->num_rows > 0) {
        // Fetch the admin record from the database
        $admin = $result_ad->fetch_assoc();
        
        // Compare plain-text password (not recommended; consider hashing)
        if ($password === $admin['Ad_Password']) {
            $_SESSION['ADMIN_ID'] = $id;  // Store the admin ID in the session
            header("Location: ZooKeeper_ad.php?name=admin"); // Redirect to the admin dashboard
            exit(); // Stop further execution
        }
    }

    // Step 2: Check if the user is a zookeeper
    $query_zk = "SELECT ZK_ID, ZK_Password FROM zookeeper WHERE ZK_ID = ?";
    $stmt_zk = $mysqli->prepare($query_zk); // Prepare the SQL statement for zookeeper login
    $stmt_zk->bind_param("s", $id);         // Bind the ID to the query
    $stmt_zk->execute();                    // Execute the query
    $result_zk = $stmt_zk->get_result();    // Fetch the query result

    if ($result_zk->num_rows > 0) {
        // Fetch the zookeeper record from the database
        $zookeeper = $result_zk->fetch_assoc();

        // Verify the provided password against the hashed password in the database
        if (password_verify($password, $zookeeper['ZK_Password'])) { //*******/
            $_SESSION['ZK_ID'] = $id;  // Store the zookeeper ID in the session
            header("Location: ZooKeeper_staff.php"); // Redirect to the zookeeper dashboard
            exit(); // Stop further execution
        }
    }

    // Step 3: If neither admin nor zookeeper credentials match
    header("Location: homepage.php?error=invalid"); // Redirect back to homepage with an error message
    exit(); // Stop further execution
}
?>
