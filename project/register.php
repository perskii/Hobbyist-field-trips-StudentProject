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

    if (empty($login)) {
        $error = true;
        $login_err = "Wpisz nazwę użytkownika";
    } else {
        $sql = "SELECT klient_id FROM klienci WHERE login ='{$login}' ";
        $result= mysqli_query($conn, $sql);

        if (mysqli_num_rows($result)!=0) {
            $login_err = "Login zajety";
            $error = true;
        }
    }

    if (empty($haslo)) {
        $error = true;
        $haslo_err = "Wpisz hasło";
    } elseif (strlen($haslo) < 6) {
        $error = true;
        $haslo_err = "Hasło musi zawierać więcej niż 6 znaków";
    }

    $potwierdz_haslo = trim($_POST["confirm_password"]);
    if (empty($potwierdz_haslo)) {
        $error = true;
        $potwierdz_haslo_err = "Potwierdź hasło";
    } else {
        if (empty($haslo_err) && ($haslo != $potwierdz_haslo)) {
            $error = true;
            $potwierdz_haslo_err = "Hasła różnią się";
        }
    }

    if (!$error) {
        $sql = "INSERT INTO klienci (login, haslo, imie, nazwisko, telefon, mail) VALUES ('{$login}','{$haslo}','{$imie}','{$nazwisko}','{$tel}','{$email}' )";
        mysqli_query($conn, $sql);

        header("Location: login.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dołącz do nas</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{ font: 14px sans-serif; }
            .wrapper{ width: 350px; padding: 20px; }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <h2>Rejestracja</h2>
            <p>Wypełnij formularz, aby utworzyć konto.</p>

            <form method="post">
                <div class="form-group <?php echo (isset($login_err)) ? 'has-error' : ''; ?>">
                    <label>Nazwa użytkownika(login)</label>
                    <input type="text" name="login" class="form-control">
                    <span class="help-block"><?php if (isset($login_err)) {
    echo $login_err;
    unset($login_err);
} ?></span>
                </div>
                <div class="form-group <?php echo (isset($haslo_err)) ? 'has-error' : ''; ?>">
                    <label>Hasło</label>
                    <input type="password" name="haslo" class="form-control">
                    <span class="help-block"><?php if (isset($haslo_err)) {
    echo $haslo_err;
    unset($haslo_err);
} ?></span>
                </div>
                <div class="form-group <?php echo (isset($potwierdz_haslo_err)) ? 'has-error' : ''; ?>">
                    <label>Potwierdź hasło</label>
                    <input type="password" name="confirm_password" class="form-control">
                    <span class="help-block"><?php if (isset($potwierdz_haslo_err)) {
    echo $potwierdz_haslo_err;
    unset($potwierdz_haslo_err);
} ?></span>
                </div><br>
                <div class="form-group <?php echo (isset($imie_err)) ? 'has-error' : ''; ?>">
                    <label>Imię</label>
                    <input type="text" name="imie" class="form-control">
                    <span class="help-block"><?php if (isset($imie_err)) {
    echo $imie_err;
    unset($imie_err);
} ?></span>
                </div>
                <div class="form-group <?php echo (isset($nazwisko_err)) ? 'has-error' : ''; ?>">
                    <label>Nazwisko</label>
                    <input type="text" name="nazwisko" class="form-control">
                    <span class="help-block"><?php if (isset($nazwisko_err)) {
    echo $nazwisko_err;
    unset($nazwisko_err);
} ?></span>
                </div>
                <div class="form-group <?php echo (isset($tel_err)) ? 'has-error' : ''; ?>">
                    <label>Telefon</label>
                    <input type="text" name="tel" class="form-control">
                    <span class="help-block"><?php if (isset($tel_err)) {
    echo $tel_err;
    unset($tel_err);
} ?></span>
                </div>
                <div class="form-group <?php echo (isset($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                    <span class="help-block"><?php if (isset($email_err)) {
    echo $email_err;
    unset($email_err);
} ?></span>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="ZAREJESTRUJ">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>
                <p>Masz już konto? <a href="login.php">Zaloguj się!</a>.</p>
            </form>
        </div>
    </body>
</html>
