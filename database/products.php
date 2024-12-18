<?php

try {
	$conn = connectDatabase();
	if (!$conn) {
		throw new Exception("No se pudo conectar a la base de datos.");
	}
	$query = "SELECT * FROM products";
	$products = $conn->query($query);
	if (!$products) {
		throw new Exception("Error al ejecutar la consulta: " . $conn->error);
	} else {
		return $products;
	}
} catch (Exception $e) {
	header('Location: ../error.php');
	exit();
}
