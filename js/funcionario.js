document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById("meuModal");
    var btnAbrir = document.getElementById("botaoAbrir");
    var btnFechar = document.getElementsByClassName("botaoFechar")[0];

    // Abre a modal ao clicar no botão de Novo Funcionário
    btnAbrir.onclick = function() {
        modal.style.display = "block";
    }

    // Fecha a modal ao clicar no X
    btnFechar.onclick = function() {
        modal.style.display = "none";
    }

    // Fecha se o usuário clicar em qualquer área fora do formulário
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});