<?php

session_start();

include '../bdd.php';


include './housing/controller/housingController.php';


$housing = getHousing($pdo);

$path = "./housing/view/housingView.php?id="
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href=".././ressouces/img/ico/favicon.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>NAV</h1>
    <ul>
        <li>
            <a href="temporalView.html">View</a>
        </li>
        <li>
            <h2>List Hébergement</h2>
            <ul>
                <?php
                foreach ($housing as $house => $row) {
                    echo " <a href='" . $path . $row['NOHEB'] . "'><li> " . $row['NOMHEB'] . "</li></a>";
                    echo "<img src='../ressouces/img/post/" . $row['PHOTOHEB'] . "' width='50' height='50' >";
                }
                ?>
            </ul>
        </li>
        <li>
            <a href="./housing/view/addHousingView.php">Crée un hébergement</a>
        </li>
        <li>
            <a href="./housing/view/addHousingTypeView.php">Crée un type d'hébergement</a>
        </li>
    </ul>
</body>

</html>