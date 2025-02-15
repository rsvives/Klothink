<!DOCTYPE html>
<html lang="es">
<?php require_once('../components/head.php'); ?>

<body>
	<?php require_once('../components/header.php'); ?>
	<main>
		<section class="profile">
			<?php require_once('../database/users.php'); ?>
			<?php $users = getUsers(); ?>
			<div class="details">
				<h3>Detalles del Usuario</h3>
				<form>
					<div>
						<label for="email">Correo Electrónico</label>
						<input type="email" id="email" placeholder="Correo Electrónico">
					</div>
					<div>
						<label for="alias">Alias</label>
						<input type="text" id="alias" placeholder="Alias">
					</div>
					<div>
						<label for="password">Contraseña</label>
						<input type="password" id="password" placeholder="Contraseña">
					</div>
					<button type="button" onclick="saveUserDetails()">Guardar</button>
				</form>
			</div>
			<div class="user-list">
				<h3>Usuarios</h3>
				<ul>
					<li onclick="showUserDetails('Usuario 1', 'user1@example.com', 'Alias1')">Usuario 1</li>
					<li onclick="showUserDetails('Usuario 2', 'user2@example.com', 'Alias2')">Usuario 2</li>
					<li onclick="showUserDetails('Usuario 3', 'user3@example.com', 'Alias3')">Usuario 3</li>
				</ul>
			</div>
		</section>
	</main>
	<?php require_once('../components/footer.php'); ?>
</body>

</html>