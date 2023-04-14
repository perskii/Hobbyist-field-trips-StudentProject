<?php
session_start();
require_once "config.php";

$organizatorzy_id = $_GET['organizator_id'];
$sql = "DELETE FROM organizatorzy WHERE organizatorzy_id ='$organizatorzy_id'";

mysqli_query($conn, $sql);

header("Location: organizatorzy.php");

?>
