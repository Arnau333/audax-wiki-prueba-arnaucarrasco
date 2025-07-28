<?php
// Incluir la configuración de la base de datos
require_once __DIR__ . '/db_config.php';


// Verificar que la solicitud sea de tipo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    exit();
}

// Verificar que el término de búsqueda fue enviado
if (!isset($_POST['term']) || empty($_POST['term'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Término no proporcionado.']);
    exit();
}

$searchTerm = $_POST['term'];

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
