/**
 * Obtiene el carrito almacenado en localStorage.
 * @returns {Array} El array de productos en el carrito.
 */
function getCartFromLocalStorage() {
    let cart = localStorage.getItem('cart');
    return cart ? JSON.parse(cart) : [];
}

/**
 * Guarda el carrito actualizado en localStorage.
 * @param {Array} cart - El carrito que se guardará en localStorage.
 */
function saveCartToLocalStorage(cart) {
    console.log(cart)
    localStorage.setItem('cart', JSON.stringify(cart));
}

/**
 * Inicializa la acción de agregar un producto al carrito.
 */
function initAddToCart() {
    let addToCartForm = document.getElementById('product_detail_form');

    addToCartForm.addEventListener('submit', (event) => {
        event.preventDefault();
        let product = extractProductData(event.target);
        let cart = getCartFromLocalStorage();
        cart = addOrUpdateProductInCart(cart, product);
        saveCartToLocalStorage(cart);
        // console.log(cart);
    });
}
document.addEventListener('DOMContentLoaded', () => {
    initAddToCart();
});

/**
 * Extrae los datos del formulario y los convierte en un objeto producto.
 * @param {HTMLFormElement} form - El formulario con los datos del producto.
 * @returns {Object} El objeto producto con la información extraída del formulario.
 */
function extractProductData(form) {
    let productImage = document.getElementById('main-product-image');
    let productForm = new FormData(form);
    let product = {};

    if (productForm.get('name')) product.name = productForm.get('name');
    if (productForm.get('price')) product.price = productForm.get('price');
    if (productForm.get('fit')) product.fit = productForm.get('fit');
    if (productForm.get('size')) product.size = productForm.get('size');
    if (productForm.get('colour')) product.colour = productForm.get('colour');

    if (productImage) {
        product.image = productImage.src;
    }

    product.quantity = 1;
    console.log(product);
    return product;
}

/**
 * Añade un producto al carrito o actualiza la cantidad si ya existe.
 * @param {Array} cart - El carrito actual.
 * @param {Object} product - El producto a agregar o actualizar.
 * @returns {Array} El carrito actualizado.
 */
function addOrUpdateProductInCart(cart, product) {
    let found = false;

    if (cart.length === 0) {
        cart.push(product);
    } else {
        for (let item of cart) {
            if (isProductEqual(item, product)) {
                found = true;
                item.quantity++;
                break;
            }
        }
        if (!found) {
            cart.push(product);
        }
    }
    return cart;
}

/**
 * Compara si dos productos son iguales (basado en propiedades clave).
 * @param {Object} item - Un producto en el carrito.
 * @param {Object} product - El nuevo producto a comparar.
 * @returns {boolean} Verdadero si los productos son iguales, falso si no lo son.
 */
function isProductEqual(item, product) {
    return item.name === product.name &&
        item.price === product.price &&
        (!product.fit || item.fit === product.fit) &&
        (!product.size || item.size === product.size) &&
        (!product.colour || item.colour === product.colour);
}

/**
 * Elimina un producto del carrito.
 * @param {Array} cart - El carrito actual.
 * @param {Object} product - El producto a eliminar.
 * @returns {Array} El carrito actualizado.
 */
function removeProductFromCart(cart, product) {
    return cart.filter(item => !isProductEqual(item, product));
}

/**
 * Actualiza la cantidad de un producto en el carrito.
 * @param {Array} cart - El carrito actual.
 * @param {Object} product - El producto con la cantidad actualizada.
 * @returns {Array} El carrito actualizado.
 */
function updateProductQuantityInCart(cart, product) {
    for (let item of cart) {
        if (isProductEqual(item, product)) {
            item.quantity = product.quantity;
        }
    }
    return cart;
}