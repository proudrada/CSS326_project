<?php
// Include the database connection file to establish a connection to the database
require('connect.php');

// Check if the form was submitted via the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all form data is captured and sanitized to prevent SQL injection
    $zk_id = $mysqli->real_escape_string($_POST['zookeeper_id']);
    $zk_fname = $mysqli->real_escape_string($_POST['f_name']);
    $zk_lname = $mysqli->real_escape_string($_POST['l_name']);
    $z_date_of_birth = $mysqli->real_escape_string($_POST['dob']);
    $z_sex = $mysqli->real_escape_string($_POST['sex']);
    $salary = $mysqli->real_escape_string($_POST['salary']);
    $zk_password = $mysqli->real_escape_string($_POST['password']);
    $zk_email = $mysqli->real_escape_string($_POST['email']);

    // Hash the password before storing it to ensure secure storage
    $hashed_password = password_hash($zk_password, PASSWORD_DEFAULT);

    // Handle image upload if the user has uploaded an image
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        // Get the temporary file name and file extension of the uploaded image
        $image_tmp_name = $_FILES['profile_image']['tmp_name'];
        $image_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        
        // Set the path for saving the uploaded image in the 'img' directory
        $image_path = 'img/' . $zk_fname . '.' . $image_extension;

        // Move the uploaded image file to the specified path
        if (!move_uploaded_file($image_tmp_name, $image_path)) {
            // If the image upload fails, display an error and exit the script
            echo "Error uploading image.";
            exit();
        }
    } else {
        // If no image is uploaded, set a default image
        $image_path = 'img/default-image.jpg';
    }

    // Prepare the SQL query to insert the new zookeeper details into the database
    $stmt = $mysqli->prepare("INSERT INTO zookeeper (ZK_ID, ZKFName, ZKLName, ZDate_of_birth, ZSex, Salary, image_path, ZK_Password, zk_email) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Check if the prepared statement was successful
    if ($stmt) {
        // Bind the form data to the prepared statement, including the hashed password
        $stmt->bind_param("sssssisss", $zk_id, $zk_fname, $zk_lname, $z_date_of_birth, $z_sex, $salary, $image_path, $hashed_password, $zk_email);

        // Execute the prepared statement and check if the query was successful
        if ($stmt->execute()) {
            // If successful, redirect to the zookeeper management page with a success message
            header("Location: zookeeper_ad.php?message=added");
            exit();
        } else {
            // If the query execution fails, display the error message
            echo "Error executing query: " . $stmt->error;
        }

        // Close the prepared statement after execution
        $stmt->close();
    } else {
        // If the prepared statement failed to prepare, display the error message
        echo "Error preparing query: " . $mysqli->error;
    }
} else {
    // If the form was not submitted via POST, display an invalid request message
    echo "Invalid request method.";
}
?>
