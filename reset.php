<?php
// Start the session to track logged-in user information
session_start();

// Include the database connection file
require_once('connect.php');

// Get the logged-in Zookeeper's ID from the session
$code = $_SESSION['ZK_ID'];
$_SESSION['role'] = $_GET['role'];
$head = '';

// Fetch the Zookeeper's details from the database using their ID
$zk_query = $mysqli->query("SELECT * FROM zookeeper WHERE ZK_ID = '$code'");
$zookeeper = $zk_query->fetch_assoc(); // Convert the result to an associative array

// Handle the cancel button logic
if (isset($_POST['cancel'])) {
    $ad_query = $mysqli->query("SELECT * FROM admin WHERE Ad_ID = '$code'");
    $zk_query = $mysqli->query("SELECT * FROM zookeeper WHERE ZK_ID = '$code'");
    $zookeeper = $zk_query->fetch_assoc();

    if ($ad_query && $ad_query->num_rows > 0) {
        header("Location: ZooKeeper_ad.php");
    } elseif ($zk_query && $zk_query->num_rows > 0) {
        $head = 'ZooKeeper_staff.php';
        header("Location: ZooKeeper_staff.php");
    } else {
        $head = 'default_page.php';
        header("Location: homepage.php");
    }
    $_SESSION['head'] = $head;
}

// Handle the form submission for resetting the password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the new password and confirmation password from the form
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the two entered passwords match
    if ($password === $confirm_password) {
        // Hash the new password securely before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update the password in the database for the current Zookeeper
        $update_query = $mysqli->query("UPDATE zookeeper SET ZK_password = '$hashed_password' WHERE ZK_ID = '$code'");

        // Check if the update was successful
        if ($update_query) {
            $success_message = "Password updated successfully!";
        } else {
            $error_message = "Error updating password."; // Handle database update error
        }
    } else {
        $error_message = "Passwords do not match."; // Handle password mismatch error
    }
}

// Determine the redirect URL based on the user's role (admin or staff)
$role = $_GET['role'];
$redirect_url = 'homepage.php';

if ($role == 'admin') {
    $redirect_url = 'ZooKeeper_ad.php';
} elseif ($role == 'staff') {
    $redirect_url = 'ZooKeeper_staff.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style_add_meal.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="container">
        <h1>Reset Password</h1>
        
        <!-- Display success or error messages if available -->
        <?php if (isset($success_message)) echo "<p class='success'>$success_message</p>"; ?>
        <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>
        
        <!-- Form for resetting the password -->
        <form action="" method="POST">
            <!-- Display the Zookeeper's ID (read-only) -->
            <label for="zk_id">Zookeeper ID</label>
            <input type="text" id="zk_id" name="zk_id" value="<?= htmlspecialchars($zookeeper['ZK_ID']) ?>" readonly>

            <!-- Input field for the new password -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <!-- Input field to confirm the new password -->
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <!-- Buttons to submit the form or cancel and go back -->
            <div class="buttons">
                <button type="submit" class="add-button">Reset Password</button>
                <button type="button" onclick="window.location.href='Zookeeper_staff.php'" class="cancel-button">Close</button>
            </div>
        </form>
    </div>
</body>
</html>
