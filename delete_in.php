<?php
require('connect.php');

// Check if the ingredient ID is provided via GET
if (isset($_GET['In_ID'])) {
    // Use prepared statements to avoid SQL injection
    $ingredient_id = $_GET['In_ID'];
    $stmt = $mysqli->prepare("DELETE FROM ingredient WHERE In_ID = ?");
    
    if ($stmt) {
        // Bind the parameter and execute the statement
        $stmt->bind_param("s", $ingredient_id);
        
        if ($stmt->execute()) {
            // Redirect back to the ingredient management page with a success message
            header("Location: ingredient_ad.php?message=deleted");
            exit();
        } else {
            // Display an error message if execution fails
            echo "Error executing query: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Display an error message if statement preparation fails
        echo "Error preparing query: " . $mysqli->error;
    }
} else {
    echo "No ingredient ID specified.";
}
?>
