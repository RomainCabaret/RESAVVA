<?php
session_start();


if (!isset($_SESSION['account']) || $_SESSION['account']['TYPECOMPTE'] == "VIS") {
    header("location:./../../homeView.php");
}


include '../../../bdd.php';
include '../controller/housingController.php';

include '../../../ressouces/component/select.php';


$errorMSG = "";

if (
    #isset($_POST['type']) &&
    isset($_POST['name']) &&
    isset($_POST['nbplace']) &&
    isset($_POST['surface']) &&
    // isset($_POST['internet']) &&
    isset($_POST['dateheb']) &&
    isset($_POST['secteur']) &&
    isset($_POST['orientation']) &&
    isset($_POST['state']) &&
    isset($_POST['description']) &&
    isset($_FILES['picture']) &&
    isset($_POST['pricing'])
) {


    $type = $_POST['CODETYPEHEB'];
    $name = $_POST['name'];
    $NBplace = $_POST['nbplace'];
    $surface = $_POST['surface'];
    $internet = isset($_POST['internet']) ? 1 : 0;
    $dateHEB = $_POST['dateheb'];
    $secteur = $_POST['secteur'];
    $orientation = $_POST['orientation'];
    $state = $_POST['state'];
    $description = $_POST['description'];
    $picture = $_FILES['picture'];
    $pricing = $_POST['pricing'];


    $name = $_POST['name'];
    if (addNewHousing($type, $name, $NBplace, $surface, $internet, $dateHEB, $secteur, $orientation, $state, $description, $picture, $pricing, $pdo)) {
        header("location:../../homeView.php");
    }
    $errorMSG = "failed to add housing type";
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../../ressouces/css/addHousing.css" />
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1>Ajouter une nouvelle propriété</h1>
        <?php echo $errorMSG ?>
        <form action="addHousingView.php" method="post" enctype="multipart/form-data">
            <div class="grid-layout">
                <div>
                    <label for="name">Nom : <span class="star">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Entrer un nom" maxlength="40" required />
                </div>


                <div>
                    <label for="dateheb">Année de l'hébergement : <span class="star">*</span></label>
                    <input type="number" name="dateheb" id="dateheb" placeholder="Entrer l'année" required>
                </div>


                <div>
                    <label for="nbplace">Nombre de places : <span class="star">*</span></label>

                    <input type="number" name="nbplace" id="nbplace" placeholder="Entrer le nombre d'occupant possible" max="5" required>
                </div>
                <div>
                    <label for="">Type d'hébergement : <span class="star">*</span></label>

                    <?php showSelect(getHousingType($pdo), "CODETYPEHEB", "NOMTYPEHEB") ?>
                </div>

                <div>
                    <label for="surface">Surface : <span class="star">*</span></label>

                    <input type="number" name="surface" id="surface" placeholder="Entrer la superficie" required />
                </div>

                <div>
                    <label for="pricing">Prix : <span class="star">*</span></label>

                    <input type="number" name="pricing" id="pricing" placeholder="Entrer un prix" required />
                </div>

                <div>
                    <label for="secteur">Secteur : <span class="star">*</span></label>

                    <input type="text" name="secteur" id="secteur" placeholder="Entrer un nom" maxlength="15" required />
                </div>

                <div>
                    <label for="orientation">Orientation : <span class="star">*</span></label>

                    <select name="orientation" id="orientation">
                        <option value="Nord">Nord</option>
                        <option value="Sud">Sud</option>
                        <option value="Est">Est</option>
                        <option value="West">Ouest</option>
                    </select>
                </div>

                <div>
                    <label for="state">Etat : <span class="star">*</span></label>

                    <!-- <input type="text" placeholder="Entrer un Etat" name="state" id="state" maxlength="32" required /> -->
                    <select name="state" id="state">
                        <option value="Parfais">Parfais</option>
                        <option value="Bon">Bon</option>
                        <option value="Correct">Correct</option>
                        <option value="Renovation">Renovation</option>
                    </select>
                </div>
                <div>
                    <label for="internet">Internet : <span class="star">*</span></label>

                    <input type="checkbox" name="internet" id="internet" />
                </div>
            </div>
            <div class="bottom-container">
                <div class="desc-container">
                    <label for="description">Description : <span class="star">*</span></label>
                    <textarea placeholder="Enter une description" name="description" id="description" cols="30" rows="10" maxlength="200" required></textarea>
                </div>

                <div class="img-container">
                    <label for="picture">Ajouter une image : <span class="star">*</span></label>
                    <label for="picture" class="drop-container" id="dropcontainer">
                        <span class="drop-title">Supporte : JPG, JPEG, PNG</span>
                        <input type="file" id="picture" accept="image/*" name="picture" required />
                    </label>
                </div>
                <div class="btn-container">
                    <button>Ajouter une propriété</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>