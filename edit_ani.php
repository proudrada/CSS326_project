<?php
require('connect.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input values
    $a_id = $mysqli->real_escape_string($_POST['animal_id']); 
    $a_name = $mysqli->real_escape_string($_POST['animal_name']);
    $a_sex = $mysqli->real_escape_string($_POST['sex']);
    $a_date_of_birth = $mysqli->real_escape_string($_POST['dob']);   
    $species = $mysqli->real_escape_string($_POST['species']);
    $zk_id = $mysqli->real_escape_string($_POST['zookeeper_id']);
    $zone_name = $mysqli->real_escape_string($_POST['zone_name']); // Corrected the variable name to match

    // Check if the zookeeper exists
    $result = $mysqli->query("SELECT * FROM animal WHERE A_ID = '$a_id'");
    if (!$result || $result->num_rows === 0) {
        echo "Animal not found.";
        exit();
    }
    $existing_row = $result->fetch_assoc();

    // Handle image upload
    $image_path = $existing_row['image_path']; // Default to existing image
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $image_tmp_name = $_FILES['profile_image']['tmp_name'];
        $image_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $image_path = 'img/' . $a_name . '.' . $image_extension;

        // Move the uploaded file to the designated folder
        if (!move_uploaded_file($image_tmp_name, $image_path)) {
            echo "Error uploading image.";
            exit();
        }
    }

    // Update existing record
    $stmt = $mysqli->prepare(
        "UPDATE animal SET A_name=?, A_Sex=?, ADate_of_birth=?, Species=?, ZK_ID=?, Zone_name=?, image_path=? WHERE A_ID=?"
    );
    $stmt->bind_param("ssssssss", $a_name, $a_sex, $a_date_of_birth, $species, $zk_id, $zone_name, $image_path, $a_id);
    
    // Execute the query
    if ($stmt && $stmt->execute()) {
        header("Location: animal_ad.php?message=success");
        exit();
    } else {
        echo "Error executing query: " . ($stmt ? $stmt->error : $mysqli->error);
    }

    $stmt->close();
} 
else {
    echo "Invalid request method.";
}
?>
