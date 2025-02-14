<?php
/**
 * Cierra la sesión del proveedor.
 */
session_start();
session_destroy();
header('Location: index.php');
exit;
?>