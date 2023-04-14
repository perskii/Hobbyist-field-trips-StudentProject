<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = false;
    $login = trim($_POST["login"]);
    $haslo = trim($_POST["haslo"]);
    $imie = trim($_POST["imie"]);
    $nazwisko = trim($_POST["nazwisko"]);
    $tel = trim($_POST["tel"]);
    $email = trim($_POST["email"]);
    $uprawnienia = $_POST["uprawnienia"];

    if (strlen($imie) < 3) {
        $error = true;
        $imie_err ="Podaj imie";
    }

    if (strlen($nazwisko) < 3) {
        $error = true;
        $nazwisko_err ="Podaj nazwisko";
    }

    if (strlen($tel) < 8) {
        $error = true;
        $tel_err ="Podaj telefon";
    }

    if (strlen($email) < 3) {
        $error = true;
        $email_err ="Podaj email";
    }

    if (strlen($login) < 3) {
        $error = true;
        $login_err ="Podaj login";
    }

    if (strlen($haslo) < 3) {
        $error = true;
        $haslo_err ="Podaj hasło";
    }

    if (!$error) {
        $id = $_GET['id'];
        $sql = "UPDATE klienci SET imie = '{$imie}', nazwisko = '{$nazwisko}', login = '{$login}', haslo = '{$haslo}',
                                   mail = '{$email}', telefon = '{$tel}', uprawnienia = '{$uprawnienia}'
                WHERE klient_id = '{$id}' ";
        mysqli_query($conn, $sql);

        header("Location: profil.php");
    }
}

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
      <div class="wrapper">
          <h2>Edycja danych uzytkownika </h2>

          <?php
            $id = $_GET['id'];
            $sql = "SELECT * FROM klienci WHERE klient_id = '{$id}' ";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

           ?>

          <form method="post">
              <div class="form-group <?php echo (isset($login_err)) ? 'has-error' : ''; ?>">
                  <label>Nazwa użytkownika(login)</label>
                  <input type="text" name="login" class="form-control" value="<?php echo $row['login']; ?>">
                  <span class="help-block"><?php if (isset($login_err)) {
               echo $login_err;
               unset($login_err);
           } ?></span>
              </div>
              <div class="form-group <?php echo (isset($haslo_err)) ? 'has-error' : ''; ?>">
                  <label>Hasło</label>
                  <input type="text" name="haslo" class="form-control" value="<?php echo $row['haslo']; ?>">
                  <span class="help-block"><?php if (isset($haslo_err)) {
               echo $haslo_err;
               unset($haslo_err);
           } ?></span>
              </div>
              <div class="form-group <?php echo (isset($imie_err)) ? 'has-error' : ''; ?>">
                  <label>Imię</label>
                  <input type="text" name="imie" class="form-control" value="<?php echo $row['imie']; ?>">
                  <span class="help-block"><?php if (isset($imie_err)) {
               echo $imie_err;
               unset($imie_err);
           } ?></span>
              </div>
              <div class="form-group <?php echo (isset($nazwisko_err)) ? 'has-error' : ''; ?>">
                  <label>Nazwisko</label>
                  <input type="text" name="nazwisko" class="form-control" value="<?php echo $row['nazwisko']; ?>">
                  <span class="help-block"><?php if (isset($nazwisko_err)) {
               echo $nazwisko_err;
               unset($nazwisko_err);
           } ?></span>
              </div>
              <div class="form-group <?php echo (isset($tel_err)) ? 'has-error' : ''; ?>">
                  <label>Telefon</label>
                  <input type="text" name="tel" class="form-control" value="<?php echo $row['telefon']; ?>">
                  <span class="help-block"><?php if (isset($tel_err)) {
               echo $tel_err;
               unset($tel_err);
           } ?></span>
              </div>
              <div class="form-group <?php echo (isset($email_err)) ? 'has-error' : ''; ?>">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" value="<?php echo $row['mail']; ?>">
                  <span class="help-block"><?php if (isset($email_err)) {
               echo $email_err;
               unset($email_err);
           } ?></span>
              </div>

              <div class="form-group">
               <label for="uprawnienia">Uprawnienia</label>
               <select class="form-control" name="uprawnienia">
                   <option value="0" <?php if ($row['uprawnienia'] == 0) {
               echo 'selected';
           }?>>Użytkownik</option>
                   <option value="1" <?php if ($row['uprawnienia'] == 1) {
               echo 'selected';
           }?>>Administrator</option>
               </select>
             </div>

              <div class="form-group">
                  <input type="submit" class="btn btn-success" value="Zapisz">
                  <a href="profil.php"><input type="button" class="btn btn-warning" value="Cofnij"></a>
              </div>
          </form>
      </div>
  </body>


</html>
