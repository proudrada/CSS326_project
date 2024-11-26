<?php
require('connect.php'); // Include the database connection file

$message = ""; // To hold success or error messages
$showPopup = false; // Flag to indicate whether to show a popup

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $animal_id = $mysqli->real_escape_string($_POST['A_ID'] ?? $_GET['A_ID']);

    if (empty($animal_id)) {
        $message = "Error: Animal ID is required.";
        $showPopup = true;
    } else {
        // Delete related records in `meal` table
        $stmt = $mysqli->prepare("DELETE FROM meal WHERE A_ID = ?");
        if ($stmt) {
            $stmt->bind_param("s", $animal_id);
            if (!$stmt->execute()) {
                $message = "Error deleting related meals: " . $stmt->error;
                $showPopup = true;
                exit();
            }
            $stmt->close();
        } else {
            $message = "Error preparing delete query for meals: " . $mysqli->error;
            $showPopup = true;
            exit();
        }

        // Fetch and delete the animal image
        $stmt = $mysqli->prepare("SELECT image_path FROM animal WHERE A_ID = ?");
        if ($stmt) {
            $stmt->bind_param("s", $animal_id);
            $stmt->execute();
            $stmt->bind_result($db_image_path);
            $stmt->fetch();
            $stmt->close();

            if ($db_image_path && file_exists($db_image_path)) {
                if (!unlink($db_image_path)) {
                    $message = "Error: Failed to delete the image file.";
                    $showPopup = true;
                    exit();
                }
            }
        } else {
            $message = "Error preparing query to fetch image path: " . $mysqli->error;
            $showPopup = true;
            exit();
        }

        // Delete the animal record
        $stmt = $mysqli->prepare("DELETE FROM animal WHERE A_ID = ?");
        if ($stmt) {
            $stmt->bind_param("s", $animal_id);
            if ($stmt->execute()) {
                $message = "Animal deleted successfully!";
                $showPopup = true;
            } else {
                $message = "Error executing query: " . $stmt->error;
                $showPopup = true;
            }
            $stmt->close();
        } else {
            $message = "Error preparing delete query for animal: " . $mysqli->error;
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
    <title>Delete Animal</title>
    <script>
        function showPopupAndRedirect(message, redirectUrl) {
            alert(message);
            window.location.href = redirectUrl;
        }
    </script>
</head>
<body>
    <?php if ($showPopup): ?>
        <script>
            showPopupAndRedirect("<?php echo $message; ?>", "animal_ad.php");
        </script>
    <?php endif; ?>
</body>
</html>
