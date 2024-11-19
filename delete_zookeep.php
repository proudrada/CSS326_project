<?php
require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure zookeeper ID is provided
    $zk_id = $mysqli->real_escape_string($_POST['zookeeper_id']);

    // Get the image path of the zookeeper to delete
    $stmt = $mysqli->prepare("SELECT image_path FROM zookeeper WHERE ZK_ID = ?");
    if ($stmt) {
        $stmt->bind_param("s", $zk_id);
        $stmt->execute();
        $stmt->bind_result($image_path);
        $stmt->fetch();
        $stmt->close();

        // Delete the zookeeper record
        $delete_stmt = $mysqli->prepare("DELETE FROM zookeeper WHERE ZK_ID = ?");
        if ($delete_stmt) {
            $delete_stmt->bind_param("s", $zk_id);

            if ($delete_stmt->execute()) {
                // Check and delete the image file if it's not the default image
                if ($image_path && $image_path !== 'img/default-image.jpg' && file_exists($image_path)) {
                    unlink($image_path);
                }

                // Redirect to zookeeper management page with success message
                header("Location: zookeeper_ad.php?message=deleted");
                exit();
            } else {
                echo "Error executing delete query: " . $delete_stmt->error;
            }

            $delete_stmt->close();
        } else {
            echo "Error preparing delete query: " . $mysqli->error;
        }
    } else {
        echo "Error preparing select query: " . $mysqli->error;
    }
} else {
    echo "Invalid request method.";
}
?>
