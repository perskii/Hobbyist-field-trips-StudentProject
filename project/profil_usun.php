<?php
    include "config.php";

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM klienci WHERE klient_id = '{$id}' ";
        mysqli_query($conn, $sql);
    }

    header("Location: profil.php");
 ?>
