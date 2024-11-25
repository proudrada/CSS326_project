<?php
require_once('connect.php');
session_start();

// Receive the code from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = trim($_POST['code']); // Trim white spaces

    // Check if the code is in the admin table
    $query_ad = "SELECT Ad_ID FROM admin WHERE Ad_ID = ?";
    $stmt_ad = $mysqli->prepare($query_ad);
    $stmt_ad->bind_param("s", $code);
    $stmt_ad->execute();
    $result_ad = $stmt_ad->get_result();

    // Check if the code is in the zookeeper table
    $query_zk = "SELECT ZK_ID FROM zookeeper WHERE ZK_ID = ?";
    $stmt_zk = $mysqli->prepare($query_zk);
    $stmt_zk->bind_param("s", $code);
    $stmt_zk->execute();
    $result_zk = $stmt_zk->get_result();

    // If the code is found in the admin table
    if ($result_ad->num_rows > 0) {
        $_SESSION['ADMIN_ID'] = $code; // Set session for admin
        header("Location: ZooKeeper_ad.php?name=admin");
        exit();
    }
    // If the code is found in the zookeeper table
    elseif ($result_zk->num_rows > 0) {
        $_SESSION['ZK_ID'] = $code; // Set session for zookeeper
        header("Location: ZooKeeper_staff.php");
        exit();
    }
    // If the code is empty or not found
    elseif (empty($code)) {
        header("Location: homepage.php?error=invalid");
        exit();
    }
    // If the code is invalid
    else {
        header("Location: homepage.php?error=invalid");
        exit();
    }
} else {
    echo "No data submitted.";
}
?>
