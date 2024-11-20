<?php
require_once('connect.php');
session_start();
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
        $_SESSION['ZK_ID'] = $code;
        header("Location: ZooKeeper_staff.php");
        exit();
    }
    elseif (empty($code)) {
        header("Location: homepage.php?error=invalid");
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
?>