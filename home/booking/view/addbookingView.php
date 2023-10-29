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

if (!isset($_SESSION['account'])) {
    header("location:./../../homeView.php");
}

$housing;


if (isset($_GET['id']) && !empty(getSpecialHousing($_GET['id'], $pdo))) {
    $idHousing = $_GET['id'];
    $housing = getSpecialHousing($idHousing, $pdo);
} else {
    header('location:../../homeView.php');
}

$id = $housing['NOHEB'] . $housing['ANNEEHEB'];
$login = $_SESSION['account']['USER'];
#$housingId = $_GET['id'];
$housingId = $housing['NOHEB'];
$housingType = "AV";
$pricePerWeek =  $housing['TARIFSEMHEB'];

if (isset($_POST['amountPeople'])) {

    $bookingStart = $_POST['bookingStart'];
    $bookingEnd = $_POST['bookingEnd'];
    $amountPeople = $_POST['amountPeople'];

    #echo getSpecialBookingWeek('2023-09-01', '2023-09-30', $pdo)[0];

    $start = new DateTime($bookingStart);
    $end = new DateTime($bookingEnd);

    $interval = $start->diff($end);
    $intervalInWeeks = floor($interval->days / 7);

    echo "L'intervalle en semaine est de : " . $intervalInWeeks . " semaines";

    if (empty(getSpecialBookingWeek($bookingStart, $bookingEnd, $pdo)[0]['DATEDEBSEM'])) {
        if (!addNewBookingWeek($bookingStart, $bookingEnd, $pdo)) {
            die("error week");
        }
    }

    echo '<br>';

    echo $amountPeople;
    echo '<br>';
    echo $bookingStart;
    echo '<br>';
    echo $bookingEnd;

    $bookingPrice = 10 * $intervalInWeeks;



    // if (verifyDate($bookingStart, $bookingEnd)) {
    //     echo "Date Valid";
    // } else {
    //     echo "Date Non Valid";
    // }

    if (addNewBooking($id, $login, $bookingStart, $housingId, $housingType, $bookingStart, $bookingEnd, $bookingPrice, $amountPeople, $pricePerWeek, $pdo)) {
        die("GG");
    } else {
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body>
    <h1>Réserver</h1>

    <form action="" method="post">
        <label for="amountPeople">Nombre d'occupant</label>
        <input type="number" id="amountPeople" name="amountPeople">

        <label for="bookingStart">Date debut réservation</label>
        <input type="date" name="bookingStart" id="bookingStart">

        <label for="bookingEnd">Date fin réservation</label>
        <input type="date" name="bookingEnd" id="bookingEnd">

        <input type="text" name="datefilter" value="" />



        <button>Valider la réservation</button>
    </form>

    <script>
        $(function() {

            $('input[name="datefilter"]').daterangepicker({
                "maxSpan": {
                    "days": 7
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                autoUpdateInput: false,
                minDate: "<?php echo Date("m/d/Y"); ?>",
                // minDate: "10/26/2023",
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

        });
    </script>


</body>

</html>