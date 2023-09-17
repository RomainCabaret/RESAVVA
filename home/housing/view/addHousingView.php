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


    $id = 250;
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
    <title>Document</title>
</head>

<body>
    <h1>Ajouter un hebergement</h1>
    <?php echo $errorMSG ?>
    <form action="addHousingView.php" method="post" enctype="multipart/form-data">

        <?php showSelect(getHousingType($pdo), "CODETYPEHEB", "NOMTYPEHEB" ) ?> 

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

</body>

</html>