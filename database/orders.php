<?php
require_once '../database/db.php';
require_once '../database/functions.php';

function getOrders()
{
    try {
        $conection = connectDatabase();
        if (!$conection) {
            handleError('No se pudo conectar a la base de datos. Por favor, inténtalo de nuevo más tarde.');
        }
        $query = 'SELECT * FROM order';
        $orders = $conection->query($query);
        if ($orders) {
            return $orders;
        } else {
            handleError('Error al obtener los productos. Inténtalo nuevamente.');
        }
    } catch (Exception $e) {
        handleError('Ocurrió un error inesperado: ' . $e->getMessage());
    }
}
