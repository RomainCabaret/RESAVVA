<?php


// ---------------------- VERIFICATION ----------------------


function verifyDate($start, $end)
{

    try {

        $timeStart = strtotime($start);
        $timeEnd = strtotime($end);

        $isDifferent = ($timeStart != $timeEnd);
        $isDateValid = ($timeStart < $timeEnd);
        $isStartValid = (date('w', $timeStart) == 6); # Samedi
        $isEndValid = (date('w', $timeEnd) == 6); # Samedi

        if (
            $isDifferent &&
            $isDateValid &&
            $isStartValid &&
            $isEndValid
        ) {
            return true;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}


// ---------------------- WEEK BOOK ----------------------


function addNewBookingWeek($start, $end, $pdo)
{

    $query = "INSERT INTO `semaine`(`DATEDEBSEM`, `DATEFINSEM`) VALUES (:start,:end)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);

    if (verifyDate($start, $end)) {
        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    } else {
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
    $query =  "SELECT `NORESA`, `USER`, r.`DATEDEBSEM`, `NOHEB`, r.`CODEETATRESA`, `DATERESA`, `DATEARRHES`, `MONTANTARRHES`, `NBOCCUPANT`, `TARIFSEMRESA`, e.NOMETATRESA FROM `resa` r INNER JOIN etat_resa e ON r.CODEETATRESA = e.CODEETATRESA WHERE `NORESA` = :id ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

function getSearchBooking($start, $end, $pdo)
{
    $query =  "SELECT `NORESA`, `USER`, r.`DATEDEBSEM`, `NOHEB`, r.`CODEETATRESA`, `DATERESA`, `DATEARRHES`, `MONTANTARRHES`, `NBOCCUPANT`, `TARIFSEMRESA`, e.NOMETATRESA FROM `resa` r INNER JOIN etat_resa e ON r.CODEETATRESA = e.CODEETATRESA WHERE `DATEDEBSEM` >= :start AND `DATEARRHES` <= :end ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addNewBooking($user, $dateStart, $housing, $typeHousing, $dateBooking, $priceBooking, $amountPeople, $pricePerWeek, $pdo)
{
    $query = "INSERT INTO `resa` (`USER`, `DATEDEBSEM`, `NOHEB`, `CODEETATRESA`, `DATERESA`, `MONTANTARRHES`, `NBOCCUPANT`, `TARIFSEMRESA`) 
          SELECT :user, :dateStart, :housing, :typeHousing, :dateBooking, :priceBooking, :amountPeople, :pricePerWeek 
          FROM dual 
          WHERE NOT EXISTS (SELECT 1 FROM `resa` WHERE `NOHEB` = :housing AND `DATEDEBSEM` = :dateStart)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':dateStart', $dateStart);
    $stmt->bindParam(':housing', $housing);
    $stmt->bindParam(':typeHousing', $typeHousing);
    $stmt->bindParam(':dateBooking', $dateBooking);
    $stmt->bindParam(':priceBooking', $priceBooking);
    $stmt->bindParam(':amountPeople', $amountPeople);
    $stmt->bindParam(':pricePerWeek', $pricePerWeek);

    try {
        $result = $stmt->execute();
        if ($result && $stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function modifyBookingState($id, $newState, $pdo)
{
    $query = "UPDATE `resa` SET `CODEETATRESA`= :newState WHERE `NORESA` = :id ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':newState', $newState);

    try {
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function getHousingBookingWeek($idHousing, $pdo)
{

    $query = "SELECT `DATEDEBSEM` FROM `resa` WHERE `NOHEB` = :idHeb";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam('idHeb', $idHousing);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// ----------------------  BOOKING STATE ----------------------


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
