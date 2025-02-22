/**
 * Crea un elemento HTML con una clase opcional y contenido de texto.
 * 
 * @param {string} tag - El nombre de la etiqueta HTML a crear (por ejemplo, 'div', 'span').
 * @param {string} [className=''] - La clase CSS opcional a agregar al elemento.
 * @param {string} [textContent=''] - El contenido de texto opcional del elemento.
 * @returns {HTMLElement} - El elemento HTML creado.
 */
function createElement(tag, className = '', textContent = '') {
    let element = document.createElement(tag);
    if (className) element.classList.add(className);
    if (textContent) element.textContent = textContent;
    return element;
}

/**
 * Crea un elemento de imagen (<img>) con atributos de fuente, alt y clase opcional.
 * 
 * @param {string} src - La URL de la imagen.
 * @param {string} alt - El texto alternativo para la imagen.
 * @param {string} [className=''] - La clase CSS opcional a agregar a la imagen.
 * @returns {HTMLImageElement} - El elemento de imagen creado.
 */
function createImage(src, alt, className = '') {
    let img = document.createElement('img');
    img.src = src;
    img.alt = alt;
    if (className) img.classList.add(className);
    return img;
}

/**
 * Crea un input numérico para seleccionar la cantidad de un producto en el carrito.
 * 
 * @param {number} index - El índice del producto en el carrito.
 * @param {number} value - La cantidad inicial del producto.
 * @returns {HTMLDivElement} - Un div contenedor con la etiqueta y el input de cantidad.
 */
function createQuantityInput(index, value) {
    let quantity = createElement('div', 'quantity');

    let label = createElement('label', '', 'Cantidad:');
    label.setAttribute('for', 'quantity-' + index);

    let input = document.createElement('input');
    input.type = 'number';
    input.id = 'quantity-' + index; 
    input.step = '1';
    input.min = '1';
    input.value = value;

    input.addEventListener('change', function () {
        updateQuantity(index, input.value);
    });

    quantity.appendChild(label);
    quantity.appendChild(input);

    return quantity;
}

/**
 * Crea un artículo HTML para representar un producto en el carrito.
 * 
 * @param {Object} product - El producto a mostrar.
 * @param {string} product.name - El nombre del producto.
 * @param {string} [product.fit] - El ajuste/talla del producto (opcional).
 * @param {number} product.price - El precio del producto.
 * @param {number} product.quantity - La cantidad del producto en el carrito.
 * @param {number} index - El índice del producto en el carrito.
 * @returns {HTMLElement} - El elemento de artículo HTML para el producto.
 */
function createProductElement(product, index) {
    let article = createElement('article');

    let figure = createElement('figure');
    figure.appendChild(createImage(product.image,'Imagen del producto'));

    let header = createElement('div', 'header');
    header.appendChild(createElement('div', 'title', product.name));
    if (product.fit) {
        header.appendChild(createElement('div', 'fit', product.fit));
    }

    let figcaption = createElement('figcaption');
    figcaption.appendChild(createElement('h3', 'price', `${product.price} €`));
    figcaption.appendChild(createQuantityInput(index, product.quantity));

    let trashIcon = createImage('../images/Trash.svg', 'Eliminar producto', 'trash');
    trashIcon.addEventListener('click', () => removeFromCart(index));
    figcaption.appendChild(trashIcon);

    article.append(figure, header, figcaption);
    return article;
}