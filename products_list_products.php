<?php
/**
 * Listado de productos creados por el proveedor; permite editar o eliminar.
 */
session_start();
require_once '../db_connection.php';
if (!isset($_SESSION['proveedor_id'])) {
    header('Location: ../login.php');
    exit;
}

$proveedor_id = $_SESSION['proveedor_id'];

// Obtenemos la lista de productos
$stmt = $pdo->prepare("SELECT * FROM productos WHERE proveedor_id = :proveedor_id");
$stmt->bindParam(':proveedor_id', $proveedor_id);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Productos</title>
</head>
<body>
    <h1>Mis Productos</h1>
    <p><a href="create_product.php">Crear Nuevo Producto</a></p>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Tipo</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if($productos): ?>
                <?php foreach($productos as $p): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                        <td><?php echo number_format($p['precio'], 2); ?></td>
                        <td><?php echo htmlspecialchars($p['categoria']); ?></td>
                        <td><?php echo htmlspecialchars($p['tipo']); ?></td>
                        <td>
                            <?php if($p['imagen']): ?>
                                <img src="data:image/jpeg;base64,<?php echo $p['imagen']; ?>" alt="Producto" width="50">
                            <?php else: ?>
                                Sin imagen
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $p['id']; ?>">Editar</a> |
                            <a href="delete_product.php?id=<?php echo $p['id']; ?>"
                               onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No hay productos creados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <p><a href="../dashboard.php">Volver al Dashboard</a></p>
</body>
</html>