<?php
/**
 * Módulo para interactuar con la API de Telegram.
 * Incluye funciones para enviar mensajes, configurar menús, etc.
 */

function enviarMensajeTelegram($apiKey, $chatId, $texto) {
    if (empty($apiKey) || empty($chatId) || empty($texto)) {
        return false;
    }

    $url = "https://api.telegram.org/bot{$apiKey}/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $texto,
        'parse_mode' => 'HTML'
    ];

    $options = [
        'http' => [
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ]
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return !empty($result);
}

/**
 * Otras funciones para menús, inline keyboards, etc.
 * Ejemplo de uso futuro: enviarMensajeTelegram($proveedor['api_key_telegram'], $chatId, "Bienvenido a la tienda...");
 */
?>