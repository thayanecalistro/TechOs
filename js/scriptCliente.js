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

//  FUNÇÃO PAR BUSCA DE CEP 

 function buscarCep(cepId, campos) {
    const cepInput = document.getElementById(cepId); 

    if(!cepInput) return;

    cepInput.addEventListener("blur", function(){
        //remove os traços e espaço vazios, deixansdo somente números
        let cep = this.value.replace(/\D/g, '');

        //valida se o cep possui exatamente 8 números
        if(cep.length === 8){

            //preenche os campos com "..." enquanto carrega
            document.getElementById(campos.endereco).value = "..."; 
            document.getElementById(campos.bairro).value = "...";
            document.getElementById(campos.cidade).value = "..."; 
            document.getElementById(campos.estado).value = "..."; 
            
            //faz a requisição AJAX para a API do viaCEP
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(dados => {
                if(!dados.erro){

                    //preencheos inputs com as informações coletadas
                    document.getElementById(campos.endereco).value = dados.logradouro;
                    document.getElementById(campos.bairro).value = dados.bairro; 
                    document.getElementById(campos.cidade).value = dados.localidade; 
                    document.getElementById(campos.estado).value = dados.uf;

                    //Foca no campo "número" para o usuário continuar o preenchimento
                    document.getElementById(campos.numero).focus();
                } else {
                    alert("CEP não encontrado!");
                    limparCamposEndereco(campos);
                }
            })
            .catch(error => {
                alert("Erro ao buscar o CEP. Verifique sua conexão.");
                limparCamposEndereco(campos);
            });
        }
    });
 }
// função para limpar os campos 
  function limparCamposEndereco(campos) {
    document.getElementById(campos.endereco).value = "";
    document.getElementById(campos.bairro).value = "";
    document.getElementById(campos.cidade).value = ""; 
    document.getElementById(campos.estado).value = "";
  }

//ativa a busca de cep na subtela de cadastro 

buscarCep("cep", {
  endereco: "endereco",
  bairro: "bairro", 
  cidade: "cidade", 
  estado: "estado",
  numero: "numero"
});

//ativa o buscar cep na subtela de alteração 

buscarCep ("alterarCep", {
  endereco: "alterarEndereco", 
  bairro: "alterarBairro",
  cidade: "alterarCidade", 
  estado: "alterarEstado", 
  numero: "alterarNumero"
});


// ----------------------  PARA A SUBTELA DE VISUALIZAÇÃO ---------------
const modalVisualizar = document.getElementById("meuModalVisualizar");
const botaoFecharVisualizar = document.querySelector(".botaoFecharVisualizar"); 

//quando o clique é em qualuqer lugar da tela
document.addEventListener("click", function(event){

    if (event.target.classList.contains("btn-visualizar")) {
        const btn = event.target; 
    

    //preenche os campos com as informações cadastras antes
    document.getElementById("txtId").textContent = btn.getAttribute("data-id") || "---";
    document.getElementById("txtNome").textContent = btn.getAttribute("data-nome") || "---"; 
    document.getElementById("txtCpf").textContent = btn.getAttribute("data-cpf") || "---";
    document.getElementById("txtTelefone").textContent = btn.getAttribute("data-telefone") || "---";
    document.getElementById("txtCep").textContent = btn.getAttribute("data-cep") || "---";
    document.getElementById("txtEndereco").textContent = btn.getAttribute("data-endereco") || "---"; 
    document.getElementById("txtNumero").textContent = btn.getAttribute("data-numero") || "---";
    document.getElementById("txtComplemento").textContent = btn.getAttribute("data-complemento") || "---";
    document.getElementById("txtBairro").textContent = btn.getAttribute("data-bairro") || "---";
    document.getElementById("txtCidade").textContent = btn.getAttribute("data-cidade") || "---"; 
    document.getElementById("txtEstado").textContent = btn.getAttribute("data-estado") || "---";

    modalVisualizar.style.display="block"
    }
});

botaoFecharVisualizar.addEventListener("click", () => {
    modalVisualizar.style.display = "none";
});