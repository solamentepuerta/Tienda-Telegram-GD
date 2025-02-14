<?php
/**
 * Maneja el inicio de sesión de proveedores; también podría implementar la recuperación de contraseña.
 */
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT id, password FROM proveedores WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($proveedor && password_verify($password, $proveedor['password'])) {
            // Login exitoso
            $_SESSION['proveedor_id'] = $proveedor['id'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Credenciales inválidas.";
        }
    } else {
        $error = "Por favor, llena todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <?php if(isset($error)) : ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="email">Correo Electrónico:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Acceder</button>
    </form>
    <p><a href="index.php">Volver a la Página Principal</a></p>
</body>
</html>