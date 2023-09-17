<?php
session_start();


include '../../../bdd.php';
include '../controller/housingController.php';


$errorMSG = "";

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    if (addNewTypeHousing($name, $name, $pdo)) {
        header("location:../../homeView.php");
    } else {
        $errorMSG = "failed to add housing type";
    }
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
    <h1>Ajouter un type d'hebergement</h1>
    <?php echo $errorMSG ?>
    <form action="addHousingTypeView.php" method="post">
        <label for="name">Nom</label>
        <input type="text" name="name" id="name">

        <button>Enregister</button>
    </form>

</body>

</html>