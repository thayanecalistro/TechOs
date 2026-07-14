// Selecionando elementos em html 
const modal = document.getElementById("meuModal"); 
const botaoAbrir = document.getElementById("botaoAbrir"); 
const botaoFechar = document.querySelector(".botaoFechar"); 

// função para abrir a subtela 
botaoAbrir.addEventListener("click", () => {
    modal.style.display="block"; 
}); 

//função para fechar a subtela ao clicar no "X"
botaoFechar.addEventListener("click", () => {
   modal.style.display="none"; 
});

//função para fechar a subtela ao clicar fora da tela 
window.addEventListener("click", (event) => {
    if (event.target === modal){
        modal.style.display = "none"; 
    }
}); 

// ----------------------  PARA A SUBTELA PARA ALTERAÇÃO ---------------
const modalAlterar = document.getElementById("meuModalAlterar");
const botaoFecharAlterar = document.querySelector(".botaoFecharAlterar"); 

//quando o clique é em qualuqer lugar da tela
document.addEventListener("click", function(event){

    if (event.target.classList.contains("btn-alterar")) {
        const btn = event.target; 
    

    //preenche os campos com as informações cadastras antes
    document.getElementById("alterarId").value = btn.getAttribute("data-id");
    modalAlterar.querySelector("input[name='nNome']").value = btn.getAttribute("data-nome"); 
    modalAlterar.querySelector("input[name='nCpf']").value = btn.getAttribute("data-cpf");
    modalAlterar.querySelector("input[name='nTelefone']").value = btn.getAttribute("data-telefone");
    modalAlterar.querySelector("input[name='nCep']").value = btn.getAttribute("data-cep");
    modalAlterar.querySelector("input[name='nEndereco']").value = btn.getAttribute("data-endereco"); 
    modalAlterar.querySelector("input[name='nNumero']").value = btn.getAttribute("data-numero");
    modalAlterar.querySelector("input[name='nComplemento']").value = btn.getAttribute("data-complemento");
    modalAlterar.querySelector("input[name='nBairro']").value = btn.getAttribute("data-bairro");
    modalAlterar.querySelector("input[name='nCidade']").value = btn.getAttribute("data-cidade"); 
    modalAlterar.querySelector("input[name='nEstado']").value = btn.getAttribute("data-estado");

    modalAlterar.style.display="block"
    }
});

botaoFecharAlterar.addEventListener("click", () => {
    modalAlterar.style.display = "none";
});

document.addEventListener("click", function(event) {
   if (event.target.classList.contains("btn-apagar") || event.target.closest(".btn-apagar")){
    const botao = event.target.classList.contains("btn-apagar") ? event.target : event.target.closest("btn-apagar");
    const idCliente = botao.getAttribute("data-id"); 

    const confirmou = confirm("Tem certeza que deseja excluir esse cliente? Esta ação não pode ser desfeita."); 

    if (confirmou){
        window.location.href = "php/salvarCliente.php?opcao=D&nIdCliente=" + idCliente; 
    }
   }

});

