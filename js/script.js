/**
 * Filtra los productos según la categoría seleccionada.
 *
 * @param {string} category - La categoría de productos a filtrar ('men', 'women', 'unisex', 'all').
 * @description
 * La función selecciona todos los elementos `<article>` y verifica si contienen
 * la clase correspondiente a la categoría seleccionada. Si la categoría es 'all',
 * todos los productos se muestran. De lo contrario, solo se muestran aquellos
 * que coinciden con la categoría.
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
 * Funcion que establece el botón activo según la selección del usuario.
 *
 * @param {HTMLElement} button - El botón que debe ser marcado como activo.
 * @description
 * La funcion recorre una lista de botones y elimina la clase 'active' de todos ellos.
 * Luego, agrega la clase 'active' al botón seleccionado para reflejar la acción del usuario.
 */
function setActiveButton(button) {
    buttons.forEach(btn => {
        btn.classList.remove('active');
    });
    button.classList.add('active');
}
let buttons = document.querySelectorAll('.filters button');
buttons.forEach(button => {
    button.click = function() {
       filterProducts(button.id);
        setActiveButton(button);
    };
});
/**
 * Funcion que cambia la imagen del icono de visibilidad de contraseña y el tipo de input
 * dependiendo de si el usuario quiere ver u ocultar la contraseña.
 */
function changeImage() {
    let passwordField = document.getElementById('register-password');
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
togglePassword.click = changeImage;

/**
 *
 * Funcion que agrega productos al carrito visualizando detalles en el DOM.
 *
 * @param {number|string} productId - ID del producto que se quiere agregar.
 * @description
 * La funcion agrega el ID del producto al arreglo `productsCart` y actualiza el DOM
 * mostrando el producto en el carrito. La estructura incluye la imagen,
 * título, cantidad y precio del producto.
 */
function addProductToCart(productId) {
    let productContainer = document.getElementsByClassName('products')
  if (!productContainer) {
      alert("¡Contenedor de productos no encontrado!")
  } else {
      alert('Has seleccionado el producto' + productId)
      let
  }
}
/**
 *  Muestra un cuadro de diálogo de confirmación para eliminar un producto y, si el usuario lo confirma,
 * envía una solicitud al servidor para eliminarlo.
 * @param {number} productId - El identificador único del producto que se desea eliminar.
 * @param {string} productName - El nombre del producto que se desea eliminar.
 * @returns {boolean} - Devuelve true si el usuario confirma la eliminación, de lo contrario false.
 * @description
 * Si el usuario confirma, se muestra un mensaje de confirmación con el ID y nombre del producto.
 * La función devuelve true si el usuario confirma la eliminación, de lo contrario devuelve false.
 */
function confirmDelete(ev, productId, productName) {
    let message = `¿Estás seguro de eliminar el producto con ID: ${productId} (${productName})?`;
    if (!confirm(message)) {
        return ev.preventDefault();
    }
}
/**
 * 
 */
/**
 * Función para abrir el formulario emergente.
 * Cambia el estilo del elemento con el id 'popupForm' para que sea visible.
 */
function openPopup() {
    let form = document.getElementById('popupForm')
    form.style.display = 'flex';
}
/**
 * Función para cerrar el formulario emergente.
 * Cambia el estilo del elemento con el id 'popupForm' para que sea oculto.
 */
function closePopup() {
    let form = document.getElementById('popupForm')
    form.style.display = 'none';
}
document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') { 
        closePopup(); 
    }
});
 /**
     * Cambia el botón de navegación activo en función del archivo actual de la URL.
     * La función determina el archivo actual basado en la ruta de la URL, compara el nombre del archivo
     * con casos predefinidos ('index.php', 'products.php', 'contact.php') y asigna la clase 'active'
     * al botón de navegación correspondiente.
     *
     * El método busca todos los elementos con la clase 'nav-button' y activa el primero que coincide
     * con el archivo actual. Si no se encuentra un archivo que coincida, no se realiza ningún cambio.
     *
     * Esta función se utiliza típicamente para resaltar el botón de navegación correspondiente a la
     * página actual del usuario.
     *
     * @function changeNav
     */
 function changeNav() {
    let file = window.location.pathname.split('/').pop();
    let navButtons = document.querySelectorAll('.nav-button');
    let activeButton;
    switch (file) {
        case 'index.php':
            activeButton = navButtons[0];
            break;
        case 'products.php':
            activeButton = navButtons[1];
            break;
        case 'contact.php':
            activeButton = navButtons[2];
            break;
    }
    if (activeButton) {
        activeButton.classList.add('active');
    }
}
changeNav()
    