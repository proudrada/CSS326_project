<?php
require_once('connect.php');

// Check if Meal_code is provided
if (isset($_GET['Meal_code'])) {
    $meal_code = $mysqli->real_escape_string($_GET['Meal_code']);

    // SQL query to delete the meal
    $query = "DELETE FROM meal WHERE Meal_code = '$meal_code'";

    if ($mysqli->query($query) === TRUE) {
        // Redirect back to the meal_ad.php page with a success message
        header("Location: meal_ad.php?message=deleted");
        exit();
    } else {
        echo "Error: " . $mysqli->error;
    }
} else {
    echo "No Meal_code specified.";
}
?>
