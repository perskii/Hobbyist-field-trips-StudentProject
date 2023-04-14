<?php
    session_start();
    include "config.php";

    if(isset($_GET['zamowienie_id'])) {
        $zamowienie_id = $_GET['zamowienie_id'];
        $sql = "DELETE FROM zamowienia WHERE zamowienie_id = '{$zamowienie_id}' ";
        mysqli_query($conn, $sql);
    }

    header('Location: profil.php');
 ?>
