<?php

function getUser($login, $password, $pdo){
    $query = "SELECT `USER`, `MDP` FROM `compte` WHERE USER = :login AND MDP = :password";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':password', $password);
    $stmt->execute();


    $result = $stmt->rowCount();
    
    if($result == 1){
        return true;
    }
    else{
        return false;
    }
}

function getUserInfos($login, $password, $pdo){
    $query = "SELECT * FROM `compte` WHERE USER = :login AND MDP = :password";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':password', $password);
    $stmt->execute();


    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $userInfos = array(
        "USER" => $result['USER'],
        // "MDP" => $result['MDP'],
        "NOMCPTE" => $result['NOMCPTE'],
        "PRENOMCPTE" => $result['PRENOMCPTE'],
        "DATEINSCRIP" => $result['DATEINSCRIP'],
        "DATEFERME" => $result['DATEFERME'],
        "TYPECOMPTE" => $result['TYPECOMPTE'],
        "ADRMAILCPTE" => $result['ADRMAILCPTE'],
        "NOTELCPTE" => $result['NOTELCPTE'],
        "NOPORTCPTE" => $result['NOPORTCPTE']
    );

    return $userInfos;
}


?>