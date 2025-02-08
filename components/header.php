<header>
    <nav>
        <ul>
            <li class="nav-button" class="active"><a href="../views/index.php">Inicio</a></li>
            <li class="nav-button"><a href="../views/products.php">Productos</a></li>
        </ul>
        <a href="./index.php"><img src="../images/brand-page.svg" alt="Página principal"></a>
        <ul class="dropdown">
            <?php if (isset($_SESSION['user_alias'])): ?>
                <li class="title">
                    <a href="#">
                        <img src="../images/profile.svg" alt="profile">
                        <p><?= htmlspecialchars($_SESSION['user_alias']) ?></p>
                        <img src="../images/arrow-down.svg" alt="arrow-down">
                    </a>
                    <ul class="dropdown-menu">
                        <li class="profile">
                            <div class="profile-photo">
                                <img src="../images/profile.svg" alt="profile-photo">
                            </div>
                            <div class="name">
                                <h1><?= htmlspecialchars($_SESSION['user_alias']) ?></h1>
                                <h3 class="role"><?= htmlspecialchars($_SESSION['user_role']) ?></h3>
                            </div>
                        </li>
                        <li class="item">
                            <h2 class="title">Cuenta</h2>
                            <ul class="dropdown-inner-menu">
                                <li class="item">
                                    <a href="../views/profile.php">
                                        <img src="../images/user.svg" alt="user-profile">
                                        <p>Perfil</p>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="../views/wish.list.php">
                                        <img src="../images/cart.svg" alt="wish-list">
                                        <p>Lista de deseos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="item">
                            <h2 class="title">Ajustes</h2>
                            <ul class="dropdown-inner-menu">
                                <li class="item">
                                    <a href="../views/settings.php">
                                        <img src="../images/settings.svg" alt="settings">
                                        <p>Ajustes</p>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="../views/security.php">
                                        <img src="../images/lock.svg" alt="security">
                                        <p>Seguridad</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="item">
                            <a href="../database/logout.php">
                                <img src="../images/logout.svg" alt="logout">
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php else: ?>
                <li><a href="../views/register.php">Registrarse</a></li>
            <?php endif; ?>
            <li class="shopping-cart"><a href="../views/cart.php"><img src="../images/shopping-cart.svg" alt="Carrito de compras"></a></li>
            <li class="nav-button"><a href="../views/contact.php">Contacto</a></li>
        </ul>
    </nav>
</header>