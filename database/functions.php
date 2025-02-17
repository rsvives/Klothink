<?php

/**
 * Maneja los errores redirigiendo a la página de error con un mensaje comprensible.
 *
 * @param string $errorMessage El mensaje de error a mostrar.
 */
function handleError($errorMessage)
{
    header('Location: ../views/error.php?error=' . urlencode($errorMessage));
    exit();
}
