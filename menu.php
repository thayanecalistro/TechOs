<!DOCTYPE html>


<html lang="pt-br">
    <head>
        <title>Menu lateral com submenus</title>
        <meta charsed="UTF-8">

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 
        <!--ICONES-->
        <link rel="stylesheet" 
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
        
        
        <!--JQUERY-->
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        
        <!--MEU ESTILO-->
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>

    <body>
        <div class="btnAbre"><span class="material-symbols-outlined">menu</span>
        </div>
        <!--<script src="js/novo.js"></script>-->
        <nav class="menuLateral">
            <div class="titulo">Meu site <span class="material-icons btnFecha">close</span></div>
            <ul>
                <li><a href="#" class="link-menu" data-file="dashboard.html">Dashboard</a></li>
                <li><a href="#" class="link-menu" data-file="os.html">Ordem de Servico</a></li>
                <li><a href="#" class="link-menu" data-file="orcamento.html">Orcamento</a></li>
                <li><a href="#" class="sudeste">Cliente<span class="material-icons seta1">arrow_right</span></a>
                    <ul class="itensSudeste">
                        <li><a href="#" class="link-menu" data-tela="tela-clientes">Gerenciar Lista</a></li>
                        <li><a href="#">Aparelho</a></li>
                    </ul>
                </li>
                <li><a href="#" class="nordeste">Funcionario<span class="material-icons seta2">arrow_right</span> </a>
                    <!--PARA SUBMENU-->
                    <ul class="itensNordeste">
                        <li><a href="#">Pernambuco</a></li>
                        <li><a href="#">Maranhão</a></li>
                        <li><a href="#">Sergipe</a></li>
                        <li><a href="#">Bahia</a></li>
                    </ul>             
                </li>
                <li><a href="#" class="link-menu" data-tela="tela-estoque">Estoque</a></li>
            </ul>           
        </nav>

        <main class="conteudo-principal" id="conteudo">
            
<!--            <section id="tela-dashboard" class="tela ativa">
                <h1>Bem-vindo ao Dashboard</h1>
                <div class="cards">
                    <div class="card"><h3>Vendas</h3><p>R$ 15.000</p></div>
                    <div class="card"><h3>Clientes</h3><p>120</p></div>
                    <div class="card"><h3>Alertas</h3><p>3 pendentes</p></div>
                </div>
            </section>
    
            <section id="tela-orcamento" class="tela">
                <h1>Orçamentos</h1>
                <p>Gerencie aqui seus orçamentos pendentes e aprovados.</p>
            </section>
    
            <section id="tela-os" class="tela">
                <h1>Ordens de Serviço</h1>
                <p>Lista de serviços em execução.</p>
            </section>-->
    
        </main>

        <script type="text/javascript" src="js/menu.js"></script>
          
    </body>

</html>