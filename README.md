# Buscador de Wikipedia

Este es un proyecto de una aplicación web simple que permite a los usuarios buscar artículos en Wikipedia utilizando su API. Los resultados se muestran dinámicamente en la página y las búsquedas se guardan en un historial.

El proyecto está construido con HTML, CSS y JavaScript en el frontend, y utiliza PHP en el backend para comunicarse con la API de Wikipedia.

## ✨ Características

-   **Búsqueda en Wikipedia:** Escribe un término en el campo de búsqueda y presiona "Buscar".
-   **Visualización de resultados:** Los resultados de la búsqueda se muestran dinámicamente en la página principal.
-   **Historial de búsqueda:** Un enlace permite acceder a una página `history.html` para ver las búsquedas anteriores.

## 🚀 Tecnologías Utilizadas

-   **Frontend:**
    -   HTML5
    -   CSS3
    -   JavaScript
-   **Backend:**
    -   PHP (para la lógica del servidor y la comunicación con la API)
-   **API:**
    -   Wikipedia API (MediaWiki)

## 🔧 Instalación y Puesta en Marcha

Para levantar el entorno de desarrollo local, necesitarás tener [Docker](https://www.docker.com/get-started) y [Docker Compose](https://docs.docker.com/compose/install/) instalados en tu máquina.

Sigue estos pasos para poner en marcha la aplicación:

1.  **Levanta los contenedores:**
    Abre una terminal en la raíz del proyecto y ejecuta el siguiente comando. Esto construirá (si es la primera vez) y levantará los servicios de Apache/PHP y MySQL en segundo plano (`-d`). La primera vez que se inicie, también creará la base de datos y la tabla `search_history` automáticamente.
    ```bash
    docker compose up -d
    ```

2.  **Accede a la aplicación:**
    Una vez que los contenedores estén en funcionamiento, puedes acceder al buscador de Wikipedia en tu navegador web:
    > 👉 **http://localhost:8080/**

3.  **Detener la aplicación:**
    Para detener todos los servicios, ejecuta:
    ```bash
    docker compose down
    ```
    Si además quieres eliminar los datos de la base de datos (el volumen persistente), usa el flag `-v`:
    ```bash
    docker compose down -v
    ```