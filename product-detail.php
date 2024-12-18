<!DOCTYPE html>
<html lang="en">

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
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./css/styles.css" />
    <script defer src="./js/script.js"></script>
    <?php include './database/db.php'; ?>
</head>

<body>
    <?php require_once('./components/header.php') ?>
    <main>
        <?php
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $host = 'localhost';
            $dbname = 'klothink';
            $username = 'root';
            $password = '';

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if (!$conn) {
                die("Error de conexión: " . mysqli_connect_error());
            }

            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $query = "SELECT * FROM products WHERE id = '$id'";
            $connquery = mysqli_query($conn, $query);
            if ($connquery && $product = $connquery->fetch_assoc()) {
                $productImagesUrls = !empty($product['images']) ? explode(',', $product['images']) : [];
            } else {
                header('Location: http://localhost/klothink/error.php');
            }
        } else {
            header('Location: http://localhost/klothink/error.php');
            exit;
        }
        ?>
        <section class="product-detail">
            <div class="product">
                <?php if (!empty($productImagesUrls)): ?>
                    <figure>
                        <img src="<?= htmlspecialchars($productImagesUrls[0]) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    </figure>
                    <div class="images">
                        <?php foreach ($productImagesUrls as $imageUrl): ?>
                            <figure>
                                <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            </figure>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No hay imágenes disponibles para este producto.</p>
                <?php endif; ?>
            </div>
            <div class="details">
                <div class="header">
                    <div class="title">
                        <h2><?= htmlspecialchars($product['name']) ?></h2>
                        <h3 class="price"><?= htmlspecialchars($product['price']) ?></h3>
                    </div>
                    <div class="buttons">
                        <button class="buy">
                            <p>Comprar ahora</p> <img src="./images/buy.svg" alt="buy-icon">
                        </button>
                        <form method="POST" action="./database/products.php">
                            <input type="hidden" name="product_id" value="1">
                            <button type="submit">Añadir al carrito</button>
                        </form>
                    </div>
                </div>
                <div class="blocks">
                    <div class="block">
                        <div class="header">
                            <div class="matherial">
                                <h3>Material</h3>
                                <p><?= htmlspecialchars($product['material']) ?></p>
                            </div>
                            <div class="fit">
                                <h3>Fit</h3>
                                <p><?= htmlspecialchars($product['fit']) ?></p>
                            </div>
                            <div class="colour">
                                <h3>Color</h3>
                                <div class="inputs" id="color-picker">
                                    <?php $colours = explode(',', $product['colours']); ?>
                                    <?php foreach ($colours as $colour): ?>
                                        <input value="<?= htmlspecialchars($colour) ?>" class="color" type="checkbox" style="background: <?= htmlspecialchars($colour) ?>;">
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="sizes">
                                <h3>Tallas</h3>
                                <div class="inputs">
                                    <?php $sizes = explode(',', $product['sizes']) ?>
                                    <?php foreach ($sizes as $size): ?>
                                        <section id="<?= htmlspecialchars($size) ?>">
                                            <section id="<?= htmlspecialchars($size) ?>">
                                                <input type="checkbox" id="<?= htmlspecialchars($size) ?>">
                                                <label for="<?= htmlspecialchars($size) ?>"><?= htmlspecialchars($size) ?></label>
                                            </section>
                                        </section>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block">
                        <h3>Información de envio</h3>
                        <?php $information = explode(',', $product['shopping_information']) ?>
                        <ul>
                            <?php foreach ($information as $i) :
                            ?>
                                <li><?= htmlspecialchars($i) ?></li>
                            <?php
                            endforeach  ?>
                        </ul>
                    </div>
                    <div class="block">
                        <h3>Caracteristicas</h3>
                        <?php $characteristics = explode(',', $product['characteristics']) ?>
                        <ul>
                            <?php foreach ($characteristics as $characteristic) :
                            ?>
                                <li><?= htmlspecialchars($characteristic) ?></li>
                            <?php
                            endforeach  ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="reviews">
            <section class="hero">
                <section class="header">
                    <section class="title">
                        <h1>reseñas</h1>
                        <h3>reseñas de productos</h3>
                    </section>
                    <p>En Klothink, nuestros clientes son el corazón de nuestra marca. Explora los sinceros testimonios compartidos por aquellos que han experimentado la magia de la moda Klothink.</p>
                </section>
                <section class="news">
                    <div class="new">
                        <div class="header">
                            <div class="info">
                                <div class="profile">
                                    <img src="./images/profile.jpg" alt="profile-photo">
                                </div>
                                <div class="title">
                                    <h2>Alex M.</h2>
                                    <img src="./images/stars.png" alt="stars">
                                </div>
                            </div>
                            <div class="logo">
                                <img src="./images/logo-profile.png" alt="logo-profile">
                            </div>
                        </div>
                        <p>¡Me encanta esta sudadera! El ajuste es perfecto y los detalles desgastados le dan un aspecto robusto pero elegante. Se ha convertido en mi prenda preferida para salidas informales. ¡Muy recomendable!</p>

                    </div>
                    </div>
                    <div class="new">
                        <div class="header">
                            <div class="info">
                                <div class="profile">
                                    <img src="./images/profile.jpg" alt="profile-photo">
                                </div>
                                <div class="title">
                                    <h2>Alex M.</h2>
                                    <img src="./images/stars.png" alt="stars">
                                </div>
                            </div>
                            <div class="logo">
                                <img src="./images/logo-profile.png" alt="logo-profile">
                            </div>
                        </div>
                        <p>Gran calidad y opciones de estilo versátiles. Los botones son resistentes y la chaqueta se siente bien hecha. Deduje una estrella porque desearía que tuviera un bolsillo interior, pero en general.</p>
                    </div>
                    <div class="new">
                        <div class="header">
                            <div class="info">
                                <div class="profile">
                                    <img src="./images/profile.jpg" alt="profile-photo">
                                </div>
                                <div class="title">
                                    <h2>Alex M.</h2>
                                    <img src="./images/stars.png" alt="stars">
                                </div>
                            </div>
                            <div class="logo">
                                <img src="./images/logo-profile.png" alt="logo-profile">
                            </div>
                        </div>
                        <p>Gran calidad y opciones de estilo versátiles. Los botones son resistentes y la chaqueta se siente bien hecha. Deduje una estrella porque desearía que tuviera un bolsillo interior, pero en general.</p>
                    </div>
                    </div>
                </section>
            </section>
        </section>
        </section>
        <section class="faq">
            <section class="hero">
                <section class="header">
                    <section class="title">
                        <h1>faq</h1>
                        <h3>preguntas frecuentes</h3>
                    </section>
                    <p>Entra en el mundo de Klothink con claridad. Nuestras preguntas frecuentes cubren un espectro de temas, lo que garantiza que tenga la información que necesita para una experiencia de compra perfecta.</p>
                </section>
                <section class="news">
                    <div class="new">
                        <details>
                            <summary>
                                <div class="header">
                                    <div class="title">
                                        <h1>¿Hay bolsillos interiores en la sudadera?</h1>
                                    </div>
                                </div>
                            </summary>
                            <p>¡Hola! Nuestra sudadera no cuenta con bolsillos interiores, ya que está diseñada pensando en la comodidad y en un estilo minimalista. Sin embargo, incluimos prácticos bolsillos exteriores que se integran perfectamente en su diseño. Si estás buscando una opción con bolsillos internos, podemos recomendarte otras prendas de nuestra colección.</p>

                            <p>¡Gracias por tu interés en nuestros productos y no dudes en preguntarnos cualquier otra duda! 😊</p>
                        </details>
                    </div>
                    <div class="new">
                        <details>
                            <summary>
                                <div class="header">
                                    <div class="title">
                                        <h1>¿Cómo determino el tamaño adecuado para mí sudadera?</h1>
                                    </div>
                                    <div class="logo">
                                    </div>
                                </div>
                            </summary>
                            <p>¡Hola! Para asegurarte de elegir el tamaño perfecto para tu sudadera, te recomendamos seguir estos pasos:</p>
                            <ul>
                                <li><b>Consulta nuestra guía de tallas:</b> Cada prenda incluye una tabla detallada con medidas específicas para pecho, cintura y largo.</li>
                                <li><b>Mide tu cuerpo:</b> Usa una cinta métrica para medir tus dimensiones y compáralas con nuestra tabla.</li>
                                <li><b>Considera el ajuste:</b> Si prefieres un estilo más holgado, elige una talla más grande; para un ajuste más ceñido, elige tu talla habitual.</li>
                            </ul>
                            <p>Si tienes dudas o necesitas ayuda personalizada, ¡no dudes en contactarnos! Estamos aquí para ayudarte a encontrar la sudadera ideal para ti. 😊</p>
                        </details>
                    </div>
                    <div class="new">
                        <details>
                            <summary>
                                <div class="header">
                                    <div class="title">
                                        <h1>¿Los detalles desgastados de la sudadera son propensos a deshilacharse?</h1>
                                    </div>
                                </div>
                            </summary>
                            <p>¡Hola! Los detalles desgastados de nuestras sudaderas están diseñados cuidadosamente para combinar estilo y durabilidad. Utilizamos técnicas de acabado especializadas que aseguran que el desgaste sea intencional y controlado, evitando que se deshilache con el uso normal.</p>
                            <ul>
                                <li><b>Lava la sudadera del revés:</b> Lava la sudadera en la lavadora a una temperatura de 30/40°C.</li>
                                <li><b>Evita el uso de secadoras:</b> Opta por secado al aire para conservar la textura y calidad.</li>
                                <li><b>Sigue nuestras instrucciones de cuidado:</b> Incluidas en la etiqueta de la prenda.</li>
                            </ul>
                            <p>Si notas algún problema o tienes más preguntas, no dudes en contactarnos. ¡Estamos aquí para ayudarte! 😊</p>
                        </details>
                    </div>
                    <div class="new">
                        <details>
                            <summary>
                                <div class="header">
                                    <div class="title">
                                        <h1>¿Puedo lavar la sudadera a máquina?</h1>
                                    </div>
                                    <div class="logo">
                                    </div>
                                </div>
                            </summary>
                            <p>¡Hola! Claro, puedes lavar tu sudadera a máquina. Aquí te dejo las instrucciones detalladas para que la mantengas en perfecto estado:</p>
                            <ul>
                                <li><b>Temperatura:</b> Lava la sudadera en la lavadora a una temperatura de 30/40°C.</li>
                                <li><b>Suavizante:</b> No es necesario usar suavizante.</li>
                                <li><b>Lejía:</b> No uses lejía ni productos similares.</li>
                                <li><b>Colores:</b> Lava la sudadera con ropa de color similar.</li>
                                <li><b>Secado:</b> Lo ideal es dejarla secar en horizontal.</li>
                                <li><b>Secadora:</b> No uses la secadora.</li>
                                <li><b>Plancha:</b> Si es necesario, plancha a temperatura baja.</li>
                            </ul>
                            <p>Espero que estas instrucciones te sean útiles. Si tienes alguna otra pregunta, no dudes en contactarnos. ¡Gracias por elegirnos! 😊</p>
                        </details>
                    </div>
                    <div class="new">
                        <details>
                            <summary>
                                <div class="header">
                                    <div class="title">
                                        <h1>¿Puedo lavar la sudadera a máquina?</h1>
                                    </div>
                                    <div class="logo">
                                    </div>
                                </div>
                            </summary>
                            <p>¡Hola! Claro, puedes lavar tu sudadera a máquina. Aquí te dejo las instrucciones detalladas para que la mantengas en perfecto estado:</p>
                            <ul>
                                <li><b>Temperatura:</b> Lava la sudadera en la lavadora a una temperatura de 30/40°C.</li>
                                <li><b>Suavizante:</b> No es necesario usar suavizante.</li>
                                <li><b>Lejía:</b> No uses lejía ni productos similares.</li>
                                <li><b>Colores:</b> Lava la sudadera con ropa de color similar.</li>
                                <li><b>Secado:</b> Lo ideal es dejarla secar en horizontal.</li>
                                <li><b>Secadora:</b> No uses la secadora.</li>
                                <li><b>Plancha:</b> Si es necesario, plancha a temperatura baja.</li>
                            </ul>
                            <p>Espero que estas instrucciones te sean útiles. Si tienes alguna otra pregunta, no dudes en contactarnos. ¡Gracias por elegirnos! 😊</p>
                        </details>
                    </div>
                    <div class="new">
                        <details>
                            <summary>
                                <div class="header">
                                    <div class="title">
                                        <h1>¿La sudadera es ecológica?</h1>
                                    </div>
                                    <div class="logo">
                                    </div>
                                </div>
                            </summary>
                            <p>¡Sí, definitivamente! En Klothink nos enorgullece ofrecer productos que no solo son modernos y cómodos, sino también responsables con el medio ambiente.</p>
                            <p>Nuestra sudadera está hecha con materiales ecológicos, como algodón orgánico o fibras recicladas, que ayudan a reducir el impacto ambiental.</p>
                            <p> Además, trabajamos bajo prácticas sostenibles,desde la producción hasta el embalaje, para minimizar nuestra huella de carbono.</p>


                            <p> Al elegir nuestra sudadera, no solo te vistes con estilo, sino que también contribuyes a un futuro más verde.🌱</p>
                        </details>
                    </div>
                    </div>
                </section>
            </section>
        </section>
        </section>
    </main>
    <footer>
        <section class="main">
            <section class="suscription">
                <img src="./images/brand-page.svg" alt="brand-page" />
                <div class="main">
                    <input type="text" placeholder="Ingrese su correo electrónico" />
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
        </section>
        <section class="footer-policies">
            <div class="policies-content">
                <a href="./polities/Terminos-Condiciones.php">
                    <p>Términos y condiciones</p>
                </a>
                <a href="./polities/Politica-privacidad.php">
                    <p>Política de privacidad</p>
                </a>
            </div>
            <div class="social-media-icons">
                <a href="https://www.linkedin.com/in/nicolas-sanmarcos/" target="_blank" class="social-icon">
                    <img src="./images/linkedin.svg" alt="linkedin-logo" />
                </a>
                <a href="https://x.com/home" class="social-icon" target="_blank">
                    <img src="./images/twitter.svg" alt="twitter-logo" />
                </a>
                <a href="https://github.com/N1C0SM" class="social-icon" target="_blank">
                    <img src="./images/github.svg" alt="github-logo" />
                </a>
            </div>
            <div class="rights">
                <p>© 2024 Klothink. Todos los derechos reservados.</p>
            </div>
        </section>
    </footer>
</body>

</html>