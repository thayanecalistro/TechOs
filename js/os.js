document.addEventListener('DOMContentLoaded', () => {
    const campoPesquisar = document.getElementById('pesquisar');
    const btnBuscar = document.getElementById('btnBuscar');
    const ordenarSelect = document.getElementById('ordenarSelect');
    const tableBody = document.querySelector('#osTable tbody');
    const btnExcluir = document.getElementById('btnExcluir');
    
    // Elementos do modal de status
    const statusModal = document.getElementById('statusModal');
    const btnFecharStatusModal = document.getElementById('btnFecharStatusModal');
    const statusIdOs = document.getElementById('statusIdOs');
    const modalNovoStatus = document.getElementById('modalNovoStatus');

    const confirmModal = document.getElementById('confirmModal');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDelete');
    const modalMessage = document.getElementById('modalMessage');

    let selectedRow = null;
    let orderAsc = true;

    // 1. Pesquisa por ID ou Nome (Filtra ao clicar no botão ou dar enter)

    function filtrarTabela() {
        const termo = campoPesquisar.value.toLowerCase().trim();
        const linhasTabela = document.querySelectorAll("#orcamentoTable tbody tr");

        linhasTabela.forEach(linha => {
            // Ignora linhas que sejam de "Nenhum orçamento cadastrado"
            if (linha.cells.length < 2) return; 

            // Pega o texto do ID (Coluna 1) e do Cliente (Coluna 2)
            const idTexto = linha.cells[0] ? linha.cells[0].innerText.toLowerCase().trim() : "";
            const clienteTexto = linha.cells[1] ? linha.cells[1].innerText.toLowerCase().trim() : "";
            
            // Se o termo estiver contido no ID ou no Nome do Cliente, exibe a linha
            if (idTexto.includes(termo) || clienteTexto.includes(termo)) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        });
    }

    // Filtra tanto ao digitar (tempo real) quanto ao clicar no botão "Buscar"
    if (campoPesquisar) campoPesquisar.addEventListener("input", filtrarTabela);
    if (btnBuscar) btnBuscar.addEventListener("click", filtrarTabela);

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
        // Ignora se o duplo clique foi em cima do botão do status
        if (e.target.classList.contains('badge-status-btn')) return;

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

    // =========================================================================
    // EVENTO DE CLIQUE NA BADGE DE STATUS PARA EXIBIÇÃO DO MODAL
    // =========================================================================
    tableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('badge-status-btn')) {
            const linha = e.target.closest('tr');
            if (!linha) return;

            const idOS = linha.getAttribute('data-id');
            const statusAtual = linha.getAttribute('data-status');

            if (idOS && statusModal) {
                // Alimenta os campos ocultos do modal
                statusIdOs.value = idOS;
                if (modalNovoStatus) {
                    modalNovoStatus.value = statusAtual;
                }
                // Exibe o modal na tela
                statusModal.style.display = 'flex';
            }
        }
    });

    // Fecha o modal de alteração de status
    if (btnFecharStatusModal) {
        btnFecharStatusModal.addEventListener('click', () => {
            statusModal.style.display = 'none';
        });
    }

    // 4. Modal de Confirmação e Exclusão
    btnExcluir.addEventListener('click', () => {
        if (!selectedRow) {
            alert('Dê um duplo clique em um item da tabela para selecioná-lo primeiro.');
            return;
        }
        const idOS = selectedRow.cells[0].textContent;
        const clienteOS = selectedRow.cells[3].textContent;
        
        modalMessage.innerHTML = 'Tem certeza que deseja excluir a OS #${idOS} do cliente ${clienteOS}?';
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