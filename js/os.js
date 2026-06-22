document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('pesquisar');
    const btnBuscar = document.getElementById('btnBuscar');
    const ordenarSelect = document.getElementById('ordenarSelect');
    const tableBody = document.querySelector('#osTable tbody');
    const btnExcluir = document.getElementById('btnExcluir');
    
    const confirmModal = document.getElementById('confirmModal');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDelete');
    const modalMessage = document.getElementById('modalMessage');

    let selectedRow = null;
    let orderAsc = true;

    // 1. Pesquisa por ID ou Nome (Filtra ao clicar no botão ou dar enter)
    function filtrarTabela() {
        const query = searchInput.value.toLowerCase().trim();
        const rows = tableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const id = row.cells[0].textContent.toLowerCase();
            const cliente = row.cells[3].textContent.toLowerCase();

            if (id.includes(query) || cliente.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    btnBuscar.addEventListener('click', filtrarTabela);
    searchInput.addEventListener('keypress', (e) => { if(e.key === 'Enter') filtrarTabela(); });

    // 2. Ordenação Alternada por ID ou Nome
    ordenarSelect.addEventListener('change', () => {
        const criterio = ordenarSelect.value;
        if (!criterio) return;

        const rows = Array.from(tableBody.querySelectorAll('tr'));

        rows.sort((rowA, rowB) => {
            let valA = rowA.cells[criterio === 'id' ? 0 : 3].textContent.trim();
            let valB = rowB.cells[criterio === 'id' ? 0 : 3].textContent.trim();

            if (criterio === 'id') {
                return orderAsc ? parseInt(valA) - parseInt(valB) : parseInt(valB) - parseInt(valA);
            } else {
                return valA.localeCompare(valB) * (orderAsc ? 1 : -1);
            }
        });

        rows.forEach(row => tableBody.appendChild(row));
        orderAsc = !orderAsc; // Inverte para o próximo clique ordenar invertido
        ordenarSelect.value = ""; // Reseta o select para permitir re-cliques
    });

    // 3. Duplo Clique para Seleção
    tableBody.addEventListener('dblclick', (e) => {
        const targetRow = e.target.closest('tr');
        if (!targetRow) return;

        if (targetRow === selectedRow) {
            targetRow.classList.remove('selected-row');
            selectedRow = null;
        } else {
            if (selectedRow) selectedRow.classList.remove('selected-row');
            targetRow.classList.add('selected-row');
            selectedRow = targetRow;
        }
    });

    // 4. Modal de Confirmação e Exclusão
    btnExcluir.addEventListener('click', () => {
        if (!selectedRow) {
            alert('Dê um duplo clique em um item da tabela para selecioná-lo primeiro.');
            return;
        }
        const idOS = selectedRow.cells[0].textContent;
        const clienteOS = selectedRow.cells[3].textContent;
        
        modalMessage.innerHTML = 
        confirmModal.style.display = 'flex';
    });

    // Executa a exclusão visual da linha
    confirmDelete.addEventListener('click', () => {
        if (selectedRow) {
            selectedRow.remove();
            selectedRow = null;
        }
        confirmModal.style.display = 'none';
    });

    // Fecha o modal sem deletar
    cancelDelete.addEventListener('click', () => {
        confirmModal.style.display = 'none';
    });
});