<?php
session_start();

unset($_SESSION["loggedin"]);
unset($_SESSION["klient_id"]);
unset($_SESSION["login"]);
unset($_SESSION["uprawnienia"]);

header("location: index.php");
exit;
?>
