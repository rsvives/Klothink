/**
 * Actualiza la cantidad de un producto en el carrito.
 * 
 * @param {number} index - Índice del producto en el array del carrito.
 * @param {number} newQuantity - Nueva cantidad del producto.
 */
function updateQuantity(indexProduct, newQuantity) {
    let cart = getCartFromLocalStorage();
    cart[indexProduct].quantity = parseInt(newQuantity);
    calculateTotal();
    saveCartToLocalStorage(cart);
}

/**
 * Elimina un producto del carrito según su índice.
 * 
 * @param {number} index - Índice del producto en el array del carrito.
 */
function removeFromCart(indexProduct) {
    let cart = getCartFromLocalStorage();
    cart.splice(indexProduct, 1);
    calculateTotal();
    displayCart();
    saveCartToLocalStorage(cart);
}

/**
 * Muestra los productos del carrito en la página y actualiza el estado del carrito.
 * Si el carrito está vacío, muestra un mensaje indicando esto.
 */
function displayCart() {
    let cart = getCartFromLocalStorage();
    let productsContainer = document.getElementById('products');
    
    if (!productsContainer) {
        console.error("El contenedor de productos no se encuentra.");
        return;
    }

    productsContainer.innerHTML = '';  
    let cartStatus = document.getElementById('cart-status');

    if (cart.length === 0) {
        cartStatus.textContent = 'El carrito está vacío.';
        return;
    } else if (cart.length === 1) {
        cartStatus.textContent = `Tiene ${cart.length} producto en la cesta.`;
    } else {
        cartStatus.textContent = `Tiene ${cart.length} productos en la cesta.`;
    }

    cart.forEach((product, index) => {
        let productElement = createProductElement(product, index);
        productsContainer.appendChild(productElement);
    });

    calculateTotal();
}
document.addEventListener('DOMContentLoaded', displayCart);

/**
 * Calcula el precio total del carrito sumando el precio de cada producto multiplicado por su cantidad,
 * y actualiza el valor en la interfaz.
 */
function calculateTotal() {
    let totalPriceElement = document.getElementById('subtotal');
    let cart = getCartFromLocalStorage();
    let totalPrice = 0;

    cart.forEach(product => {
        totalPrice += product.price * product.quantity; 
    });

    totalPriceElement.innerHTML = `${totalPrice.toFixed(2)} €`;
}