<?php
require('connect.php'); // Include the database connection file

// Fetch zookeeper data for the dropdown
$query_zookeep = "SELECT ZK_ID, ZKFName, ZKLName FROM zookeeper"; // Query to get zookeepers' details
$query_zone = "SELECT Zone_name FROM zone"; // Query to get the available zone names

// Execute zookeeper query
$result_zookeep = $mysqli->query($query_zookeep);
if (!$result_zookeep) {
    die("Query failed: " . $mysqli->error); // Handle query failure for zookeepers
}

// Execute zone query
$result_zone = $mysqli->query($query_zone);
if (!$result_zone) {
    die("Query failed: " . $mysqli->error); // Handle query failure for zones
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Zookeeper</title>
    <link rel="stylesheet" href="style_add_ani.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="container">

    <h1>Create New Animal</h1>
    <form action="add_ani.php" method="POST" enctype="multipart/form-data">
        <!-- Profile Image Upload Section -->
        <div class="profile-image">
            <label for="animal_image" class="image-upload-label">
                <img src="placeholder.png" alt="Profile Placeholder" id="profile-preview"> <!-- Placeholder image -->
                <input type="file" id="animal_image" name="animal_image" accept="image/*" required onchange="previewImage(event)"> <!-- Image file input -->
                <span>Select image file</span>
            </label>
        </div>

        <!-- Animal Name Input -->
        <label for="name">Name</label>
        <input type="text" id="animal_name" name="animal_name" required> <!-- Name of the animal -->

        <!-- Animal ID Input -->
        <label for="animal_id">Animal ID</label>
        <input type="text" id="animal_id" name="animal_id" required> <!-- Animal's unique ID -->

        <!-- Species Input -->
        <label for="species">Species</label>
        <input type="text" id="species" name="species" required> <!-- Species of the animal -->

        <!-- Sex Selection (Radio Buttons) -->
        <label>Sex</label>
        <div class="radio-group">
            <input type="radio" id="male" name="sex" value="Male" required> <!-- Male radio button -->
            <label for="male">Male</label>
            <input type="radio" id="female" name="sex" value="Female" required> <!-- Female radio button -->
            <label for="female">Female</label>
        </div>

        <!-- Date of Birth Input -->
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" required> <!-- Animal's date of birth -->

        <!-- Zookeeper Dropdown -->
        <label for="zookeeper_id">Zookeeper ID</label>
        <select type="drop-down" id="zookeeper_id" name="zookeeper_id" required>
            <option value="" disabled selected>Select Zookeeper</option> <!-- Default option -->
            <?php
            // Loop through the fetched zookeeper data and display options in the dropdown
            while ($row = $result_zookeep->fetch_assoc()) {
                $zkId = $row['ZK_ID']; // Get the Zookeeper ID
                $zkName = $row['ZKFName'] . ' ' . $row['ZKLName']; // Concatenate First and Last name of the Zookeeper
                echo "<option value='$zkId'>$zkId - $zkName</option>"; // Display Zookeeper options
            }
            ?>
        </select>

        <!-- Zone Dropdown -->
        <label for="zone_name">Zone</label>
        <select type="drop-down" id="zone_name" name="zone_name" required>
            <option value="" disabled selected>Select Zone</option> <!-- Default option -->
            <?php
            // Loop through the fetched zone data and display options in the dropdown
            while ($row = $result_zone->fetch_assoc()) {
                echo "<option value=\"{$row['Zone_name']}\">{$row['Zone_name']}</option>"; // Display Zone options
            }
            ?>
        </select>

        <!-- Form Submit and Cancel Buttons -->
        <div class="buttons">
            <button type="submit" class="add-button">Add Animal</button>
            <button type="button" onclick="window.location.href='animal_ad.php'" class="cancel-button">Cancel</button> <!-- Cancel button to redirect -->
        </div>
    </form>
    </div>

    <!-- JavaScript for Image Preview -->
    <script>
        // Function to preview the uploaded image
        function previewImage(event) {
            const file = event.target.files[0]; // Get the selected file
            const preview = document.getElementById('profile-preview'); // Get the image preview element

            if (file) {
                const reader = new FileReader(); // Create a FileReader object
                reader.onload = function(e) {
                    preview.src = e.target.result; // Set the preview image source to the selected file
                };
                reader.readAsDataURL(file); // Read the file as a data URL
            }
        }
    </script>

</body>
</html>
