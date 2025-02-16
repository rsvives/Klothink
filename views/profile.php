<!DOCTYPE html>
<html lang="es">
<?php include '../components/head.php'; ?>

<body>
    <style>

    </style>

    <?php include '../components/header.php'; ?>

    <main>
        <section class="profile">
            <div class="info">
                <div class="profile-pic-container">
                    <img src="<?= $_SESSION['user_photo'] ?>" alt="Foto de perfil" class="profile-pic" id="profile-pic">

                    <div class="edit-icon" id="edit-icon">
                        <img src="../images/pen-solid.svg" alt="Editar">
                    </div>
                    <input type="file" id="file-upload" accept="image" style="display: none;">
                </div>
                <h2>Información</h2>
                <h3>Nombre: <?= $_SESSION['user_alias'] ?></h3>
                <h3>Rol: <?= $_SESSION['user_role'] ?></h3>
            </div>
            <div class="details">
                <form action="" method="post">
                    <h2>Ajustes del Usuario</h2>
                    <label for="alias">Alias</label>
                    <input type="text" name="alias" placeholder="Tu alias" required>

                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" placeholder="Tu correo electrónico" required>

                    <button type="submit">Guardar Cambios</button>
                </form>

                <form action="" method="post">
                    <h2>Cambiar Contraseña</h2>
                    <label for="current-password">Contraseña Actual</label>
                    <input type="password" name="current-password" placeholder="Introduce tu contraseña actual" required>

                    <label for="new-password">Nueva Contraseña</label>
                    <input type="password" name="new-password" placeholder="Nueva contraseña" required>

                    <label for="confirm-password">Confirmar Contraseña</label>
                    <input type="password" name="confirm-password" placeholder="Confirma la nueva contraseña" required>

                    <button type="submit">Actualizar Contraseña</button>
                </form>
            </div>
        </section>
    </main>

    <?php include '../components/footer.php'; ?>

    <script>
        document.getElementById("edit-icon").addEventListener("click", function() {
            document.getElementById("file-upload").click();
        });

        document.getElementById("file-upload").addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("profile-pic").src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>

</html>