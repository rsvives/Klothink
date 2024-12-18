<?php
require_once './db.php';
/**
 * Registra un nuevo usuario en la base de datos.
 */
function registerUser($alias, $email, $password)
{
    $connection = connectDatabase();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "El correo electrónico no es válido.";
        $connection->close();
        return;
    }
    $checkQuery = $connection->prepare("SELECT alias, email FROM users WHERE alias = ? OR email = ?");
    $checkQuery->bind_param("ss", $alias, $email);
    $checkQuery->execute();
    $checkQuery->store_result();

    if ($checkQuery->num_rows > 0) {
        $checkQuery->bind_result($existingAlias, $existingEmail);
        $checkQuery->fetch();

        if ($existingAlias === $alias) {
            echo "El alias ya está en uso. Por favor, elige otro.";
        } elseif ($existingEmail === $email) {
            echo "El correo ya está registrado. Por favor, usa otro.";
        }
        $checkQuery->close();
        $connection->close();
        return;
    }
    $checkQuery->close();
    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
    $insertUserQuery = $connection->prepare("INSERT INTO users (alias, email, password) VALUES (?, ?, ?)");
    $insertUserQuery->bind_param("sss", $alias, $email, $encryptedPassword);
    if ($insertUserQuery->execute()) {
        echo "Usuario " . htmlspecialchars($alias) . " registrado correctamente.";
        loginUser($alias, $password);
    } else {
        echo "Error al registrar usuario: " . $insertUserQuery->error;
    }

    $insertUserQuery->close();
    $connection->close();
}
/**
 * Funcion auxiliar que obtiene el rol de un usuario a partir de su alias.
 */
function getUserRole($alias)
{
    $connection = connectDatabase();
    $query = $connection->prepare("SELECT role FROM users WHERE alias = ?");
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
    $checkQuery = $connection->prepare("SELECT password FROM users WHERE alias = ?");
    $checkQuery->bind_param("s", $alias);
    $checkQuery->execute();
    $checkQuery->bind_result($hashedPassword);

    if ($checkQuery->fetch() && password_verify($password, $hashedPassword)) {
        session_start();
        $_SESSION['user_alias'] = $alias;
        $_SESSION['user_role'] = getUserRole($alias);
        header("Location: ../index.php");
        exit();
    } else {
        echo "Alias o contraseña incorrectos.";
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
        if (isset($_POST['name'], $_POST['email'], $_POST['password'])) {
            registerUser($_POST['name'], $_POST['email'], $_POST['password']);
        } else {
            echo "Por favor, complete todos los campos para el registro.";
        }
    } elseif ($action === 'login') {
        if (isset($_POST['name'], $_POST['password'])) {
            loginUser($_POST['name'], $_POST['password']);
        } else {
            echo "Por favor, complete todos los campos para iniciar sesión.";
        }
    } else {
        echo "Acción no válida.";
    }
}
