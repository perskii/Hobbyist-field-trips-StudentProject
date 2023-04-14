<?php
session_start();
include "config.php";

    $id = $_GET['wycieczka_id'];
    $klient_id = $_SESSION['klient_id'];

    $sql = "INSERT INTO zamowienia(klient_id,wycieczka_id) VALUES('{$klient_id}','{$id}')";
    mysqli_query($conn, $sql);

    $platnosc_id = mysqli_insert_id($conn);

    if($platnosc_id) {
      $sql = "INSERT INTO platnosc(platnosc_id) VALUES('{$platnosc_id}')";
      mysqli_query($conn, $sql);
    }

    header("Location: wycieczki.php");
 ?>
