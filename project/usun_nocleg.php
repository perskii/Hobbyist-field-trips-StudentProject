<?php
session_start();
require_once "config.php";

$nocleg_id = $_GET['nocleg_id'];
$sql = "DELETE FROM nocleg WHERE nocleg_id='$nocleg_id'";

mysqli_query($conn, $sql);

header("Location: nocleg.php");

?>
