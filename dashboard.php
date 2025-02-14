<?php
/**
 * Panel de control para el proveedor:
 * - Vista de productos
 * - Enlace para crear/editar productos
 * - Vinculación de API Key de Telegram
 */
session_start();
require_once 'db_connection.php';

// Verifica que el proveedor haya iniciado sesión
if (!isset($_SESSION['proveedor_id'])) {
    header('Location: login.php');
    exit;
}

// Obtén información del proveedor
$proveedor_id = $_SESSION['proveedor_id'];
$stmt = $pdo->prepare("SELECT * FROM proveedores WHERE id = :id");
$stmt->bindParam(':id', $proveedor_id);
$stmt->execute();
$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

// Guardar o actualizar la API Key de Telegram
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['api_key_telegram'])) {
    $apiKey = trim($_POST['api_key_telegram']);
    $update = $pdo->prepare("UPDATE proveedores SET api_key_telegram = :api WHERE id = :id");
    $update->bindParam(':api', $apiKey);
    $update->bindParam(':id', $proveedor_id);
    $update->execute();
    $proveedor['api_key_telegram'] = $apiKey;
    $mensaje = "API Key actualizada correctamente.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard del Proveedor</title>
</head>
<body>
    <h1>Bienvenido(a), <?php echo htmlspecialchars($proveedor['nombre_proveedor'] ?? ''); ?></h1>
    <?php if(isset($mensaje)) : ?>
        <p style="color:green;"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <h2>Información de la Tienda</h2>
    <p>Nombre de la Tienda: <?php echo htmlspecialchars($proveedor['nombre_tienda'] ?? ''); ?></p>

    <form method="post">
        <label for="api_key_telegram">API Key de Telegram:</label><br>
        <input type="text" name="api_key_telegram" value="<?php echo htmlspecialchars($proveedor['api_key_telegram'] ?? ''); ?>">
        <button type="submit">Guardar</button>
    </form>

    <hr>
    <h2>Gestión de Productos</h2>
    <p><a href="products/create_product.php">Crear Producto</a></p>
    <p><a href="products/list_products.php">Listar Productos</a></p>

    <hr>
    <p><a href="logout.php">Cerrar Sesión</a></p>
</body>
</html>