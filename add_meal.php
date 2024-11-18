<?php
require_once('connect.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input values
    $meal_code = $mysqli->real_escape_string($_POST['meal_code']);
    $animal_id = $mysqli->real_escape_string($_POST['Animal_ID']);
    $ingredient_id = $mysqli->real_escape_string($_POST['Ingredient_ID']);
    $date = $mysqli->real_escape_string($_POST['Date']);
    $time = $mysqli->real_escape_string($_POST['Time']);

    // SQL query to insert the data into the meal table
    $query = "INSERT INTO meal (Meal_code, A_ID, In_ID, Date, Time) 
              VALUES ('$meal_code', '$animal_id', '$ingredient_id', '$date', '$time')";

    // Execute the query
    if ($mysqli->query($query) === TRUE) {
        // Redirect back to the meal_ad.php page with a success message
        header("Location: meal_ad.php?message=success");
        exit();
    } else {
        // Display an error message
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}
?>
