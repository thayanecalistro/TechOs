document.addEventListener("DOMContentLoaded", function() {
    
    // --- LÓGICA DO MODAL: NOVO APARELHO ---
    const modalNovo = document.getElementById("modalAparelho");
    const btnAbrirNovo = document.getElementById("btnAbrirNovo");
    const btnFecharNovo = document.getElementById("btnFecharNovo");
    const btnCancelarNovo = document.getElementById("btnCancelarNovo");

    if (btnAbrirNovo && modalNovo) {
        btnAbrirNovo.addEventListener("click", () => modalNovo.style.display = "flex");
    }
    
    const fecharModalNovo = () => { if (modalNovo) modalNovo.style.display = "none"; };
    if (btnFecharNovo) btnFecharNovo.addEventListener("click", fecharModalNovo);
    if (btnCancelarNovo) btnCancelarNovo.addEventListener("click", fecharModalNovo);

    // --- LÓGICA DO MODAL: ALTERAR APARELHO ---
    const modalAlterar = document.getElementById("modalAlterarAparelho");
    const btnFecharAlterar = document.getElementById("btnFecharModalAlterar");
    const btnCancelarAlterar = document.getElementById("btnCancelarAlterar");

    const fecharModalAlterar = () => { if (modalAlterar) modalAlterar.style.display = "none"; };
    if (btnFecharAlterar) btnFecharAlterar.addEventListener("click", fecharModalAlterar);
    if (btnCancelarAlterar) btnCancelarAlterar.addEventListener("click", fecharModalAlterar);

    // --- BOTÕES DA TABELA: ALTERAR ---
    const botoesAlterar = document.querySelectorAll(".btn-alterar");
    botoesAlterar.forEach(botao => {
        botao.addEventListener("click", function(e) {
            e.preventDefault();
            const id = this.getAttribute("data-id");
            const cliente = this.getAttribute("data-cliente");
            const marca = this.getAttribute("data-marca");
            const modelo = this.getAttribute("data-modelo");
            const imei = this.getAttribute("data-imei");

            if (modalAlterar) {
                document.getElementById("alt_id").value = id;
                document.getElementById("alt_cliente").value = cliente;
                document.getElementById("alt_marca").value = marca;
                document.getElementById("alt_modelo").value = modelo;
                document.getElementById("alt_imei").value = imei;

                document.getElementById("formAlterar").action = "php/salvarAparelho.php?opcao=U&id=" + id;
                modalAlterar.style.display = "flex";
            }
        });
    });

    // --- LÓGICA DO MODAL: EXCLUIR APARELHO ---
    const modalExcluir = document.getElementById("modalExcluirAparelho");
    const btnFecharExcluir = document.getElementById("btnFecharModalExcluir");
    const btnNaoExcluir = document.getElementById("btnNaoExcluir");
    const btnSimExcluir = document.getElementById("btnSimExcluir");

    const fecharModalExcluir = () => { if (modalExcluir) modalExcluir.style.display = "none"; };
    
    // Fecha o modal ao clicar no 'X' ou no botão "Não"
    if (btnFecharExcluir) btnFecharExcluir.addEventListener("click", fecharModalExcluir);
    if (btnNaoExcluir) btnNaoExcluir.addEventListener("click", fecharModalExcluir);

    // --- BOTÕES DA TABELA: EXCLUIR ---
    const botoesExcluir = document.querySelectorAll(".btn-excluir");
    botoesExcluir.forEach(botao => {
        botao.addEventListener("click", function(e) {
            e.preventDefault(); // Impede qualquer ação nativa indesejada
            const id = this.getAttribute("data-id");
            if (modalExcluir) {
                // Configura o link do botão "Sim, Excluir"
                btnSimExcluir.href = "php/salvarAparelho.php?opcao=D&id=" + id;
                modalExcluir.style.display = "flex";
            } else {
                console.error("ERRO: O HTML do modal de exclusão não foi encontrado na página.");
            }
        });
    });

    // --- LÓGICA DE PESQUISA (FILTRO NA TABELA) ---
    const inputPesquisar = document.getElementById('pesquisar');
    const btnBuscar = document.getElementById('btnBuscar');

    function filtrarTabela() {
        if (!inputPesquisar) return; 

        const termoBusca = inputPesquisar.value.toLowerCase().trim().replace('#', '');
        const linhasTabela = document.querySelectorAll('table tbody tr'); 

        linhasTabela.forEach(linha => {
            const colunas = linha.querySelectorAll('td');
            
            if (colunas.length >= 2) {
                const idDaLinha = colunas[0].textContent.toLowerCase().replace('#', '').trim();
                const nomeCliente = colunas[1].textContent.toLowerCase();

                if (termoBusca === "" || idDaLinha === termoBusca || nomeCliente.includes(termoBusca)) {
                    linha.style.display = ''; 
                } else {
                    linha.style.display = 'none'; 
                }
            }
        });
    }

    if (btnBuscar) {
        btnBuscar.addEventListener('click', function(e) {
            e.preventDefault(); 
            filtrarTabela();
        });
    }

    if (inputPesquisar) {
        inputPesquisar.addEventListener('keyup', filtrarTabela);
    }
});