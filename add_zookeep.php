<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Zookeeper</title>
    <link rel="stylesheet" href="style_add_zookeep.css">
</head>
<body>
    <div class="container">
        <h1>Create New Zookeeper</h1>
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

            <label>Animal ID</label>
            <div class="checkbox-group">
                <input type="checkbox" id="A001" name="animal_id[]" value="A001">
                <label for="A001">A001</label>
                <input type="checkbox" id="A002" name="animal_id[]" value="A002">
                <label for="A002">A002</label>
                <input type="checkbox" id="A003" name="animal_id[]" value="A003">
                <label for="A003">A003</label>
                <input type="checkbox" id="A004" name="animal_id[]" value="A004">
                <label for="A004">A004</label>
                <input type="checkbox" id="A005" name="animal_id[]" value="A005">
                <label for="A005">A005</label>
                <input type="checkbox" id="A006" name="animal_id[]" value="A006">
                <label for="A006">A006</label>
                <input type="checkbox" id="A007" name="animal_id[]" value="A007">
                <label for="A007">A007</label>
                <input type="checkbox" id="A008" name="animal_id[]" value="A008">
                <label for="A008">A008</label>
                <input type="checkbox" id="A009" name="animal_id[]" value="A009">
                <label for="A009">A009</label>
            </div>

            <div class="buttons">
                <button type="button" onclick="window.location.href='Zookeeper_ad.php'" class="cancel-button">Cancel</button>
                <button type="submit" class="add-button">Add Zookeeper</button>
            </div>
        </form>
    </div>
</body>
</html>
