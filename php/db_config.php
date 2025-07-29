<?php

// Lee la variable de entorno 'DB_HOST' y la define como la constante 'DB_HOST'
define('DB_HOST', getenv('DB_HOST'));
define('DB_NAME', getenv('DB_DATABASE'));
define('DB_USER', getenv('DB_USERNAME'));
define('DB_PASS', getenv('DB_PASSWORD'));
define('DB_CHARSET', 'utf8mb4');
?>

