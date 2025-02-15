<!DOCTYPE html>
<html lang="es">
<?php require_once('../components/head.php') ?>



<body>
	<?php $error_message = isset($_GET['error']) ? $_GET['error'] : 'unknown'; ?>
	<main>
		<section class="error">
			<h1>¡Vaya! Algo salió mal.</h1>
			<p>🎭 <strong>Klothink se ha perdido en el espacio digital.</strong></p>
			<p><?= $error_message ?></p>
			<div class="actions">
				<a href="./index.php"><button>Volver al inicio</button></a>
				<a href="./contact.php"><button>Contáctanos</button></a>
			</div>
		</section>
	</main>
</body>

</html>

</html>