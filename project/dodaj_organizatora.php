<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazwa = $_POST['nazwa'];
    $adres = $_POST['adres'];
    $mail= $_POST['mail'];
    $telefon = $_POST['telefon'];

    $sql = "INSERT INTO organizatorzy(nazwa_organizatora,adres,mail,telefon)
            VALUES('{$nazwa}','{$adres}','{$mail}','{$telefon}')";
    mysqli_query($conn, $sql);

    header("Location: organizatorzy.php");
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

      <div class="form-group">
          <label>Nazwa organizatora</label>
          <input type="text" name="nazwa" class="form-control" placeholder="Nazwa organizatora">
      </div>

      <div class="form-group">
          <label>Adres firmy</label>
          <input type="text" name="adres" class="form-control" placeholder="Adres firmy">
      </div>

      <div class="form-group">
          <label>Email</label>
          <input type="email" name="mail" class="form-control" placeholder="Email">
      </div>

      <div class="form-group">
          <label>Telefon</label>
          <input type="number" name="telefon" class="form-control" placeholder="Telefon">
      </div>

       <input type="submit" name="submit" class="btn btn-success" value="Dodaj">
       <a href="organizatorzy.php"><input type="button" class="btn btn-warning" value="Cofnij"></a>

     </form>
    </body>
</div>
</html>
