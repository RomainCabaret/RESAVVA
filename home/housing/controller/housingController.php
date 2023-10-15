<?php

// ---------------------- VERIFICATION ----------------------


function verifyInput($type, $name, $NBplace, $surface, $internet, $dateHEB, $secteur, $orientation, $state, $description, $picture, $pricing)
{
    $isNameValid = (strlen($name) > 0 && strlen($name) <= 28 && !empty($name));
    $isNBplaceValid = (is_numeric($NBplace) && $NBplace > 0 && $NBplace <= 10);
    $isSurfaceValid = (is_numeric($surface) && $surface >= 10 && $surface <= 1000);
    $isInternetValid = (is_numeric($internet) && $internet == 0 || $internet === 1);
    $isDateValid = (is_numeric($dateHEB) && $dateHEB >= 1975 && $dateHEB < (date('Y') + 1));
    $isSecteurValid = (in_array($secteur, ['Zone ski', 'Zone pâturage', 'Zone loisir', 'Zones refuge']));
    $isOrientationValid = in_array($orientation, ['Nord', 'Sud', 'Est', 'West']);
    $isStateValid = in_array($state, ['Parfais', 'Bon', 'Correct', 'Renovation']);
    $isDescriptionValid = (strlen($description) <= 200);
    $isPricingValid = (is_numeric($pricing) && $pricing >= 20 && $pricing <= 10000);

    if (
        $isNameValid &&
        $isNBplaceValid &&
        $isSurfaceValid &&
        $isInternetValid &&
        $isDateValid &&
        $isSecteurValid &&
        $isOrientationValid &&
        $isStateValid &&
        $isDescriptionValid &&
        $isPricingValid
    ) {
        return true;
    }
    return false;
}

function verifyPicture($picture)
{
    $allowedSize = ($picture['size'] < 2097152); // 2 Mo (en octets)
    $allowedTypes = (in_array(mime_content_type($picture['tmp_name']), ['image/jpeg', 'image/png', 'image/gif']));

    if (
        $allowedSize &&
        $allowedTypes
    ) {
        return true;
    }
    return false;
}

// ---------------------- HOUSING ----------------------

function getSpecialHousing($id, $pdo)
{
    $query =  "SELECT  `NOHEB`, `CODETYPEHEB`, `NOMHEB`, `NBPLACEHEB`, `SURFACEHEB`, `INTERNET`, `ANNEEHEB`, `SECTEURHEB`, `ORIENTATIONHEB`, `ETATHEB`, `DESCRIHEB`, `PHOTOHEB`, `TARIFSEMHEB` FROM `hebergement` WHERE NOHEB = :id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

function getSearchHousing($search, $type, $pdo)
{
    $query = "SELECT * FROM `hebergement` WHERE `NOMHEB` LIKE :search AND `CODETYPEHEB` LIKE :type ";
    $stmt = $pdo->prepare($query);

    $search = "%" . $search . "%";
    $type = "%" . $type . "%";


    $stmt->bindParam(':search', $search);
    $stmt->bindParam(':type', $type);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getHousing($pdo)
{

    $query =  "SELECT `NOHEB`, `CODETYPEHEB`, `NOMHEB`, `NBPLACEHEB`, `SURFACEHEB`, `INTERNET`, `ANNEEHEB`, `SECTEURHEB`, `ORIENTATIONHEB`, `ETATHEB`, `DESCRIHEB`, `PHOTOHEB`, `TARIFSEMHEB` FROM `hebergement`";

    $stmt = $pdo->prepare($query);
    $stmt->execute();


    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addNewHousing($type, $name, $NBplace, $surface, $internet, $dateHEB, $secteur, $orientation, $state, $description, $picture, $pricing, $pdo)
{
    try {

        $query = "INSERT INTO `hebergement`(`CODETYPEHEB`, `NOMHEB`, `NBPLACEHEB`, `SURFACEHEB`, `INTERNET`, `ANNEEHEB`, `SECTEURHEB`, `ORIENTATIONHEB`, `ETATHEB`, `DESCRIHEB`, `PHOTOHEB`, `TARIFSEMHEB`) VALUES (:type,:name,:nbplace,:surface,:internet,:dateheb,:secteur,:orientation,:state,:description,:picture,:pricing)";


        if (verifyInput($type, $name, $NBplace, $surface, $internet, $dateHEB, $secteur, $orientation, $state, $description, $picture, $pricing)) {

            if (is_string($picture) || (isset($picture) && $picture['error'] === UPLOAD_ERR_OK)) {
                if (is_string($picture)) {
                    $imgName = $picture;
                } else {
                    $uuid = uniqid();
                    $extension = pathinfo($picture['name'], PATHINFO_EXTENSION);
                    $imgName = strtolower($uuid . '.' . $extension);

                    $path = '../../../ressouces/img/post/';
                    $destinationPath = $path . $imgName;

                    if (!verifyPicture($picture)) {
                        return false;
                    }

                    if (!move_uploaded_file($picture['tmp_name'], $destinationPath)) {
                        return false;
                    }
                }

                $stmt = $pdo->prepare($query);
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


                $stmt->execute();

                return true;
            }
            return false;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function modifyHousing($id, $type, $name, $NBplace, $surface, $internet, $dateHEB, $secteur, $orientation, $state, $description, $picture, $pricing, $pdo)
{
    try {
        $query = "UPDATE `hebergement` SET `CODETYPEHEB`= :type, `NOMHEB`= :name, `NBPLACEHEB`=:nbplace, `SURFACEHEB`=:surface, `INTERNET`=:internet, `ANNEEHEB`=:dateheb, `SECTEURHEB`=:secteur, `ORIENTATIONHEB`=:orientation, `ETATHEB`=:state, `DESCRIHEB`=:description";

        if (verifyInput($type, $name, $NBplace, $surface, $internet, $dateHEB, $secteur, $orientation, $state, $description, $picture, $pricing)) {

            if ($picture !== "") {
                $query .= ", `PHOTOHEB`=:picture";
            }

            $query .= ", `TARIFSEMHEB`=:pricing WHERE `NOHEB` = :num";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':num', $id);
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
            $stmt->bindParam(':pricing', $pricing);

            if ($picture !== "") {
                $uuid = uniqid();
                $extension = pathinfo($picture['name'], PATHINFO_EXTENSION);
                $imgName = strtolower($uuid . '.' . $extension);

                $path = '../../../ressouces/img/post/';
                $destinationPath = $path . $imgName;

                if (!verifyPicture($picture)) {
                    return false;
                }

                if (!move_uploaded_file($picture['tmp_name'], $destinationPath)) {
                    return false;
                }
                $stmt->bindParam(':picture', $imgName);
            }

            $stmt->execute();
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}



// ----------------------  HOUSING TYPE ----------------------

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
    $query =  "SELECT `CODETYPEHEB`, `NOMTYPEHEB` FROM `type_heb`";

    $stmt = $pdo->prepare($query);
    $stmt->execute();


    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
