<!DOCTYPE html>
<html lang="es">
<?php require_once('../components/head.php') ?>


<body>
	<?php
	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$collectionData = getCollectionById($_GET['id']);
		if ($collectionData) {
			$collection = $collectionData['collection'];
			$products = $collectionData['products'];
		} else {
			handleError('La colección solicitada no se ha encontrado.');
			exit;
		}
	} else {
		handleError('ID inválido. Asegúrate de que el ID de la colección es correcto.');
		exit;
	}
	?>
	<?php require_once('../components/header.php') ?>
	<main id="detail">
		<section class="collections">
			<div class="collection" id="<?= htmlspecialchars($collection['name']); ?>">
				<div class="header">
					<div class="title">
						<h2><?= htmlspecialchars($collection['name']); ?></h2>
						<p><?= htmlspecialchars($collection['description']); ?></p>
					</div>
				</div>

				<div class="clothes">
					<?php if (empty($products)): ?>
						<p>No hay productos disponibles en esta colección.</p>
					<?php else: ?>
						<?php foreach ($products as $product): ?>
							<?php if ($product['idCollection'] === $collection['id']): ?>
								<?php include '../components/article.php'; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<?php require_once '../components/faq.php'; ?>
	</main>

	<?php require_once '../components/footer.php'; ?>
</body>


</html>