# Sistema de Gestión de Tiendas Telegram

Este proyecto en PHP demuestra la estructura básica para un sistema de gestión de tiendas en Telegram, donde proveedores pueden crear y administrar sus tiendas (productos digitales y físicos) y enlazar un Bot de Telegram para que los clientes finales realicen compras directamente en la plataforma de mensajería.

## Características Principales

- **Autenticación de Proveedores**: Registro, inicio de sesión y recuperación de contraseña.  
- **Gestión de Tienda**: Creación y edición de productos (digitales o físicos), actualización de precios, categorías e imágenes.  
- **Integración Bot de Telegram**: Vinculación con la API Key del bot y configuración básica (nombre, foto, mensaje de bienvenida, etc.).  
- **Proceso de Compra en Telegram**: Listado de productos, carrito, confirmación de pedido y notificaciones.  
- **Planes y Precios** (Ejemplo): Versión gratuita (3 productos máximos) y versión de pago (productos ilimitados).  

## Instrucciones de Instalación

1. Asegúrate de tener instalado PHP (>=7.4) y una base de datos MySQL o MariaDB.  
2. Crea una base de datos y actualiza tus credenciales en el archivo `db_connection.php`.  
3. Configura tu servidor web (por ejemplo, Apache o Nginx) apuntando al directorio raíz donde se encuentran estos archivos.  
4. Ejecuta las migraciones (o crea las tablas manualmente) según sea necesario.  
5. Abre tu navegador en la URL correspondiente e ingresa a `index.php` para comenzar.  

## Estructura de Archivos

- **db_connection.php**: Conexión a la base de datos.  
- **index.php**: Página principal, muestra la Landing Page y redirecciona a registro/login.  
- **register.php**: Maneja el registro de nuevos proveedores.  
- **login.php**: Maneja el inicio de sesión y la recuperación de contraseña.  
- **dashboard.php**: Panel de control principal para el proveedor (gestión de productos y Bot de Telegram).  
- **products/**: Módulos para listar, crear y editar productos.  
- **telegram_bot_manager.php**: Lógica para interactuar con la API de Telegram (vinculación de Bot y envío de mensajes).  
- **telegram_webhook.php**: Endpoint para recibir actualizaciones de Telegram (para manejar el flujo de compra).  

¡Disfruta explorando y ampliando este sistema para ajustarlo a tus requerimientos!