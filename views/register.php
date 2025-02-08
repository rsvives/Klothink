<?php require_once('../components/head.php') ?>

<body>
	<?php require_once '../components/header.php'; ?>
	<main>
		<section class="register">
			<img src="../images\background.png" alt="background">
			<div class="main">
				<section class="header">
					<img src="../images/brand-page.svg" alt="Logo de la marca">
					<h2>Registrate</h2>
					<button>
						<p>Registrate con google</p>
						<img src="../images\google-icon.png" alt="google-icon">
					</button>
					<div class="separator">
						<span>o</span>
					</div>


				</section>
				<form method="post" action="../database/users.php">
					<input type="hidden" name="action" value="register">
					<div class="form-group">
						<input type="text" name="name" placeholder="Ingresa tu Alias" required>
					</div>
					<div class="form-group">
						<input type="text" name="email" placeholder="Ingresa tu correo electronico" required>
					</div>
					<div class="form-group password-container">
						<input type="password" name="password" id="register-password" placeholder="Contraseña" required>
						<span class="toggle-password">
							<img src="../images/hide-password.svg" alt="Toggle Password Visibility">
						</span>
					</div>
					<button class="btn-submit" type="submit">Registrarse</button>
				</form>
				<div class="footer">
					<p>Ya tienes una cuenta?</p>
					<a href="./logIn.php">Iniciar sesión</a>
				</div>
			</div>
		</section>
	</main>
	<?php require_once '../components/footer.php'; ?>
</body>

</html>