<article class="<?= htmlspecialchars($product['gender'] === 'men' ? 'men' : ($product['gender'] === 'women' ? 'women' : 'unisex')); ?> <?= htmlspecialchars($collection['name']); ?>">
	<?php if ($_SESSION['user_role'] === 'Administrador'): ?>
		<div class="action-buttons">
			<form method="post" action="../database/products.php" class="delete-button" onsubmit="confirmDelete(event,<?= htmlspecialchars($product['id']); ?>, '<?= htmlspecialchars($product['name']); ?>')">
				<input type="hidden" name="action" value="delete_product">
				<input type="hidden" name="idProduct" value="<?= htmlspecialchars($product['id']); ?>">
				<button type="submit" class="delete-button">
					<img src="../images/close-icon.svg" alt="Eliminar">
				</button>
			</form>
		</div>
	<?php endif; ?>
	<?php $productsImagesUrls = explode(',', $product['images']); ?>
	<figure>
		<a href="./product-detail.php?id=<?= htmlspecialchars($product['id']); ?>">
			<img src="<?= htmlspecialchars($productsImagesUrls[0]); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
		</a>
		<button type="submit" class="shopping-cart">
			<img src="../images/shopping-cart.svg" alt="shopping-cart">
		</button>
	</figure>
	<figcaption>
		<a href="./product-detail.php?id=<?= htmlspecialchars($product['id']); ?>">
			<h2><?= htmlspecialchars($product['name']); ?></h2>
		</a>
		<div class="footer">
			<h3><?= htmlspecialchars($product['fit']); ?></h3>
			<span><?= htmlspecialchars(number_format($product['price'], 2, ',')) ?></span>
		</div>
	</figcaption>
</article>

<script>
	// let addToCartForm = document.querySelector('.add_to_cart_form')

	// addToCartForm.onsubmit = (event) => {
	// 	event.preventDefault()
	// 	console.log('hello')

	// }
</script>