<?php
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all form data is captured
    $zk_id = $mysqli->real_escape_string($_POST['zookeeper_id']);
    $zk_fname = $mysqli->real_escape_string($_POST['f_name']);
    $zk_lname = $mysqli->real_escape_string($_POST['l_name']);
    $z_date_of_birth = $mysqli->real_escape_string($_POST['dob']);
    $z_sex = $mysqli->real_escape_string($_POST['sex']);
    $salary = $mysqli->real_escape_string($_POST['salary']);

    // Image upload handling
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
    else {
        // If no image is uploaded, set a default image
        $image_path = 'img/default-image.jpg';
    }

    // Prepare the SQL query
    $stmt = $mysqli->prepare("UPDATE INTO zookeeper (ZK_ID, ZKFName, ZKLName, ZDate_of_birth, ZSex, Salary, image_path) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("sssssis", $zk_id, $zk_fname, $zk_lname, $z_date_of_birth, $z_sex, $salary, $image_path);

        if ($stmt->execute()) {
            // Redirect to zookeeper management page with success message
            header("Location: zookeeper_ad.php?message=added");
            exit();
        } else {
            echo "Error executing query: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing query: " . $mysqli->error;
    }
} 
else {
    echo "Invalid request method.";
}
?>
