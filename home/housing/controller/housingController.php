<?php


// ---------------------- HOUSING ----------------------

function getSpecialHousing($id, $pdo)
{
    $query =  "SELECT `CODETYPEHEB`, `NOMHEB`, `NBPLACEHEB`, `SURFACEHEB`, `INTERNET`, `ANNEEHEB`, `SECTEURHEB`, `ORIENTATIONHEB`, `ETATHEB`, `DESCRIHEB`, `PHOTOHEB`, `TARIFSEMHEB` FROM `hebergement` WHERE NOHEB = :id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

function getHousing($pdo)
{

    $query =  "SELECT `NOHEB`, `CODETYPEHEB`, `NOMHEB`, `NBPLACEHEB`, `SURFACEHEB`, `INTERNET`, `ANNEEHEB`, `SECTEURHEB`, `ORIENTATIONHEB`, `ETATHEB`, `DESCRIHEB`, `PHOTOHEB`, `TARIFSEMHEB` FROM `hebergement`";

    $stmt = $pdo->prepare($query);
    $stmt->execute();


    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addNewHousing($id, $type, $name, $NBplace, $surface, $internet, $dateHEB, $secteur, $orientation, $state, $description, $picture, $pricing, $pdo)
{
    $query = "INSERT INTO `hebergement`(`NOHEB`, `CODETYPEHEB`, `NOMHEB`, `NBPLACEHEB`, `SURFACEHEB`, `INTERNET`, `ANNEEHEB`, `SECTEURHEB`, `ORIENTATIONHEB`, `ETATHEB`, `DESCRIHEB`, `PHOTOHEB`, `TARIFSEMHEB`) VALUES (:id,:type,:name,:nbplace,:surface,:internet,:dateheb,:secteur,:orientation,:state,:description,:picture,:pricing)";

    if (isset($picture) && $picture['error'] === UPLOAD_ERR_OK) {

        $uuid = uniqid();
        $extension = pathinfo($picture['name'], PATHINFO_EXTENSION);


        $imgName = strtolower($uuid . '.' . $extension);

        // $imgType = $picture['type'];
        // $imgData = file_get_contents($picture['tmp_name']);

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':nbplace', $NBplace);
        $stmt->bindParam(':surface', $surface);
        $stmt->bindParam(':internet', $internet);
        $stmt->bindParam(':dateheb', $dateHEB);
        $stmt->bindParam(':secteur', $secteur);
        $stmt->bindParam(':orientation', $orientation);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':picture', $imgName);
        $stmt->bindParam(':pricing', $pricing);

        // try {
        $stmt->execute();

        $path = '../../../ressouces/img/post/';
        $destinationPath = $path . $imgName;

        if (move_uploaded_file($picture['tmp_name'], $destinationPath)) {
            return true;
        }
        // } catch (Exception $e) {
        // }
    }

    return false;
}


// ----------------------  HOUSING TYPE ----------------------


# **** we need to include bdd.php in file will use that function ****

function addNewTypeHousing($id, $name, $pdo)
{
    $query = "INSERT INTO `type_heb`(`CODETYPEHEB`, `NOMTYPEHEB`) VALUES (:id,:name)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);

    try {
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function getSpecialHousingType($id, $pdo)
{
    $query =  "SELECT `CODETYPEHEB`, `NOMTYPEHEB` FROM `type_heb` WHERE `CODETYPEHEB` = :id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

function getHousingType($pdo)
{

    $query =  "SELECT `CODETYPEHEB`, `NOMTYPEHEB` FROM `type_heb`";

    $stmt = $pdo->prepare($query);
    $stmt->execute();


    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
