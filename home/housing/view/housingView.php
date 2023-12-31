<?php

session_start();

include '../../../bdd.php';
include '../controller/housingController.php';


if (!isset($_SESSION['account'])) {
    header("location:./../../homeView.php");
}

$housing;


if (isset($_GET['id']) && !empty(getSpecialHousing($_GET['id'], $pdo))) {
    $id = $_GET['id'];
    $housing = getSpecialHousing($id, $pdo);
} else {
    header('location:../../homeView.php');
}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../ressouces/img/ico/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="../../../ressouces/img/ico/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../../ressouces/css/addHousing.css" />
    <title>RESA - VVA - <?php echo $housing['NOMHEB'] ?></title>
</head>

<body>
    <h1><?php echo htmlspecialchars($housing['NOMHEB']) ?></h1>
    <div class="container">
    
        <ul>
            <?php
            echo "<li> <b>Code Type</b> : " . htmlspecialchars($housing['CODETYPEHEB']) . "</li>";
            echo "<li> <b>Nom</b> :  " . htmlspecialchars($housing['NOMHEB']) . "</li>";
            echo "<li> <b>Place</b> : " . htmlspecialchars($housing['NBPLACEHEB']) . "</li>";
            echo "<li> <b>Surface</b> : " . htmlspecialchars($housing['SURFACEHEB']) . "</li>";
            echo "<li> <b>Internet</b> : " . htmlspecialchars($housing['INTERNET']) . "</li>";
            echo "<li> <b>Année</b> : " . htmlspecialchars($housing['ANNEEHEB']) . "</li>";
            echo "<li> <b>Secteur</b> : " . htmlspecialchars($housing['SECTEURHEB']) . "</li>";
            echo "<li> <b>Orientation</b> : " . htmlspecialchars($housing['ORIENTATIONHEB']) . "</li>";
            echo "<li> <b>Etat</b> : " . htmlspecialchars($housing['ETATHEB']) . "</li>";
            echo "<li> <b>Description</b> : " . htmlspecialchars($housing['DESCRIHEB']) . "</li>";
            echo "<img src='../../../ressouces/img/post/" . $housing['PHOTOHEB'] .  "' width='50' height='50'>";
            echo "<li> <b>Tarif</b> : " . htmlspecialchars($housing['TARIFSEMHEB']) . "</li>";
            ?>
        </ul>
        <a href="./../../booking/view/addbookingView.php?id=<?php echo $housing['NOHEB']; ?>">
            <button>Réserver</button>
        </a>
        <?php
        if (isset($_SESSION['account']['TYPECOMPTE']) && $_SESSION['account']['TYPECOMPTE'] != "VIS") {
        ?>

            <a href="./addHousingView.php?id=<?php echo $housing['NOHEB']; ?>">
                <button>Modifier</button>
            </a>
        <?php
        }

        ?>
    </div>
</body>

</html>