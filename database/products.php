<?php
require_once '../database/db.php';
require_once '../database/functions.php';

/**
 * Obtiene todos los productos de la base de datos.
 *
 * @return mysqli_result|false Los productos de la base de datos o false si ocurre un error.
 */
function getProducts()
{
	try {
		$conn = connectDatabase();
		if (!$conn) {
			handleError('No se pudo conectar a la base de datos.');
			return false;
		}

		$query = "SELECT * FROM product";
		return $conn->query($query);
	} catch (Exception $e) {
		handleError('Error inesperado: ' . $e->getMessage());
		return false;
	}
}

/**
 * Obtiene un producto desde la base de datos por su 'id'.
 *
 * @param int $id El ID del producto a obtener.
 * @return array|null Un arreglo con los datos del producto o null si ocurre un error.
 */
function getProductById($id)
{
	try {
		$conn = connectDatabase();
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
function deleteProductById($id)
{
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

		header("Location: ../views/products.php");
		exit();
	} catch (Exception $e) {
		handleError('Error inesperado: ' . $e->getMessage());
	}
}

/**
 * Añade un producto a la base de datos.
 */
function createProduct($name, $price, $material, $fit, $gender, $characteristics, $colours, $images, $sizes, $idCollection)
{
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

		header("Location: ../views/products.php");
		exit();
	} catch (Exception $e) {
		handleError('Error inesperado: ' . $e->getMessage());
	}
}

/**
 * Obtiene el ID del usuario por su alias.
 *
 * @param string $alias El alias del usuario.
 * @return int|null El ID del usuario o null si no se encuentra.
 */
function getUserIdByAlias($alias)
{
	try {
		$conn = connectDatabase();
		$query = "SELECT id FROM user WHERE alias = ?";
		$stmt = $conn->prepare($query);

		if (!$stmt) {
			handleError('Error al preparar la consulta.');
			return null;
		}

		$stmt->bind_param('s', $alias);
		$stmt->execute();
		$result = $stmt->get_result();
		$user = $result->fetch_assoc();

		$stmt->close();
		$conn->close();

		return $user['id'] ?? null;
	} catch (Exception $e) {
		return null;
	}
}

/**
 * Procesa las acciones relacionadas con productos.
 */
function actions()
{
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
				if (!empty($_POST['productName']) & isset($_POST['productPrice'], $_POST['productMaterial'], $_POST['productFit'], $_POST['productGender'], $_POST['productCharacteristics'], $_POST['productColours'], $_POST['productImages'], $_POST['productSizes'], $_POST['productCollection'])) {
					createProduct($_POST['productName'], (float)$_POST['productPrice'], $_POST['productMaterial'], $_POST['productFit'], $_POST['productGender'], $_POST['productCharacteristics'], $_POST['productColours'], $_POST['productImages'], $_POST['productSizes'], (int)$_POST['productCollection']);
				} else {
					handleError('Completa todos los campos requeridos.');
				}
				break;
			default:
				handleError('Acción no válida.');
				break;
		}
	}
}

actions();
