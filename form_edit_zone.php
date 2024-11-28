<?php
require('connect.php');

// Get Zone Name from query string
if (isset($_GET['Zone_name'])) {
    $zone_name = $mysqli->real_escape_string($_GET['Zone_name']);

    // Query to fetch zone details
    $query = "SELECT * FROM zone WHERE Zone_name = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $zone_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $zone = $result->fetch_assoc();

    if (!$zone) {
        echo "Zone not found.";
        exit();
    }
} else {
    echo "No Zone Name provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Zone</title>
    <link rel="stylesheet" href="style_edit_zone.css">
</head>
<body>
    <div class="container">
        <h1>Edit Zone</h1>
        <form action="edit_zone.php" method="POST" enctype="multipart/form-data">
            <div class="profile-image">
                <label for="profile_image" class="image-upload-label">
                    <img src="placeholder.png" alt="Profile Placeholder" id="profile-preview">
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(event)">
                    <span>Change Zone Image</span>
                </label>
            </div>  

            <label for="name">Zone Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($zone['Zone_name']) ?>" readonly>

            <label for="avg_temp">Average Temperature</label>
            <input type="text" id="avg_temp" name="avg_temp" value="<?= htmlspecialchars($zone['Avg_temp']) ?>" required>

            <label for="habitat">Habitat</label>
            <input type="text" id="habitat" name="habitat" value="<?= htmlspecialchars($zone['Habitat']) ?>" required>
                       
            <label for="environment">Environment</label>
            <input type="text" id="environment" name="environment" value="<?= htmlspecialchars($zone['Environment']) ?>" required>

            <label for="humidity">Humidity</label>
            <input type="text" id="humidity" name="humidity" value="<?= htmlspecialchars($zone['Relative_humidity']) ?>" required>

            <div class="buttons">
                <button type="submit" class="add-button">Edit Zone</button>
                <button type="button" onclick="window.location.href='Zone_ad.php'" class="cancel-button">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>
