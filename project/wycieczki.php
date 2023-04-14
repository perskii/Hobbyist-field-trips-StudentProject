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

    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>

<body>
    <nav>
      <div class="topnav" >

          <a href="index.php">Strona Glowna</a>
          <a href="wycieczki.php">Wycieczki</a>

          <a href="nocleg.php">Nocleg</a>
          <a href="organizatorzy.php"> Organizatorzy </a>


          <?php

              if (isset($_SESSION["loggedin"])) {
                  echo'<li style="float: right;"><a href="logout.php">Wyloguj się</a></li>';
                  echo'<li style="float: right;"><a href="profil.php">Profil</a></li>';
                  if ($_SESSION["uprawnienia"] == 1) {
                      echo'<a style = "float: right;"  href="raporty.php">Raporty</a></li>';
                  }
              } else {
                  echo'<a style = "float: right;" href="login.php">Login</a></li>';
                  echo'<a style="float: right;" href="register.php">Rejestracja</a></li>';
              }
          ?>
      </div>
      </nav>
        <br><div class="wrapper">
            <form method="post">
                <div class="form-group">
                    <label>Wyszukaj po nazwie</label>
                    <input type="search" name="search" class="form-control" placeholder="Fraza..." <?php if (isset($_POST['search'])) {
                           echo 'value="'.$_POST['search'].'"';
                       } ?>>
                </div>
                <input type="submit" name="submit" class="btn btn-success" value="Zastosuj">
                <a href="wycieczki.php"><input type="button" class="btn btn-info" value="Reset"></a>
            </form>
        </div>
          <?php
          if ($_SESSION["uprawnienia"]) {
              echo "<br><a href='dodaj_wycieczke.php'><button class='btn btn-success'>Dodaj</button></a><br>";
          }

          if (isset($_POST['search'])) {
              $search = $_POST['search'];
              $sql = "SELECT * FROM wycieczka w INNER JOIN organizatorzy o on w.organizatorzy_id = o.organizatorzy_id WHERE LOWER(nazwa_wycieczki) LIKE LOWER('%{$search}%') ";
          } else {
              $sql = "SELECT * FROM wycieczka w INNER JOIN organizatorzy o on w.organizatorzy_id = o.organizatorzy_id";
          }

          $result = mysqli_query($conn, $sql);

          while ($row = mysqli_fetch_array($result)) {
              echo "<br>";
              echo "<b> Nazwa Wycieczki: </b>". $row['nazwa_wycieczki'] ."<br>";
              echo "<b> Początek wycieczki: </b>". $row[6] ."<br>";
              echo "<b> Koniec wycieczki: </b>". $row[7] ."<br>";
              echo "<b> Nazwa organizatora: </b>". $row['nazwa_organizatora'] ."<br/>";
              echo "<b> Cena wycieczki: </b>". $row['cena'] ."PLN<br>";

                  if ($_SESSION["uprawnienia"]) {
                      echo "<a href='edytuj_wycieczke.php?wycieczka_id=" . $row['wycieczka_id'] . "'><button class='btn btn-primary'>Edytuj</button></a> ";
                      echo " <a href='usun.php?wycieczka_id=" . $row['wycieczka_id'] . "'><button class='btn btn-warning'>Usuń</button></a><br /><br />";
                  } else {
                      $wycieczka_id = $row['wycieczka_id'];
                      $klient_id = $_SESSION['klient_id'];
                     $inner_sql = "SELECT * FROM zamowienia WHERE klient_id = '{$klient_id}' AND wycieczka_id = '{$wycieczka_id}' ";
                     $inner_result = mysqli_query($conn, $inner_sql);

                     if(mysqli_num_rows($inner_result)) {
                         echo "<a href='profil.php'><button class='btn btn-primary'>Jesteś już zapisany!</button></a><br /> ";
                     } else {
                         echo "<a href='zapisz_wycieczke.php?wycieczka_id=" . $row['wycieczka_id'] . "'><button class='btn btn-primary'>Zapisz się na wycieczke</button></a><br /> ";
                     }
                  }
              }
              echo "<hr>";

           ?>
         </div>

        </script>
</body>
</html>
