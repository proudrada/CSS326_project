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

if (isset($_GET['A_ID'])) {
    $animal_id = $mysqli->real_escape_string($_GET['A_ID']);

    // Query to fetch zookeeper details
    $query = "SELECT * FROM animal WHERE A_ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $animal_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $animal = $result->fetch_assoc();

    if (!$animal) {
        echo "Animal not found.";
        exit();
    }
} else {
    echo "No Animal ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Animal</title>
    <link rel="stylesheet" href="style_add_ani.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="container">
    <h1>Edit Animal</h1>
    <form action="edit_ani.php" method="POST" enctype="multipart/form-data">
        <!-- Profile Image Upload Section -->
        <div class="profile-image">
            <label for="animal_image" class="image-upload-label">
                <img src="placeholder.png" alt="Profile Placeholder" id="profile-preview"> <!-- Placeholder image -->
                <input type="file" id="animal_image" name="animal_image" accept="image/*" onchange="previewImage(event)"> <!-- Image file input -->
                <span>Select image file</span>
            </label>
        </div>

        <!-- Animal Name Input -->
        <label for="name">Name</label>
        <input type="text" id="animal_name" name="animal_name" value="<?= htmlspecialchars($animal['A_name']) ?>" required> <!-- Name of the animal -->

        <!-- Animal ID Input -->
        <label for="animal_id">Animal ID</label>
        <input type="text" id="animal_id" name="animal_id" value="<?= htmlspecialchars($animal['A_ID']) ?>" required> <!-- Animal's unique ID -->

        <!-- Species Input -->
        <label for="species">Species</label>
        <input type="text" id="species" name="species" value="<?= htmlspecialchars($animal['Species']) ?>"required> <!-- Species of the animal -->

        <!-- Sex Selection (Radio Buttons) -->
        <label>Sex</label>
        <div class="radio-group">
            <input type="radio" id="male" name="sex" value="Male" <?= htmlspecialchars($animal['A_Sex'] === 'Male') ? 'checked' : '' ?>> 
            <label for="male">Male</label>
            <input type="radio" id="female" name="sex" value="Female" <?= htmlspecialchars($animal['A_Sex'] === 'Female') ? 'checked' : '' ?>>
            <label for="female">Female</label>
        </div>

        <!-- Date of Birth Input -->
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($animal['ADate_of_birth']) ?>" required> <!-- Animal's date of birth -->

        <!-- Zookeeper Dropdown -->
        <label for="zookeeper_id">Zookeeper ID</label>
        <select type="drop-down" id="zookeeper_id" name="zookeeper_id" required>
            <option value="" disabled>Select Zookeeper</option> <!-- Default option -->
            <?php
            while ($row = $result_zookeep->fetch_assoc()) {
                $zkId = $row['ZK_ID']; // Get the Zookeeper ID
                $zkName = $row['ZKFName'] . ' ' . $row['ZKLName']; // Concatenate First and Last name of the Zookeeper

                // Check if the zookeeper ID matches the one assigned to the animal
                $selected = ($animal['ZK_ID'] == $zkId) ? 'selected' : '';

                // Display the dropdown option with the selected attribute if it matches
                echo "<option value='$zkId' $selected>$zkId - $zkName</option>";
            }
            ?>
        </select>


        <!-- Zone Dropdown -->
        <label for="zone_name">Zone</label>
        <select type="drop-down" id="zone_name" name="zone_name" required>
            <option value="" disabled>Select Zone</option> <!-- Default option -->
                <?php
                // Loop through the fetched zone data and display options in the dropdown
                while ($row = $result_zone->fetch_assoc()) {
                    $zoneName = $row['Zone_name']; // Get the zone name

                    // Check if the zone name matches the one assigned to the animal
                    $selected = ($animal['Zone_name'] == $zoneName) ? 'selected' : '';

                    // Display the dropdown option with the selected attribute if it matches
                    echo "<option value=\"$zoneName\" $selected>$zoneName</option>";
                }
                ?>
        </select>


        <!-- Form Submit and Cancel Buttons -->
        <div class="buttons">
            <button type="submit" class="add-button">Edit Animal</button>
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
