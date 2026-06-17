document.addEventListener("DOMContentLoaded", function() {
    
    // --- LÓGICA DO MODAL: NOVO APARELHO ---
    const modalNovo = document.getElementById("modalAparelho");
    const btnAbrirNovo = document.getElementById("btnAbrirModal");
    const btnFecharNovo = document.getElementById("btnFecharModal");
    const btnCancelarNovo = document.getElementById("btnCancelar");

    if(btnAbrirNovo) btnAbrirNovo.addEventListener("click", () => modalNovo.style.display = "flex");
    const fecharModalNovo = () => modalNovo.style.display = "none";
    if(btnFecharNovo) btnFecharNovo.addEventListener("click", fecharModalNovo);
    if(btnCancelarNovo) btnCancelarNovo.addEventListener("click", fecharModalNovo);

    // --- LÓGICA DO MODAL: ALTERAR APARELHO ---
    const modalAlterar = document.getElementById("modalAlterarAparelho");
    const btnFecharAlterar = document.getElementById("btnFecharModalAlterar");
    const btnCancelarAlterar = document.getElementById("btnCancelarAlterar");

    const fecharModalAlterar = () => modalAlterar.style.display = "none";
    if(btnFecharAlterar) btnFecharAlterar.addEventListener("click", fecharModalAlterar);
    if(btnCancelarAlterar) btnCancelarAlterar.addEventListener("click", fecharModalAlterar);

    // Fechar modais ao clicar fora da caixa branca
    window.addEventListener("click", (e) => {
        if (e.target === modalNovo) fecharModalNovo();
        if (e.target === modalAlterar) fecharModalAlterar();
    });

    // --- BOTÕES DA TABELA: ALTERAR ---
    const botoesAlterar = document.querySelectorAll(".btn-alterar");
    botoesAlterar.forEach(botao => {
        botao.addEventListener("click", function() {
            // Pega os dados escondidos no botão
            const id = this.getAttribute("data-id");
            const cliente = this.getAttribute("data-cliente");
            const marca = this.getAttribute("data-marca");
            const modelo = this.getAttribute("data-modelo");
            const imei = this.getAttribute("data-imei");

            // Injeta os dados nos inputs do formulário de Alteração
            document.getElementById("alt_id").value = id;
            document.getElementById("alt_cliente").value = cliente;
            document.getElementById("alt_marca").value = marca;
            document.getElementById("alt_modelo").value = modelo;
            document.getElementById("alt_imei").value = imei;

            // Atualiza a URL do formulário para passar a opção U (Update) e o ID na URL
            document.getElementById("formAlterar").action = "php/salvarAparelho.php?opcao=U&id=" + id;

            // Exibe o modal
            modalAlterar.style.display = "flex";
        });
    });

    // --- BOTÕES DA TABELA: EXCLUIR ---
    const botoesExcluir = document.querySelectorAll(".btn-excluir");
    botoesExcluir.forEach(botao => {
        botao.addEventListener("click", function() {
            const id = this.getAttribute("data-id");
            
            // Cria um alerta nativo do navegador para confirmar
            if (confirm("Tem certeza que deseja excluir o aparelho ID " + id + "?")) {
                // Se o usuário clicar em "Sim", redireciona para a rota de Delete
                window.location.href = "php/salvarAparelho.php?opcao=D&id=" + id;
            }
        });
    });

});