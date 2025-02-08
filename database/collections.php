<?php require_once '../database/db.php';
require_once '../database/functions.php';


/**
 * Obtiene todas las colecciones de la base de datos.
 *
 * Esta función se conecta a la base de datos, ejecuta una consulta para obtener todas las colecciones
 * de la tabla `collections` y devuelve el resultado de la consulta. Si ocurre un error en la conexión
 * o en la ejecución de la consulta, la función redirige al usuario a una página de error.
 *
 * @return mysqli_result|void Un objeto `mysqli_result` que contiene las colecciones obtenidas de la base de datos,
 *                             o nada si ocurre un error (se redirige a una página de error).
 *
 * @throws Exception Si no se puede conectar a la base de datos o si hay un error al ejecutar la consulta.
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
		} else {
			return $collections;
		}
	} catch (Exception $e) {
		handleError('Ocurrió un error inesperado. Inténtalo nuevamente más tarde.');
		exit();
	}
}

/**
 * Obtiene una colección desde la base de datos por su 'id' y maneja los productos de dicha colección.
 * Si no se encuentra la colección o el 'id' no es válido, redirige a la página de error.
 *
 * @param int $id El ID de la colección a obtener desde la URL.
 * @return array|null Un arreglo con los productos de la colección o `null` si ocurre un error.
 */
function getCollectionById($id)
{
	if (!isset($id) || empty($id) || !is_numeric($id)) {
		handleError('El ID de la colección proporcionado no es válido.');
		exit;
	}

	$conn = connectDatabase();
	if ($conn->connect_error) {
		handleError('No se pudo conectar con la base de datos. Verifica tu conexión e inténtalo nuevamente.');
		exit;
	}

	$query = "SELECT * FROM collection WHERE id = ?";
	$stmt = $conn->prepare($query);

	if ($stmt === false) {
		$conn->close();
		handleError('Error al preparar la consulta para obtener la colección.');
		exit;
	}

	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result && $collection = $result->fetch_assoc()) {
		$query_products = "SELECT * FROM product WHERE idCollection = ?";
		$stmt_products = $conn->prepare($query_products);

		if ($stmt_products === false) {
			$stmt->close();
			$conn->close();
			handleError('Error al preparar la consulta para obtener los productos de la colección.');
			exit;
		}

		$stmt_products->bind_param('i', $id);
		$stmt_products->execute();
		$result_products = $stmt_products->get_result();

		$products = [];
		while ($product = $result_products->fetch_assoc()) {
			$products[] = $product;
		}

		$stmt->close();
		$stmt_products->close();
		$conn->close();

		return [
			'products' => $products,
			'collection' => $collection
		];
	} else {
		$stmt->close();
		$conn->close();
		handleError('No se encontró la colección solicitada.');
		exit;
	}

	return null;
}
