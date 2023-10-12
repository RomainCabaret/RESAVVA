<?php

session_start();

include '../bdd.php';


include './housing/controller/housingController.php';


$housing = getHousing($pdo);

$path = "./housing/view/housingView.php?id="
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,500;1,9..40,500&family=Inter:wght@700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;800&family=Manrope:wght@500&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../ressouces/css/home.css" />
    <title>RESA-VVA</title>
</head>

<body style="background:black">
    <a href="./housing/view/addHousingView.php">Crée un hébergement</a>
    <a href="./housing/view/addHousingTypeView.php">Crée un type d'hébergement</a>
    <a href="temporalView.html">View</a>
    <!-- <h1>NAV</h1>
    <ul>
        <li>
            <a href="temporalView.html">View</a>
        </li>
        <li>
            <h2>List Hébergement</h2>
            <ul>
                <?php
                foreach ($housing as $house => $row) {
                    echo " <a href='" . $path . $row['NOHEB'] . "'><li> " . $row['NOMHEB'] . "</li></a>";
                    echo "<img src='../ressouces/img/post/" . $row['PHOTOHEB'] . "' width='50' height='50' >";
                }
                ?>
            </ul>
        </li>
        <li>
            <a href="./housing/view/addHousingView.php">Crée un hébergement</a>
        </li>
        <li>
            <a href="./housing/view/addHousingTypeView.php">Crée un type d'hébergement</a>
        </li>
    </ul> -->

    <section class="rented-list">
        <div class="rented-header">
            <h2><span class="underline">Liste </span>des propriétés</h2>
            <button>Voir tous les biens</button>
        </div>
        <div class="rented-container">

            <?php
            foreach ($housing as $house => $row) {
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
                        <p class="rented-adress"><?php echo $row['NOMHEB'] ?></p>
                        <p class="rented-label">Chambre privée</p>
                        <p class="rented-pricing"><?php echo $row['SURFACEHEB'] ?>€/Semaine</p>

                    </div>
                    <div class="rented-subinfo">
                        <div class="bedroom-container">
                            <img src="../ressouces/img/ico/Bed.svg" alt="" />
                            <p><?php echo $row['INTERNET'] ?></p>
                        </div>
                        <div class="shower-container">
                            <img src="../ressouces/img/ico/Shower.svg" alt="" />
                            <p><?php echo $row['NBPLACEHEB'] ?></p>
                        </div>
                        <div class="size-container">
                            <img src="../ressouces/img/ico/Size.svg" alt="" />
                            <p><?php echo $row['SURFACEHEB'] ?></p>
                        </div>
                    </div>
                </div>

            <?php

            }
            ?>



        </div>
        <div class="pagination-container">
            <div class="pagination">
                <button>Premier</button>
                <button class="is-here">1</button>
                <button>2</button>
                <button>3</button>
                <button>Dernier</button>
            </div>
        </div>
    </section>
</body>

</html>