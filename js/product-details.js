let selectedSize

let selectedColour




/**
 * Función añadir al session storage
 *
 * se ejecuta cuando hacemos click en "añadir al carrito"
 */

function addToCart() {
    const searchParams = new URLSearchParams(window.location.search)



    //leer el carrito del session storage

    //si hay, añadir el producto con las opciones seleccionadas a los existentes

    // si no hay, añadirlo a un array vacio
    let product = {
        id: searchParams.get('id'),
        price: 1,
        picture: '',
        size: selectedSize,
        colour: selectedColour
    }
    console.log(product)
}

addToCart()