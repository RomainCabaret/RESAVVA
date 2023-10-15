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

    $housing = getSearchHousing($_GET['search'], $_GET['CODETYPEHEB'], $pdo);
} else {
    $housing = getSearchHousing("", "", $pdo);
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
        }
        ?>
        <a href="temporalView.html"><button>View</button></a>
        <div class="rented-header">
            <h2><span class="underline">Liste </span>des propriétés</h2>
            <button>Voir tous les biens</button>
        </div>
        <form action="" method="GET">
            <input type="text" name="search" <?php echo "value='" . (isset($_GET['search']) ? htmlspecialchars($_GET['search']) : "") . "'" ?> placeholder="Rechercher">
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

        <div class="rented-container">

            <?php if (count($housing) == 0) { ?>
                <h2 class="errorMSG">Aucun logement <?php echo (isset($_GET['search'])) ? "pour cette recherche." : "" ?></h2>
            <?php } ?>
            <?php

            foreach ($housing as $row) {
                // echo " <a href='" . $path . $row['NOHEB'] . "'><li> " . $row['NOMHEB'] . "</li></a>";
                // echo "<img src='../ressouces/img/post/" . $row['PHOTOHEB'] . "' class='placeholder-img' >";

            ?>
                <div class="card">
                    <?php
                    echo " <a href='" . $path . $row['NOHEB'] . "'>";
                    echo "<img src='../ressouces/img/post/" . $row['PHOTOHEB'] . "' class='placeholder-img' >";
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
                            <img src="../ressouces/img/ico/Shower.svg" alt="" />
                            <p><?php echo htmlspecialchars($row['INTERNET']) ?></p>
                        </div>
                        <div class="shower-container">
                            <img src="../ressouces/img/ico/Bed.svg" alt="" />
                            <p><?php echo htmlspecialchars($row['NBPLACEHEB']) ?></p>
                        </div>
                        <div class="size-container">
                            <img src="../ressouces/img/ico/Size.svg" alt="" />
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