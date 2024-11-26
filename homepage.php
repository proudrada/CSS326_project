<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Dashboard</title>
    <link rel="stylesheet" href="style_homepage.css"> <!-- Link to CSS file -->
    <script>
        // ฟังก์ชันสำหรับแสดง popup
        function showAlert(message) {
            alert(message); // แสดงข้อความแจ้งเตือน
        }
    </script>
<body>
    <?php
    // ตรวจสอบว่ามี error message จาก process.php หรือไม่
    if (isset($_GET['error']) && $_GET['error'] == "invalid") {
        echo "<script>showAlert('Invalid ID or Password! Please Try Again');</script>";
    }
    ?>

    <!-- Banner -->
    <div class="banner">
        <h1>Himalayan Zoo of Mount Olympus and Mount Liangshan</h1>
        <form action="process.php" method="POST">
            <input 
                type="text" 
                class="admin-input" 
                name="id" 
                placeholder="Enter your ID" 
                required
            >
            <input 
                type="password" 
                class="admin-input" 
                name="password" 
                placeholder="Password" 
                required
            >
            <!-- ปุ่ม submit ซ่อน (กด Enter เพื่อส่งค่า) -->
            <button type="submit" style="display: none;">Submit</button>
        </form>
    </div>
</body>
</html>