/**
 * Funcion que cambia la imagen del icono de visibilidad de contraseña y el tipo de input
 * dependiendo de si el usuario quiere ver u ocultar la contraseña.
 */
function changeImage() {
    let passwordField = document.getElementById('register-password');
    let image = document.getElementById('togglePassword').querySelector('img');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        image.src = '../images/show-password.svg';
    } else {
        passwordField.type = 'password';
        image.src = '../images/hide-password.svg';
    }
}

document.getElementById('togglePassword')?.addEventListener('click', changeImage);