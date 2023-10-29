<?php

session_start();


if (!isset($_SESSION['account']) || $_SESSION['account']['TYPECOMPTE'] == "VIS") {
    header("location:./../../homeView.php");
}


include '../../../bdd.php';
include '../controller/housingController.php';
include '../../../ressouces/component/select.php';


$defaultHousingImage = "default-house-icon.png";
$errorMSG = false;
$modify = false;
$housing;

if (isset($_GET['id']) && !empty(getSpecialHousing($_GET['id'], $pdo))) {
    $id = $_GET['id'];
    $housing = getSpecialHousing($id, $pdo);
    $modify = true;
}

if (
    isset($_POST['CODETYPEHEB']) &&
    isset($_POST['name']) &&
    isset($_POST['nbplace']) &&
    isset($_POST['surface']) &&
    // isset($_POST['internet']) &&
    isset($_POST['dateheb']) &&
    isset($_POST['secteur']) &&
    isset($_POST['orientation']) &&
    isset($_POST['state']) &&
    isset($_POST['description']) &&
    // isset($_FILES['picture']) &&
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
    $pricing = $_POST['pricing'];
    $picture;

    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $picture = $_FILES['picture'];
    } else {
        $picture = $defaultHousingImage;
    }

    if ($modify) {
        if ($picture === $defaultHousingImage) {
            $picture = "";
        }

        if (modifyHousing($_GET['id'], $type, $name, $NBplace, $surface, $internet, $dateHEB, $secteur, $orientation, $state, $description, $picture, $pricing, $pdo)) {
            $_SESSION['success_message'] = true;
            header("location:../../homeView.php");
        }
    } elseif (addNewHousing($type, $name, $NBplace, $surface, $internet, $dateHEB, $secteur, $orientation, $state, $description, $picture, $pricing, $pdo)) {
        $_SESSION['success_message'] = true;
        header("location:../../homeView.php");
    }
    $errorMSG = true;
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connectez-vous facilement à votre compte sur notre plateforme de location de confiance, similaire à Airbnb. Accédez à des offres uniques, gérez vos réservations en un clic et explorez des hébergements exceptionnels à travers le monde. Connectez-vous pour vivre l'expérience de voyage parfaite dès maintenant !">
    <link rel="shortcut icon" href="../../../ressouces/img/ico/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../../ressouces/css/addHousing.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bulma@4/bulma.css" rel="stylesheet">
    <title>RESA - VVA - <?php echo $modify ? "Modifie un hébergement"  : "Ajouter un hébergement" ?></title>
</head>

