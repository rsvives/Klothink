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
                            <img src="../images/profile.svg" alt="Perfil">
                            <p><?= htmlspecialchars($_SESSION['user_alias']) ?></p>
                            <img src="../images/arrow-down.svg" alt="Flecha">
                        </a>
                    </div>
                    <ul class="dropdown-menu">
                        <li class="profile">
                            <div class="profile-photo">
                                <img src="../images/profile.svg" alt="Foto de perfil">
                            </div>
                            <h1><?= htmlspecialchars($_SESSION['user_alias']) ?></h1>
                            <h3 class="role"><?= htmlspecialchars($_SESSION['user_role']) ?></h3>
                        </li>
                        <li class="item"><a href="../views/profile.php">👤 Ver Perfil</a></li>
                        <li class="item"><a href="../views/orders.php">📦 Mis Pedidos</a></li>

                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <li class="item"><a href="../views/dashboard.php">📊 Dashboard</a></li>
                            <li class="item"><a href="../views/user-management.php">👥 Gestión de Usuarios</a></li>
                        <?php endif; ?>

                        <li class="item"><a href="../views/settings.php">⚙️ Ajustes</a></li>
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
<style>
    .dropdown {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: white;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        min-width: 200px;
        border-radius: 5px;
        overflow: hidden;
        z-index: 1000;
        right: 0;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-menu .item {
        padding: 10px;
        display: block;
        text-decoration: none;
        color: black;
        border-bottom: 1px solid #f1f1f1;
    }

    .dropdown-menu .item:hover {
        background-color: #f1f1f1;
    }

    .profile {
        text-align: center;
        padding: 10px;
        background-color: #f9f9f9;
    }

    .profile-photo img {
        width: 50px;
        border-radius: 50%;
    }

    .profile h1 {
        font-size: 16px;
        margin: 5px 0;
    }

    .profile .role {
        font-size: 12px;
        color: gray;
    }
</style>