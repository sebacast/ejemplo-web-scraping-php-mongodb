<?php 
function conectar_bd(){
	$conn = new mysqli("localhost", "root", '', "dtc");
	return $conn;
}
?>