<?php

session_start();

include '../../../bdd.php';

include '../controller/bookingController.php';
include '../../housing/controller/housingController.php';



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

$login = $_SESSION['account']['USER'];
$housingId = $housing['NOHEB'];
$bookingType = "BL";
$pricePerWeek =  $housing['TARIFSEMHEB'];

if (isset($_POST['amountPeople'])) {

    $dates = explode(" - ", $_POST['date']); # 2023-11-25 - 2023-12-02 

    $bookingStart = str_replace(' ', '', $dates[0]); #2023-11-25
    $bookingEnd = str_replace(' ', '', $dates[1]); #2023-12-02
    $amountPeople = $_POST['amountPeople'];

    #echo getSpecialBookingWeek('2023-09-01', '2023-09-30', $pdo)[0];

    $start = new DateTime($bookingStart);
    $end = new DateTime($bookingEnd);

    $interval = $start->diff($end);
    $intervalInWeeks = floor($interval->days / 7);

    if($start == $end){
        echo "Date incorrect, veuillez selection une semaine";
    }else{

        #echo "L'intervalle en semaine est de : " . $intervalInWeeks . " semaines";
    
        if (empty(getSpecialBookingWeek($bookingStart, $bookingEnd, $pdo)[0]['DATEDEBSEM'])) {
            if (!addNewBookingWeek($bookingStart, $bookingEnd, $pdo)) {
                #die("error week");
            }
        }
    
        echo '<br>';
    
    
        $bookingPrice = ($housing['TARIFSEMHEB'] * $intervalInWeeks) * 0.20; # MONTANTARRHES ?
    
    
        $result = addNewBooking($login, $bookingStart, $housingId, $bookingType, date('Y-m-d'), $bookingPrice, $amountPeople, $pricePerWeek, $pdo);
    
    
        echo '<a href="../../homeView.php">Retour à l\'acceil</a>';
        echo '<br>';
        if ($result !== false) {
            die("Votre réservation a bien été enregistrée avec le numéro : " . $result);
        } else {
            die(":/ Vous avez deja réservé une réservation");
        }
    }

}



// addNewBooking($id, $login, $dateStart, $housingId, $bookingType, $bookingStart, $bookingEnd, $bookingPrice, $amountPeople, $pricePerWeek, $pdo);
// $housing = getSpecialHousing($id, $pdo);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Fichier de traduction pour le français -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.fr.js"></script>

    <link rel="stylesheet" href="../../../ressouces/css/searchBar.css" />

</head>

<body>
    <h1 class="main">Réserver</h1>

    <form action="" method="post">
        <label for="amountPeople">Nombre d'occupant</label>
        <input type="number" id="amountPeople" name="amountPeople" value="1" max="<?php echo $housing['NBPLACEHEB'] ?>">

        <label for="date-range">Date réservation</label>
        <input type="text" id="date-range" name="date" placeholder="xxxx-xx-xx" required>


        <button>Valider la réservation</button>
    </form>

    <script>
        $(function() {
            moment.locale('fr');

            //semaines à exclure
            var weeksToExclude = [
                // [moment('2023-11-25'), moment('2023-12-02')], // Exclure 25 novembre au 2 décembre 2023
                // [moment('2023-12-09'), moment('2023-12-16')], // Exclure 9 décembre au 16 décembre 2023
                <?php
                foreach (getHousingBookingWeek($housing['NOHEB'], $pdo) as $row) {
                    $excludeDateDeb = $row['DATEDEBSEM'];
                    $excludeDateEnd = date('Y-m-d', strtotime($row['DATEDEBSEM'] . ' + 6 days'));

                    echo "[moment('$excludeDateDeb'), moment('$excludeDateEnd')],\n";
                }

                ?>
            ];

            $('#date-range').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD',
                    applyLabel: 'Appliquer',
                    cancelLabel: 'Annuler',
                    daysOfWeek: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                    monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                    firstDay: 6 // Commence à Samedi
                },
                minDate: moment().startOf('day'), // uniquement dates futures
                isInvalidDate: function(date) {
                    // date à exclure
                    for (var i = 0; i < weeksToExclude.length; i++) {
                        if (date.isBetween(weeksToExclude[i][0], weeksToExclude[i][1], null, '[]')) {
                            return true;
                        }
                    }
                    return date.isoWeekday() !== 6; // Désactive autres jours
                },
                maxSpan: {
                    days: 7
                }
            });

            // Événement sélectionné plage
            $('#date-range').on('apply.daterangepicker', function(ev, picker) {

                // Vérifie si la plage de dates sélectionnée est du samedi au samedi
                if (picker.startDate.isoWeekday() !== 6 || picker.endDate.isoWeekday() !== 6) {
                    alert('Veuillez sélectionner une plage de dates du samedi au samedi.');
                    // Réinitialise le champ de saisie
                    $(this).val('');
                }
            });
        });
    </script>


</body>

</html>