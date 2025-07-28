<?php
// Incluir la configuración de la base de datos
require_once __DIR__ . '/db_config.php';


// Verificar que la solicitud sea de tipo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    exit();
}

// Verificar que el término de búsqueda fue enviado
if (!isset($_POST['term'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Término no proporcionado.']);
    exit();
}

// Sanear y validar el término de búsqueda.
// Nota: El uso de sentencias preparadas con PDO (más abajo) ya es la protección principal y más efectiva contra inyecciones SQL.
// Estas validaciones adicionales son buenas prácticas para asegurar la calidad de los datos.

// 1. Eliminar espacios en blanco al inicio y al final.
$searchTerm = trim($_POST['term']);

// 2. Validar que el término no esté vacío después de limpiar y no sea demasiado largo.
if (empty($searchTerm) || strlen($searchTerm) > 255) { // Ajusta 255 al límite de tu columna en la BD.
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Término de búsqueda inválido.']);
    exit();
}

// Configuración de DSN para PDO
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Crear una nueva instancia de PDO
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

    // Preparar la consulta SQL para evitar inyecciones SQL
    $sql = "INSERT INTO search_history (term) VALUES (?)";
    $stmt = $pdo->prepare($sql);

    // Ejecutar la consulta con el término de búsqueda
    $stmt->execute([$searchTerm]);

    // Enviar una respuesta de éxito
    http_response_code(201); // Created
    echo json_encode(['status' => 'success', 'message' => 'Búsqueda guardada.']);

} catch (PDOException $e) {
    // Manejar errores de la base de datos
    http_response_code(500); // Internal Server Error
    // En un entorno de producción, no deberías mostrar el error detallado al cliente
    // error_log($e->getMessage()); // Guardar el error en un log del servidor
    echo json_encode(['status' => 'error', 'message' => 'Error al conectar o guardar en la base de datos.']);
}
?>
