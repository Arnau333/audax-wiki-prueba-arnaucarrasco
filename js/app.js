document.addEventListener('DOMContentLoaded', () => {

    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search-input');
    const resultsContainer = document.getElementById('results-container');

    searchForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Evita que la página se recargue

        const searchTerm = searchInput.value.trim();
        if (!searchTerm) {
            alert('Por favor, ingresa un término de búsqueda.');
            return;
        }

        // Limpiar resultados anteriores
        resultsContainer.innerHTML = '<p>Buscando...</p>';

        try {
            // 1. Llamada a la API de Wikipedia
            const wikiResponse = await fetch(`https://es.wikipedia.org/w/api.php?action=query&list=search&srsearch=${encodeURIComponent(searchTerm)}&format=json&origin=*`);
            const wikiData = await wikiResponse.json();
            
            displayResults(wikiData.query.search);

            // 2. Guardar la búsqueda en la base de datos (llamada al backend)
            saveSearchTerm(searchTerm);

        } catch (error) {
            console.error('Error al buscar en Wikipedia:', error);
            resultsContainer.innerHTML = '<p>Ocurrió un error al realizar la búsqueda. Inténtalo de nuevo.</p>';
        }
    });

    function displayResults(results) {
        resultsContainer.innerHTML = ''; // Limpiar el mensaje "Buscando..."

        if (results.length === 0) {
            resultsContainer.innerHTML = '<p>No se encontraron resultados para tu búsqueda.</p>';
            return;
        }

        results.forEach(result => {
            const resultElement = document.createElement('div');
            resultElement.className = 'result-item';
            resultElement.innerHTML = `
                <h3>
                    <a href="https://es.wikipedia.org/?curid=${result.pageid}" target="_blank">
                        ${result.title}
                    </a>
                </h3>
                <div>${result.snippet}</div>
            `;
            resultsContainer.appendChild(resultElement);
        });
    }

    async function saveSearchTerm(term) {
        try {
            await fetch('/php/save_search.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `term=${encodeURIComponent(term)}`
            });
        } catch (error) {
            console.error('Error al guardar el término de búsqueda:', error);
        }
    }
});
