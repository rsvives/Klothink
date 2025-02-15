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
	<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_name('Klothink');
		session_start();
	}
	if (file_exists('../database/db.php') | file_exists('../database/products.php') | file_exists('../database/collections.php')) {
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
	 * Cambia el botón de navegación activo en función del archivo actual de la URL.
	 * La función determina el archivo actual basado en la ruta de la URL, compara el nombre del archivo
	 * con casos predefinidos ('index.php', 'products.php', 'contact.php') y asigna la clase 'active'
	 * al botón de navegación correspondiente.
	 *
	 * El método busca todos los elementos con la clase 'nav-button' y activa el primero que coincide
	 * con el archivo actual. Si no se encuentra un archivo que coincida, no se realiza ningún cambio.
	 *
	 * Esta función se utiliza típicamente para resaltar el botón de navegación correspondiente a la
	 * página actual del usuario.
	 *
	 */
	function changeNav() {
		let file = window.location.pathname.split('/').pop();
		let navButtons = document.querySelectorAll('.nav-button');
		let activeButton;
		switch (file) {
			case 'index.php':
				activeButton = navButtons[0];
				break;
			case 'products.php':
				activeButton = navButtons[1];
				break;
			case 'contact.php':
				activeButton = navButtons[2];
				break;
		}
		if (activeButton) {
			activeButton.classList.add('active');
		}
	}
</script>