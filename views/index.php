<!DOCTYPE html>
<html lang="es">
<?php require_once('../components/head.php'); ?>

<body>

    <?php require_once('../components/header.php'); ?>
    <main id="detail">
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
                <button id="men"> Ropa de caballeros</button>
                <button id="women">Ropa de mujer</button>
                <button id="unisex">Ropa unisex</button>
            </div>
            <div class="filters category">
                <button id="casual">casual</button>
                <button id="activo">sport</button>
                <button id="formal">formal</button>
            </div>
        </section>
        <section class="collections">
            <?php require_once('../database/products.php'); ?>
            <?php $collections = getCollections(); ?>
            <?php foreach ($collections as $collection): ?>
                <div class="collection" id="<?= htmlspecialchars($collection['name']); ?>">
                    <div class="clothes">
                        <?php $products = getProducts(); ?>
                        <?php foreach ($products as $product): ?>
                            <?php if ($product['idCollection'] === $collection['id']): ?>
                                <?php include '../components/article.php'; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
        <?php require_once '../components/faq.php'; ?>
    </main>
    <?php require_once '../components/footer.php'; ?>
</body>


</html>