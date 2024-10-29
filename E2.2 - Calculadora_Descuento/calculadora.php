<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
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
                    <input type="submit" name="enviar">
                </td>
            </tr>

        </table>
        <?php

        define('LIMITE_CANTIDAD_ADICIONAL', 0.05);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Mostrar el valor de cantMancuerna
            if (isset($_REQUEST["cantMancuerna"])) {
                echo nl2br("\n") . " Cantidad de mancuernas de 20kg: " . $_REQUEST["cantMancuerna"] . nl2br("\n");
                $cantManc = $_REQUEST["cantMancuerna"];
            } else {
                echo "No se ha enviado ninguna cantidad.";
            }
            // Mostrar el valor de cantPressBanca
            if (isset($_REQUEST["cantPressBanca"])) {
                echo "Cantidad de máquinas de press banca: " . $_REQUEST["cantPressBanca"] . nl2br("\n");
                $cantPressBanca = $_REQUEST["cantPressBanca"];
            } else {
                echo "No se ha enviado ninguna cantidad.";
            }
            // Mostrar el valor de cantBarraOlim
            if (isset($_REQUEST["cantBarraOlim"])) {
                echo "Cantidad de Barra Olim: " . $_REQUEST["cantBarraOlim"] . nl2br("\n");
                $cantBarraOlim = $_REQUEST["cantBarraOlim"];
            } else {
                echo "No se ha enviado ninguna cantidad.";
            }

            if ($cantManc < 0) {
                $cantManc = 0;
            }
            if ($cantPressBanca < 0) {
                $cantPressBanca = 0;
            }
            if ($cantBarraOlim < 0) {
                $cantBarraOlim = 0;
            }

            $sumaPrecioMancu =  $cantManc * $productos[0]['precio'];
            $sumaPrecioPressBanc =  $cantPressBanca * $productos[1]['precio'];
            $sumaPrecioBarraOlim =  $cantBarraOlim * $productos[2]['precio'];

            $precioTotal = $sumaPrecioBarraOlim + $sumaPrecioPressBanc + $sumaPrecioMancu;
            $totalUnidades = $cantManc + $cantPressBanca + $cantBarraOlim;

            if ($totalUnidades >= 40) {
                echo "<h3>Tienes un descuento de un 5%</h3>";
                $precioConDescuento = $precioTotal - $precioTotal * LIMITE_CANTIDAD_ADICIONAL;
            } else {
                echo "<h3>No hay descuento aplicable</h3>";
            }


            echo "<br>----------------------------------------------------------------<br>";

            echo "Total a pagar sin descuento: " . (float)$precioTotal . "€" . nl2br("\n");

            if ($totalUnidades >= 40) {
                echo "Total a pagar con descuento: " . number_format($precioConDescuento, 2) . "€";
            }

        }

        ?>
</body>

</html>