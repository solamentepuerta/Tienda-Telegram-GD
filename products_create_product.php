<?php
/**
 * Página para crear un producto nuevo (digital o físico).
 */
session_start();
require_once '../db_connection.php';
if (!isset($_SESSION['proveedor_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $categoria = trim($_POST['categoria'] ?? '');
    $tipo = trim($_POST['tipo'] ?? 'digital');
    $proveedor_id = $_SESSION['proveedor_id'];

    if (!empty($nombre) && $precio > 0 && !empty($categoria)) {
        // Subida de imagen (opcional)
        $imagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagenTmp = $_FILES['imagen']['tmp_name'];
            $imagenData = file_get_contents($imagenTmp);
            $imagen = base64_encode($imagenData); // Ejemplo de almacenado en base64
        }

        $stmt = $pdo->prepare("INSERT INTO productos 
            (nombre, descripcion, precio, categoria, tipo, imagen, proveedor_id) 
            VALUES (:nombre, :descripcion, :precio, :categoria, :tipo, :imagen, :proveedor_id)");

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->bindParam(':proveedor_id', $proveedor_id);

        if ($stmt->execute()) {
            header('Location: list_products.php');
            exit;
        } else {
            $error = "Error al crear el producto. Revisa los datos.";
        }
    } else {
        $error = "Completa todos los campos obligatorios (nombre, precio, categoría).";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
</head>
<body>
    <h1>Crear Producto</h1>
    <?php if(isset($error)) : ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre del Producto:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label for="descripcion">Descripción:</label><br>
        <textarea name="descripcion"></textarea><br><br>

        <label for="precio">Precio:</label><br>
        <input type="number" step="0.01" name="precio" required><br><br>

        <label for="categoria">Categoría:</label><br>
        <input type="text" name="categoria" required><br><br>

        <label for="tipo">Tipo de Producto:</label><br>
        <select name="tipo">
            <option value="digital">Digital</option>
            <option value="fisico">Físico</option>
        </select><br><br>

        <label for="imagen">Imagen del Producto (opcional):</label><br>
        <input type="file" name="imagen"><br><br>

        <button type="submit">Crear</button>
    </form>
    <p><a href="list_products.php">Volver a la Lista de Productos</a></p>
</body>
</html>