<?php

session_start();

include '../bdd.php';

#print_r($_SESSION['account']);

if (!isset($_SESSION['account'])) {
    header("location:./../index.php");
}

include './housing/controller/housingController.php';

include './../ressouces/component/select.php';


// $housing = getHousing($pdo);
if (isset($_GET['search']) && isset($_GET['CODETYPEHEB'])) {
    $dates = explode(" - ", $_GET['date']); # 2023-11-25 - 2023-11-25 
    $dateDeb = str_replace(' ', '', $dates[0]); #2023-11-25

    $housing = getSearchHousing($_GET['search'], $_GET['CODETYPEHEB'],  $dateDeb, $pdo);
} else {
    $housing = getSearchHousing("", "", date("Y-m-d"), $pdo);
}

$path = "./housing/view/housingView.php?id="
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="shortcut icon" href="../ressouces/img/ico/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,500;1,9..40,500&family=Inter:wght@700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;800&family=Manrope:wght@500&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../ressouces/css/home.css" />
    <link rel="stylesheet" href="../ressouces/css/searchBar.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bulma@4/bulma.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.fr.js"></script>


    <title>RESA-VVA</title>
</head>

<body>
    <section class="rented-list">
        <?php if (isset($_SESSION['success_message']) ? $_SESSION['success_message'] : false) {
            unset($_SESSION['success_message']);
        ?>
            <script>
                Swal.fire(
                    'Action effectuée !',
                    '',
                    'success'
                )
            </script>
        <?php
        }
        ?>
        <?php
        if ($_SESSION['account']['TYPECOMPTE'] != "VIS") {
            echo '<a href="./housing/view/addHousingView.php"><button>Crée un hébergement</button></a>';
            echo '<a href="./booking/view/bookingHomeView.php"><button>Gestionnaire</button></a>';
        }
        ?>
        <a href="temporalView.html"><button>View</button></a>
        <div class="rented-header">
            <h2><span class="underline">Liste </span>des propriétés</h2>
            <button>Voir tous les biens</button>
        </div>

        <form action="" method="GET">
            <input type="text" name="search" <?php echo "value='" . (isset($_GET['search']) ? htmlspecialchars($_GET['search']) : "") . "'" ?> placeholder="Rechercher">
            <input type="text" id="date-range" name="date" <?php echo "value='" . (isset($_GET['date']) ? htmlspecialchars($_GET['date']) : "") . "'" ?> placeholder="">

            <select name="CODETYPEHEB">
                <option value="" selected>Tout</option>
                <?php

                foreach (getHousingType($pdo) as $row) {
                    if (isset($_GET['CODETYPEHEB']) && $_GET['CODETYPEHEB'] == $row["CODETYPEHEB"]) {
                        echo '<option value="' . htmlspecialchars($row["CODETYPEHEB"]) . '" selected>' . htmlspecialchars($row["NOMTYPEHEB"]) . '</option>';
                    } else {

                        echo '<option value="' . htmlspecialchars($row["CODETYPEHEB"]) . '" >' . htmlspecialchars($row["NOMTYPEHEB"]) . '</option>';
                    }
                }
                ?>
            </select>
            <button type="submit" class="search-button">Rechercher</button>
        </form>

        <script>
            $(function() {

                $('#date-range').daterangepicker({
                    opens: 'left',
                    locale: {
                        format: 'YYYY-MM-DD',
                        applyLabel: 'Appliquer',
                        cancelLabel: 'Annuler',
                        daysOfWeek: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                        firstDay: 6 //  Commence Samedi

                    },
                    minDate: moment().startOf('day'), // Autorise uniquement les dates futures
                    isInvalidDate: function(date) { // Désactive les jours qui ne sont pas des samedis
                        return date.day() !== 6;
                    },
                    maxSpan: {
                        days: 7 // Limite la plage de dates à une semaine
                    }
                });

                // Événement appelé après que l'utilisateur a sélectionné une plage de dates
                $('#date-range').on('apply.daterangepicker', function(ev, picker) {

                    // if (picker.startDate.day() !== 6 || picker.endDate.day() !== 6 || picker.endDate.diff(picker.startDate, 'days') !== 6) {
                    //     alert('Veuillez sélectionner une plage de dates du samedi au samedi.');

                    //     $(this).val('');
                    // }
                });
            });
        </script>


        <div class="rented-container">

            <?php if (count($housing) == 0) { ?>
                <h2 class="errorMSG">Aucun logement <?php echo (isset($_GET['search'])) ? "pour cette recherche." : "" ?></h2>
            <?php } ?>
            <?php

            foreach ($housing as $row) {

            ?>
                <div class="card">
                    <?php
                    echo " <a href='" . $path . $row['NOHEB'] . "'>";
                    echo "<img src='../ressouces/img/post/" . $row['PHOTOHEB'] . "' class='placeholder-img' alt='illustration du logement'>";
                    echo "</a>";
                    ?>
                    <div class="info-rented">
                        <p class="rented-adress"><?php echo htmlspecialchars($row['NOMHEB']) ?></p>
                        <p class="rented-label"><?php echo htmlspecialchars(getSpecialHousingType($row['CODETYPEHEB'], $pdo)['NOMTYPEHEB'])  ?></p>
                        <!-- <p class="rented-label">Chambre privée</p> -->
                        <p class="rented-pricing"><?php echo htmlspecialchars($row['TARIFSEMHEB']) ?>€/Semaine</p>

                    </div>
                    <div class="rented-subinfo">
                        <div class="bedroom-container">
                            <img src="../ressouces/img/ico/Shower.svg" alt="icone Internet" />
                            <p><?php echo htmlspecialchars($row['INTERNET']) ?></p>
                        </div>
                        <div class="shower-container">
                            <img src="../ressouces/img/ico/Bed.svg" alt="icone lits" />
                            <p><?php echo htmlspecialchars($row['NBPLACEHEB']) ?></p>
                        </div>
                        <div class="size-container">
                            <img src="../ressouces/img/ico/Size.svg" alt="icone surface" />
                            <p><?php echo htmlspecialchars($row['SURFACEHEB']) ?>m²</p>
                        </div>
                    </div>
                </div>

            <?php

            }
            ?>



        </div>
        <div class="pagination-container">
            <!-- <div class="pagination">
                <button>Premier</button>
                <button class="is-here">1</button>
                <button>2</button>
                <button>3</button>
                <button>Dernier</button>
            </div> -->
        </div>
    </section>
</body>

</html>