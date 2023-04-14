
<?php

session_start();
include "config.php";

 ?>

<html lang="pl-PL">

<head>
    <meta charset="utf-8">
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
              <a href="nocleg.php"><input type="button" class="btn btn-info" value="Reset"></a>
          </form>
      </div>
        <?php
        if ($_SESSION["uprawnienia"]) {
            echo "<br><a href='dodaj_nocleg.php'><button class='btn btn-success'>Dodaj</button></a><br><br />";
        }

        if (isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql = "SELECT * FROM nocleg WHERE LOWER(nazwa) LIKE LOWER('%{$search}%')";
        } else {
            $sql = "SELECT * FROM nocleg";
        }

        $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($result)) {
                $nocleg_id = $row['nocleg_id'];
                $inner_sql = "SELECT * FROM wycieczka WHERE nocleg_id = '{$nocleg_id}' ";
                $inner_result = mysqli_query($conn, $inner_sql);

                echo "<b> Nazwa noclegu: </b>". $row['nazwa'] ."<br>";
                echo "<b> Adres noclegu: </b>". $row['adres_wycieczki'] ."<br>";
                if(mysqli_num_rows($inner_result)) {
                    echo "<b> Przypisane wyczieczki do noclegu: </b> ";
                } else {
                    echo "<b> Brak wycieczek przypisanych do noclegu. </b> ";
                }

                while ($inner_row = mysqli_fetch_array($inner_result)) {
                    echo $inner_row['nazwa_wycieczki'].', ';
                }

                if ($_SESSION["uprawnienia"]) {
                    echo "<br><a href='edytuj_nocleg.php?nocleg_id=" . $row['nocleg_id'] . "'><button class='btn btn-primary'>Edytuj</button></a> ";
                    echo " <a href='usun_nocleg.php?nocleg_id=" . $row['nocleg_id'] . "'><button class='btn btn-warning'>Usuń</button></a><br /><br />";
                }
                echo "<hr>";
            }
         ?>
    </body>
</html>
