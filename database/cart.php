<?php require_once 'db.php';
$conection = connectDatabase();

$queryCollections = 'SELECT * FROM collections';
$query = $connection->query($queryCollections);
var_dump($query->fetch_assoc());

if (isset($_SESSION['user_alias'])) {
	var_dump($_SESSION['user_alias']);
}
