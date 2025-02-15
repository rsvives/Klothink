<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Responsive</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700&display=swap" rel="stylesheet">
    <style>
        header {
            width: 100%;
            background: #ffffff;
            border-bottom: 1px solid #f1f1f3;
            padding: 1em 0;
            position: relative;
        }

        .nav-desktop {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1em;
        }

        .nav-desktop ul {
            display: flex;
            list-style: none;
            gap: 2em;
        }

        .nav-desktop ul li {
            padding: 14px 20px;
            text-transform: capitalize;
            border-radius: 100px;
            border: 1px solid #f1f1f3;
            position: relative;
        }

        .nav-desktop ul li a {
            text-decoration: none;
            color: #656567;
            font-size: 18px;
        }

        .nav-desktop ul li.active {
            background: #f7f7f8;
        }

        .nav-desktop ul li.active a {
            color: #262626;
        }

        .shopping-cart {
            background: #ffd400;
            padding: 1em;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        div.logo-burger {
            display: flex;
            gap: 5em;
            align-items: center;
        }


        .burger-icon {
            width: 40px;
            height: 40px;
            cursor: pointer;
            display: none;
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: white;
            transform: translateX(-100%);
            transition: transform 0.4s ease-in-out;
            padding-top: 2em;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
            z-index: 999;
        }

        .mobile-menu ul {
            list-style: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 1.5em;
            padding: 1em;
        }

        .mobile-menu ul li {
            padding: 10px;
            border-bottom: 1px solid #f1f1f3;
        }

        .mobile-menu ul li a {
            text-decoration: none;
            color: #262626;
            font-size: 18px;
        }



        @media (max-width: 768px) {
            .burger-icon {
                display: block;
            }

            .nav-desktop ul {
                display: none;
            }

            .mobile-menu {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .nav-desktop ul {
                display: flex;
            }

            .mobile-menu {
                display: none;
            }

            .logo-burger {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }

            .burger-icon {
                display: inline-block;
            }
        }
    </style>
</head>

<body>

    <div class="overlay" id="overlay"></div>

    <header>
        <nav class="nav-desktop">
            <div class="logo-burger">
                <div class="burger-icon" id="burger-icon">
                    <img src="../images/burger-icon.svg" alt="Menú">
                </div>
                <a href="./index.php"><img src="../images/brand-page.svg" alt="Página principal"></a>

            </div>

            <ul>
                <li class="nav-button active"><a href="../views/index.php">Inicio</a></li>
                <li class="nav-button"><a href="../views/products.php">Productos</a></li>
            </ul>

            <ul>
                <?php if (isset($_SESSION['user_alias'])): ?>
                    <li class="dropdown">
                        <a href="#">
                            <img src="../images/profile.svg" alt="Perfil">
                            <p><?= htmlspecialchars($_SESSION['user_alias']) ?></p>
                            <img src="../images/arrow-down.svg" alt="arrow">
                        </a>
                        <ul class="dropdown-menu">
                            <li class="profile">
                                <div class="profile-photo">
                                    <img src="../images/profile.svg" alt="Foto de perfil">
                                </div>
                                <h1><?= htmlspecialchars($_SESSION['user_alias']) ?></h1>
                                <h3 class="role"><?= htmlspecialchars($_SESSION['user_role']) ?></h3>
                            </li>
                            <li class="item"><a href="../views/profile.php">Perfil</a></li>
                            <li class="item"><a href="../views/wish.list.php">Lista de deseos</a></li>
                            <li class="item"><a href="../views/settings.php">Ajustes</a></li>
                            <li class="item"><a href="../database/logout.php">Logout</a></li>
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

    <nav class="mobile-menu" id="mobile-menu">
        <ul>
            <li><a href="../views/index.php">Inicio</a></li>
            <li><a href="../views/products.php">Productos</a></li>
            <li><a href="../views/contact.php">Contacto</a></li>
        </ul>
    </nav>

    <script>
        const burgerIcon = document.getElementById('burger-icon');
        const mobileMenu = document.getElementById('mobile-menu');

        function openMenu() {
            mobileMenu.style.transform = 'translateX(0)';
        }

        function closeMenu() {
            mobileMenu.style.transform = 'translateX(-100%)';
        }

        burgerIcon.addEventListener('click', openMenu);
    </script>

</body>

</html>