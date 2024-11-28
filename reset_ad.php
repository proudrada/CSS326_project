<?php
// Start the session to track logged-in user information
session_start();

// Include the database connection file
require_once('connect.php');

// Check if Ad_ID is set in the session
$code = $_SESSION['ADMIN_ID'] ?? null;
if (!$code) {
    die("Ad_ID is not set in the session."); // Handle missing Ad_ID
}

// Fetch the Admin's details from the database using their ID
$ad_query = $mysqli->prepare("SELECT * FROM admin WHERE Ad_ID = ?");
$ad_query->bind_param("s", $code);
$ad_query->execute();
$admin_result = $ad_query->get_result();
$admin = $admin_result->fetch_assoc();

if (!$admin) {
    die("Admin record not found."); // Handle missing admin record
}

// Handle the form submission for resetting the password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the new password and confirmation password from the form
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Check if the two entered passwords match
    if ($password === $confirm_password) {
        // Hash the new password securely before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update the password in the database for the current Admin
        $update_query = $mysqli->prepare("UPDATE admin SET Ad_Password = ? WHERE Ad_ID = ?");
        $update_query->bind_param("ss", $hashed_password, $code);

        if ($update_query->execute()) {
            $success_message = "Password updated successfully!";
        } else {
            $error_message = "Error updating password."; // Handle database update error
        }
    } else {
        $error_message = "Passwords do not match."; // Handle password mismatch error
    }
}

// Determine the redirect URL for the cancel button
$redirect_url = 'homepage.php';
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
            <!-- Display the Admin's ID (read-only) -->
            <label for="ad_id">Admin ID</label>
            <input type="text" id="ad_id" name="ad_id" value="<?= htmlspecialchars($admin['Ad_ID']) ?>" readonly>

            <!-- Input field for the new password -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <!-- Input field to confirm the new password -->
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <!-- Buttons to submit the form or cancel and go back -->
            <div class="buttons">
            <button type="submit" class="add-button">Reset Password</button>
            <button type="button" onclick="window.location.href='Zookeeper_ad.php'" class="cancel-button">Close</button>
            </div>
        </form>
    </div>
</body>
</html>
