<?php
require('connect.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input values
    $zone_name = $mysqli->real_escape_string($_POST['name']);
    $zone_avg_temp = $mysqli->real_escape_string($_POST['avg_temp']);
    $zone_habitat = $mysqli->real_escape_string($_POST['habitat']);
    $zone_environment = $mysqli->real_escape_string($_POST['environment']);
    $zone_humidity = $mysqli->real_escape_string($_POST['humidity']);

    // Check if the zone exists
    $result = $mysqli->query("SELECT * FROM zone WHERE Zone_name = '$zone_name'");
    if (!$result || $result->num_rows === 0) {
        echo "Zone not found.";
        exit();
    }
    $existing_row = $result->fetch_assoc();

    // Handle image upload
    $image_path = $existing_row['image_path']; // Default to existing image
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $image_tmp_name = $_FILES['profile_image']['tmp_name'];
        $image_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $image_path = 'img/' . $zone_name . '.' . $image_extension;

        // Move the uploaded file to the designated folder
        if (!move_uploaded_file($image_tmp_name, $image_path)) {
            echo "Error uploading image.";
            exit();
        }
    }

    // Update existing record
    $stmt = $mysqli->prepare(
        "UPDATE zone SET Avg_temp=?, Habitat=?, Environment=?, Relative_humidity=?, image_path=? WHERE Zone_name=?"
    );
    $stmt->bind_param("sssiss", $zone_avg_temp,  $zone_habitat, $zone_environment,  $zone_humidity, $image_path, $zone_name);

    // Execute the query
    if ($stmt && $stmt->execute()) {
        header("Location: zone_ad.php?message=success");
        exit();
    } else {
        echo "Error executing query: " . ($stmt ? $stmt->error : $mysqli->error);
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}
?>
