<?php
require('connect.php');

// Check if the Meal_code is provided via GET
if (isset($_GET['Meal_code'])) {
    $meal_code = $_GET['Meal_code'];
    $stmt = $mysqli->prepare("DELETE FROM meal WHERE Meal_code = ?");

    if ($stmt) {
        // Bind the parameter and execute the statement
        $stmt->bind_param("s", $meal_code);

        if ($stmt->execute()) {
            // Redirect back with a success message
            header("Location: meal_ad.php?message=deleted");
            exit();
        } else {
            echo "Error executing query: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing query: " . $mysqli->error;
    }
} else {
    echo "No meal code specified.";
}
?>
