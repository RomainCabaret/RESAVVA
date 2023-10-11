<?php

session_start();

include '../../../bdd.php';

include '../controller/bookingController.php';
include '../../housing/controller/housingController.php';



// if (
//     #isset($_POST['type']) &&
//     isset($_POST['name']) &&
//     isset($_POST['nbplace']) &&
//     isset($_POST['surface']) &&
//     // isset($_POST['internet']) &&
//     isset($_POST['dateheb']) &&
//     isset($_POST['secteur']) &&
//     isset($_POST['orientation']) &&
//     isset($_POST['state']) &&
//     isset($_POST['description']) &&
//     isset($_FILES['picture']) &&
//     isset($_POST['pricing'])
// ) {
//     $id = 250;
//     $type = $_POST['CODETYPEHEB'];
//     $name = $_POST['name'];
//     $NBplace = $_POST['nbplace'];
//     $surface = $_POST['surface'];
//     $internet = isset($_POST['internet']) ? 1 : 0;
//     $dateHEB = $_POST['dateheb'];
//     $secteur = $_POST['secteur'];
//     $orientation = $_POST['orientation'];
//     $state = $_POST['state'];
//     $description = $_POST['description'];
//     $picture = $_FILES['picture'];
//     $pricing = $_POST['pricing'];
// }


//$id, $user, $dateStart, $housing, $typeHousing, $dateBooking, $dateEnd, $priceBooking, $amountPeople, $pricePerWeek, $pdo

$id = 12;
$login = $_SESSION['login'];
#$housingId = $_GET['id'];
$housingId = 1;
$housingType = "CC";
$bookingPrice = 10;
$pricePerWeek = 10;

if (isset($_POST['amountPeople'])) {

    $bookingStart = $_POST['bookingStart'];
    $bookingEnd = $_POST['bookingEnd'];
    $amountPeople = $_POST['amountPeople'];

    #echo getSpecialBookingWeek('2023-09-01', '2023-09-30', $pdo)[0];

    if (empty(getSpecialBookingWeek($bookingStart, $bookingEnd, $pdo)[0]['DATEDEBSEM'])) {
        if (!addNewBookingWeek($bookingStart, $bookingEnd, $pdo)) {
            die("error week");        
        }
    }

    echo $amountPeople;
    echo '<br>';
    echo $bookingStart;
    echo '<br>';
    echo $bookingEnd;
    
    if(addNewBooking($login, $bookingStart, $housingId, $housingType, $bookingStart, $bookingEnd, $bookingPrice, $amountPeople, $pricePerWeek, $pdo)){
        die ("GG");
    }
    else{
        die("error");
    }


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
    <h1>Réserver</h1>

    <form action="./bookingView.php" method="post">
        <label for="amountPeople">Nombre d'occupant</label>
        <input type="number" id="amountPeople" name="amountPeople">

        <label for="bookingStart">Date debut réservation</label>
        <input type="date" name="bookingStart" id="bookingStart">

        <label for="bookingEnd">Date fin réservation</label>
        <input type="date" name="bookingEnd" id="bookingEnd">


        <button>Valider la réservation</button>
    </form>


</body>

</html>