<?php
/**
 * Maneja el registro de nuevos proveedores.
 * Guarda la información en la base de datos y redirige al dashboard.
 */
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreProveedor = trim($_POST['nombre_proveedor'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $nombreTienda = trim($_POST['nombre_tienda'] ?? '');

    if (!empty($nombreProveedor) && !empty($email) && !empty($password) && !empty($nombreTienda)) {
        // Encriptamos la contraseña para guardarla de forma segura
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO proveedores (nombre_proveedor, email, password, nombre_tienda)
                               VALUES (:nombre, :email, :pass, :tienda)");
        $stmt->bindParam(':nombre', $nombreProveedor);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $hashedPassword);
        $stmt->bindParam(':tienda', $nombreTienda);

        if ($stmt->execute()) {
            // Registro exitoso, redirige al login o dashboard
            header('Location: login.php');
            exit;
        } else {
            $error = "No se pudo completar el registro. Intenta nuevamente.";
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Proveedores</title>
</head>
<body>
    <h1>Registro de Proveedores</h1>
    <?php if(isset($error)) : ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="nombre_proveedor">Nombre Completo:</label><br>
        <input type="text" name="nombre_proveedor" required><br><br>

        <label for="email">Correo Electrónico:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <label for="nombre_tienda">Nombre de la Tienda:</label><br>
        <input type="text" name="nombre_tienda" required><br><br>

        <button type="submit">Registrarse</button>
    </form>
    <p><a href="index.php">Volver a la Página Principal</a></p>
</body>
</html>