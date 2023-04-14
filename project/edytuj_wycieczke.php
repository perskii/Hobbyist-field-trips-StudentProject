<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $organizator = $_POST['organizator'];
    $lider = $_POST['lider'];
    $nocleg = $_POST['nocleg'];
    $nazwa = $_POST['nazwa'];
    $cena = $_POST['cena'];
    $od = $_POST['od'];
    $do = $_POST['do'];
    $id = $_POST['wycieczka_id'];

    $sql = "UPDATE wycieczka SET organizatorzy_id = '{$organizator}',nocleg_id = '{$nocleg}',lider_id = '{$lider}',
                                nazwa_wycieczki = '{$nazwa}',cena  = '{$cena}',data_od = '{$od}',data_do = '{$do}'
                                WHERE wycieczka_id = '{$id}' ";

    mysqli_query($conn, $sql);

    header("Location: wycieczki.php");
}

?>
<html>
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
    <div class="wrapper">
     <form method="post">
        <?php
        $core_id = $_GET['wycieczka_id'];
        $main_sql = "SELECT * FROM wycieczka WHERE wycieczka_id = '{$core_id}' ";
        $main_result = mysqli_query($conn, $main_sql);
        $main_row = mysqli_fetch_array($main_result);

         $sql = "SELECT * FROM organizatorzy";
         $result = mysqli_query($conn, $sql);
         ?>

         <div class="form-group">
          <label for="organizator">Nazwa organizatora</label>
          <select class="form-control" name="organizator">
             <?php
                 while ($row = mysqli_fetch_array($result)) {
                         echo '<option value="'.$row['organizatorzy_id'].'" '.($main_row['organizatorzy_id'] == $row['organizatorzy_id'] ? 'selected' : '' ).'>'.$row['nazwa_organizatora'].'</option>';
                 }
              ?>
          </select>
          </div>

        <?php
          $sql = "SELECT * FROM lider";
          $result = mysqli_query($conn, $sql);
        ?>

        <div class="form-group">
         <label for="lider">Nazwa Lidera</label>
         <select class="form-control" name="lider">
             <?php
              while ($row = mysqli_fetch_array($result)) {
                  echo '<option value="'.$row['lider_id'].'" '.($main_row['lider_id'] == $row['lider_id'] ? 'selected' : '' ).'>'.$row['imie'].' '.$row['nazwisko'].' '.$row['wiek'].'lat</option>';
              }
              ?>
          </select>
          </div>

        <?php
          $sql = "SELECT * FROM nocleg";
          $result = mysqli_query($conn, $sql);
        ?>

        <div class="form-group">
         <label for="nocleg">Nazwa Noclegu</label>
         <select class="form-control" name="nocleg">
             <?php
              while ($row = mysqli_fetch_array($result)) {
                  echo '<option value="'.$row['nocleg_id'].'" '.($main_row['nocleg_id'] == $row['nocleg_id'] ? 'selected' : '' ).'>'.$row['nazwa'].'</option>';
              }
              ?>
      </select>
      </div>

      <div class="form-group">
          <label>Nazwa wycieczki</label>
          <input type="text" name="nazwa" class="form-control" value='<?php echo $main_row['nazwa_wycieczki'];?>'>
      </div>

      <div class="form-group">
          <label>Cena wycieczki</label>
          <input type="number" name="cena" class="form-control" value='<?php echo $main_row['cena'];?>'>
      </div>

      <div class="form-group">
          <label>Od kiedy</label>
          <input type="date" name="od" class="form-control" value='<?php echo $main_row['data_od'];?>'>
      </div>

      <div class="form-group">
          <label>Do kiedy</label>
          <input type="date" name="do" class="form-control" value='<?php echo $main_row['data_do'];?>'>
      </div>

       <input type="hidden" name="wycieczka_id" value="<?php echo $main_row['wycieczka_id']; ?>">

       <input type="submit" name="submit" class="btn btn-success" value="Aktualizuj">
       <a href="wycieczki.php"><input type="button" class="btn btn-warning" value="Cofnij"></a>

     </form>
    </body>
</div>
</html>
