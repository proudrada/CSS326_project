<?php
session_start(); 
require('connect.php');

// Initialize variables for popup functionality
$message = "";
$showPopup = false;

// Check if the ingredient ID is provided via GET
if (isset($_GET['In_ID']) && !empty($_GET['In_ID'])) {
    $ingredient_id = htmlspecialchars($_GET['In_ID']); // Sanitize input

    // Check if the ingredient is associated with any meals
    $stmt = $mysqli->prepare("SELECT COUNT(*) AS count FROM meal WHERE In_ID = ?");
    $stmt->bind_param("s", $ingredient_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($result['count'] > 0) {
        $message = "Cannot delete this ingredient because it is used in one or more meals. Please delete those meals first.";
    } else {
        // Proceed with the deletion process
        $stmt = $mysqli->prepare("DELETE FROM ingredient WHERE In_ID = ?");
        if ($stmt) {
            $stmt->bind_param("s", $ingredient_id);
            if ($stmt->execute()) {
                $message = "Ingredient deleted successfully.";
            } else {
                $message = "Error executing query: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Error preparing query: " . $mysqli->error;
        }
    }

    // Redirect to the ingredient_ad.php page with the message
    header("Location: ingredient_ad.php?message=" . urlencode($message));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Ingredient</title>
</head>
<body>
</body>
</html>
