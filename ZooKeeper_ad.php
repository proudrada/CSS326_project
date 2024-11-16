<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Dashboard</title>
    <link rel="stylesheet" href="style_ZooKeep.css">
</head>
<body>
    <!-- Banner with Navigation Links -->
    <div class="banner">
        <h1>Himalayan Zoo of Mount Olympus and Mount Liangshan</h1>
        <nav>
            <a href="zookeeper_ad.php">Zoo Keeper</a>
            <a href="animal_ad.php">Animal</a>
            <a href="zone_ad.html">Zone</a>
            <a href="ingredient_ad.php">Ingredient</a>
            <a href="meal_ad.php">Meal</a>
        </nav>
        <!-- Admin Dropdown -->
        <div class="admin-dropdown">
            <button class="admin-btn">Admin_1 ▼</button>
            <div class="dropdown-content">
                <a href="homepage.html">Log-out</a>
            </div>
        </div>
    </div>

    <div class="topic">
        <h1>Zookeeper</h1>
    </div>

    <?php
    $zookeepers = [
        [
            'img' => 'img/newt.jpg',
            'name' => 'Newt Scamander',
            'id' => '001',
            'dob' => '1990-02-07',
            'sex' => 'Male',
            'salary' => '$50,000',
            'animal_id' => 'A123',
            'age' => 32
        ],
        [
            'img' => 'img/percy.jpg',
            'name' => 'Percy Jackson',
            'id' => '002',
            'dob' => '1994-08-18',
            'sex' => 'Male',
            'salary' => '$55,000',
            'animal_id' => 'A124',
            'age' => 30
        ],
        [
            'img' => 'img/hagrid.jpg',
            'name' => 'Rubeus Hagrid',
            'id' => '003',
            'dob' => '1968-12-06',
            'sex' => 'Male',
            'salary' => '$60,000',
            'animal_id' => 'A125',
            'age' => 56
        ],
    ];
    ?>

    <!-- Cards Container -->
    <div class="cards-container">
        <?php foreach ($zookeepers as $zookeeper): ?>
        <div class="card">
            <button class="close-btn" title="Close">X</button>
            <img src="<?= $zookeeper['img'] ?>" alt="<?= $zookeeper['name'] ?>" class="profile-img">
            <h2><?= $zookeeper['name'] ?></h2>
            <p>Zookeeper ID: <span contenteditable="true"><?= $zookeeper['id'] ?></span></p>
            <p>Date of birth: <span contenteditable="true"><?= $zookeeper['dob'] ?></span></p>
            <p>Sex: <span contenteditable="true"><?= $zookeeper['sex'] ?></span></p>
            <p>Salary: <span contenteditable="true"><?= $zookeeper['salary'] ?></span></p>
            <p>Animal ID: <span contenteditable="true"><?= $zookeeper['animal_id'] ?></span></p>
            <p>Age: <span contenteditable="true"><?= $zookeeper['age'] ?></span></p>
            <a href="#" class="edit-icon" title="Edit">&#9998;</a>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="add-button-container">
        <button onclick="window.location.href='add_zookeep.php'" class="add-button">+</button>
    </div>
</body>
</html>
