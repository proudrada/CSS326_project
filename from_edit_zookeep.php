<?php
require('connect.php');

// Get Zookeeper ID from query string
if (isset($_GET['ZK_ID'])) {
    $zookeeper_id = $mysqli->real_escape_string($_GET['ZK_ID']);

    // Query to fetch zookeeper details
    $query = "SELECT * FROM zookeeper WHERE ZK_ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $zookeeper_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $zookeeper = $result->fetch_assoc();

    if (!$zookeeper) {
        echo "Zookeeper not found.";
        exit();
    }
} else {
    echo "No Zookeeper ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Zookeeper</title>
    <link rel="stylesheet" href="style_add_zookeep.css">
</head>
<body>
    <div class="container">
        <h1>Edit Zookeeper</h1>
        <form action="edit_zookeep.php" method="POST" enctype="multipart/form-data">
            <div class="profile-image">
                <label for="profile_image" class="image-upload-label">
                    <img src="placeholder.png" alt="Profile Placeholder" id="profile-preview">
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(event)">
                    <span>Change Profile Image</span>
                </label>
            </div>  

            <label for="f_name">First Name</label>
            <input type="text" id="f_name" name="f_name" value="<?= htmlspecialchars($zookeeper['ZKFName']) ?>" required>

            <label for="l_name">Last Name</label>
            <input type="text" id="l_name" name="l_name" value="<?= htmlspecialchars($zookeeper['ZKLName']) ?>" required>

            <label for="zookeeper_id">Zookeeper ID</label>
            <input type="text" id="zookeeper_id" name="zookeeper_id" value="<?= htmlspecialchars($zookeeper['ZK_ID']) ?>" readonly>

            <label for="zk_email">Zookeeper Email</label>
            <input type="email" id="zk_email" name="zk_email" value="<?= htmlspecialchars($zookeeper['zk_email']) ?>" required>

            <label>Sex</label>
            <div class="radio-group">
                <input type="radio" id="male" name="sex" value="Male" <?= ($zookeeper['ZSex'] === 'Male') ? 'checked' : '' ?>>
                <label for="male">Male</label>
                <input type="radio" id="female" name="sex" value="Female" <?= ($zookeeper['ZSex'] === 'Female') ? 'checked' : '' ?>>
                <label for="female">Female</label>
            </div>

            <label for="salary">Salary</label>
            <input type="text" id="salary" name="salary" value="<?= htmlspecialchars($zookeeper['Salary']) ?>" required>

            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($zookeeper['ZDate_of_birth']) ?>" required>

            <div class="buttons">
                <button type="submit" class="add-button">Edit Zookeeper</button>
                <button type="button" onclick="window.location.href='Zookeeper_ad.php'" class="cancel-button">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>