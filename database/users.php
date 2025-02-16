<?php
require_once '../database/db.php';
require_once '../database/functions.php';
/**
 * Registra un nuevo usuario en la base de datos.
 */
function registerUser($alias, $email, $password)
{
    $conn = connectDatabase() or handleError("No se pudo conectar a la base de datos.");

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        handleError("El correo electrónico ingresado no es válido.");
    }

    $stmtCheck = $conn->prepare("SELECT alias, email FROM user WHERE alias = ? OR email = ?");
    if (!$stmtCheck) {
        handleError("Error al preparar la consulta de verificación.");
    }
    $stmtCheck->bind_param("ss", $alias, $email);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        $stmtCheck->bind_result($existingAlias, $existingEmail);
        $stmtCheck->fetch();
        $stmtCheck->close();
        $conn->close();

        if ($existingAlias === $alias) {
            handleError("El alias '$alias' ya está en uso.");
        }
        if ($existingEmail === $email) {
            handleError("El correo '$email' ya está registrado.");
        }
    }

    $stmtCheck->close();
    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmtInsert = $conn->prepare("INSERT INTO user (alias, email, password) VALUES (?, ?, ?)");
    if (!$stmtInsert) {
        handleError("Error al preparar la inserción de usuario.");
    }
    $stmtInsert->bind_param("sss", $alias, $email, $encryptedPassword);

    if ($stmtInsert->execute()) {
        loginUser($alias, $password);
    } else {
        handleError("Error al registrar el usuario: " . $stmtInsert->error);
    }

    $stmtInsert->close();
    $conn->close();
}

/**
 * Obtiene el rol de un usuario a partir de su alias.
 */
function getUserRole($alias)
{
    $conn = connectDatabase();
    if (!$conn) {
        handleError("No se pudo conectar a la base de datos.");
    }
    $stmt = $conn->prepare("SELECT role FROM user WHERE alias = ?");
    if (!$stmt) {
        handleError("Error al preparar la consulta del rol de usuario.");
    }
    $stmt->bind_param("s", $alias);
    $stmt->execute();
    $stmt->bind_result($role);
    $stmt->fetch();

    $stmt->close();
    $conn->close();
    return $role;
}


/**
 * Inicia sesión de un usuario utilizando su alias y contraseña.
 */
function loginUser($alias, $password)
{
    $conn = connectDatabase();

    if (!$conn) {
        handleError("No se pudo conectar a la base de datos.");
    }

    $stmtCheck = $conn->prepare("SELECT password FROM user WHERE alias = ?");
    if (!$stmtCheck) {
        handleError("Error al preparar la consulta de inicio de sesión.");
    }
    $stmtCheck->bind_param("s", $alias);
    $stmtCheck->execute();
    $stmtCheck->bind_result($hashedPassword);

    if ($stmtCheck->fetch() && password_verify($password, $hashedPassword)) {
        session_name('Klothink');
        session_start();
        $_SESSION['user_alias'] = $alias;
        $_SESSION['user_role'] = getUserRole($alias);
        header("Location: ../views/index.php");
        die();
    } else {
        handleError("Alias o contraseña incorrectos.");
    }

    $stmtCheck->close();
    $conn->close();
}


/**
 * Obtiene todos los usuarios de la base de datos.
 */
function getUsers()
{
    $conn = connectDatabase();
    if (!$conn) {
        handleError("No se pudo conectar a la base de datos.");
    }

    $query = "SELECT * FROM user";
    $users = $conn->query($query);

    if (!$users) {
        handleError("No se pudieron obtener los usuarios.");
    }

    return $users;
}

/**
 * Actualiza el rol de un usuario en la base de datos.
 */
function updateUsers($id, $role)
{
    $connection = connectDatabase();
    if (!$connection) {
        handleError("No se pudo conectar a la base de datos.");
    }

    $query = "UPDATE user SET role = ? WHERE id = ?";
    $stmt = $connection->prepare($query);
    if (!$stmt) {
        handleError("No se pudo preparar la consulta para actualizar el usuario.");
    }

    $stmt->bind_param("si", $role, $id);
    if (!$stmt->execute()) {
        handleError("No se pudo actualizar el rol del usuario.");
    }

    $stmt->close();
    $connection->close();
    return true;
}
/**
 * Obtiene la foto de perfil de un usuario y la guarda en la sesión.
 *
 * @param string $alias El alias del usuario.
 * @return string|null La imagen de perfil si existe, o null si no tiene una.
 */
function obtenerFotoUsuario($alias)
{

    $conn = connectDatabase();
    $foto = null;

    if ($stmt = $conn->prepare("SELECT image FROM user WHERE alias = ?")) {
        $stmt->bind_param("s", $alias);
        $stmt->execute();
        $stmt->bind_result($image);

        if ($stmt->fetch() && !empty($image)) {
            $_SESSION['user_photo'] = $image;
            $foto = $image;
        }

        $stmt->close();
    }

    $conn->close();
}

/**
 * Procesa las acciones del formulario de registro e inicio de sesión.
 */
function actions()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'register') {
            if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                registerUser($_POST['name'], $_POST['email'], $_POST['password']);
            } else {
                handleError("Por favor, completa todos los campos para el registro.");
            }
        } elseif ($action === 'login') {
            if (!empty($_POST['name']) && !empty($_POST['password'])) {
                loginUser($_POST['name'], $_POST['password']);
            } else {
                handleError("Por favor, completa todos los campos para iniciar sesión.");
            }
        } else {
            handleError("Acción no válida.");
        }
    }
}
actions();
