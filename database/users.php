<?php
require_once '../database/db.php';
require_once '../database/functions.php';

/**
 * Registra un nuevo usuario en la base de datos.
 */
function registerUser($alias, $email, $password, $image = null)
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

    // Subir la imagen si se proporciona
    if ($image) {
        // Definir el directorio para guardar la imagen
        $uploadDir = __DIR__ . '/../local_storage/profile_pics/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Crear el directorio si no existe
        }

        // Generar un nombre único para la imagen
        $imagePath = $uploadDir . time() . '_' . basename($image['name']);

        // Mover el archivo subido a la carpeta local
        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            handleError("Error al subir la imagen.");
        }
    } else {
        $imagePath = null; // No se sube ninguna imagen, asigna null
    }

    $stmtCheck->close();
    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmtInsert = $conn->prepare("INSERT INTO user (alias, email, password, image) VALUES (?, ?, ?, ?)");
    if (!$stmtInsert) {
        handleError("Error al preparar la inserción de usuario.");
    }
    $stmtInsert->bind_param("ssss", $alias, $email, $encryptedPassword, $imagePath);

    if ($stmtInsert->execute()) {
        // Después de insertar, actualizamos la sesión con la imagen
        $_SESSION['user_alias'] = $alias;
        $_SESSION['user_role'] = getUserRole($alias);
        $_SESSION['user_photo'] = $imagePath;  // Guardamos la imagen en la sesión
        header("Location: ../views/index.php");
        die();
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

    $stmtCheck = $conn->prepare("SELECT password, image FROM user WHERE alias = ?");
    if (!$stmtCheck) {
        handleError("Error al preparar la consulta de inicio de sesión.");
    }
    $stmtCheck->bind_param("s", $alias);
    $stmtCheck->execute();
    $stmtCheck->bind_result($hashedPassword, $image);

    if ($stmtCheck->fetch() && password_verify($password, $hashedPassword)) {
        session_name('Klothink');
        session_start();
        $_SESSION['user_alias'] = $alias;
        $_SESSION['user_role'] = getUserRole($alias);
        $_SESSION['user_photo'] = $image;  // Al iniciar sesión, guardamos la imagen en la sesión
        header("Location: ../views/index.php");
        die();
    } else {
        handleError("Alias o contraseña incorrectos.");
    }

    $stmtCheck->close();
    $conn->close();
}

/**
 * Obtiene la foto de perfil de un usuario y la guarda en la sesión.
 *
 * @param string $alias El alias del usuario.
 * @return string|null La imagen de perfil si existe, o null si no tiene una.
 */
function getProfileImageUser($alias)
{
    $conn = connectDatabase();

    if ($stmt = $conn->prepare("SELECT image FROM user WHERE alias = ?")) {
        $stmt->bind_param("s", $alias);
        $stmt->execute();
        $stmt->bind_result($image);

        if ($stmt->fetch() && !empty($image)) {
            $_SESSION['user_photo'] = $image;
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

        switch ($action) {
            case 'register':
                if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                    // Pasamos también el archivo de imagen si está presente
                    $image = $_FILES['profile_picture'] ?? null;
                    registerUser($_POST['name'], $_POST['email'], $_POST['password'], $image);
                } else {
                    handleError("Por favor, completa todos los campos para el registro.");
                }
                break;

            case 'login':
                if (!empty($_POST['name']) && !empty($_POST['password'])) {
                    loginUser($_POST['name'], $_POST['password']);
                } else {
                    handleError("Por favor, completa todos los campos para iniciar sesión.");
                }
                break;

            default:
                handleError("Acción no válida.");
                break;
        }
    }
}

actions();
