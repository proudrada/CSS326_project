<?php
require('connect.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input values
    $zk_id = $mysqli->real_escape_string($_POST['zookeeper_id']);
    $zk_fname = $mysqli->real_escape_string($_POST['f_name']);
    $zk_lname = $mysqli->real_escape_string($_POST['l_name']);
    $z_date_of_birth = $mysqli->real_escape_string($_POST['dob']);
    $z_sex = $mysqli->real_escape_string($_POST['sex']);
    $salary = $mysqli->real_escape_string($_POST['salary']);
    $zk_email = $mysqli->real_escape_string($_POST['zk_email']);

    // Check if the zookeeper exists
    $result = $mysqli->query("SELECT * FROM zookeeper WHERE ZK_ID = '$zk_id'");
    if (!$result || $result->num_rows === 0) {
        echo "Zookeeper not found.";
        exit();
    }
    $existing_row = $result->fetch_assoc();

    // Handle image upload
    $image_path = $existing_row['image_path']; // Default to existing image
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $image_tmp_name = $_FILES['profile_image']['tmp_name'];
        $image_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $image_path = 'img/' . $zk_fname . '.' . $image_extension;

        // Move the uploaded file to the designated folder
        if (!move_uploaded_file($image_tmp_name, $image_path)) {
            echo "Error uploading image.";
            exit();
        }
    }

    // Update existing record
    $stmt = $mysqli->prepare(
        "UPDATE zookeeper SET ZKFName=?, ZKLName=?, ZDate_of_birth=?, ZSex=?, Salary=?, image_path=?, zk_email=? WHERE ZK_ID=?"
    );
    $stmt->bind_param("ssssisss", $zk_fname, $zk_lname, $z_date_of_birth, $z_sex, $salary, $image_path, $zk_email, $zk_id);

    // Execute the query
    if ($stmt && $stmt->execute()) {
        header("Location: zookeeper_ad.php?message=success");
        exit();
    } else {
        echo "Error executing query: " . ($stmt ? $stmt->error : $mysqli->error);
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}
?>
