<?php
require_once('connect.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input values
    $ingredient_id = $mysqli->real_escape_string($_POST['ingredient_id']);
    $ingredient_type = $mysqli->real_escape_string($_POST['ingredient_type']);
    $ingredient_amount = $mysqli->real_escape_string($_POST['ingredient_amount']);
    $expiration_date = $mysqli->real_escape_string($_POST['expiration_date']);

    // SQL query to insert the data into the ingredient table
    $query = "INSERT INTO ingredient (In_ID, In_type, In_amount, Expiration_date) 
              VALUES ('$ingredient_id', '$ingredient_type', '$ingredient_amount', '$expiration_date')";

    // Execute the query
    if ($mysqli->query($query) === TRUE) {
        // Redirect back to the ingredient_ad.php page with a success message
        header("Location: ingredient_ad.php?message=success");
        exit();
    } else {
        // Display an error message
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}
?>
