document.addEventListener('DOMContentLoaded', () => {
    const historyContainer = document.getElementById('history-container');


    /**
     * Obtiene el historial desde el servidor y lo muestra en la página.
     */
    async function fetchHistory() {
        try {            const response = await fetch('/php/get_history.php');
            if (!response.ok) {
                throw new Error(`Error en la solicitud: ${response.statusText}`);
            }

            const historyData = await response.json();

            if (historyData.status === 'error') {
                throw new Error(historyData.message);
            }

            displayHistory(historyData);

        } catch (error) {
            console.log(error);
            historyContainer.innerHTML = '<p>No se pudo cargar el historial. Inténtalo de nuevo más tarde.</p>';
        }
    }

    /**
     * Renderiza la lista del historial en el DOM.
     * @param {Array} history - Un array de objetos con el historial.
     */
    function displayHistory(history) {
        if (history.length === 0) {
            historyContainer.innerHTML = '<p>No hay búsquedas recientes en el historial.</p>';
            return;
        }

        const historyList = document.createElement('ul');
        history.forEach(item => {
            const listItem = document.createElement('li');
            listItem.innerHTML = `<span>${item.term}</span><span>${new Date(item.search_timestamp).toLocaleString('es-ES')}</span>`;
            historyList.appendChild(listItem);
        });

        historyContainer.appendChild(historyList);
    }

    fetchHistory();
});
