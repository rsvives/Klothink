<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Klothink - Productos</title>
	<link rel="stylesheet" href="./css/styles.css">
	<?php include './database/db.php' ?>
	<?php include './database/cart.php' ?>
</head>

<body>
	<header>
		<nav>
			<ul>
				<li><a href="./index.php">Inicio</a></li>
				<li><a href="./products.php">Productos</a></li>
			</ul>
			<img src="./images/brand-page.svg" alt="Klothink Logo">
			<ul>
				<li class="shopping-cart"><a href="./cart.php"><img src="./images/shopping-cart.svg" alt="Carrito"></a></li>
				<li><a href="./contact.php">Contacto</a></li>
			</ul>
		</nav>
	</header>
	<main>
		<section class="cart">
			<section class="header">
				<h2>Mi carrito</h2>
				<h3>Mi carrito</h3>
				<h3>Tienes 3 items en la cesta</h3>
			</section>
			<section class="main">
				<section class="products" id="productCart">


				</section>
				<section class="aside">
					<div class="main">
						<div class="header">
							<div class="title">
								<h2>Card details</h2>
							</div>
							<div class="image">
								<img src="./images/profile.jpg" alt="">
							</div>
						</div>
						<form>
							<label for="cardName">Nombre de la tarjeta</label>
							<input type="text" id="cardName" placeholder="Nombre">
							<label for="cardNumber">Numero de la tarjeta</label>
							<input type="text" id="cardNumber" placeholder="1111 2222 3333 4444">
							<div class="footer-button">
								<div class="expiration-date">
									<label for="date">Fecha de expiración</label>
									<input type="text" placeholder="mm/yy" id="date">
								</div>
								<div class="cvv">
									<label for="cvv">CVV</label>
									<input type="text" placeholder="123" id="cvv">
								</div>
							</div>
							<div class="footer">
								<div class="subtotal">
									<h4>Subtotal</h4>
								</div>
								<div class="envio">
									<h4>Envío</h4>
								</div>
								<div class="total">
									<h4>Total</h4>
								</div>
							</div>
							<button type="submit">
								<div id="show-price">1.672 €</div>
								<div class="text">Pagar</div>
								<img src="./images/arrow-right.svg" alt="arrow-right">
							</button>
						</form>
					</div>
				</section>
			</section>
		</section>
	</main>

</body>

</html>