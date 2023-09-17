<?php
session_start();
include 'bdd.php';
include './login/requestLogin.php';

$errorMSG = "";

if (isset($_POST['login']) && isset($_POST['password'])) {

    $login = $_POST['login'];
    $password = $_POST['password'];

    if (getUser($login, $password, $pdo)) {
        $_SESSION['login'] = $login;
        header("location:./home/homeView.php");
    } else {
        $errorMSG = "wrong login or password <br>";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="shortcut icon" href="./ressouces/img/ico/favicon.png" type="image/x-icon">
    <?php include './ressouces/head/head.html' ?>
    <title>Login</title>
</head>

<body>
    <form action="index.php" method="post">
        <?php

        echo $errorMSG;

        ?>

        <label for="login">Login</label>
        <input type="text" name="login" placeholder="login" required>

        <br>

        <label for="password" id="password">Password</label>
        <input type="text" name="password" id="password" placeholder="password" required>

        <br>

        <button>Login</button>
    </form>

</body>

</html>