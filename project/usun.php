<?php
session_start();
require_once "config.php";


		$wycieczka_id = $_GET[wycieczka_id];
		$sql = "DELETE FROM wycieczka WHERE wycieczka_id='$wycieczka_id'";

		if ($conn->query($sql) === TRUE) {
			echo "Record deleted successfully";
		} else {
			echo "Error deleting record: " . $conn->error;
		}

$conn->close();
header('Location: wycieczki.php');
?>
