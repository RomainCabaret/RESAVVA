<?php



// ---------------------- WEEK BOOK ----------------------


function addNewBookingWeek($start, $end, $pdo)
{

    $query = "INSERT INTO `semaine`(`DATEDEBSEM`, `DATEFINSEM`) VALUES (:start,:end)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);

    try {
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function getSpecialBookingWeek($start, $end, $pdo)
{
    $query = "SELECT `DATEDEBSEM`, `DATEFINSEM` FROM `semaine` WHERE `DATEDEBSEM` >= :start AND `DATEFINSEM` <= :end";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':start', $start, PDO::PARAM_STR);
    $stmt->bindParam(':end', $end, PDO::PARAM_STR);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// ---------------------- BOOKING ----------------------


function getBooking($pdo)
{

    $query =  "SELECT `NORESA`, `USER`, `DATEDEBSEM`, `NOHEB`, `CODEETATRESA`, `DATERESA`, `DATEARRHES`, `MONTANTARRHES`, `NBOCCUPANT`, `TARIFSEMRESA` FROM `resa`;";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    return $stmt->fetch();
}

function getSpecialBooking($id, $pdo)
{
    $query =  "SELECT `NORESA`, `USER`, `DATEDEBSEM`, `NOHEB`, `CODEETATRESA`, `DATERESA`, `DATEARRHES`, `MONTANTARRHES`, `NBOCCUPANT`, `TARIFSEMRESA` FROM `resa` WHERE `NORESA` = :id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

function addNewBooking($id, $user, $dateStart, $housing, $typeHousing, $dateBooking, $dateEnd, $priceBooking, $amountPeople, $pricePerWeek, $pdo)
{
    $query = "INSERT INTO `resa` (`NORESA`, `USER`, `DATEDEBSEM`, `NOHEB`, `CODEETATRESA`, `DATERESA`, `DATEARRHES`, `MONTANTARRHES`, `NBOCCUPANT`, `TARIFSEMRESA`) VALUES (:id, :user, :dateStart, :housing, :typeHousing, :dateBooking , :dateEnd, :priceBooking, :amountPeople, :pricePerWeek );";


    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':dateStart', $dateStart);
    $stmt->bindParam(':housing', $housing);
    $stmt->bindParam(':typeHousing', $typeHousing);
    $stmt->bindParam(':dateBooking', $dateBooking);
    $stmt->bindParam(':dateEnd', $dateEnd);
    $stmt->bindParam(':priceBooking', $priceBooking);
    $stmt->bindParam(':amountPeople', $amountPeople);
    $stmt->bindParam(':pricePerWeek', $pricePerWeek);


    try {
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return false;
    }
}


// ----------------------  HOUSING STATE ----------------------


# **** we need to include bdd.php in file will use that function ****

function getBookingState($pdo)
{

    $query = "SELECT `CODEETATRESA`, `NOMETATRESA` FROM `etat_resa`";

    $stmt = $pdo->prepare($query);
    $stmt->execute();


    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSpecialBookingState($id, $pdo)
{
    $query =  "SELECT `CODEETATRESA`, `NOMETATRESA` FROM `etat_resa` WHERE CODEETATRESA = :id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}


function addNewBookingState($id, $name, $pdo)
{
    $query = "INSERT INTO `etat_resa`(`CODEETATRESA`, `NOMETATRESA`) VALUES (:id,:name)";

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
