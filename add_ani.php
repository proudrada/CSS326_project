<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Zookeeper</title>
    <link rel="stylesheet" href="style_add_ani.css">
</head>
<body>
    <div class="container">
        <h1>Create New Animal</h1>
        <form action="process.php" method="POST" enctype="multipart/form-data">
            <div class="profile-image">
                <label for="profile_image">
                    <img src="placeholder.png" alt="Profile Placeholder">
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" required>
                    <span>Select image file</span>
                </label>
            </div>

            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="animal_id">Animal ID</label>
            <input type="text" id="animal_id" name="animal_id" required>

            <label for="species">Species</label>
            <input type="text" id="species" name="species" required>

            <label>Sex</label>
            <div class="radio-group">
                <input type="radio" id="male" name="sex" value="Male" required>
                <label for="male">Male</label>
                <input type="radio" id="female" name="sex" value="Female" required>
                <label for="female">Female</label>
            </div>

            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required>

            <label for="zookeeper_id">Zookeeper ID</label>
            <select id="zookeeper_id" name="zookeeper_id" required>
                <option value="" disabled selected>Select Zookeeper ID</option>
                <option value="Z001">Z001</option>
                <option value="Z002">Z002</option>
                <option value="Z003">Z003</option>
            </select>


            <div class="buttons">
                <button type="button" onclick="window.location.href='animal_ad.php'" class="cancel-button">Cancel</button>
                <button type="submit" class="add-button">Add Animal</button>
            </div>
        </form>
    </div>
</body>
</html>
