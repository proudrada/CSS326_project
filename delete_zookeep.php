<?php
require('connect.php'); // Include the database connection file to enable database interactions

// Check if the request method is POST or GET
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve the Zookeeper ID from POST or GET request and escape it to prevent SQL injection
    $zk_id = $mysqli->real_escape_string($_POST['ZK_ID'] ?? $_GET['ZK_ID']);

    // Check if the Zookeeper ID is provided; if not, return an error and exit
    if (empty($zk_id)) {
        echo "Error: Zookeeper ID is required.";
        exit();
    }

    // Construct the path to the image dynamically using the Zookeeper ID
    $image_path = "img/" . $zk_id;

    // Prepare a query to fetch the `image_path` associated with the provided Zookeeper ID
    $stmt = $mysqli->prepare("SELECT image_path FROM zookeeper WHERE ZK_ID = ?");
    if ($stmt) { // Check if the query preparation was successful
        $stmt->bind_param("s", $zk_id); // Bind the Zookeeper ID parameter to the query
        $stmt->execute(); // Execute the query
        $stmt->bind_result($db_image_path); // Bind the result of the query to the `$db_image_path` variable
        $stmt->fetch(); // Fetch the result from the database
        $stmt->close(); // Close the prepared statement

        // If an image path is retrieved and the file exists, attempt to delete the file
        if ($db_image_path && file_exists($db_image_path)) {
            if (!unlink($db_image_path)) { // Attempt to delete the file and check if it fails
                echo "Error: Failed to delete the image file."; // Display an error if the file cannot be deleted
                exit(); // Stop the script execution
            }
        }
    } else { // If the query preparation fails
        echo "Error preparing query to fetch image path: " . $mysqli->error; // Display the error message
        exit(); // Stop the script execution
    }

    // Prepare a query to delete the zookeeper record from the database
    $stmt = $mysqli->prepare("DELETE FROM zookeeper WHERE ZK_ID = ?");
    if ($stmt) { // Check if the query preparation was successful
        $stmt->bind_param("s", $zk_id); // Bind the Zookeeper ID parameter to the query
        if ($stmt->execute()) { // Execute the query and check if it succeeds
            // Redirect to the zookeeper management page with a success message
            header("Location: zookeeper_ad.php?message=deleted");
            exit(); // Stop further script execution after redirect
        } else { // If query execution fails
            echo "Error executing query: " . $stmt->error; // Display the error message
        }
        $stmt->close(); // Close the prepared statement
    } else { // If the query preparation fails
        echo "Error preparing delete query: " . $mysqli->error; // Display the error message
    }
} else { // If the request method is neither POST nor GET
    echo "Invalid request method."; // Display an error message
}
?>
