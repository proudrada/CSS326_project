<?php
require_once('connect.php');
session_start();

// ตรวจสอบว่ามี ID ใน session หรือไม่
if (!isset($_SESSION['ZK_ID'])) {
    header("Location: homepage.php?error=not_logged_in");
    exit();
}

$zookeeperID = $_SESSION['ZK_ID'];

// Query เพื่อดึงข้อมูล zookeeper
$query = "SELECT * FROM zookeeper WHERE ZK_ID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $zookeeperID);
$stmt->execute();
$result = $stmt->get_result();
$zookeeper = $result->fetch_assoc();

$query_animal = "SELECT A_ID FROM animal WHERE ZK_ID = ?";
$stmt_animal = $mysqli->prepare($query_animal);
$stmt_animal->bind_param("s", $zookeeperID);
$stmt_animal->execute();
$result_animal = $stmt_animal->get_result();

// Initialize animal ID array
$animal_ids = [];
while ($animal_row = $result_animal->fetch_assoc()) {
    $animal_ids[] = $animal_row['A_ID'];  // Store animal IDs
}
$animal_ids_str = implode(', ', $animal_ids);  // Convert array to comma-separated string
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zookeeper Profile</title>
    <link rel="stylesheet" href="style_ZooKeep_Staff.css"> <!-- Link to external CSS file -->
</head>
<body>
    <nav>
        <a href="zookeeper_staff.php" class="zk"><u>Your profile</u></a>
        <a href="animal_staff.php">Animal</a>
        <a href="zone_staff.php">Zone</a>
        <a href="ingredient_staff.php">Ingredient</a>
        <a href="meal_staff.php">Meal</a>
        <!-- Admin Dropdown -->
        <div class="admin-dropdown">
            <button class="admin-btn"><?= $zookeeper['ZKFName'] . "_" . $zookeeper['ZK_ID']; ?>▼</button>
            <div class="dropdown-content">
                <a href="homepage.php">Log-out</a>
                <a href="reset.php">Reset Password</a>
            </div>
        </div>
    </nav>
    <!-- Banner with Navigation Links -->
    <div class="banner">
        <h1>Himalayan Zoo of Mount Olympus and Mount Liangshan</h1>
    </div>


    <div class="profile-container">
        <?php if ($zookeeper): 
            
            ?>
            <img src="<?= $zookeeper['image_path']; ?>" alt="<?= $zookeeper['ZKFName']; ?>">
            <div class="profile-text">
                <h1>Welcome! <?= $zookeeper['ZKFName'] . " " . $zookeeper['ZKLName']; ?></h1>              
                <div class = "profile-info">
                    <p>Zookeeper ID: <?= ($zookeeper['ZK_ID']); ?></p>
                    <p>Date of birth: <?= ($zookeeper['ZDate_of_birth']); ?></p>
                    <p>Sex: <?= ($zookeeper['ZSex']); ?></p>
                    <p>Salary: $<?= number_format($zookeeper['Salary']); ?></p>
                    <p>Animal ID(s): <span contenteditable='true'><?= $animal_ids_str ?></span></p>
                    <p>Age: 
                        <?php 
                        $dob = $zookeeper['ZDate_of_birth'];
                        if (!empty($dob)) {
                            $dobDate = new DateTime($dob);
                            $now = new DateTime();
                            echo $now->diff($dobDate)->y . " years";
                        } else {
                            echo "N/A";
                        }
                        ?>
                    </p>
                </div>
            </div>
        
        <?php else: ?>
            <p>No zookeeper data found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

