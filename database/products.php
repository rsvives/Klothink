<?php
require_once '../database/db.php';
require_once '../database/functions.php';

/**
 * Obtiene todos los productos de la base de datos.
 *
 * @return mysqli_result|false Los productos de la base de datos o false si ocurre un error.
 */
function getProducts() {
	try {
		$conn = connectDatabase();
		if (!$conn) {
			handleError('No se pudo conectar a la base de datos.');
			return false;
		}

		$query = "SELECT * FROM product";
		$result = $conn->query($query);
		if (!$result) {
			handleError('Error al ejecutar la consulta.');
			return false;
		}

		return $result;
	} catch (Exception $e) {
		handleError('Error inesperado: ' . $e->getMessage());
		return false;
	}
}

/**
 * Obtiene un producto desde la base de datos por su ID.
 *
 * @param int $id El ID del producto a obtener.
 * @return array|null Un arreglo con los datos del producto o null si ocurre un error.
 */
function getProductById($id) {
	try {
		$conn = connectDatabase();
		if (!$conn) {
			handleError('No se pudo conectar a la base de datos.');
			return null;
		}

		$query = 'SELECT * FROM product WHERE id = ?';
		$stmt = $conn->prepare($query);
		if (!$stmt) {
			handleError('Error al preparar la consulta.');
			return null;
		}

		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = $result->fetch_assoc();

		$stmt->close();
		$conn->close();

		return $data ?: null;
	} catch (Exception $e) {
		handleError('Error inesperado: ' . $e->getMessage());
		return null;
	}
}

/**
 * Elimina un producto de la base de datos mediante su ID.
 *
 * @param int $id El ID del producto que se desea eliminar.
 */
function deleteProductById($id) {
	try {
		$conn = connectDatabase();
		if (!$conn) {
			handleError('No se pudo conectar a la base de datos.');
			return;
		}

		$query = "DELETE FROM product WHERE id = ?";
		$stmt = $conn->prepare($query);
		if (!$stmt) {
			handleError('Error al preparar la consulta.');
			return;
		}

		$stmt->bind_param('i', $id);
		if (!$stmt->execute()) {
			handleError('No se pudo eliminar el producto.');
		}

		$stmt->close();
		$conn->close();

		exit();
	} catch (Exception $e) {
		handleError('Error inesperado: ' . $e->getMessage());
	}
}

/**
 * Añade un producto a la base de datos.
 */
function createProduct($name, $price, $material, $fit, $gender, $characteristics, $colours, $images, $sizes, $idCollection) {
	try {
		$conn = connectDatabase();
		if (!$conn) {
			handleError('No se pudo conectar a la base de datos.');
			return;
		}

		$query = "INSERT INTO product (name, characteristics, colours, fit, gender, idCollection, images, material, price, sizes)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $conn->prepare($query);

		if (!$stmt) {
			handleError('Error al preparar la consulta.');
			return;
		}

		$stmt->bind_param('sssssissds', $name, $material, $fit, $gender, $colours, $sizes, $price, $characteristics, $images, $idCollection);

		if (!$stmt->execute()) {
			handleError('No se pudo crear el producto. Error: ' . $stmt->error);
		}

		$stmt->close();
		$conn->close();
		exit();
	} catch (Exception $e) {
		handleError('Error inesperado: ' . $e->getMessage());
	}
}

/**
 * Elimina un atributo específico de un producto en la base de datos.
 *
 * @param int $id ID del producto.
 * @param string $attribute Nombre del atributo a eliminar (se establecerá como NULL o se actualizará).
 * @param string|null $value (Opcional) Valor específico a eliminar dentro del atributo.
 */
function deleteProductAttribute($productId, $attributeName, $valueToDelete) {
	$connection = connectDatabase();
	if (!$connection) {
		handleError('No se pudo conectar a la base de datos');
		exit();
	}

	$query = "SELECT * FROM product WHERE id = ?";
	$statement = $connection->prepare($query);
	if (!$statement) {
		handleError('Error al preparar la consulta');
		exit();
	}
	$statement->bind_param('i', $productId);
	$statement->execute();
	$result = $statement->get_result();
	$product = $result->fetch_assoc();
	$statement->close();

	if (!$product) {
		handleError('Producto no encontrado');
		exit();
	}

	if (!array_key_exists($attributeName, $product)) {
		handleError('El atributo no existe');
		exit();
	}

	if ($attributeName === 'sizes') {
		$sizes = explode(',', $product['sizes']);
		$updatedSizes = array_filter($sizes, function ($size) use ($valueToDelete) {
			return trim($size) !== $valueToDelete;
		});
		$newSizes = implode(',', $updatedSizes);

		if (empty($newSizes)) {
			$newSizes = null;
		}

		$updateQuery = "UPDATE product SET sizes = ? WHERE id = ?";
		$updateStatement = $connection->prepare($updateQuery);
		if (!$updateStatement) {
			handleError('Error al preparar la consulta de actualización');
			exit();
		}
		$updateStatement->bind_param('si', $newSizes, $productId);
		if (!$updateStatement->execute()) {
			handleError('No se pudo eliminar el valor del atributo');
			exit();
		}
		header("Location: ../views/products.php");
		$updateStatement->close();
	}

	$connection->close();
	exit();
}

/**
 * Procesa las acciones relacionadas con productos.
 */
function actions() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$action = $_POST['action'] ?? '';

		switch ($action) {
			case 'delete_product':
				if (!empty($_POST['idProduct']) && is_numeric($_POST['idProduct'])) {
					deleteProductById((int)$_POST['idProduct']);
				} else {
					handleError('El ID del producto no es válido.');
				}
				break;

			case 'create_product':
				if (!empty($_POST['productName']) && isset($_POST['productPrice'], $_POST['productMaterial'], $_POST['productFit'], $_POST['productGender'], $_POST['productCharacteristics'], $_POST['productColours'], $_POST['productImages'], $_POST['productSizes'], $_POST['productCollection'])) {
					createProduct($_POST['productName'], (float)$_POST['productPrice'], $_POST['productMaterial'], $_POST['productFit'], $_POST['productGender'], $_POST['productCharacteristics'], $_POST['productColours'], $_POST['productImages'], $_POST['productSizes'], (int)$_POST['productCollection']);
				} else {
					handleError('Completa todos los campos requeridos.');
				}
				break;

			case 'delete_product_attribute':
				if (!empty($_POST['attribute']) && isset($_POST['idProduct'])) {
					deleteProductAttribute((int)$_POST['idProduct'], $_POST['attribute'], $_POST['value']);
				} else {
					handleError('Faltan parámetros para eliminar el atributo.');
				}
				break;

			default:
				handleError('Acción no válida.');
				break;
		}
	}
}

actions();
