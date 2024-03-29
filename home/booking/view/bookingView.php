<?php

session_start();

include '../../../bdd.php';
include '../controller/bookingController.php';
include '../../../ressouces/component/select.php';


if (!isset($_SESSION['account']) || $_SESSION['account']['TYPECOMPTE'] == "VIS") {
    header("location:./../../homeView.php");
}


$booking;


if (isset($_GET['id']) && !empty(getSpecialBooking($_GET['id'], $pdo))) {
    $id = $_GET['id'];
    $booking = getSpecialBooking($id, $pdo);
} else {
    header('location:../../homeView.php');
}

$bookingWeek = getSimpleBookingWeek($booking['DATEDEBSEM'], $pdo);



if (isset($_POST['CODEETATRESA'])) {

    if (DateTime::createFromFormat('Y-m-d', $bookingWeek['DATEFINSEM']) > new DateTime()) {
        if ($_POST['CODEETATRESA'] != 'BL') {
            $query = "UPDATE `resa` SET `DATEARRHES`= now() WHERE `NORESA` = :id AND DATEARRHES = null ";

            try {
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':id', $_GET['id']);
                $stmt->execute();
                if (modifyBookingState($_GET['id'], $_POST['CODEETATRESA'], $pdo)) {
                    header("location:./bookingHomeView.php");
                } else {
                    echo "Erreur interne";
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    } else {
        echo "Le gestionnaire ne peut pas modifier une réservation dont la date de fin de séjour est écoulée.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../ressouces/img/ico/favicon.png" type="image/x-icon">
    <title>RESA - VVA - <?php echo $booking['NORESA'] ?></title>
</head>

<body>
    <h1>House</h1>
    <form action="" method="post">
        <ul>
            <?php
            echo "<li> <b>Numero Résa</b> : " . htmlspecialchars($booking['NORESA']) . "</li>";
            echo "<li> <b>Réservant</b> : " . htmlspecialchars($booking['USER']) . "</li>";
            echo "<li> <b>Date debut</b> :  " . htmlspecialchars($booking['DATEDEBSEM']) . "</li>";
            echo "<li> <b>Date fin</b> : " . htmlspecialchars($bookingWeek['DATEFINSEM']) . "</li>";
            echo "<li> <b>Numero Hebergement</b> : " . htmlspecialchars($booking['NOHEB']) . "</li>";
            echo "<li> <b>Etape résa</b> : " . htmlspecialchars($booking['NOMETATRESA']) . "</li>";
            echo "<li> <b>Montant Arres </b> : " . htmlspecialchars($booking['MONTANTARRHES']) . "</li>";
            echo "<li> <b>Nombre d'occupant</b> : " . htmlspecialchars($booking['NBOCCUPANT']) . "</li>";
            echo "<li> <b>TARIF SEMAINE</b> : " . htmlspecialchars($booking['TARIFSEMRESA']) . "</li>";
            showSelect(getBookingState($pdo), "CODEETATRESA", "NOMETATRESA", $booking['CODEETATRESA'])
            ?>
        </ul>
        <button>Modifier</button>
    </form>
</body>

</html>