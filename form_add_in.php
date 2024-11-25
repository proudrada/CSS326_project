<?php
session_start();
require_once('connect.php');

// Default redirect if no session
// if (!isset($_SESSION['ZK_ID'])) {
//     header("Location: login.php");
//     exit();
// }

// Determine the role and set head
$code = $_SESSION['ZK_ID'];
$_SESSION['role'] = $_GET['role'];
$head = '';

if (isset($_POST['cancel'])) {
    $ad_query = $mysqli->query("SELECT * FROM admin WHERE Ad_ID = '$code'");
    $zk_query = $mysqli->query("SELECT * FROM zookeeper WHERE ZK_ID = '$code'");

    if ($ad_query && $ad_query->num_rows > 0) {
        header("Location: ingredient_ad.php");
    } elseif ($zk_query && $zk_query->num_rows > 0) {
        $head = 'ingredient_staff.php';
        header("Location: ingredient_staff.php");
    } else {
        $head = 'default_page.php';
        header("Location: homepage.php");
    }
    $_SESSION['head'] = $head;
}

$role = $_GET['role'];
$redirect_url = 'homepage.php';

if ($role == 'admin') {
    $redirect_url = 'ingredient_ad.php';
} elseif ($role == 'staff') {
    $redirect_url = 'ingredient_staff.php';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Ingredient</title>
    <link rel="stylesheet" href="style_add_in.css">
</head>
<body>
    <div class="container">
        <h1>Create New Ingredient</h1>
        <form action="add_in.php" method="POST">
            <label for="ingredient_id">Ingredient ID</label>
            <input type="text" id="ingredient_id" name="ingredient_id" required>

            <label for="ingredient_type">Ingredient Type</label>
            <input type="text" id="ingredient_type" name="ingredient_type" required>

            <label for="ingredient_amount">Ingredient Amount</label>
            <input type="text" id="ingredient_amount" name="ingredient_amount" required>

            <label for="expiration_date">Expiration Date</label>
            <input type="date" id="expiration_date" name="expiration_date" required>

        
            <button type="submit" class="add-button">Add Ingredient</button>
        </form>
        <div>
            <button type="button" onclick="window.location.href='<?php echo $redirect_url; ?>'" class="cancel-button">Cancel</button>
        </div>
    </div>
</body>
</html>
