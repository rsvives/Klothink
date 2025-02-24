<?php
echo "pedido realizado correctamente<br>";

// $cart = $_POST['cart'];
$cart = json_decode($_POST['cart'], true);
$total_price = 0;

foreach ($cart as $key => $item) {
    $total_price += floatval($item['price']) * intval($item['quantity']);
}

var_dump($cart);
var_dump($total_price);


//del array de cart, sacar los ids de los productos  y sus cantidades. 

//sacar con SQL el precio de cada uno de los productos con un foreach (ir acumulándolo en una variable  (precio * cantidad))

//procesar el pago (que esto no lo vamos a hacer, lo podemos emular)

    //si pago ok
    //crear un pedido en SQL tabla orders
    // asociar todos los productos correspondientes a ese pedido en la tabla product_orders
    //devolver vista de pedido procesado correctamente

    //si pago no ok
    //devolver vista de error con pago
