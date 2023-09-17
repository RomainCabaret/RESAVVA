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

?>