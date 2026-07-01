// Selecionando elementos do Modal de Cadastro
const modalCadastro = document.getElementById("meuModal"); 
const botaoAbrir = document.getElementById("botaoAbrir"); 
const botaoFechar = document.getElementById("botaoFechar"); 

// Selecionando elementos do Modal de Alteração
const modalAlterar = document.getElementById("meuModalAlterar"); 
const botaoFecharAlterar = document.getElementById("botaoFecharAlterar"); 

// Abrir modal de cadastro
botaoAbrir.addEventListener("click", () => {
    modalCadastro.style.display = "flex"; 
}); 

// Fechar modal de cadastro
botaoFechar.addEventListener("click", () => {
    modalCadastro.style.display = "none"; 
    document.getElementById("formCadastroCliente").reset();
});

// Abrir modal de alteração (Chamado pelo botão "Editar" na tabela)
function abrirModalAlterar(idCliente) {
    document.getElementById("alterarId").value = idCliente;
    modalAlterar.style.display = "flex"; 
}

// Fechar modal de alteração
botaoFecharAlterar.addEventListener("click", () => {
    modalAlterar.style.display = "none"; 
    document.getElementById("formAlterarCliente").reset();
});

// Fechar qualquer modal de forma amigável ao clicar na área escura (overlay)
window.addEventListener("click", (event) => {
    if (event.target === modalCadastro) {
        modalCadastro.style.display = "none"; 
        document.getElementById("formCadastroCliente").reset();
    }
    if (event.target === modalAlterar) {
        modalAlterar.style.display = "none"; 
        document.getElementById("formAlterarCliente").reset();
    }
});