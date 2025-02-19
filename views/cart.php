<!DOCTYPE html>
<html lang="es">
<?php require_once '../components/head.php' ?>

<body>
	<?php require_once '../components/header.php' ?>

	<header>
		<h1>Mi carrito</h1>
		<h3 id="cart-status">Tienes productos en la cesta</h3>
	</header>

	<main>
		<section class="cart">
			<section class="products" id="cart-container">
			</section>
			<section class="aside">
				<div class="main">
					<h2>Detalles de la tarjeta</h2>
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
								<label for="cvv">CVV</label>
								<input type="text" placeholder="123" id="cvv" name="cvv" required>
							</div>
						</div>

						<div class="footer">
							<div class="subtotal">
								<h4>Subtotal</h4>
								<p id="subtotal">0.00 €</p>
							</div>
							<div class="envio">
								<h4>Envío</h4>
								<p>Calculado en el pago</p>
							</div>
						</div>
						<button type="submit">Proceder al pago</button>
					</form>

					<button id="clear-cart" class="clear-cart">Vaciar carrito</button>
				</div>
			</section>
		</section>
	</main>


</body>

</html>