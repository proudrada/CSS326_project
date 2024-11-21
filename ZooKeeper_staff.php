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
    <!-- Banner -->
    <div class="banner">
        <h1>Himalayan Zoo of Mount Olympus and Mount Liangshan</h1>
        <nav>
            <a href="ZooKeeper_staff.php">Your profile</a>
            <a href="animal_staff.php">Animal</a> 
            <a href="zone_ad.php">Zone</a> <!--ยังไม่ได้เชื่อมและสร้าง -->
            <a href="ingredient_ad.php">Ingredient</a> <!--ยังไม่ได้เชื่อมและสร้าง -->
            <a href="meal_ad.php">Meal</a> <!--ยังไม่ได้เชื่อมและสร้าง -->
        </nav>
        <!-- Admin Dropdown -->
        <div class="admin-dropdown">
            <button class="admin-btn"><?= $zookeeper['ZKFName'] . "_" . $zookeeper['ZK_ID']; ?>▼</button>
            <div class="dropdown-content">
                <a href="homepage.php">Log-out</a>
            </div>
        </div>
    </div>

    <div class="profile-container">
        <?php if ($zookeeper): ?>
            <img src="<?= $zookeeper['image_path']; ?>" alt="<?= $zookeeper['ZKFName']; ?>">
            <div class="profile-text">
                <h1>Welcome! <?= $zookeeper['ZKFName'] . " " . $zookeeper['ZKLName']; ?></h1>
                <div class = "profile-info">
                    <p>Zookeeper ID: <?= ($zookeeper['ZK_ID']); ?></p>
                    <p>Date of birth: <?= ($zookeeper['ZDate_of_birth']); ?></p>
                    <p>Sex: <?= ($zookeeper['ZSex']); ?></p>
                    <p>Salary: $<?= number_format($zookeeper['Salary']); ?></p>
                    <p>Animal ID: <?= ($zookeeper['A_ID']); ?></p>
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

