<?php

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
    $host = 'localhost:3306';
    $db = 'klothink';
    $user = 'root';
    $pass = '';

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
// $conn = connectDatabase();
// $query = "SELECT * FROM products";
// $products = $conn->query($query);

// $query = "SELECT * FROM collections";
// $collections = $conn->query($query);
