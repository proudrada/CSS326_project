<?php
require('connect.php'); // Include the database connection file to enable database interactions

// Initialize variables for popup functionality
$message = "";
$showPopup = false;

// Check if the request method is POST or GET
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $zk_id = $mysqli->real_escape_string($_POST['ZK_ID'] ?? $_GET['ZK_ID']);

    if (empty($zk_id)) {
        $message = "Error: Zookeeper ID is required.";
        $showPopup = true;
    } else {
        // Check if the zookeeper is assigned to any animals
        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM animals WHERE ZK_ID = ?");
        if ($stmt) {
            $stmt->bind_param("s", $zk_id);
            $stmt->execute();
            $stmt->bind_result($animalCount);
            $stmt->fetch();
            $stmt->close();

            // If the zookeeper is assigned to any animals, show the message and do not delete the image or zookeeper
            if ($animalCount > 0) {
                $message = "Cannot delete this zookeeper because they are assigned to one or more animals. Please reassign or delete those animals first.";
                $showPopup = true;
            } else {
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
                            $message = "Error: Failed to delete the image file.";
                            $showPopup = true;
                        }
                    }
                } else {
                    $message = "Error preparing query to fetch image path: " . $mysqli->error;
                    $showPopup = true;
                }

                // Proceed to delete the zookeeper record from the database
                if (!$showPopup) { // Proceed only if no error occurred earlier
                    $stmt = $mysqli->prepare("DELETE FROM zookeeper WHERE ZK_ID = ?");
                    if ($stmt) {
                        $stmt->bind_param("s", $zk_id);
                        if ($stmt->execute()) {
                            // Set message for success and redirect later
                            $message = "Zookeeper deleted successfully.";
                            $showPopup = true;
                        } else {
                            $message = "Error deleting zookeeper.";
                            $showPopup = true;
                        }
                        $stmt->close();
                    } else {
                        $message = "Error preparing delete query: " . $mysqli->error;
                        $showPopup = true;
                    }
                }
            }
        } else {
            $message = "Error checking animal assignments: " . $mysqli->error;
            $showPopup = true;
        }
    }
} else {
    $message = "Invalid request method.";
    $showPopup = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Zookeeper</title>
    <script>
        // Function to display a popup message and redirect after a delay
        function showPopupAndRedirect(message, redirectUrl) {
            alert(message); // Show the popup
            setTimeout(function() {
                window.location.href = redirectUrl; // Redirect after clicking "OK"
            }, 100); // Delay redirection slightly after alert
        }
    </script>
</head>
<body>
    <?php if ($showPopup): ?>
        <script>
            // Trigger the popup and redirect to zookeeper_ad.php
            showPopupAndRedirect("<?php echo addslashes($message); ?>", "zookeeper_ad.php");
        </script>
    <?php endif; ?>
</body>
</html>
