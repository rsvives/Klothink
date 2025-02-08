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
			handleError('No se pudo conectar a la base de datos. Por favor, inténtalo de nuevo más tarde.');
		}
		$query = "SELECT * FROM product";
		$products = $conn->query($query);
		if ($products) {
			return $products;
		} else {
			handleError('Error al obtener los productos. Inténtalo nuevamente.');
		}
	} catch (Exception $e) {
		handleError('Ocurrió un error inesperado: ' . $e->getMessage());
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
		$conection = connectDatabase();
		$query = 'SELECT * FROM product WHERE id = ?';

		$product = $conection->prepare($query);
		if (!$product) {
			handleError('Error al preparar la consulta.');
			return false;
		}
		$product->bind_param('i', $id);
		$product->execute();
		$result = $product->get_result();
		$data = $result->fetch_assoc();
		$product->close();
		$conection->close();
		if ($data) {
			return $data;
		} else {
			handleError('No se encontró el producto con ID: ' . $id);
			return false;
		}
	} catch (Exception $e) {
		handleError('Error inesperado: ' . $e->getMessage());
		return false;
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
		$connection = connectDatabase();
		if (!$connection) {
			handleError('No se pudo conectar a la base de datos. Inténtalo más tarde.');
		}

		$query = "DELETE FROM product WHERE id = ?";
		$stmt = $connection->prepare($query);

		if (!$stmt) {
			handleError('Error al preparar la consulta para eliminar el producto.');
		}

		$stmt->bind_param('i', $id);
		if (!$stmt->execute()) {
			handleError('No se pudo eliminar el producto. Inténtalo nuevamente.');
		}
		$stmt->close();
		$connection->close();
		header("Location: ../views/products.php");
		exit();
	} catch (Exception $e) {
		handleError('Ocurrió un error inesperado: ' . $e->getMessage());
	}
}
/**
 * Añade un producto a la base de datos mediante los campos asociados.
 *
 * @param int $id El ID del producto que se desea añadir.
 */
function createProduct($name, $price, $material, $fit, $gender, $characteristics, $colours, $images, $sizes, $idCollection, $idCategory)
{
	try {
		$connection = connectDatabase();
		if (!$connection) {
			handleError('No se pudo conectar a la base de datos. Inténtalo más tarde.');
		}

		$query = "INSERT INTO product VALUES (?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $connection->prepare($query);

		if (!$stmt) {
			handleError('Error al preparar la consulta para eliminar el producto.');
		}

		$stmt->bind_param('sdsssssssss', $name, $price, $material, $fit, $gender, $characteristics, $colours, $images, $sizes, $idCollection, $idCategory);
		if (!$stmt->execute()) {
			handleError('No se pudo eliminar el producto. Inténtalo nuevamente.');
		}

		$stmt->close();
		$connection->close();
		header("Location: ../views/products.php");
		exit();
	} catch (Exception $e) {
		handleError('Ocurrió un error inesperado: ' . $e->getMessage());
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
			handleError('Error al preparar la consulta para obtener el usuario.');
		}
		$stmt->bind_param('s', $alias);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result && $user = $result->fetch_assoc()) {
			return $user['id'];
		}
		$stmt->close();
		$conn->close();
		return null;
	} catch (Exception $e) {
		return null;
	}
}

/**
 * Añade un producto al carrito del usuario basado en el alias.
 *
 * @param int $idProduct El ID del producto que se va a añadir.
 */
function addProductToCart($idProduct)
{
	try {
		session_start();
		if (!isset($_SESSION['user_alias'])) {
			handleError('No hay sesión activa. Inicia sesión para continuar.');
		}

		$userAlias = $_SESSION['user_alias'];
		$idUser = getUserIdByAlias($userAlias);

		if (!$idUser) {
			handleError('Usuario no encontrado. Verifica tu sesión e inténtalo nuevamente.');
		}

		$conn = connectDatabase();
		$query = 'INSERT INTO `order` (idUser, idProduct) VALUES (?, ?)';
		$stmt = $conn->prepare($query);

		if (!$stmt) {
			handleError('Error al preparar la consulta para añadir el producto al carrito.');
		}

		$stmt->bind_param('ii', $idUser, $idProduct);
		if (!$stmt->execute()) {
			handleError('No se pudo añadir el producto al carrito. Inténtalo nuevamente.');
		}

		$stmt->close();
		$conn->close();
		header('Location: http://localhost/klothink/views/products.php');
		exit();
	} catch (Exception $e) {
		handleError('Ocurrió un error inesperado: ' . $e->getMessage());
	}
}
/**
 * Maneja las acciones del formulario.
 */
function actions()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$action = $_POST['action'] ?? '';
		if ($action === 'delete_product') {
			if (isset($_POST['idProduct']) && is_numeric($_POST['idProduct'])) {
				deleteProductById($_POST['idProduct']);
			} else {
				handleError('El ID del producto no es válido.');
			}
		}
		if ($action === 'create_product') {
			createProduct($_POST['productName'], $_POST['productPrice'], $_POST['productMaterial'], $_POST['productFit'], $_POST['productGender'], $_POST['productCharacteristics'], $_POST['productColours'], $_POST['productImages'], $_POST['productSizes'], $_POST['productCollection'], $_POST['idCategory']);
		}
		if ($action === 'add_to_cart') {
			if (isset($_POST['idProduct']) && is_numeric($_POST['idProduct'])) {
				addProductToCart($_POST['idProduct']);
			} else {
				handleError('El ID del producto no es válido.');
			}
		}
	}
}
actions();
