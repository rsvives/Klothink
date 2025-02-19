<header>
    <nav>
        <ul>
            <li class="nav-button active"><a href="../views/index.php">Inicio</a></li>
            <li class="nav-button"><a href="../views/products.php">Productos</a></li>
        </ul>

        <a href="./index.php"><img src="../images/brand-page.svg" alt="Página principal"></a>

        <ul>
            <?php if (isset($_SESSION['user_alias'])): ?>
                <li class="dropdown">
                    <div class="title">
                        <a href="#">
                            <img src="<?= $_SESSION['user_photo'] ?>" alt="Perfil">
                            <p><?= htmlspecialchars($_SESSION['user_alias']) ?></p>
                            <img src="../images/arrow-down.svg" alt="Flecha">
                        </a>
                    </div>
                    <ul class="dropdown-menu">
                        <li class="profile">
                            <div class="profile-photo">
                                <img src="<?= htmlspecialchars($_SESSION['user_photo']) ?>" alt="Foto de perfil">
                            </div>
                            <h1><?= htmlspecialchars($_SESSION['user_alias']) ?></h1>
                            <h3 class="role"><?= htmlspecialchars($_SESSION['user_role']) ?></h3>
                        </li>
                        <li class="item"><a href="../views/profile.php">👤 Ver Perfil</a></li>
                        <li class="item"><a href="../views/orders.php">📦 Mis Pedidos</a></li>

                        <?php if ($_SESSION['user_role'] === 'Administrador'): ?>
                            <li class="item"><a href="../views/dashboard.php">📊 Dashboard</a></li>
                            <li class="item"><a href="../views/user-management.php">👥 Gestión de Usuarios</a></li>
                        <?php endif; ?>
                        <li class="item"><a href="../database/logout.php">🚪 Cerrar Sesión</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li><a href="../views/register.php">Registrarse</a></li>
            <?php endif; ?>

            <li class="shopping-cart"><a href="../views/cart.php"><img src="../images/shopping-cart.svg" alt="Carrito"></a></li>
            <li class="nav-button"><a href="../views/contact.php">Contacto</a></li>
        </ul>
    </nav>
</header>