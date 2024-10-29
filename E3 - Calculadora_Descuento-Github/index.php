<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <h1>CALCULADORA DESCUENTO</h1>

    <!-- Solicitar a los usuarios datos sobre los productos -->
    <form action="calculadora.php" method="post">
        <label for="nombre">Nombre Producto:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" required>
        <br>
        <label for="precioUnidad">Precio Unidad:</label>
        <input type="number" name="precioUnidad" id="precioUnidad" required>
        <br>
        <label for="descuento">% de Descuento</label>
        <input type="number" name="descuento" id="descuento">
        <br>
        <input class="button" type="submit" value="Calcular">
    </form>

</body>
</html>