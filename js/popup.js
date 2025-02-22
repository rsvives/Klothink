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
    if (event.key === 'Escape') { 
        closePopup(); 
    }
});