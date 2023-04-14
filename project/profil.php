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
                    echo'<a style = "float: right;"  href="logout.php">Wyloguj się</a></li>';
                    echo'<a style = "float: right;"  href="profil.php">Profil</a></li>';
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
  <body>
      <?php
            if ($_SESSION["uprawnienia"] == 1) {
                ?>
                <br><div class="wrapper">
                    <form method="post">
                        <div class="form-group">
                            <label>Wyszukaj po nazwie</label>
                            <input type="search" name="search" class="form-control" placeholder="Fraza..." <?php if (isset($_POST['search'])) {
                                   echo 'value="'.$_POST['search'].'"';
                               } ?>>
                        </div>
                        <input type="submit" name="submit" class="btn btn-success" value="Zastosuj">
                        <a href="profil.php"><input type="button" class="btn btn-info" value="Reset"></a>
                    </form>
                </div><br>
           <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Imie</td>
                        <td>Nazwisko</td>
                        <td>Login</td>
                        <td>Email</td>
                        <td>Telefon</td>
                        <td>Uprawnienia</td>
                        <td>Aktualne wycieczki</td>
                        <td>Opcje</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['search'])) {
                        $search = $_POST['search'];
                        $sql = "SELECT * FROM klienci WHERE LOWER(CONCAT(imie,' ',nazwisko)) LIKE LOWER('%{$search}%') ";
                    } else {
                        $sql = "SELECT * FROM klienci";
                    }

                $result= mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_array($result)) {
                    $current_id = $row['klient_id'];
                    $inner_sql = "SELECT * FROM zamowienia WHERE klient_id = '{$current_id}' ";

                    $inner_result= mysqli_query($conn, $inner_sql);
                    $inner_row = mysqli_fetch_array($inner_result);

                    echo '
                        <tr>
                            <td>'.$row['imie'].'</td>
                            <td>'.$row['nazwisko'].'</td>
                            <td>'.$row['login'].'</td>
                            <td>'.$row['mail'].'</td>
                            <td>'.$row['telefon'].'</td>
                            <td>';
                    if ($row['uprawnienia']) {
                        echo 'Administrator';
                    } else {
                        echo 'Użytkownik';
                    }
                    echo '</td>
                            <td>'.mysqli_num_rows($inner_result).'</td>
                            <td>
                                <a href="profil_edycja.php?id='.$row['klient_id'].'"><button class="btn btn-primary">Edytuj</button></a>
                                <a href="profil_usun.php?id='.$row['klient_id'].'"><button class="btn btn-warning" >Usuń</button></a>
                            </td>
                        </tr>';
                } ?>
                </tbody>
           </table>
       <?php
            } else {
                $id = $_SESSION['klient_id'];

                $sql = "SELECT w.nazwa_wycieczki AS nazwa_wycieczki, w.cena AS cena, w.data_od AS data_od, w.data_do AS data_do,
                                o.nazwa_organizatora AS nazwa_organizatora , n.nazwa AS nazwa, l.imie AS imie, l.nazwisko AS nazwisko,
                                 p.zaliczka AS zaliczka, p.oplacone AS oplacone, z.zamowienie_id AS z_zamowienie_id
                        FROM zamowienia AS z
                        INNER JOIN wycieczka AS w ON w.wycieczka_id = z.wycieczka_id
                        INNER JOIN organizatorzy AS o ON w.organizatorzy_id = o.organizatorzy_id
                        INNER JOIN nocleg AS n ON w.nocleg_id =  n.nocleg_id
                        INNER JOIN lider AS l ON w.lider_id = l.lider_id
                        INNER JOIN platnosc AS p ON z.zamowienie_id = p.platnosc_id
                        WHERE z.klient_id = '{$id}' ";

                $result= mysqli_query($conn, $sql);
                ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Nazwa wycieczki</td>
                        <td>Data początku</td>
                        <td>Data końca</td>
                        <td>Organizator</td>
                        <td>Nocleg</td>
                        <td>Lider</td>
                        <td>Koszt wycieczki</td>
                        <td>Płatności</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(mysqli_num_rows($result)) {
                            while($row = mysqli_fetch_array($result)) {
                                echo '
                                    <tr>
                                        <td>'.$row['nazwa_wycieczki'].'</td>
                                        <td>'.$row['data_od'].'</td>
                                        <td>'.$row['data_do'].'</td>
                                        <td>'.$row['nazwa_organizatora'].'</td>
                                        <td>'.$row['nazwa'].'</td>
                                        <td>'.$row['imie'].' '.$row['nazwisko'].'</td>
                                        <td>'.$row['cena'].'</td>
                                        <td>';
                                            if($row['zaliczka']) {
                                                echo "<button class='btn btn-success'>Zaliczka opłacona</button> ";
                                            } else {
                                                echo "<a href='oplac.php?zamowienie_id=" . $row['z_zamowienie_id'] . "&zaliczka'>
                                                        <button class='btn btn-primary'>Opłać zaliczke</button>
                                                     </a>";
                                            }

                                            if($row['oplacone']) {
                                                echo "<button class='btn btn-success'>Wycieczka opłacona</button>";
                                            } else {
                                                echo "<a href='oplac.php?zamowienie_id=" . $row['z_zamowienie_id'] . "&oplacone'>
                                                        <button class='btn btn-primary'>Opłać wycieczke</button>
                                                     </a>";
                                            }

                                            if(!$row['oplacone'] && !$row['zaliczka']) {
                                                echo "<a href='anuluj.php?zamowienie_id=" . $row['z_zamowienie_id'] . "'>
                                                        <button class='btn btn-danger'>Wypisz się z wycieczki</button>
                                                     </a>";
                                            }
                                echo '
                                        </td>
                                    </tr>
                                ';
                            }
                        } else {
                            echo '<tr><td colspan="8">Jeszcze nie jestes zapisany do żadnej wycieczki.</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        <?php
            }
         ?>
  </body>


</html>
