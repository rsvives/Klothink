<?php

try {
	$conn = connectDatabase();
	if (!$conn) {
		throw new Exception("No se pudo conectar a la base de datos.");
	}
	$query = "SELECT * FROM collections";
	$collections = $conn->query($query);
	if (!$collections) {
		throw new Exception("Error al ejecutar la consulta: " . $conn->error);
	} else {
		return $collections;
	}
} catch (Exception $e) {
	header('Location: ../error.php');
	exit();
}
