<!DOCTYPE html>
<html lang="es">
<?php require_once('../components/head.php'); ?>

<body>

	<?php require_once('../components/header.php'); ?>

	<main>
		<div class="products"></div>
		<section class="cart">
			<section class="header">
				<h2>Mi carrito</h2>
				<?php
				$user = $_SESSION['user_alias'];
				require_once('../database/orders.php');
				foreach ($orders as $order) {
					if ($order['idUser '] === $user) {
						$product = getProductById($order['idProduct']);
						if ($product) {
							$products[] = $product;
						}
					}
				}
				?>
				<h3>Tienes <?= count($products) ?> productos en la cesta</h3>
			</section>

			<?php foreach ($orders as $order) : ?>
				<?php
				if ($order['idUser  '] === $user) :
					$product = getProductById($order['idProduct']);
					if ($product) :
						$subtotal += $product['price'] * $order['quantity'];
				?>
						<section class="main">
							<section class="products">
								<article>
									<?php foreach ($product['images'] as $imageUrl): ?>
										<figure>
											<img src="<?= htmlspecialchars($imageUrl) ?>" alt="Imagen del producto">
										</figure>
									<?php endforeach; ?>
									<div class="header">
										<div class="title"><?= htmlspecialchars($product['name']) ?></div>
										<div class="fit"><?= htmlspecialchars($product['fit']) ?></div>
									</div>
									<figcaption>
										<div class="quantity">
											<label for="quantity">Cantidad:</label>
											<input type="number" id="quantity" step="1" min="1" value="<?= htmlspecialchars($order['quantity']) ?>">
										</div>
										<h3 class="price"><?= htmlspecialchars($product['price']) ?> €</h3>
										<img class="trash" src="./images/trash.svg" alt="Eliminar producto">
									</figcaption>
								</article>
							</section>
						</section>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>

			<section class="aside">
				<div class="main">
					<div class="header">
						<div class="title">
							<h2>Detalles de la tarjeta</h2>
						</div>
						<div class="image">
							<img src="./images/profile.jpg" alt="">
						</div>
					</div>
					<form action="process_payment.php" method="POST">
						<label for="cardName">Nombre de la tarjeta</label>
						<input type="text" id="cardName" name="cardName" placeholder="Nombre" required>
						<label for="cardNumber">Número de la tarjeta</label>
						<input type="text" id="cardNumber" name="cardNumber" placeholder="1111 2222 3333 4444" required>

						<div class="footer-button">
							<div class="expiration-date">
								<label for="date">Fecha de expiración</label>
								<input type="text" placeholder="mm/yy" id="date" name="date" required>
							</div>
							<div class="cvv">
								<label for="cv v">CVV</label>
								<input type="text" placeholder="123" id="cvv" name="cvv" required>
							</div>
						</div>

						<div class="footer">
							<div class="subtotal">
								<h4>Subtotal</h4>
								<p id="subtotal"><?= number_format($subtotal, 2) ?> €</p>
							</div>
							<div class="envio">
								<h4>Envío</h4>
								<p>Calculado en el pago</p>
							</div>
						</div>
						<button type="submit">Proceder al pago</button>
					</form>
				</div>
			</section>
		</section>
	</main>
	<?php require_once('../components/footer.php'); ?>
</body>

</html>