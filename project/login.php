<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: powitanie.php");

    exit;
}
require_once "config.php";

$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $login = trim($_POST["login"]);
    $password = trim($_POST["haslo"]);

    if(empty($login)){
        $username_err = "Proszę podać login.";
    }

    if(empty($password)){
        $password_err = "Proszę podać hasło.";
    }

    if(empty($username_err) && empty($password_err)) {
        $sql = "SELECT klient_id,uprawnienia FROM klienci WHERE login = '{$login}' AND haslo = '{$password}'  ";
        $result= mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if (mysqli_num_rows($result)==1) {
            $_SESSION["loggedin"] = true;
            $_SESSION["klient_id"] = $row['klient_id'];
            $_SESSION["login"] = $login;
            $_SESSION["uprawnienia"] = $row['uprawnienia'];

            header("location: index.php");
        } else {
            $username_err = "Bledy login lub haslo.";
        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Zaloguj sie</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{ font: 14px sans-serif; }
            .wrapper{ width: 350px; padding: 20px; }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <h2>Login</h2>
            <p>Podaj swoje dane logowania, aby się zalogować.</p>
            <form method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Nazwa użytkownika</label>
                    <input type="text" name="login" class="form-control" placeholder="Login">
                    <span class="help-block"><?php echo $username_err; unset($username_err); ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Hasło</label>
                    <input type="password" name="haslo" class="form-control " placeholder="Hasło">
                    <span class="help-block"><?php echo $password_err; unset($password_err); ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="login">
                </div>
                <p>Nie masz konta? Załóż już dziś!<a href="register.php">Kliknij tutaj!</a>.</p>
            </form>
        </div>
    </body>
</html>
