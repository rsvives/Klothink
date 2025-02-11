<?php
require_once '../database/functions.php';
require_once '../database/functions.php';


/**
 * Conexión a la base de datos utilizando MySQLi.
 *
 * @var string $host El host de la base de datos (localhost).
 * @var string $db El nombre de la base de datos (klothink).
 * @var string $user El nombre de usuario para la conexión.
 * @var string $pass La contraseña para la conexión.
 *
 * @return mysqli Retorna la instancia de la conexión MySQLi.
 */
function connectDatabase()
{
    $host = 'localhost';
    $db = 'klothink';
    $user = 'root';
    $pass = '';

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        handleError("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
