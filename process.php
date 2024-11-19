<?php
require_once('connect.php');
// Query to fetch zookeeper data
// $query_zk = "SELECT ZK_ID FROM zookeeper";
// $query_ad = "SELECT Ad_ID FROM admin";
// $result_zk = $mysqli->query($query);
// $result_ad = $mysqli->query($query);
// // Check if query execution was successful
// if (!$result) {
//     die("Query failed: " . $mysqli->error);
// }
// ?>

<?php
// รับค่าจากฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = trim($_POST['code']); // กำจัดช่องว่างรอบๆ

    // ตรวจสอบรหัสในตาราง admin
    $query_ad = "SELECT Ad_ID FROM admin WHERE Ad_ID = ?";
    $stmt_ad = $mysqli->prepare($query_ad);
    $stmt_ad->bind_param("s", $code);
    $stmt_ad->execute();
    $result_ad = $stmt_ad->get_result();

    // ตรวจสอบรหัสในตาราง zookeeper
    $query_zk = "SELECT ZK_ID FROM zookeeper WHERE ZK_ID = ?";
    $stmt_zk = $mysqli->prepare($query_zk);
    $stmt_zk->bind_param("s", $code);
    $stmt_zk->execute();
    $result_zk = $stmt_zk->get_result();

    // ถ้าเจอรหัสในตาราง admin
    if ($result_ad->num_rows > 0) {
        header("Location: ZooKeeper_ad.php?name=admin");
        exit();
    }
    // ถ้าเจอรหัสในตาราง zookeeper
    elseif ($result_zk->num_rows > 0) {
        header("Location: ZooKeeper_staff.php?name=" . urlencode($code));
        exit();
    }
    // ถ้ารหัสไม่ถูกต้อง
    else {
        header("Location: homepage.php?error=invalid");
        exit();
    }
} else {
    echo "No data submitted.";
}
