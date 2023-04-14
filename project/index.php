
<?php

session_start();
include "config.php";

 ?>

<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <title>Sklep</title>
    <link rel="stylesheet" href="css/galeriastyle.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body background="pobrane.jpg">
    <nav>
    <div class="topnav" >
        <a href="index.php">Strona Glowna</a>

        <?php
            if(isset($_SESSION["loggedin"])) {
        ?>
        <a href="wycieczki.php">Wycieczki</a>

        <a href="nocleg.php">Nocleg</a>
        <a href="organizatorzy.php"> Organizatorzy </a>
        <?php
            }
        ?>


        <?php
            if(isset($_SESSION["loggedin"]))
            {
                echo'<li style="float: right;"><a href="logout.php">Wyloguj się</a></li>';
                echo'<li style="float: right;"><a href="profil.php">Profil</a></li>';
                if ($_SESSION["uprawnienia"] == 1) {
                    echo'<a style = "float: right;"  href="raporty.php">Raporty</a></li>';
                }
            }
            else
            {
                echo'<a style = "float: right;" href="login.php">Login</a></li>';
                echo'<a style="float: right;" href="register.php">Rejestracja</a></li>';
            }
            ?>
    </div>
</nav>

</body>
</html>
