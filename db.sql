-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS wikipedia_searcher;

-- Usar la base de datos recién creada
USE wikipedia_searcher;

-- Crear la tabla para el historial de búsquedas
CREATE TABLE IF NOT EXISTS search_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    term VARCHAR(255) NOT NULL,
    search_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
