<?php
    session_start();
    include "config.php";
 ?>

<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <title>Raporty</title>
    <link rel="stylesheet" href="css/galeriastyle.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        table {width: 600px !important; border: 2px solid lightgrey; margin-left: 40px;}
        .table_title {width: 600px; font-weight: 600; font-size: 20px; text-align: center; margin-left: 40px; padding: 10px; color: #34A853;}
        .thead-dark {background-color: #e0e0e0;}
        .table-success {background-color: rgba(65, 231, 110, 0.71);}
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
    <div class="wrapper">
        <form method="post">
         <div class="form-group">
             <label>Od kiedy</label>
             <input type="date" name="od" class="form-control" <?php if (isset($_POST['od'])) {
                    echo 'value="'.$_POST['od'].'"';
                } ?>>
         </div>

         <div class="form-group">
             <label>Do kiedy</label>
             <input type="date" name="do" class="form-control" <?php if (isset($_POST['do'])) {
                    echo 'value="'.$_POST['do'].'"';
                } ?>>
         </div>

          <input type="submit" name="submit" class="btn btn-success" value="Zastosuj">

        </form>
    </div>
        <?php
            if (isset($_POST['od']) && isset($_POST['do'])) {
                $od = $_POST['od'];
                $do = $_POST['do'];

                $sql = "SELECT k.imie AS imie, k.nazwisko AS nazwisko, COUNT(z.zamowienie_id) AS ilosc_zamowien,
                        SUM(CASE WHEN p.zaliczka = 1 THEN 1 ELSE 0 END) AS ilosc_zaliczki,
                        SUM(CASE WHEN p.oplacone = 1 THEN 1 ELSE 0 END) AS ilosc_oplacone
                        FROM zamowienia z
                        INNER JOIN klienci k ON k.klient_id = z.klient_id
                        INNER JOIN platnosc p ON p.platnosc_id = z.zamowienie_id
                        WHERE z.dodano BETWEEN '{$od}' AND '{$do}'
                        GROUP BY z.klient_id";

                $result = mysqli_query($conn, $sql);
                ?>
                <div class="table_title">Raport ilości zamówień</div>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Imię i nazwisko</th>
                            <th>Ilość zamówień</th>
                            <th>Ilość opłaconych zaliczek</th>
                            <th>Ilość opłaconych zamówień</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($row = mysqli_fetch_array($result)) {
                                echo '
                                <tr>
                                    <td>'.$row['imie'].' '.$row['nazwisko'].'</td>
                                    <td>'.$row['ilosc_zamowien'].'</td>
                                    <td>'.$row['ilosc_zaliczki'].'</td>
                                    <td>'.$row['ilosc_oplacone'].'</td>
                                </tr>
                                ';
                            } ?>
                    </tbody>
                </table>

                <?php
                $sql = "SELECT w.nazwa_wycieczki AS nazwa_wycieczki, COUNT(z.wycieczka_id) AS ilosc
                        FROM zamowienia z
                        INNER JOIN wycieczka w ON w.wycieczka_id = z.wycieczka_id
                        WHERE z.dodano BETWEEN '{$od}' AND '{$do}'
                        GROUP BY z.wycieczka_id
                        ORDER BY ilosc DESC";

                $result = mysqli_query($conn, $sql);

                $sql = "SELECT w.nazwa_wycieczki AS nazwa_wycieczki, z.dodano AS dodano
                        FROM zamowienia z
                        INNER JOIN wycieczka w ON w.wycieczka_id = z.wycieczka_id
                        WHERE z.dodano BETWEEN '{$od}' AND '{$do}'
                        ORDER BY z.dodano DESC";

                $result_vol2 = mysqli_query($conn, $sql);
                ?>
                <div class="row">
                    <div class="col">
                        <div class="table_title">Ilości zamówień dla poszczególnych wycieczek</div>
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nazwa wycieczki</th>
                                    <th>Ilość zamówień</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($result as $key => $row) {
                                        if($key == 0) $big_af = $row['ilosc'];

                                        echo '
                                        <tr '.(isset($big_af) && $big_af == $row['ilosc'] ? 'class="table-success"' : '').'>
                                            <td>'.$row['nazwa_wycieczki'].'</td>
                                            <td>'.$row['ilosc'].'</td>
                                        </tr>
                                        ';
                                    } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col">
                        <div class="table_title">Zamówione wycieczki</div>
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nazwa wycieczki</th>
                                    <th>Data zamówienia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while ($row = mysqli_fetch_array($result_vol2)) {
                                        echo '
                                        <tr>
                                            <td>'.$row['nazwa_wycieczki'].'</td>
                                            <td>'.$row['dodano'].'</td>
                                        </tr>
                                        ';
                                    } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php
                $sql = "SELECT o.nazwa_organizatora AS nazwa_organizatora, COUNT(w.organizatorzy_id) AS ilosc
                        FROM zamowienia z
                        INNER JOIN wycieczka w ON w.wycieczka_id = z.wycieczka_id
                        INNER JOIN organizatorzy o ON o.organizatorzy_id = w.organizatorzy_id
                        WHERE z.dodano BETWEEN '{$od}' AND '{$do}'
                        GROUP BY w.organizatorzy_id
                        ORDER BY ilosc DESC";

                $result = mysqli_query($conn, $sql);

                ?>
                <div class="table_title">Raport dla organizatorów</div>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nazwa organizatora</th>
                            <th>Ilość zamówień</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($result as $key => $row) {
                                if($key == 0) $big_af = $row['ilosc'];

                                echo '
                                <tr '.(isset($big_af) && $big_af == $row['ilosc'] ? 'class="table-success"' : '').'>
                                    <td>'.$row['nazwa_organizatora'].'</td>
                                    <td>'.$row['ilosc'].'</td>
                                </tr>
                                ';
                            } ?>
                    </tbody>
                </table>

                <?php
                $sql = "SELECT n.nazwa AS nocleg_nazwa, COUNT(w.nocleg_id) AS ilosc
                        FROM zamowienia z
                        INNER JOIN wycieczka w ON w.wycieczka_id = z.wycieczka_id
                        INNER JOIN nocleg n ON n.nocleg_id = w.nocleg_id
                        WHERE z.dodano BETWEEN '{$od}' AND '{$do}'
                        GROUP BY w.nocleg_id
                        ORDER BY ilosc DESC";

                $result = mysqli_query($conn, $sql);

                ?>
                <div class="table_title">Raport dla noclegów</div>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nazwa noclegu</th>
                            <th>Ilość zamówień</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($result as $key => $row) {
                                if($key == 0) $big_af = $row['ilosc'];

                                echo '
                                <tr '.(isset($big_af) && $big_af == $row['ilosc'] ? 'class="table-success"' : '').'>
                                    <td>'.$row['nocleg_nazwa'].'</td>
                                    <td>'.$row['ilosc'].'</td>
                                </tr>
                                ';
                            } ?>
                    </tbody>
                </table>

                <?php
                $sql = "SELECT k.imie AS imie, k.nazwisko AS nazwisko, k.dodano AS dodano
                        FROM klienci k
                        WHERE k.dodano BETWEEN '{$od}' AND '{$do}'
                        ORDER BY k.dodano DESC";

                $result = mysqli_query($conn, $sql);

                ?>
                <div class="table_title">Zarejestrowani klienci: <?php if($x = mysqli_num_rows($result)) echo $x;?></div>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Imię i nazwisko</th>
                            <th>Data rejestracji</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($row = mysqli_fetch_array($result)) {
                                echo '
                                <tr>
                                    <td>'.$row['imie'].' '.$row['nazwisko'].'</td>
                                    <td>'.(int)date('d', strtotime($row['dodano'])).'-'.(int)date('m', strtotime($row['dodano'])).'-'.date('Y H:i', strtotime($row['dodano'])).'</td>
                                </tr>
                                ';
                            } ?>
                    </tbody>
                </table>
        <?php
            }
        ?>
  </body>


</html>
