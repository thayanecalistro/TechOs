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
    document.getElementById("alterarTipo").value = btn.getAttribute("data-tipo"); 
    document.getElementById("alterarNome").value = btn.getAttribute("data-nome"); 
    document.getElementById("alterarCpf").value = btn.getAttribute("data-cpf");
    document.getElementById("alterarEmail").value = btn.getAttribute("data-email");
    document.getElementById("alterarTelefone").value = btn.getAttribute("data-telefone");
    document.getElementById("alterarCep").value = btn.getAttribute("data-cep");
    document.getElementById("alterarEndereco").value = btn.getAttribute("data-endereco"); 
    document.getElementById("alterarNumero").value = btn.getAttribute("data-numero");
    document.getElementById("alterarComplemento").value = btn.getAttribute("data-complemento");
    document.getElementById("alterarBairro").value = btn.getAttribute("data-bairro");
    document.getElementById("alterarCidade").value = btn.getAttribute("data-cidade"); 
    document.getElementById("alterarEstado").value = btn.getAttribute("data-estado");
    document.getElementById("alterarLogin").value = btn.getAttribute("data-login");
    document.getElementById("alterarSenha").value = btn.getAttribute("data-senha");


    modalAlterar.style.display="block"
    }
});

botaoFecharAlterar.addEventListener("click", () => {
    modalAlterar.style.display = "none";
});

document.addEventListener("click", function(event) {
   if (event.target.classList.contains("btn-apagar") || event.target.closest(".btn-apagar")){
    const botao = event.target.classList.contains("btn-apagar") ? event.target : event.target.closest("btn-apagar");
    const idFuncionario = botao.getAttribute("data-id"); 

    const confirmou = confirm("Tem certeza que deseja excluir esse cliente? Esta ação não pode ser desfeita."); 

    if (confirmou){
        window.location.href = "php/salvarFuncionario.php?opcao=D&idFuncionario=" + idFuncionario; 
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
