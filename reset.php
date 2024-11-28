<?php
// Start the session
session_start();
require_once('connect.php');

// Ensure the user is logged in
// if (!isset($_SESSION['ZK_ID'])) {
//     header("Location: homepage.php"); // Redirect if not logged in
//     exit();
// }

$code = $_SESSION['ZK_ID']; // Retrieve the logged-in Zookeeper's ID

// Handle the form submission for resetting the password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Use a prepared statement to prevent SQL injection
        $stmt = $mysqli->prepare("UPDATE zookeeper SET ZK_password = ? WHERE ZK_ID = ?");
        $stmt->bind_param("si", $hashed_password, $code);

        if ($stmt->execute()) {
            // Redirect after a successful password update
            header("Location: homepage.php");
            exit();
        } else {
            $error_message = "Error updating password.";
        }
        $stmt->close(); // Close the statement
    } else {
        $error_message = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style_add_meal.css">
</head>
<body>
    <div class="container">
        <h1>Reset Password</h1>
        <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>
        <form action="" method="POST">
            <label for="zk_id">ID</label>
            <input type="text" id="zk_id" name="zk_id" value="<?= htmlspecialchars($code) ?>" readonly>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <div class="buttons">
                <button type="submit" class="add-button">Reset Password</button>
                <button type="button" onclick="window.location.href='ZooKeeper_staff.php'" class="cancel-button">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>
