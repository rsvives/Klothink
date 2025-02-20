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
            <form action="../database/products.php" method="post" id="product_detail_form">
                <div class="product">
                    <?php if (!empty($productImagesUrls)): ?>
                        <figure>
                            <img id="main-product-image" src="<?= htmlspecialchars($productImagesUrls[0]) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        </figure>
                        <div class="images">
                            <?php foreach ($productImagesUrls as $imageUrl): ?>
                                <figure>
                                    <!-- <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                        <div class="action-buttons">
                                            <form method="post" action="../database/edit-product.php" class="delete-button" onsubmit="return confirmDelete(<?= htmlspecialchars($product['id']); ?>, '<?= htmlspecialchars($product['name']); ?>')">
                                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
                                                <button type="submit" class="delete-button" title="Eliminar imagen">
                                                    <img src="../images/Minus.png" alt="Eliminar imagen">
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?> -->
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
                            <h2><?= htmlspecialchars($product['name']) ?></h2>
                            <h3 class="price"><?= htmlspecialchars($product['price']) ?></h3>
                        </div>
                        <div class="buttons">
                            <button class="buy">
                                <p>Comprar ahora</p>
                                <img src="../images/buy-white-icon.svg" alt="buy-icon" />
                            </button>
                            <button type="submit" class="shopping-cart" id="add-product-form">
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
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']); ?>">
                                    <input type="text" name="material" value="<?= htmlspecialchars($product['material']); ?>" class="overlay-input" readonly required>
                                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                        <button type="submit">
                                            <img src="../images/pen-solid.svg" alt="Editar Material">
                                        </button>
                                    <?php endif; ?>
                                </div>
                                <div class="fit">
                                    <h3>Fit</h3>
                                    <!-- <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']); ?>"> -->
                                    <input type="text" name="fit" value="<?= htmlspecialchars($product['fit']); ?>" class="overlay-input" readonly required>
                                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                        <button type="submit">
                                            <img src="../images/pen-solid.svg" alt="Editar Fit">
                                        </button>
                                    <?php endif; ?>
                                </div>
                                <div class="colour">
                                    <h3>Color</h3>
                                    <div class="inputs" id="color-picker">
                                        <?php $colours = explode(',', $product['colours']); ?>
                                        <?php foreach ($colours as $colour): ?>
                                            <input value="<?= htmlspecialchars($colour) ?>" name="color" class="color" type="radio" style="background: <?= htmlspecialchars($colour) ?>;" required>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="sizes">
                                    <h3>Tallas</h3>
                                    <div class="inputs">
                                        <?php $sizes = explode(',', $product['sizes']); ?>
                                        <?php foreach ($sizes as $key => $size): ?>
                                            <section id="<?= htmlspecialchars($size) ?>">
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
                                        <input type="text" name="shopping_information" value="<?= htmlspecialchars($information); ?>" class="overlay-input" readonly required>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnails = document.querySelectorAll('.product-thumbnail');
            const mainImage = document.getElementById('main-product-image');

            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    mainImage.src = this.src;
                });
            });
        });

        let addToCartForm = document.getElementById('product_detail_form')

        addToCartForm.onsubmit = (event) => {
            event.preventDefault()

            let form = event.target
            // let product = {}
            let productForm = new FormData(form)
            // console.log('añadiendo a carrito', productForm)

            // for (const [clave, valor] of productForm.entries()) {
            //     product[clave] = valor
            // }
            // console.log(product)

            // let product = {
            //     id: form.id.value,
            //     size: form.size.value,
            //     fit:form.fit.value
            // }
            let product = {
                id: productForm.get('id'),
                fit: productForm.get('fit'),
                size: productForm.get('size'),
                color: productForm.get('color'),
                quantity: 1

            }
            // console.log(product)

            //TO-DO:
            //1. sacar el carrito del localstorage (devuelve un string, hay que parsearlo para convertirlo en un array/objeto)
            let cart = localStorage.getItem('cart') === null ? [] : JSON.parse(localStorage.getItem('cart'))

            //2. añadir el producto al carrito 


            let found = false
            if (cart.length === 0) {
                cart.push(product)
            } else {
                for (let item of cart) {
                    // console.log(item, product)
                    if (item.id === product.id && item.fit === product.fit && item.size === product.size && item.color === product.color) {
                        found = true
                        item.quantity++
                    }
                }
                if (!found) cart.push(product)
            }


            //más elegante:

            // const foundProduct = cart.find(item => (item.id === product.id && item.fit === product.fit && item.size === product.size && item.color === product.color)) || false
            // console.log('found', foundProduct)
            // if (cart.length === 0 || !foundProduct) {
            //     cart.push(product)
            // } else {
            //     cart = cart.map(item => {
            //         return item.id === product.id &&
            //             item.fit === product.fit &&
            //             item.size === product.size &&
            //             item.color === product.color ? {
            //                 ...item,
            //                 quantity: item.quantity + 1
            //             } : item
            //     })
            // }

            console.log(cart)

            //3. volver a convertir todo en string y volver a almacenarlo en el localstorage
            localStorage.setItem('cart', JSON.stringify(cart))




        }
    </script>

</body>


</html>