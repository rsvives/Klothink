<!DOCTYPE html>
<html lang="es">
<?php require_once('../components/head.php'); ?>

<body>
    <?php require_once('../components/header.php') ?>
    <main>
        <section class="hero">
            <section class="header">
                <section class="title">
                    <h1>Descubre la moda.</h1>
                    <h3>Productos</h3>
                </section>
                <p>Sumérgete en un mundo de innovación en moda en Klothink. Nuestras colecciones cuidadosamente seleccionadas reúnen las últimas tendencias y clásicos atemporales, asegurándote de encontrar las piezas perfectas para cada ocasión.</p>
            </section>
            <section class="news">
                <div class="new">
                    <h2>Novedades</h2>
                    <p>50+ nuevas diarias</p>
                </div>
                <div class="new">
                    <h2>Más de 1,500+</h2>
                    <p>Productos de moda seleccionados</p>
                </div>
            </section>
        </section>
        <section class="filters-container">
            <div class="filters gender">
                <button id="all" class="active">Todo</button>
                <button id="men"><img src="../images/shirt.svg" alt="Ropa de caballeros" /> Ropa de caballeros</button>
                <button id="women"><img src="../images/dress.svg" alt="Ropa de mujer" /> Ropa de mujer</button>
                <button id="unisex"><img src="../images/baby-dress.svg" alt="Ropa unisex" /> Ropa unisex</button>
            </div>
        </section>
        <section class="collections">
            <?php $collections = getCollections(); ?>
            <?php foreach ($collections as $collection): ?>
                <div class="collection" id="<?= htmlspecialchars($collection['name']); ?>">
                    <div class="header">
                        <div class="title">
                            <h2><?= htmlspecialchars($collection['name']); ?></h2>
                            <p><?= htmlspecialchars($collection['description']); ?></p>
                        </div>
                    </div>
                    <div class="clothes">
                        <?php $products = getProducts(); ?>
                        <?php foreach ($products as $product): ?>
                            <?php if ($product['idCollection'] === $collection['id']): ?>
                                <?php include '../components/article.php'; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if ($_SESSION['user_role'] === 'Administrador') : ?>
                            <article class="add-product-container">
                                <button id="add-button" onclick="openPopup()">➕</button>
                                <section id="popupForm" style="display:none">
                                    <div class="windowPopUp">
                                        <button class="close-form" onclick="closePopup()">X</button>
                                        <form action="../database/products.php" method="post">
                                            <input type="hidden" name="action" value="create_product">
                                            <input type="text" name="productName" placeholder="Nombre del Producto" required />
                                            <input type="number" step="0.01" name="productPrice" placeholder="Precio del Producto" />
                                            <input type="text" name="productMaterial" placeholder="Material del Producto" required />
                                            <input type="text" name="productFit" placeholder="Ajuste del Producto" required />

                                            <input type="text" name="productGender" placeholder="Género del Producto" list="genderList" required />
                                            <datalist id="genderList">
                                                <option value="Men">
                                                <option value="Unisex">
                                                <option value="Women">
                                            </datalist>

                                            <input type="text" name="productCharacteristics" placeholder="Características del Producto" required />
                                            <input type="text" name="productColours" placeholder="Colores del Producto" required />
                                            <input type="text" name="productImages" placeholder="Imágenes del Producto" />
                                            <input type="text" name="productSizes" placeholder="Tamaños del Producto" required />

                                            <input type="text" name="productCollection" placeholder="Colección del Producto" list="collectionList" required />
                                            <datalist id="collectionList">
                                                <option value="1 - Casual">
                                                <option value="2 - Formal">
                                                <option value="3 - Sport">
                                            </datalist>

                                            <button class="submit-button">Agregar Producto</button>
                                        </form>
                                    </div>
                                </section>
                            </article>
                        <?php endif; ?>
                    </div>
                    <div class="buttons">
                        <button class="black"><img src="../images\arrow-left.svg" alt="arrow-right"></button>
                        <a href="./collection-detail.php?id=<?= htmlspecialchars($collection['id']) ?>"><button class="white"><img src="../images\arrow-right.svg" alt="arrow-right"></button></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
        <?php require_once '../components/faq.php'; ?>
    </main>
    <?php require_once '../components/footer.php'; ?>
</body>


</html>