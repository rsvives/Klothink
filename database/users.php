<?php
require_once '../database/db.php';
/**
 * Registra un nuevo usuario en la base de datos.
 */
function registerUser($alias, $email, $password)
{
    $connection = connectDatabase();
    if (!$connection) {
        handleError("No se pudo conectar a la base de datos. Inténtalo más tarde.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        handleError("El correo electrónico ingresado no es válido.");
    }

    $checkQuery = $connection->prepare("SELECT alias, email FROM user WHERE alias = ? OR email = ?");
    $checkQuery->bind_param("ss", $alias, $email);
    $checkQuery->execute();
    $checkQuery->store_result();

    if ($checkQuery->num_rows > 0) {
        $checkQuery->bind_result($existingAlias, $existingEmail);
        $checkQuery->fetch();
        $checkQuery->close();
        $connection->close();

        if ($existingAlias === $alias) {
            handleError("El alias '$alias' ya está en uso. Elige otro.");
        }
        if ($existingEmail === $email) {
            handleError("El correo '$email' ya está registrado. Usa otro.");
        }
    }

    $checkQuery->close();
    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
    $insertUserQuery = $connection->prepare("INSERT INTO user (alias, email, password) VALUES (?, ?, ?)");
    $insertUserQuery->bind_param("sss", $alias, $email, $encryptedPassword);

    if ($insertUserQuery->execute()) {
        loginUser($alias, $password);
    } else {
        handleError("Error al registrar el usuario: " . $insertUserQuery->error);
    }

    $insertUserQuery->close();
    $connection->close();
}

/**
 * Obtiene el rol de un usuario a partir de su alias.
 */
function getUserRole($alias)
{
    $connection = connectDatabase();
    if (!$connection) {
        handleError("No se pudo conectar a la base de datos.");
    }

    $query = $connection->prepare("SELECT role FROM user WHERE alias = ?");
    $query->bind_param("s", $alias);
    $query->execute();
    $query->bind_result($role);
    $query->fetch();

    $query->close();
    $connection->close();

    return $role;
}

/**
 * Inicia sesión de un usuario utilizando su alias y contraseña.
 */
function loginUser($alias, $password)
{
    $connection = connectDatabase();
    if (!$connection) {
        handleError("No se pudo conectar a la base de datos.");
    }

    $checkQuery = $connection->prepare("SELECT password FROM user WHERE alias = ?");
    $checkQuery->bind_param("s", $alias);
    $checkQuery->execute();
    $checkQuery->bind_result($hashedPassword);

    if ($checkQuery->fetch() && password_verify($password, $hashedPassword)) {
        session_start();
        $_SESSION['user_alias'] = $alias;
        $_SESSION['user_role'] = getUserRole($alias);
        header("Location: ../views/index.php");
        exit();
    } else {
        handleError("Alias o contraseña incorrectos.");
    }

    $checkQuery->close();
    $connection->close();
}

/**
 * Procesa las acciones del formulario de registro e inicio de sesión.
 */
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
