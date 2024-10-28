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

    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $precioUnidad = $_POST['precioUnidad'];

    $descuento = $_POST['descuento'];

    $total = $cantidad * $precioUnidad;
    $totalConDescuento = $total - ($total * $descuento / 100);

    echo "<p>El precio Total de $nombre es de: $total €</p>";
    echo "<p>Con el descuento aplicado se queda en: $totalConDescuento €</p>";
?>
</body>
</html>