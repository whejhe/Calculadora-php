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

    ?>

    <form action="" method="post">

        <table>

    <?php

    // Definimos los productos disponibles y sus precios
    $productos = [
        ["nombre" => "Mancuerna 20kg", "precio" => 85],
        ["nombre" => "Maquina press banca", "precio" => 150],
        ["nombre" => "Barra olimpica", "precio" => 40]
    ];

    ?>

    <!-- Formulario para ingresar las cantidades de los productos -->
    <form action="" method="post">
        <table>
            <h1>CALCULADORA DE PRODUCTOS</h1>
            <tr>
                <td><?php echo $productos[0]["nombre"] ?></td>
                <td>
                    Cantidad: <input type="number" name="cantMancuerna" value="0" minlength="0">
                </td>
                <td>
                    Precio: <?php echo $productos[0]["precio"] ?>€
                </td>
            </tr>
            <tr>
                <td><?php echo $productos[1]["nombre"] ?></td>
                <td>
                    Cantidad: <input type="number" name="cantPressBanca" value="0" minlength="0">
                </td>
                <td>
                    Precio: <?php echo $productos[1]["precio"] ?>€
                </td>
            </tr>
            <tr>
                <td><?php echo $productos[2]["nombre"] ?></td>
                <td>
                    Cantidad: <input type="number" name="cantBarraOlim" value="0" minlength="0">
                </td>
                <td>
                    Precio: <?php echo $productos[2]["precio"] ?>€
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <input style="margin-left: 40%; margin-top: 5%;" type="submit" name="enviar">
                </td>
            </tr>

        </table>
        <?php

        define('LIMITE_CANTIDAD_ADICIONAL', 0.05);
        define('LIMITE_CANTIDAD_DESCUENTO', 40);
        define('LIMITE_CANTIDAD_GRATIS', 100);
        define('PRECIO_MINIMO', 0); // Precio mínimo para un producto
        define('PRECIO_MAXIMO', 3000); // Precio máximo que se puede establecer (ejemplo)

        // Verificamos si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Capturamos y mostramos la cantidad de mancuernas
            $cantManc = isset($_REQUEST["cantMancuerna"]) ? $_REQUEST["cantMancuerna"] : 0;
            echo nl2br("\n") . " Cantidad de mancuernas de 20kg: " . $cantManc . nl2br("\n");

            // Capturamos y mostramos la cantidad de máquinas de press banca
            $cantPressBanca = isset($_REQUEST["cantPressBanca"]) ? $_REQUEST["cantPressBanca"] : 0;
            echo "Cantidad de máquinas de press banca: " . $cantPressBanca . nl2br("\n");

            // Capturamos y mostramos la cantidad de barras olímpicas
            $cantBarraOlim = isset($_REQUEST["cantBarraOlim"]) ? $_REQUEST["cantBarraOlim"] : 0;
            echo "Cantidad de Barra Olim: " . $cantBarraOlim . nl2br("\n");

            // Aseguramos que las cantidades no sean negativas
            $cantManc = max($cantManc, 0);
            $cantPressBanca = max($cantPressBanca, 0);
            $cantBarraOlim = max($cantBarraOlim, 0);

            // Análisis de límites para las cantidades
            if ($cantManc + $cantPressBanca + $cantBarraOlim > 100) {
                echo "<br>Advertencia: Se ha superado el límite de 100 unidades. Esto podría causar problemas de inventario.<br>";
            }

            // Calculamos el precio total por tipo de producto
            $sumaPrecioMancu = $cantManc * $productos[0]['precio'];
            $sumaPrecioPressBanc = $cantPressBanca * $productos[1]['precio'];
            $sumaPrecioBarraOlim = $cantBarraOlim * $productos[2]['precio'];

            // Calculamos el precio total y el total de unidades
            $precioTotal = $sumaPrecioBarraOlim + $sumaPrecioPressBanc + $sumaPrecioMancu;
            $totalUnidades = $cantManc + $cantPressBanca + $cantBarraOlim;

            // Análisis de límites para precios
            if ($precioTotal < PRECIO_MINIMO) {
                echo "Error: El precio total no puede ser menor que " . PRECIO_MINIMO . "€.<br>";
            } elseif ($precioTotal > PRECIO_MAXIMO) {
                echo "<br>Advertencia: El precio total ha alcanzado el límite máximo de " . PRECIO_MAXIMO . "€.<br>";
            }

            // Verificamos si se aplica un descuento
            if ($totalUnidades >= LIMITE_CANTIDAD_DESCUENTO) {
                echo "<h3>Tienes un descuento de un 5%</h3>";
                $precioConDescuento = $precioTotal - $precioTotal * LIMITE_CANTIDAD_ADICIONAL;

                // Verificamos si el cliente recibe un producto gratuito
                if ($totalUnidades >= LIMITE_CANTIDAD_GRATIS || $precioTotal >= 3000) {
                    echo "<h3>Tienes un producto gratuito: Barra Olimpica x1</h3><br>";
                    $cantBarraOlim++;
                    echo nl2br("\n") . " Cantidad de mancuernas de 20kg: " . $cantManc . nl2br("\n");
                    echo "Cantidad de máquinas de press banca: " . $cantPressBanca . nl2br("\n");
                    echo "Cantidad de Barra Olim: " . $cantBarraOlim . nl2br("\n");
                }
            } else {
                echo "<h3>No hay descuento aplicable</h3>";
            }
        

            // Verificar si el total de unidades es par o impar
            if ($totalUnidades % 2 == 0) {
                echo "<br>El total de productos es par.";
            } else {
                echo "<br>El total de productos es impar.<br>";
            }

            // Línea separadora
            echo "<br>----------------------------------------------------------------<br>";

            // Calculamos el promedio del precio por unidad
            if ($totalUnidades > 0) {
                $promedioPrecUD = $precioTotal / $totalUnidades;
                echo "Promedio del precio por unidad: " . number_format($promedioPrecUD, 2) . "€<br>";
            } else {
                echo "No se han comprado unidades, por lo que no hay promedio que mostrar.<br>";
            }

            // Mostramos el total a pagar
            echo "Total a pagar sin descuento: " . number_format($precioTotal, 2) . "€" . nl2br("\n");

            // Mostramos el total a pagar con descuento, si aplica
            if ($totalUnidades >= LIMITE_CANTIDAD_DESCUENTO) {
                echo "Total a pagar con descuento: " . number_format($precioConDescuento, 2) . "€";
            }
        }
        ?>
</body>

</html>
