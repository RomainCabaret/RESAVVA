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
        $errorMSG = "Identifiant ou mot de passe incorrect";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="shortcut icon" href="./ressouces/img/ico/favicon.png" type="image/x-icon">
    <?php include './ressouces/head/head.html' ?>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="ressouces/css/login.css" />
    <title>Login</title>
</head>

<body>
    <h1>Logo</h1>
    <div class="grid-layout">
        <div class="container-left">
            <!-- <img src="ressouces/img/login/3644996.png" alt="" /> -->
        </div>
        <div class="container-right">
            <form method="post" action="index.php" class="container-login">
                <h2>Connectez-vous</h2>
                <p>Pour vous connecter, il est nécessaire d'avoir un compte.</p>


                <label for="login" class="login-label">Identifiant</label>
                <label for="login" class="input-icon">
                    <img src="ressouces/img/login/message.svg" alt="">
                </label>
                <input type="text" name="login" id="login" placeholder="Entrer votre identifiant" required />

                <label for="password" class="login-label">Mot de passe</label>
                <label for="password" class="input-icon">
                    <img src="ressouces/img/login/padlock.svg" alt="">
                </label>
                <input type="password" name="password" id="password" placeholder="Entrer votre mot de passe" required />


                <?php

                echo '<p class="error-message">' . $errorMSG  . '</p>';

                ?>

                <button>Connexion</button>
            </form>
        </div>
    </div>
    <!-- <form action="index.php" method="post">

        <label for="login">Login</label>
        <input type="text" name="login" placeholder="login" required>

        <br>

        <label for="password" id="password">Password</label>
        <input type="text" name="password" id="password" placeholder="password" required>

        <br>

        <button>Login</button>
    </form> -->

</body>

</html>