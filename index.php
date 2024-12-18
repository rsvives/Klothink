<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="twitter:title" content="Klothink - Ropa Sostenible y Personalizada" />
    <meta property="og:title" content="Klothink - Ropa Sostenible y Personalizada" />
    <meta name="keywords" content="Moda sostenible, ropa personalizada, estilo de vida, algoritmos, aprendizaje automático, impacto ambiental" />
    <meta name="twitter:description" content="Encuentra ropa que se adapte a tu estilo de vida y valores." />
    <meta property="og:description" content="Encuentra ropa que se adapte a tu estilo de vida y valores." />
    <meta name="description" content="Klothink - Encuentra ropa sostenible y personalizada que se adapta a tu estilo de vida y valores." />
    <title>Klothink - Encuentra ropa que se adapte a tu estilo de vida y valores.</title>
    <link rel="icon" href="./images/brand-page.svg" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/styles.css" />
    <script defer src="./js/script.js"></script>
    <?php require_once './database/db.php'; ?>
    <?php require_once './database/products.php'; ?>
    <?php require_once './database/collections.php'; ?>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li class="active"><a href="./index.php">inicio</a></li>
                <li><a href="./products.php">productos</a></li>
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
                    <li><a href="./contact.php">contacto</a></li>
                    </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <section class="header">
                <section class="title">
                    <h1>descubre la moda.</h1>
                    <h3>productos</h3>
                </section>
                <p>sumergete en un mundo de innovación en moda en Klothink. Nuestras colecciones cuidadosamente seleccionadas reúnen las últimas tendencias y clásicos atemporales, asegurándote de encontrar las piezas perfectas para cada ocasión.</p>
            </section>
            <section class="news">
                <a href="./products.php"><button>Ver todos los productos</button></a>
            </section>
        </section>
        <section class="filters-container">
            <div class="filters category">
                <button id="formal">formal</label>
                    <button id="casual">casual</label>
                        <button id="sport">sport</label>
            </div>
            <div class="filters gender">
                <button id="all">todo</label>
                    <button id="men"><img src="./images/shirt.svg" alt="shirt" /> ropa de caballeros</label>
                        <button id="women"><img src="./images/dress.svg" alt="dress" /> ropa de mujer</label>
                            <button id="unisex"><img src="./images/baby-dress.svg" alt="baby-dress" /> ropa unisex</label>
            </div>
        </section>
        <section class="collections">
            <?php foreach ($collections as $collection): ?>
                <div class="collection">
                    <div class="clothes">
                        <!-- <a>
                            <article>
                                <figure>
                                    <summary>
                                    <h1>Añadir producto</h1>
                                </summary>
                            </figure>
                                <figcaption>
                                <details>
                                    <form method="post" action="./database/products.php">
                                    <label for="name">Nombre del Producto:</label>
                                    <input type="text" name="name" id="name" required>

                                    <label for="description">Descripción:</label>
                                    <textarea name="description" id="description" required></textarea><

                                    <label for="price">Precio:</label>
                                    <input type="number" name="price" id="price" required>

                                    <label for="material">Material:</label>
                                    <input type="text" name="material" id="material" required>

                                    <label for="fit">Ajuste:</label>
                                    <input type="text" name="fit" id="fit">

                                    <label for="gender">Género:</label>
                                    <input type="text" name="gender" id="gender">

                                    <label for="brand">Marca:</label>
                                    <select name="brand_id" id="brand_id">
                                        <option value="">Selecciona una marca</option>
                                    </select><br>

                                    <label for="new_brand">Nueva Marca:</label>
                                    <input type="text" name="new_brand" id="new_brand" placeholder="Escribe una nueva marca"><br>

                                    <label for="category">Categoría:</label>
                                    <select name="category_id" id="category_id">
                                        <option value="">Selecciona una categoría</option>
                                    </select>

                                    <label for="new_category">Nueva Categoría:</label>
                                    <input type="text" name="new_category" id="new_category" placeholder="Escribe una nueva categoría">

                                    <button type="submit">Añadir Producto</button>
                                </form>

                                </details>
                                </figcaption>
                            </article>
                        </a> -->
                        <?php foreach ($products as $product): ?>
                            <a href="./product-detail.php?id=<?= htmlspecialchars($product['id']); ?>">
                                <?php $productsImagesUrls = explode(",", $product['images']); ?>
                                <article class="<?= htmlspecialchars($product['gender'] === 'men' ? 'men' : ($product['gender'] === 'women' ? 'women' : 'unisex')); ?> <?= htmlspecialchars($collection['name']); ?>">
                                    <figure>
                                        <img src="<?= htmlspecialchars($productsImagesUrls[0]); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                                    </figure>
                                    <figcaption>
                                        <h2><?= htmlspecialchars($product['name']); ?></h2>
                                        <div class="footer">
                                            <h3><?= htmlspecialchars($product['fit']); ?></h3>
                                            <span><?= htmlspecialchars($product['price']); ?></span>
                                        </div>
                                    </figcaption>
                                </article>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <footer>
        <section class="main">
            <section class="header">
                <div class="header">
                    <img src="./images/brand-page.svg" alt="Logo">
                    <div class="social-media-icons">
                        <a href="#"><img src="./images/github.svg" alt="Facebook"></a>
                        <a href="#"><img src="./images/twitter.svg" alt="Twitter"></a>
                        <a href="#"><img src="./images/linkedin.svg" alt="Instagram"></a>
                    </div>
                </div>
                <div class="suscription">
                    <input type="email" placeholder="Ingresa tu correo">
                    <button>Suscribirse</button>
                </div>
            </section>
            <section class="menu">
                <div class="row">
                    <a href="./index.php">
                        <h2>Inicio</h2>
                    </a>
                    <a href="">
                        <p>Características</p>
                    </a>
                    <a href="">
                        <p>Productos populares</p>
                    </a>
                    <a href="">
                        <p>Testimonios</p>
                    </a>
                    <a href="">
                        <p>FAQ</p>
                    </a>
                </div>
                <div class="row">
                    <a href="">
                        <h2>Hombre</h2>
                    </a>
                    <a href="#formal">
                        <p>Formal</p>
                    </a>
                    <a href="#sport">
                        <p>Sport</p>
                    </a>
                    <a href="#casual">
                        <p>Casual</p>
                    </a>
                </div>
                <div class="row">
                    <a href="">
                        <h2>Mujer</h2>
                    </a>
                    <a href="">
                        <p>Formal</p>
                    </a>
                    <a href="">
                        <p>Sport</p>
                    </a>
                    <a href="">
                        <p>Casual</p>
                    </a>
                </div>
                <div class="row">
                    <a href="">
                        <h2>Niños</h2>
                    </a>
                    <a href="">
                        <p>Formal</p>
                    </a>
                    <a href="">
                        <p>Sport</p>
                    </a>
                    <a href="">
                        <p>Casual</p>
                    </a>
                </div>
            </section>
            <!-- <p class="responsive">
                <p>Inicio</p>
                <p>Productos</p>
                <p>Contacto</p>
            </p> -->
        </section>
        <section class="footer-policies">
            <div class="policies-content">
                <a href="#">Política de privacidad</a>
                <a href="#">Términos y condiciones</a>
            </div>
        </section>
    </footer>
</body>

</html>