<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Dashboard</title>
    <link rel="stylesheet" href="style_animal.css">
</head>
<body>
    <?php
    // Include a common header or navigation file if needed
    ?>
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
    </div>

    <div class="topic">
        <h1>Animal</h1>
    </div>

    <!-- Cards Container -->
    <div class="cards-container">
        <?php
        // Define animals data
        $animals = [
            [
                'img' => 'img/sunwukong.jpg',
                'name' => 'Sun Wukong',
                'id' => 'A001',
                'dob' => '2015-05-10',
                'species' => 'Monkey',
                'sex' => 'Male',
                'zookeeper_id' => '001',
                'age' => 8,
            ],
            [
                'img' => 'img/hippogriff.jpg',
                'name' => 'Hippogriff',
                'id' => 'A002',
                'dob' => '2012-03-20',
                'species' => 'Hybrid',
                'sex' => 'Male',
                'zookeeper_id' => '002',
                'age' => 11,
            ],
            [
                'img' => 'img/hippocamp.jpg',
                'name' => 'Hippocamp',
                'id' => 'A003',
                'dob' => '2018-07-01',
                'species' => 'Sea Horse',
                'sex' => 'Female',
                'zookeeper_id' => '003',
                'age' => 5,
            ],
            // Add more animals as needed
        ];

        // Loop through animals to generate cards
        foreach ($animals as $animal) {
            echo "
            <div class='card'>
                <img src='{$animal['img']}' alt='{$animal['name']}' class='profile-img'>
                <h2>{$animal['name']}</h2>
                <p>Animal ID: <span contenteditable='true'>{$animal['id']}</span></p>
                <p>Date of birth: <span contenteditable='true'>{$animal['dob']}</span></p>
                <p>Species: <span contenteditable='true'>{$animal['species']}</span></p>
                <p>Sex: <span contenteditable='true'>{$animal['sex']}</span></p>
                <p>Zookeeper ID: <span contenteditable='true'>{$animal['zookeeper_id']}</span></p>
                <p>Age: <span contenteditable='true'>{$animal['age']}</span></p>
                <a href='#' class='edit-icon' title='Edit'>&#9998;</a>
            </div>";
        }
        ?>
    </div>
    
    <div class="add-button-container">
        <button onclick="window.location.href='add_ani.php'" class="add-button">+</button>
    </div>
</body>
</html>