<body>
    <?php
    if ($errorMSG) {

    ?>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                width: 400,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: 'Erreur, Echec de l\'enregistrement'
            })
        </script>
    <?php
    }

    ?>

    <div class="container">
        <h1><?php echo $modify ? "Modification de " . htmlspecialchars($housing['NOMHEB']) : "Ajouter une nouvelle propriété" ?></h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="grid-layout">
                <div>
                    <label for="name">Nom : <span class="star">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Entrer un nom" maxlength="28" <?php echo $modify ? "value='" . htmlspecialchars($housing['NOMHEB']) . "'" : "" ?> required />
                </div>


                <div>
                    <label for="dateheb">Dernière remise en état : <span class="star">*</span></label>
                    <input type="number" name="dateheb" id="dateheb" placeholder="Entrer l'année" min="1975" max="<?php echo date('Y') ?>" <?php echo $modify ? "value='" . htmlspecialchars($housing['ANNEEHEB']) . "'" : "value='" . date('Y') . "'" ?> required>
                </div>


                <div>
                    <label for="nbplace">Nombre de places maximum : <span class="star">*</span></label>

                    <input type="number" name="nbplace" id="nbplace" placeholder="Entrer le nombre d'occupant maximum" min="1" max="10" <?php echo $modify ? "value='" . htmlspecialchars($housing['NBPLACEHEB']) . "'" : "" ?> required>
                </div>
                <div>
                    <label for="CODETYPEHEB">Type d'hébergement : <span class="star">*</span></label>

                    <?php showSelect(getHousingType($pdo), "CODETYPEHEB", "NOMTYPEHEB", $modify ? $housing['CODETYPEHEB'] : "") ?>
                </div>

                <div>
                    <label for="surface">Surface habitable : <span class="star">*</span></label>

                    <input type="number" name="surface" id="surface" placeholder="Entrer la superficie" min="10" max="1000" <?php echo $modify ? "value='" . htmlspecialchars($housing['SURFACEHEB']) . "'" : "" ?> required />
                </div>

                <div>
                    <label for="pricing">Prix : <span class="star">*</span></label>

                    <input type="number" name="pricing" id="pricing" placeholder="Entrer un prix" min="20" max="10000" <?php echo $modify ? "value='" . htmlspecialchars($housing['TARIFSEMHEB']) . "'" : "" ?> step="any" required />
                </div>

                <div>
                    <label for="secteur">Secteur : <span class="star">*</span></label>

                    <!-- <input type="text" name="secteur" id="secteur" placeholder="Entrer un nom" maxlength="15" <?php echo $modify ? "value='" . htmlspecialchars($housing['SECTEURHEB']) . "'" : "" ?> required /> -->

                    <select name="secteur" id="secteur">
                        <option value="Zone ski" <?php echo $modify ? ($housing['SECTEURHEB'] == "Zone ski" ? "selected" : "") : "" ?>>Zone ski</option>
                        <option value="Zone pâturage" <?php echo $modify ? ($housing['SECTEURHEB'] == "Zone pâturage" ? "selected" : "") : "" ?>>Zone pâturage</option>
                        <option value="Zone loisir" <?php echo $modify ? ($housing['SECTEURHEB'] == "Zone loisir" ? "selected" : "") : "" ?>>Zone loisir</option>
                        <option value="Zones refuge" <?php echo $modify ? ($housing['SECTEURHEB'] == "Zones refuge" ? "selected" : "") : "" ?>>Zones refuge</option>
                    </select>

                </div>

                <div>
                    <label for="orientation">Orientation : <span class="star">*</span></label>

                    <select name="orientation" id="orientation">
                        <option value="Nord" <?php echo $modify ? ($housing['ORIENTATIONHEB'] == "Nord" ? "selected" : "") : "" ?>>Nord</option>
                        <option value="Sud" <?php echo $modify ? ($housing['ORIENTATIONHEB'] == "Sud" ? "selected" : "") : "" ?>>Sud</option>
                        <option value="Est" <?php echo $modify ? ($housing['ORIENTATIONHEB'] == "Est" ? "selected" : "") : "" ?>>Est</option>
                        <option value="West" <?php echo $modify ? ($housing['ORIENTATIONHEB'] == "West" ? "selected" : "") : "" ?>>Ouest</option>
                    </select>
                </div>

                <div>
                    <label for="state">Etat : <span class="star">*</span></label>

                    <!-- <input type="text" placeholder="Entrer un Etat" name="state" id="state" maxlength="32" required /> -->
                    <select name="state" id="state">
                        <option value="Parfais" <?php echo $modify ? ($housing['ETATHEB'] == "Parfais" ? "selected" : "") : "" ?>>Parfais</option>
                        <option value="Bon" <?php echo $modify ? ($housing['ETATHEB'] == "Bon" ? "selected" : "") : "" ?>>Bon</option>
                        <option value="Correct" <?php echo $modify ? ($housing['ETATHEB'] == "Correct" ? "selected" : "") : "" ?>>Correct</option>
                        <option value="Renovation" <?php echo $modify ? ($housing['ETATHEB'] == "Renovation" ? "selected" : "") : "" ?>>Renovation</option>
                    </select>
                </div>
                <div>
                    <label for="internet">Internet : <span class="star">*</span></label>

                    <input type="checkbox" name="internet" id="internet" <?php echo $modify ? ($housing['INTERNET'] ? "checked" : "")  : "" ?> />
                </div>
            </div>
            <div class="bottom-container">
                <div class="desc-container">
                    <label for="description">Description : <span class="star">*</span></label>
                    <textarea placeholder="Enter une description" name="description" id="description" cols="30" rows="10" maxlength="200" required><?php echo $modify ?  htmlspecialchars($housing['DESCRIHEB']) : "" ?></textarea>
                </div>


                <div class="img-container">
                    <?php if ($modify && $housing['PHOTOHEB']) { ?>
                        <div style="display: flex; justify-content:center;align-items: center;flex-direction:column;width: 90%;">
                            <input type="hidden" name="old_picture" value="<?php echo $housing['PHOTOHEB']; ?>">
                            <label>Image actuel: </label>
                            <img src="../../../ressouces/img/post/<?php echo $housing['PHOTOHEB']; ?>" alt="Image actuelle" style="max-width: 200px;">
                        </div>
                    <?php } ?>
                    <label for="picture"><?php echo $modify ? "Modifier" : "Ajouter" ?> une image : <span class="star">*</span></label>
                    <label for="picture" class="drop-container" id="dropcontainer">
                        <span class="drop-title">Supporte : JPG, JPEG, PNG</span>
                        <input type="file" id="picture" accept="image/*" name="picture" />
                    </label>

                </div>
                <div class="btn-container">
                    <button><?php echo $modify ? "Modifier" : "Ajouter" ?> une propriété</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>