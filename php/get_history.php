<?php
// Indicar que la respuesta es en formato JSON
header('Content-Type: application/json');
require_once __DIR__ . '/db_config.php';

try {

    // Configuración de DSN para PDO
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    // Crear una nueva instancia de PDO
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
    // Preparar la consulta para obtener los últimos 10 registros
    $sql = "SELECT term, search_timestamp FROM search_history ORDER BY search_timestamp DESC LIMIT 10";
    $stmt = $pdo->query($sql);
    
    // Obtener todos los resultados
    $history = $stmt->fetchAll();
    
    // Devolver los resultados como JSON
    echo json_encode($history);
    
} catch (Throwable $e) { // Usamos Throwable para capturar cualquier tipo de error (PHP 7+)
    http_response_code(500); // Internal Server Error
    // Devolvemos un mensaje de error genérico en formato JSON
    // Es buena práctica registrar el error real para depuración, sin exponerlo al cliente.
    error_log($e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Ocurrió un error en el servidor al intentar obtener el historial.']);
}
?>
