    <?php
    session_start(); // Ensure session is started
    require('connect.php');

    // Initialize variables for popup functionality
    $message = "";
    $showPopup = false;

    $role = $_SESSION['role'];

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
            // If the ingredient is associated with meals, show a popup
            $message = "Cannot delete this ingredient because it is used in one or more meals. Please delete those meals first.";
            $showPopup = true;
        } else {
            // Proceed with the deletion process
            $stmt = $mysqli->prepare("DELETE FROM ingredient WHERE In_ID = ?");
            if ($stmt) {
                $stmt->bind_param("s", $ingredient_id);

                if ($stmt->execute()) {
                $message = "Ingredient deleted successfully.";
                $showPopup = true;
                } else {
                    // Display an error message if execution fails
                    $message = "Error executing query: " . $stmt->error;
                    $showPopup = true;
                }
                $stmt->close();
            } else {
                // Display an error message if statement preparation fails
                $message = "Error preparing query: " . $mysqli->error;
                $showPopup = true;
            }
        }
    } else {
        $message = "No ingredient ID specified.";
        $showPopup = true;

        if ($role == 'staff') {
            header("Location: ingredient_staff.php?message=" . urlencode($message));
            exit();
        } elseif ($role == 'admin') {
            header("Location: ingredient_ad.php?message" . urlencode($message));
            exit();
        }

    }
    ?>

    </html>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete Ingredient</title>
        <script>
            // Function to display a popup message and redirect
            function showPopupAndRedirect(message, redirectUrl) {
                alert(message); // Show the popup
                window.location.href = redirectUrl; // Redirect after clicking "OK"
            }
        </script>
    </head>
    <body>
        <?php if ($showPopup): ?>
            <script>
                // Trigger the popup and redirect to ingredient_ad.php
                showPopupAndRedirect("<?php echo $message; ?>", "ingredient_ad.php");
            </script>
        <?php endif; ?>
    </body>
    </html>

