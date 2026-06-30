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

const modalAlterar = document.getElementById("meuModalAlterar"); 
const botaoFecharAlterar = document.querySelector(".botaoFecharAlterar"); 

  function abrirModalAlterar(idCliente){
     
    document.getElementById("alterarID").value= idCliente;

    ModalAlterar.style.display = "block"; 

  }

botaoFecharAlterar.addEventListener("click", () => {
    modal.style.display="none"; 
})