<?php
require('connect.php'); // Include the database connection file to enable database interactions

// Check if the request method is POST or GET
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $zk_id = $mysqli->real_escape_string($_POST['ZK_ID'] ?? $_GET['ZK_ID']);

    if (empty($zk_id)) {
        echo "Error: Zookeeper ID is required.";
        exit();
    }

    $image_path = "img/" . $zk_id;

    // Prepare a query to fetch the `image_path` associated with the provided Zookeeper ID
    $stmt = $mysqli->prepare("SELECT image_path FROM zookeeper WHERE ZK_ID = ?");
    if ($stmt) { 
        $stmt->bind_param("s", $zk_id); 
        $stmt->execute(); 
        $stmt->bind_result($db_image_path); 
        $stmt->fetch(); 
        $stmt->close(); 
        // If an image path is retrieved and the file exists, attempt to delete the file
        if ($db_image_path && file_exists($db_image_path)) {
            if (!unlink($db_image_path)) { // Attempt to delete the file and check if it fails
                echo "Error: Failed to delete the image file."; // Display an error if the file cannot be deleted
                exit(); 
            }
        }
    } else { // If the query preparation fails
        echo "Error preparing query to fetch image path: " . $mysqli->error; // Display the error message
        exit(); 
    }

    // Prepare a query to delete the zookeeper record from the database
    $stmt = $mysqli->prepare("DELETE FROM zookeeper WHERE ZK_ID = ?");
    if ($stmt) { // Check if the query preparation was successful
        $stmt->bind_param("s", $zk_id); // Bind the Zookeeper ID parameter to the query
        if ($stmt->execute()) { // Execute the query and check if it succeeds
            // Redirect to the zookeeper management page with a success message
            header("Location: zookeeper_ad.php?message=deleted");
            exit(); 
        } else { 
            echo "Error executing query: " . $stmt->error; 
        }
        $stmt->close(); 
    } else { 
        echo "Error preparing delete query: " . $mysqli->error; // Display the error message
    }
} else { // If the request method is neither POST nor GET
    echo "Invalid request method."; // Display an error message
}
?>
