<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="twitter:title" content="Klothink - Ropa Sostenible y Personalizada" />
	<meta property="og:title" content="Klothink - Ropa Sostenible y Personalizada" />
	<meta name="keywords" content="Moda sostenible, ropa personalizada, estilo de vida, algoritmos, aprendizaje automático, impacto ambiental" />
	<meta name="twitter:description" content="Encuentra ropa que se adapte a tu estilo de vida y valores." />
	<meta property="og:description" content="Encuentra ropa que se adapte a tu estilo de vida y valores." />
	<meta name="description" content="Klothink - Encuentra ropa sostenible y personalizada que se adapta a tu estilo de vida y valores." />
	<title>Klothink - Encuentra ropa que se adapte a tu estilo de vida y valores.</title>
	<link rel="icon" href="../images/brand-page.svg" />
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="../css/styles.css?v=2" />
	<script defer src="../js/script.js?v=2"></script>
	<?php session_name('Klothink'); ?>
	<?php session_start(); ?>
	<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if (file_exists('../database/db.php') | file_exists('../database/db.php') | file_exists('../database/db.php')) {
		require_once '../database/db.php';
		require_once '../database/products.php';
		require_once '../database/collections.php';
	} else {
		handleError('No se pudo establecer conexión con la base de datos. Por favor, inténtalo más tarde.');
	}
	?>
</head>