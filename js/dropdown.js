/**
 * Alterna la visibilidad del menú desplegable.
 * Cambia el estilo del menú y la clase del título.
 */
function toggleDropdown() {
    let dropdownMenu = document.querySelector('.dropdown-menu');
    let title = document.querySelector('.dropdown');

    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    title.classList.toggle('active');
}

/**
 * Cierra el menú desplegable.
* Cambia el estilo del menú a oculto y elimina la clase activa del título.
 */
function closeDropdown() {
    let dropdownMenu = document.querySelector('.dropdown-menu');
    let title = document.querySelector('.dropdown');

    dropdownMenu.style.display = 'none';
    title.classList.remove('active');
}

/**
* Inicializa el menú desplegable.
 * Asigna eventos para abrir y cerrar el menú desplegable.
*/
function initDropdown() {
    let dropdownTrigger = document.querySelector('.dropdown');
    let dropdownMenu = document.querySelector('.dropdown-menu');
    if (!dropdownTrigger || !dropdownMenu) return;

    dropdownTrigger.addEventListener('click', toggleDropdown);
    document.addEventListener('click', function (e) {
        if (!dropdownTrigger.contains(e.target) && !dropdownMenu.contains(e.target)) {
            closeDropdown();
        }
    });
}
document.addEventListener('DOMContentLoaded', initDropdown);