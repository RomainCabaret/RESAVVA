<?php

session_start();

include '../../../bdd.php';
include '../controller/housingController.php';

$housing;


if (isset($_GET['id']) && !empty( getSpecialHousing($_GET['id'], $pdo) ) ) {
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
        echo "<li> " . $housing['CODETYPEHEB'] . "</li>";
        echo "<li> " . $housing['NOMHEB'] . "</li>";
        echo "<li> " . $housing['NBPLACEHEB'] . "</li>";
        echo "<li> " . $housing['SURFACEHEB'] . "</li>";
        echo "<li> " . $housing['INTERNET'] . "</li>";
        echo "<li> " . $housing['ANNEEHEB'] . "</li>";
        echo "<li> " . $housing['SECTEURHEB'] . "</li>";
        echo "<li> " . $housing['ORIENTATIONHEB'] . "</li>";
        echo "<li> " . $housing['ETATHEB'] . "</li>";
        echo "<li> " . $housing['DESCRIHEB'] . "</li>";
        echo "<img src='../../../ressouces/img/post/" . $housing['PHOTOHEB'] .  "' width='50' height='50'>";
        echo "<li> " . $housing['TARIFSEMHEB'] . "</li>";
        ?>
    </ul>
    <a href="./../../booking/view/bookingView.php?id=<?php echo $housing['NOHEB']; ?>">
        <button>Réserver</button>
    </a>
</body>

</html>