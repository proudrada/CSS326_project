<?php
require_once('connect.php');

// Check if the ingredient ID is provided via GET
if (isset($_GET['id'])) {
    $ingredient_id = $mysqli->real_escape_string($_GET['id']);

    // SQL query to delete the ingredient
    $query = "DELETE FROM ingredient WHERE In_ID = '$ingredient_id'";

    // Execute the query
    if ($mysqli->query($query) === TRUE) {
        // Redirect back to the ingredient_ad.php page with a success message
        header("Location: ingredient_ad.php?message=deleted");
        exit();
    } else {
        // Display an error message
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
} else {
    echo "No ingredient ID specified.";
}
?>
