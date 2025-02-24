<head>
	<!-- Metadatos generales para la página -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Klothink - Encuentra ropa sostenible y personalizada que se adapta a tu estilo de vida y valores.">
	<meta name="keywords" content="Moda sostenible, ropa personalizada, estilo de vida, algoritmos, aprendizaje automático, impacto ambiental">
	<meta property="og:title" content="Klothink - Ropa Sostenible y Personalizada">
	<meta property="og:description" content="Encuentra ropa que se adapte a tu estilo de vida y valores.">
	<meta name="twitter:title" content="Klothink - Ropa Sostenible y Personalizada">
	<meta name="twitter:description" content="Encuentra ropa que se adapte a tu estilo de vida y valores.">

	<title>Klothink - Encuentra ropa que se adapte a tu estilo de vida y valores.</title>

	<link rel="icon" href="../images/brand-page.svg">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

	<!-- Estilos CSS de la página -->
	<link rel="stylesheet" href="../css/cart.css?v=2">
	<link rel="stylesheet" href="../css/collections.css?v=2">
	<link rel="stylesheet" href="../css/error.css?v=2">
	<link rel="stylesheet" href="../css/filters.css?v=2">
	<link rel="stylesheet" href="../css/header.css?v=2">
	<link rel="stylesheet" href="../css/hero.css?v=2">
	<link rel="stylesheet" href="../css/polities.css?v=2">
	<link rel="stylesheet" href="../css/product-detail.css?v=2">
	<link rel="stylesheet" href="../css/profile.css?v=2">
	<link rel="stylesheet" href="../css/register.css?v=2">
	<link rel="stylesheet" href="../css/reset.css?v=2">
	<link rel="stylesheet" href="../css/reviews.css?v=2">
	<link rel="stylesheet" href="../css/styles.css?v=2">

	<!-- Scripts de la página -->
	<script defer src="../js/cart.js?v=2"></script>
	<script defer src="../js/dropdown.js?v=2"></script>
	<script defer src="../js/filters.js?v=2"></script>
	<script defer src="../js/password.js?v=2"></script>
	<script defer src="../js/popup.js?v=2"></script>
	<script defer src="../js/storage.js?v=2"></script>
	<script defer src="../js/utils.js?v=2"></script>

	<!-- Código PHP para manejar la conexión a la base de datos -->
	<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_name('Klothink');
		session_start();
	}

	if (file_exists('../database/db.php') || file_exists('../database/products.php') || file_exists('../database/collections.php')) {
		require_once '../database/db.php';
		require_once '../database/products.php';
		require_once '../database/collections.php';
	} else {
		handleError('No se pudo establecer conexión con la base de datos. Por favor, inténtalo más tarde.');
	}
	?>

</head>

<script>
	/**
	 * Cambia el botón de navegación activo según la página actual.
	 * Compara el nombre del archivo de la URL y selecciona el botón correspondiente.
	 * La clase 'active' se agrega al botón correspondiente para indicar la página actual.
	 */
	function changeNav() {
		let file = window.location.pathname.split('/').pop();
		let navButtons = document.querySelectorAll('.nav-button');
		let activeButton = null;
		if (file === 'index.php') activeButton = navButtons[0];
		if (file === 'products.php') activeButton = navButtons[1];
		if (file === 'contact.php') activeButton = navButtons[2];
		if (activeButton) activeButton.classList.add('active');
	}
</script>