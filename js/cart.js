function updateQuantity(index, newQuantity) {
    let cart = getCartFromLocalStorage();
    cart[index].quantity = parseInt(newQuantity);
    saveCartToLocalStorage(cart);
}

function removeFromCart(index) {
    let cart = getCartFromLocalStorage();
    cart.splice(index, 1);
    saveCartToLocalStorage(cart);
    displayCart();
}

function displayCart() {
    let cart = getCartFromLocalStorage();
    let productsContainer = document.getElementById('products');
    
    if (!productsContainer) {
        console.error("El contenedor de productos no se encuentra.");
        return;
    }

    productsContainer.innerHTML = '';  
    let cartStatus =  document.getElementById('cart-status');
    if (cart.length === 0) {
        cartStatus.textContent = 'El carrito está vacío.';
        return;
    }else if(cart.length === 1){
        cartStatus.textContent = `Tiene ${cart.length} producto en la cesta.`
    }else {
        cartStatus.textContent = `Tiene ${cart.length} productos en la cesta.`
    }

    cart.forEach((product, index) => {
        let productElement = createProductElement(product, index);
        productsContainer.appendChild(productElement);
    });
}
document.addEventListener('DOMContentLoaded', displayCart);
function calculateTotal() {
    let totalPrice = document.getElementById('subtotal');
    let cart = getCartFromLocalStorage();
    cart.forEach(product => {
        totalPrice = product.price * quantity;
    });
    totalPrice.innerHTML += totalPrice;
}