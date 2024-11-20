<?php
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all form data is captured
    $a_id = $mysqli->real_escape_string($_POST['animal_id']); // Corrected name to animal_id
    $a_name = $mysqli->real_escape_string($_POST['animal_name']);
    $a_sex = $mysqli->real_escape_string($_POST['sex']);
    $a_date_of_birth = $mysqli->real_escape_string($_POST['dob']);   
    $species = $mysqli->real_escape_string($_POST['species']);
    $zk_id = $mysqli->real_escape_string($_POST['zookeeper_id']);
    $zone_name = $mysqli->real_escape_string($_POST['zone_name']); // Corrected the variable name to match

    // Image upload handling
    if (isset($_FILES['animal_image']) && $_FILES['animal_image']['error'] === 0) {
        $image_tmp_name = $_FILES['animal_image']['tmp_name'];
        $image_extension = pathinfo($_FILES['animal_image']['name'], PATHINFO_EXTENSION);
        $image_path = 'img/' . $a_id . '.' . $image_extension;

        // Move the uploaded file to the designated folder
        if (!move_uploaded_file($image_tmp_name, $image_path)) {
            echo "Error uploading image.";
            exit();
        }
    } else {
        // If no image is uploaded, set a default image
        $image_path = 'img/default-image.jpg';
    }

    // Prepare the SQL query
    $stmt = $mysqli->prepare("INSERT INTO animal (A_ID, A_name, A_Sex, ADate_of_birth, Species, ZK_ID, Zone_name, image_path) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // Corrected the bind_param to use the correct variable for zone_name
        $stmt->bind_param("ssssssss", $a_id, $a_name, $a_sex, $a_date_of_birth, $species, $zk_id, $zone_name, $image_path);

        if ($stmt->execute()) {
            // Redirect to the animal management page with a success message
            header("Location: animal_ad.php?message=added");
            exit();
        } else {
            // Display the error if the query execution fails
            echo "Error executing query: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Display the error if the query preparation fails
        echo "Error preparing query: " . $mysqli->error;
    }
} else {
    echo "Invalid request method.";
}
?>
