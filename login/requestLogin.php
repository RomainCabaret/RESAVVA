<?php

function getUser($login, $password, $pdo)
{
    try {
        $validableAccountType = ['ADM', 'GES', 'VIS'];

        $query = "SELECT `USER`, `MDP`, `DATEFERME`, `TYPECOMPTE` FROM `compte` WHERE USER = :login AND MDP = :password";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $result = $stmt->rowCount();



        if ($result == 1 && (date('Y-m-d') <= $user['DATEFERME'] || $user['TYPECOMPTE'] != "VIS") && in_array($user['TYPECOMPTE'], $validableAccountType)) {
            return true;
        } else {
            if ($result == 0) {
                return "Identifiant ou mot de passe incorrect.";
            } elseif (!in_array($user['TYPECOMPTE'], $validableAccountType)) {
                return "Votre compte semble avoir un type inconnue. <br>Merci de contacter un administrateur";
            } elseif (date('Y-m-d') >= $user['DATEFERME'] && $user['TYPECOMPTE'] == "VIS") {
                return "Votre compte est expirer.";
            } else {
                return "Erreur interne, Merci de contacter l'administrateur";
            }
        }
    } catch (Exception $e) {
        return "Erreur interne, Merci de contacter l'administrateur";
    }
}

function getUserInfos($login, $password, $pdo)
{
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
