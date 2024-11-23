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
        <h1>Create New Zookeeper</h1>
        <form action="edit_zookeep.php" method="POST" enctype="multipart/form-data">
            <div class="profile-image">
                <label for="profile_image" class="image-upload-label">
                    <img src="placeholder.png" alt="Profile Placeholder" id="profile-preview">
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" required onchange="previewImage(event)">
                    <span>Select Profile Image</span>
                </label>
            </div>

            <label for="first name">First Name</label>
            <input type="text" id="f_name" name="f_name" required>

            <label for="last name">Last Name</label>
            <input type="text" id="l_name" name="l_name" required>

            <label for="zookeeper_id">Zookeeper ID</label>
            <input type="text" id="zookeeper_id" name="zookeeper_id" required>

            <label>Sex</label>
            <div class="radio-group">
                <input type="radio" id="male" name="sex" value="Male" required>
                <label for="male">Male</label>
                <input type="radio" id="female" name="sex" value="Female" required>
                <label for="female">Female</label>
            </div>

            <label for="salary">Salary</label>
            <input type="text" id="salary" name="salary" required>

            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required>

            <div class="buttons">
                <button type="submit" class="add-button">Add Zookeeper</button>
                <button type="button" onclick="window.location.href='Zookeeper_ad.php'" class="cancel-button">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        // JavaScript to preview the uploaded image
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('profile-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result; // Set preview image source
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
