function addProductToCart() {

    let nameInput = form.name;
    let priceInput = form.price
    let fitInput = form.fit
    let imageInput = form.images
    let product = {
        name: nameInput.value,
        price: priceInput.value,
        fit: fitInput.value, 
        image: imageInput.value
    };

    let cart = JSON.parse(localStorage.getItem('cart')) | [];  

    cart.push(product);

    localStorage.setItem('cart', JSON.stringify(cart));

    alert('Producto añadido al carrito!');

}    
let form = document.getElementById('add-product-form');
form.addEventListener('submit', function(event) {
    addProductToCart();
    event.preventDefault(); 
});