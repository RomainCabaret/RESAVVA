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
    <title>Document</title>
</head>

<body>
    <h1>House</h1>
    <ul>
        <?php
        echo "<li> <b>Code Type</b> : " . $housing['CODETYPEHEB'] . "</li>";
        echo "<li> <b>Nom</b> :  " . $housing['NOMHEB'] . "</li>";
        echo "<li> <b>Place</b> : " . $housing['NBPLACEHEB'] . "</li>";
        echo "<li> <b>Surface</b> : " . $housing['SURFACEHEB'] . "</li>";
        echo "<li> <b>Internet</b> : " . $housing['INTERNET'] . "</li>";
        echo "<li> <b>Année</b> : " . $housing['ANNEEHEB'] . "</li>";
        echo "<li> <b>Secteur</b> : " . $housing['SECTEURHEB'] . "</li>";
        echo "<li> <b>Orientation</b> : " . $housing['ORIENTATIONHEB'] . "</li>";
        echo "<li> <b>Etat</b> : " . $housing['ETATHEB'] . "</li>";
        echo "<li> <b>Description</b> : " . $housing['DESCRIHEB'] . "</li>";
        echo "<img src='../../../ressouces/img/post/" . $housing['PHOTOHEB'] .  "' width='50' height='50'>";
        echo "<li> <b>Tarif</b> : " . $housing['TARIFSEMHEB'] . "</li>";
        ?>
    </ul>
    <a href="./../../booking/view/bookingView.php?id=<?php echo $housing['NOHEB']; ?>">
        <button>Réserver</button>
    </a>
</body>

</html>