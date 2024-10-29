<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Calculadora Descuento (Trabajo Colaborativo)</title>
</head>

<body>

    <?php
    $productos = [
        ["nombre" => "Mancuerna 20kg", "precio" => 85],
        ["nombre" => "Maquina press banca", "precio" => 150],
        ["nombre" => "Barra olimpica", "precio" => 40]
    ];

    define('LIMITE_CANTIDAD_ADICIONAL', 0.05); // Descuento adicional
    define('LIMITE_CANTIDAD_DESCUENTO', 40); // Límite para aplicar descuento de cantidad
    define('LIMITE_CANTIDAD_GRATIS', 100); // Límite para promoción de producto gratis
    define('PRECIO_MINIMO', 0);
    define('PRECIO_MAXIMO', 3000);
    define('IVA', 0.15); // IVA del 15%
    ?>

    <form action="" method="post">
        <table>
            <h1>CALCULADORA DE PRODUCTOS</h1>
            <?php foreach ($productos as $index => $producto) : ?>
                <tr>
                    <td><?php echo $producto["nombre"] ?></td>
                    <td>
                        Cantidad: <input type="number" name="cantidades[<?php echo $index ?>]" value="0" min="0">
                    </td>
                    <td>
                        Precio: <?php echo $producto["precio"] ?>€
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3">
                    <input style="margin-left: 40%; margin-top: 5%;" type="submit" name="enviar" value="Calcular">
                </td>
            </tr>
        </table>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo '<div class="container">'; // Inicia el div para los detalles de la compra

        $cantidades = isset($_POST["cantidades"]) ? array_map('intval', $_POST["cantidades"]) : [0, 0, 0];

        $totalUnidades = array_sum($cantidades);
        $precioTotal = 0;
        $detallesCompra = "";

        foreach ($productos as $index => $producto) {
            $cantidad = max($cantidades[$index], 0);
            $subtotal = $cantidad * $producto["precio"];
            $precioTotal += $subtotal;
            $detallesCompra .= "{$producto["nombre"]}: {$cantidad} unidades a {$producto["precio"]}€ cada una. Subtotal: {$subtotal}€.<br>";
        }

        echo "<hr><h3>Detalles de la compra:</h3><p>{$detallesCompra}</p>";

        // Validar límites de precio
        if ($precioTotal < PRECIO_MINIMO) {
            echo "<p>Error: El precio total no puede ser menor que " . PRECIO_MINIMO . "€.</p><br>";
        } elseif ($precioTotal > PRECIO_MAXIMO) {
            echo "<p class='warning'>Advertencia: El precio total ha alcanzado el límite máximo de " . PRECIO_MAXIMO . "€.</p><br>";
        }

        // Calcular descuento si se cumplen condiciones
        $precioConDescuento = $precioTotal;
        if ($totalUnidades >= LIMITE_CANTIDAD_DESCUENTO) {
            $precioConDescuento -= $precioTotal * LIMITE_CANTIDAD_ADICIONAL;
            echo "<p>Descuento del 5% aplicado. Total con descuento: " . number_format($precioConDescuento, 2) . "€</p>";
        } else {
            echo "<p>No hay descuento aplicable</p>";
        }

        // Calcular IVA sobre el precio con descuento
        $ivaTotal = $precioConDescuento * IVA;
        $totalConIVA = $precioConDescuento + $ivaTotal;

        echo "<p>Precio sin IVA: " . number_format($precioConDescuento, 2) . "€</p>";
        echo "<p>IVA del 15%: " . number_format($ivaTotal, 2) . "€</p>";
        echo "<p>Total con IVA: " . number_format($totalConIVA, 2) . "€</p>";

        // Promoción de producto gratis
        if ($totalUnidades >= LIMITE_CANTIDAD_GRATIS || $precioTotal >= PRECIO_MAXIMO) {
            echo "<p>Producto gratuito: Barra Olímpica x1</p>";
        }

        // Verificar paridad de cantidad total de productos
        echo ($totalUnidades % 2 === 0) ? "<p>El total de productos es par.</p>" : "<p>El total de productos es impar.</p>";

        // Calcular promedio de precio por unidad si se han comprado unidades
        if ($totalUnidades > 0) {
            $promedioPrecUD = $precioTotal / $totalUnidades;
            echo "<p>Promedio del precio por unidad: " . number_format($promedioPrecUD, 2) . "€</p><br>";
        } else {
            echo "<p>No se han comprado unidades, por lo que no hay promedio que mostrar.</p><br>";
        }

        // Mostrar total a pagar con o sin descuento
        if($totalUnidades >= LIMITE_CANTIDAD_DESCUENTO){
            echo "<h3>Total a pagar con descuento: " . number_format($precioConDescuento, 2) . "€</h3><br>";
        } else {
            echo "<h3>Total a pagar sin descuento: " . number_format($totalConIVA, 2) . "€</h3><br>";
        }

        echo '</div>'; // Cierra el div de detalles de compra
    }
    ?>

</body>

</html>
