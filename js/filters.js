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
        article.style.display = (article.classList.contains(category) || category === 'all') ? 'block' : 'none';
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
    let buttons = document.querySelectorAll('.filters button');
    buttons.forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
}

document.addEventListener('DOMContentLoaded', () => {
    let buttons = document.querySelectorAll('.filters button');
    buttons.forEach(button => {
        button.onclick = function () {
            filterProducts(button.id);
            setActiveButton(button);
        };
    });
});