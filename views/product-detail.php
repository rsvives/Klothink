<!DOCTYPE html>
<html lang="es">
<?php require_once('../components/head.php') ?>

<body>

    <?php require_once('../components/header.php') ?>

    <main>
        <?php
        if (isset($_GET['id'])) {
            $product = getProductById($_GET['id']);
            if ($product) {
                $productImagesUrls = explode(',', $product['images']);
            } else {
                handleError('Producto no encontrado.');
                die();
            }
        } else {
            handleError('ID inválido.');
            die();
        }
        ?>
        <section class="product-detail">
            <form id="product_detail_form">
                <div class="product">
                    <?php if (!empty($productImagesUrls)): ?>
                        <figure>
                            <img id="main-product-image" src="<?= htmlspecialchars($productImagesUrls[0]) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        </figure>
                        <div class="images">
                            <?php foreach ($productImagesUrls as $imageUrl): ?>
                                <figure>
                                    <img class="product-thumbnail" src="<?= htmlspecialchars($imageUrl); ?>" alt="Imagen del producto">
                                </figure>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <?php handleError('No hay imágenes disponibles para este producto.') ?>
                    <?php endif; ?>
                </div>
                <div class="details">
                    <div class="header">
                        <div class="title">
                            <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" readonly>
                            <input type="text" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" readonly>
                        </div>
                        <div class="buttons">
                            <button class="buy">
                                <p>Comprar ahora</p>
                                <img src="../images/buy-white-icon.svg" alt="buy-icon" />
                            </button>
                            <button class="shopping-cart" id="add-product-form" onclick="alert('Añadido al carrito')">
                                <p>Añadir al carrito</p>
                                <img src=" ../images/shopping-cart.svg" alt="shopping-cart">
                            </button>
                        </div>
                    </div>
                    <div class="blocks">
                        <div class="block">
                            <div class="header">
                                <div class="matherial">
                                    <h3>Material</h3>
                                    <input type="text" name="material" value="<?= htmlspecialchars($product['material']); ?>" class="overlay-input" readonly required>
                                </div>
                                <div class="fit">
                                    <h3>Fit</h3>
                                    <input type="text" name="fit" value="<?= htmlspecialchars($product['fit']); ?>" class="overlay-input" readonly required>
                                </div>
                                <div class="colour">
                                    <h3>Color</h3>
                                    <div class="inputs" id="color-picker">
                                        <?php $colours = explode(',', $product['colours']); ?>
                                        <?php foreach ($colours as $colour): ?>
                                            <section id="<?= htmlspecialchars($colour) ?>">
                                                <?php if ($_SESSION['user_role'] === 'Administrador') : ?>
                                                    <div class="action-buttons">
                                                        <form method="post" action="../database/products.php" class="delete-button" onsubmit="confirmDelete(event,<?= htmlspecialchars($product['id']); ?>, '<?= htmlspecialchars($product['name']); ?>')">
                                                            <input type="hidden" name="action" value="delete_product_with_id">
                                                            <input type="hidden" name="idProduct" value="<?= htmlspecialchars($product['id']); ?>">
                                                            <button type="submit" class="delete-button">
                                                                <img src="../images/close-icon.svg" alt="Eliminar">
                                                            </button>
                                                        </form>
                                                    </div>
                                                <?php endif; ?>
                                                <input type="radio" id="color-<?= $colour ?>" name="colour" class="color-radio" value="<?= htmlspecialchars($colour) ?> " required>
                                                <label for="color-<?= $colour ?>" class="color-label" style="background: <?= htmlspecialchars($colour) ?>;"></label>
                                            </section>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="sizes">
                                    <h3>Tallas</h3>
                                    <div class="inputs">
                                        <?php $sizes = explode(',', $product['sizes']); ?>
                                        <?php foreach ($sizes as $key => $size): ?>
                                            <section id="<?= htmlspecialchars($size) ?>">
                                                <?php if ($_SESSION['user_role'] === 'Administrador'): ?>
                                                    <div class="action-buttons">
                                                        <form method="post" action="../database/products.php" class="delete-button" onsubmit="confirmDeleteAtribute(event,<?= htmlspecialchars($product['id']); ?>, 'sizes')">
                                                            <input type="hidden" name="action" value="delete_product_attribute">
                                                            <input type="hidden" name="idProduct" value="<?= htmlspecialchars($product['id']); ?>">
                                                            <input type="hidden" name="attribute" value="sizes">
                                                            <input type="hidden" name="value" value="<?= htmlspecialchars($size) ?>">
                                                            <button type="submit" class="delete-button">
                                                                <img src="../images/close-icon.svg" alt="Eliminar">
                                                            </button>
                                                        </form>
                                                    </div>
                                                <?php endif; ?>
                                                <input type="radio" id="<?= htmlspecialchars($size) ?>-size" name="size" value="<?= $size ?>" <?= $key == 0 ? 'required' : '' ?>>
                                                <label for="<?= htmlspecialchars($size) ?>-size"><?= htmlspecialchars($size) ?></label>
                                            </section>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block">
                            <h3>Información de envío</h3>
                            <?php $shopping_information = explode(',', $product['shopping_information']); ?>
                            <ul>
                                <?php foreach ($shopping_information as $information): ?>
                                    <li>
                                        <input type="text" name="shopping_information" value="<?= htmlspecialchars($information) ?? 'Información no disponible'; ?>" class="overlay-input" readonly required>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="block">
                            <h3>Características</h3>
                            <?php $characteristics = explode(',', $product['characteristics']); ?>
                            <ul>
                                <?php foreach ($characteristics as $c): ?>
                                    <li>
                                        <input type="text" name="characteristics" value="<?= htmlspecialchars($c); ?>" class="overlay-input" readonly required>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <?php require_once '../components/reviews.php'; ?>
        <?php require_once '../components/faq.php'; ?>
    </main>
    <?php require_once '../components/footer.php'; ?>

</body>


</html>