<?php
session_start();


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


    $id = 251;
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
    if (addNewHousing($id, $type, $name, $NBplace, $surface, $internet, $dateHEB, $secteur, $orientation, $state, $description, $picture, $pricing, $pdo)) {
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

<!-- <body>
    <h1>Ajouter un hebergement</h1>
    <?php echo $errorMSG ?>
    <form action="addHousingView.php" method="post" enctype="multipart/form-data">

        <?php showSelect(getHousingType($pdo), "CODETYPEHEB", "NOMTYPEHEB") ?>

        <br>

        <label for="name">Nom</label>
        <input type="text" name="name" id="name">

        <br>

        <label for="nbplace">Nombre de place</label>
        <input type="number" name="nbplace" id="nbplace">

        <br>

        <label for="surface">Surface</label>
        <input type="number" name="surface" id="surface">

        <br>

        <label for="internet">Internet</label>
        <input type="checkbox" name="internet" id="internet">

        <br>

        <label for="dateheb">Année de l'hébergement</label>
        <input type="text" name="dateheb" id="dateheb">

        <br>

        <label for="secteur">Secteur de l'hébergement</label>
        <input type="text" name="secteur" id="secteur">

        <br>

        <label for="orientation">Orientation</label>
        <input type="text" name="orientation" id="orientation">

        <br>

        <label for="state">Etat de l'hébergement</label>
        <input type="text" name="state" id="state">

        <br>

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>

        <br>

        <label for="picture">Photo de l'hébergement</label>
        <input type="file" name="picture" id="picture" accept="image/*">

        <br>

        <label for="pricing">Tarif</label>
        <input type="number" name="pricing" id="pricing">

        <br>
        <br>

        <button>Enregister</button>
    </form>

</body> -->

<body>
    <div class="container">
        <h1>Ajouter une nouvelle propriété</h1>
        <?php echo $errorMSG ?>
        <form action="addHousingView.php" method="post" enctype="multipart/form-data">
            <div class="grid-layout">
                <div>
                    <label for="name">Nom : <span class="star">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Entrer un nom" />
                </div>


                <div>
                    <label for="dateheb">Année de l'hébergement : <span class="star">*</span></label>
                    <input type="number" name="dateheb" id="dateheb">
                </div>


                <div>
                    <label for="nbplace">Nombre de places : <span class="star">*</span></label>

                    <input type="number" name="nbplace" id="nbplace" placeholder="Entrer le nombre d'occupant possible" />
                </div>
                <div>
                    <label for="">Type d'hébergement : <span class="star">*</span></label>

                    <?php showSelect(getHousingType($pdo), "CODETYPEHEB", "NOMTYPEHEB") ?>
                </div>

                <div>
                    <label for="surface">Surface : <span class="star">*</span></label>

                    <input type="number" name="surface" id="surface" placeholder="Entrer la superficie" />
                </div>

                <div>
                    <label for="pricing">Prix : <span class="star">*</span></label>

                    <input type="number" name="pricing" id="pricing" placeholder="Entrer un prix" />
                </div>

                <div>
                    <label for="secteur">Secteur : <span class="star">*</span></label>

                    <input type="text" name="secteur" id="secteur" placeholder="Entrer un nom" />
                </div>

                <div>
                    <label for="orientation">Orientation : <span class="star">*</span></label>

                    <input type="text" placeholder="Entrer un nom" name="orientation" id="orientation" />
                </div>

                <div>
                    <label for="state">Etat : <span class="star">*</span></label>

                    <input type="text" placeholder="Entrer un Etat" name="state" id="state" />
                </div>
                <div>
                    <label for="internet">Internet : <span class="star">*</span></label>

                    <input type="checkbox" name="internet" id="internet" />
                </div>
            </div>
            <div class="bottom-container">
                <div class="desc-container">
                    <label for="description">Description : <span class="star">*</span></label>
                    <textarea placeholder="Enter une description" name="description" id="description" cols="30" rows="10"></textarea>
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