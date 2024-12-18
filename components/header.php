<header>
    <nav>
        <ul>
            <li class="nav-button"><a href="./index.php">inicio</a></li>
            <li class="nav-button"><a href="./products.php">productos</a></li>
        </ul>
        <a href="./index.php"><img src="./images/brand-page.svg" alt="brand-page" /></a>
        <?php if (isset($_SESSION['user_alias'])): ?>
            <ul>
                <li class="title">
                    <a href="#">
                        <img src="./images/profile.svg" alt="profile">
                        <p><?= htmlspecialchars($_SESSION['user_alias']) ?></p>
                        <img src="./images/arrow-down.svg" alt="arrow-down">
                    </a>
                    <ul class="dropdown-menu">
                        <li class="profile">
                            <div class="profile-photo">
                                <img src="./images/profile.svg" alt="profile">
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
                                    <a href="./profile.php">
                                        <img src="./images/user.svg" alt="user">
                                        <p>Perfil</p>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="./wish.list.php">
                                        <img src="./images/cart.svg" alt="cart">
                                        <p>Lista de deseos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="item">
                            <h2 class="title">Ajustes</h2>
                            <ul class="dropdown-inner-menu">
                                <li class="item">
                                    <a href="./settings.php">
                                        <img src="./images/settings.svg" alt="settings">
                                        <p>Ajustes</p>
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="./security.php">
                                        <img src="./images/lock.svg" alt="lock">
                                        <p>Seguridad</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="item">
                            <a href="./database\logout.php">
                                <img src="./images/logout.svg" alt="logout">
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php else: ?>
                <ul>
                    <li><a href="register.html">registrarse</a></li>
                <?php endif; ?>
                <li class="shopping-cart"><a href="./cart.php"><img src="./images/shopping-cart.svg" alt="shopping-cart" /></a></li>
                <li class="nav-button"><a href="./contact.php">contacto</a></li>
                </ul>
    </nav>
</header>

<script>
    const file = window.location.pathname.split('/').pop()
    let activeButton
    const navButtons = document.querySelectorAll('.nav-button')

    switch (file) {
        case 'index.php':
            activeButton = navButtons[0]
            break;
        case 'products.php':
            activeButton = navButtons[1]
            break;
        case 'contact.php':
            activeButton = navButtons[2]
            break;
        default:
            break;
    }

    if (activeButton) activeButton.classList.add('active')
</script>