/**
 * Filtra los productos según la categoría seleccionada.
 *
 * @param {string} category - La categoría de productos a filtrar ('men', 'women', 'unisex', 'all').
 */
function filterProducts(category) {
    let articles = document.querySelectorAll('article');
    articles.forEach(article => {
        if (article.classList.contains(category) || category === 'all') {
            article.style.display = 'block';
        } else {
            article.style.display = 'none';
        }
    });
}
/**
 * Establece el botón activo según la selección del usuario.
 *
 * @param {HTMLElement} button - El botón que debe ser marcado como activo.
 */
function setActiveButton(button) {
    buttons.forEach(btn => {
        btn.classList.remove('active');
    });
    button.classList.add('active');
}
let buttons = document.querySelectorAll('button')
buttons.forEach(button => {
    button.onclick = function() {
        filterProducts(button.id);
        setActiveButton(button);
    };
});
;
/**
 * Cambiar la imagen del ojo y el tipo de input dependiendo de si el usuario quiero ver la contraseña o no
 */
function changeImage() {
    let passwordField = document.getElementById('register-password');
    let togglePassword = document.querySelector('.toggle-password');
    let image = togglePassword.querySelector('img');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        image.src = '../images/show-password.svg';
    } else {
        passwordField.type = 'password';
        image.src = '../images/hide-password.svg';
    }
}
let togglePassword = document.querySelector('.toggle-password');
// togglePassword.onclick = changeImage
/**
 * Funcion para agregar productos al carrito
 */
function addProductToCart(productId) {
    let productsCart = [];
    productsCart.push(productId);
    Array.from(productsCart).forEach(product => {
        const article = document.createElement('article');
        const figure = document.createElement('figure');
        const img = document.createElement('img');
        img.src = product.image[0];
        img.alt = "image-array_product";
        figure.appendChild(img);
        article.appendChild(figure);

        const header = document.createElement('div');
        header.classList.add('header');

        const title = document.createElement('div');
        title.classList.add('title');
        title.textContent = product.name;
        header.appendChild(title);

        const fit = document.createElement('h4');
        fit.classList.add('fit');
        fit.textContent = product.fit;
        header.appendChild(fit);

        article.appendChild(header);

        const figcaption = document.createElement('figcaption');

        const quantity = document.createElement('h2');
        quantity.classList.add('quantity');
        const input = document.createElement('input');
        input.type = 'number';
        quantity.appendChild(input);
        figcaption.appendChild(quantity);

        const price = document.createElement('h3');
        price.classList.add('price');
        price.textContent = `$${product.price}`;
        figcaption.appendChild(price);

        const trashImg = document.createElement('img');
        trashImg.src = './images/trash.svg';
        trashImg.alt = 'Eliminar producto';
        figcaption.appendChild(trashImg);

        article.appendChild(figcaption);

        document.getElementById('products').appendChild(article);
    });
}
/**
 * Función para calcular el precio total
 */
function calculateTotal() {
    let productCart = document.querySelectorAll('#productCart article');
    let totalPrice = 0;
    productCart.forEach(product => {
        let priceElement = product.querySelector('.price');
        let price = parseFloat(priceElement.textContent.trim());

        let quantityInput = product.querySelector('.product-quantity');
        let quantity = parseInt(quantityInput.value, 10);
        totalPrice += price * quantity;
    });
    let priceContainer = document.getElementById('show-price');
    if (priceContainer) {
        priceContainer.textContent = totalPrice.toFixed(2) + ' €';
    }
}
document.querySelectorAll('.product-quantity').forEach(input => {
    input.addEventListener('input', calculateTotal);
});
window.addEventListener('load', calculateTotal);
calculateTotal();
