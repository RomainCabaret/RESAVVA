<?php

session_start();

include '../../../bdd.php';

include '../controller/bookingController.php';
include '../../housing/controller/housingController.php';



if (!isset($_SESSION['account']) || $_SESSION['account']['TYPECOMPTE'] == "VIS") {
    header("location:./../../homeView.php");
}


$booking;

if (isset($_GET['dateStart']) && isset($_GET['dateEnd'])) {
    $booking = getSearchBooking($_GET['dateStart'], $_GET['dateEnd'], $pdo);
} else {

    $prochainSamedi = strtotime('next Saturday');
    $dateProchainSamedi = date('Y-m-d', $prochainSamedi);

    $date = new DateTime($dateProchainSamedi);
    $date->modify('+1 week');

    $dateNouveauSamedi = $date->format('Y-m-d');

    echo "Le prochain samedi sera le : " . $dateProchainSamedi . "<br>";
    echo "Le samedi de la semaine suivante sera le : " . $dateNouveauSamedi;

    $dateDebut = date('Y-m-d', strtotime('next Saturday'));
    $dateFin = date('Y-m-d', strtotime('+1 week', $prochainSamedi));

    $booking = getSearchBooking($dateDebut, $dateFin, $pdo);
}



if (isset($_POST['amountPeople'])) {

    $bookingStart = $_POST['bookingStart'];
    $bookingEnd = $_POST['bookingEnd'];
    $amountPeople = $_POST['amountPeople'];

    #echo getSpecialBookingWeek('2023-09-01', '2023-09-30', $pdo)[0];

    $start = new DateTime($bookingStart);
    $end = new DateTime($bookingEnd);

    $interval = $start->diff($end);
    $intervalInWeeks = floor($interval->days / 7);


    echo '<br>';

    echo $amountPeople;
    echo '<br>';
    echo $bookingStart;
    echo '<br>';
    echo $bookingEnd;

    // if (verifyDate($bookingStart, $bookingEnd)) {
    //     echo "Date Valid";
    // } else {
    //     echo "Date Non Valid";
    // }

}



// addNewBooking($id, $login, $dateStart, $housingId, $housingType, $bookingStart, $bookingEnd, $bookingPrice, $amountPeople, $pricePerWeek, $pdo);
// $housing = getSpecialHousing($id, $pdo);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="" method="GET">
        <input type="date" name="dateStart" id="">
        <input type="date" name="dateEnd" id="">
        <button>Rechercher</button>
    </form>
    <h1>Réserver</h1>


    <?php

    if (isset($_GET['dateStart'])) {
        echo "du " . $_GET['dateStart'];
        echo " aux " . $_GET['dateEnd'];
        echo "<br>";
        echo "<br>";
    }

    if (count($booking) != 0) {

        foreach ($booking as $key) {
            echo "N° " . $key['NORESA'] . " - ";
            echo $key['USER'] . " - ";
            echo $key['NBOCCUPANT'] . " personnes - ";
            echo $key['NOMETATRESA'] . " - ";
            echo '<a href="./bookingView.php?id=' . $key['NORESA'] . '"> Plus d\' info</a>';
            echo "<br>";
        }
    } else {
        echo "Aucun résultat";
    }

    ?>


</body>

</html>