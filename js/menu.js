$(document).ready(function() {
    // Carrega o dashboard por padrão ao abrir a página
   $('#conteudo').load('dashboard.html');

    $('.link-menu').click(function(e) {
        e.preventDefault();

        // 1. Pega o nome do arquivo que deve ser carregado
        const arquivo = $(this).data('file');

        // 2. Faz a "mágica": carrega o conteúdo do arquivo dentro da main
        if(arquivo) {
            $('#conteudo').load(arquivo, function(response, status, xhr) {
                if (status == "error") {
                    $('#conteudo').html("<h2>Erro ao carregar página: " + xhr.status + "</h2>");
                }
            });
        }

        // 3. Opcional: Fecha o menu lateral no mobile após clicar
        if ($(window).width() < 768) {
            $('.menuLateral').removeClass('mostra');
        }
    });
});

/*$(document).ready(function() {
    // Isso carrega o dashboard assim que a página abre
    $('#conteudo').load('dashboard.html'); 

    $('.link-menu').click(function(e) {
        e.preventDefault();
        const arquivo = $(this).data('file'); // Pega "dashboard.html"
        
        if(arquivo) {
            $('#conteudo').load(arquivo); // Substitui o conteúdo da <main id="conteudo">
        }
    });
});*/


$('.nordeste').click (function(){
    $('.menuLateral ul .itensNordeste').toggleClass('mostra');
});

$('.sudeste').click (function(){
    $('.menuLateral ul .itensSudeste').toggleClass('mostra');
});

$('.btnAbre').click (function(){
    $('.menuLateral').toggleClass('mostra');
});

$('.btnFecha').click (function(){
    $('.menuLateral').toggleClass('mostra');
});

$('.sudeste').mouseover(function(){
    $('.menuLateral ul .seta1').toggleClass('gira');
});

$('.sudeste').mouseout(function(){
    $('.menuLateral ul .seta1').toggleClass('gira');
});

$('.nordeste').mouseover(function(){
    $('.menuLateral ul .seta2').toggleClass('gira');
});

$('.nordeste').mouseout(function(){
    $('.menuLateral ul .seta2').toggleClass('gira');
});

const $menuLateral = $('.menuLateral');
$(document).mouseup (e => {
    if(!$menuLateral.is(e.target)
       && $menuLateral.has(e.target).length === 0)
    {
        $menuLateral.removeClass('mostra');
    }
});

