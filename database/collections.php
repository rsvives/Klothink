<?php
require_once '../database/db.php';
require_once '../database/functions.php';

/**
 * Obtiene todas las colecciones de la base de datos.
 *
 * @return mysqli_result|void Un objeto `mysqli_result` con las colecciones, o redirige a una página de error.
 */
function getCollections()
{
	try {
		$conn = connectDatabase();
		if (!$conn) {
			handleError('No se pudo establecer conexión con la base de datos. Por favor, inténtalo más tarde.');
		}

		$query = "SELECT * FROM collection";
		$collections = $conn->query($query);

		if (!$collections) {
			handleError('Error al ejecutar la consulta para obtener las colecciones.');
		}

		return $collections;
	} catch (Exception $e) {
		handleError('Ocurrió un error inesperado. Inténtalo nuevamente más tarde.');
		exit();
	}
}

/**
 * Obtiene una colección por su ID junto con sus productos asociados.
 *
 * @param int $id ID de la colección.
 * @return array|null Arreglo con los productos de la colección o `null` si ocurre un error.
 */
function getCollectionById($id)
{
	if (!isset($id) || empty($id) || !is_numeric($id)) {
		handleError('El ID de la colección proporcionado no es válido.');
		exit;
	}

	$conn = connectDatabase();
	if (!$conn) {
		handleError('No se pudo conectar con la base de datos. Verifica tu conexión e inténtalo nuevamente.');
		exit;
	}

	$queryCollection = "SELECT * FROM collection WHERE id = ?";
	$stmtCollection = $conn->prepare($queryCollection);

	if (!$stmtCollection) {
		$conn->close();
		handleError('Error al preparar la consulta para obtener la colección.');
		exit;
	}

	$stmtCollection->bind_param('i', $id);
	$stmtCollection->execute();
	$resultCollection = $stmtCollection->get_result();

	if ($resultCollection && $collection = $resultCollection->fetch_assoc()) {
		$queryProducts = "SELECT * FROM product WHERE idCollection = ?";
		$stmtProducts = $conn->prepare($queryProducts);

		if (!$stmtProducts) {
			$stmtCollection->close();
			$conn->close();
			handleError('Error al preparar la consulta para obtener los productos de la colección.');
			exit;
		}

		$stmtProducts->bind_param('i', $id);
		$stmtProducts->execute();
		$resultProducts = $stmtProducts->get_result();

		$products = [];
		while ($product = $resultProducts->fetch_assoc()) {
			$products[] = $product;
		}

		$stmtCollection->close();
		$stmtProducts->close();
		$conn->close();

		return [
			'products' => $products,
			'collection' => $collection
		];
	} else {
		$stmtCollection->close();
		$conn->close();
		handleError('No se encontró la colección solicitada.');
		exit;
	}

	return null;
}
