<?php
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input values
    $zk_id = $mysqli->real_escape_string($_POST['zookeeper_id']);
    $zk_fname = $mysqli->real_escape_string($_POST['f_name']);
    $zk_lname = $mysqli->real_escape_string($_POST['l_name']);
    $z_date_of_birth = $mysqli->real_escape_string($_POST['dob']);
    $z_sex = $mysqli->real_escape_string($_POST['sex']);
    $salary = $mysqli->real_escape_string($_POST['salary']);

    // Check if the zookeeper already exists (determine insert or update)
    $result = $mysqli->query("SELECT * FROM zookeeper WHERE ZK_ID = '$zk_id'");
    
    // Handle image upload
    $image_path = '';
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

    if ($result->num_rows > 0) {
        // Update existing record
        if ($image_path) {
            // Update including image
            $stmt = $mysqli->prepare("UPDATE zookeeper SET ZKFName=?, ZKLName=?, ZDate_of_birth=?, ZSex=?, Salary=?, image_path=? WHERE ZK_ID=?");
            $stmt->bind_param("ssssiss", $zk_fname, $zk_lname, $z_date_of_birth, $z_sex, $salary, $image_path, $zk_id);
        } else {
            // Update without changing the image
            $stmt = $mysqli->prepare("UPDATE zookeeper SET ZKFName=?, ZKLName=?, ZDate_of_birth=?, ZSex=?, Salary=? WHERE ZK_ID=?");
            $stmt->bind_param("sssssi", $zk_fname, $zk_lname, $z_date_of_birth, $z_sex, $salary, $zk_id);
        }
    } else {
        // Insert new record if zookeeper does not exist
        $stmt = $mysqli->prepare("INSERT INTO zookeeper (ZK_ID, ZKFName, ZKLName, ZDate_of_birth, ZSex, Salary, image_path) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $zk_id, $zk_fname, $zk_lname, $z_date_of_birth, $z_sex, $salary, $image_path);
    }

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
