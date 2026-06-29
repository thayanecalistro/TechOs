document.addEventListener("DOMContentLoaded", function() {
    
    // ITEM 6: Força o modal nativo e bloqueia status ao interagir com o form
    const formOrcamento = document.getElementById('form-orcamento');
    if (formOrcamento) {
        formOrcamento.addEventListener('click', function(e) {
            const statusSelect = document.getElementById('status');
            if(statusSelect && statusSelect.disabled && !sessionStorage.getItem('avisoMostrado')) {
                const modal = document.getElementById('modal-aviso');
                if (modal) modal.showModal();
                sessionStorage.setItem('avisoMostrado', 'true');
            }
        });
    }

    const btnEditar = document.getElementById('btn-editar');
    if (btnEditar) {
        btnEditar.addEventListener('click', function() {
            const statusSelect = document.getElementById('status');
            const statusHidden = document.getElementById('status_hidden');
            if (statusSelect) statusSelect.disabled = false;
            if (statusHidden) statusHidden.disabled = true; // Libera o select principal para envio
        });
    }

    // ITEM 1: Autocomplete de Clientes
    const inputCliente = document.getElementById('cliente');
    if (inputCliente) {
        inputCliente.addEventListener('input', function() {
            if(this.value.length > 0) {
                fetch(`php/buscar_dados.php?acao=clientes&busca=${this.value}`)
                .then(res => res.json())
                .then(dados => {
                    let html = '';
                    dados.forEach(c => html += `<option value="${c.nomeCliente}" data-id="${c.idCliente}">`);
                    const listaClientes = document.getElementById('lista-clientes');
                    if (listaClientes) listaClientes.innerHTML = html;
                });
            }
        });

        // ITEM 2: Filtra aparelhos baseado no Cliente selecionado
        inputCliente.addEventListener('change', function() {
            const opcao = document.querySelector(`#lista-clientes option[value="${this.value}"]`);
            if(opcao) {
                const idCliente = opcao.getAttribute('data-id');
                const clienteHidden = document.getElementById('cliente_id_hidden');
                if (clienteHidden) clienteHidden.value = idCliente;

                fetch(`php/buscar_dados.php?acao=aparelhos&idCliente=${idCliente}`)
                .then(res => res.json())
                .then(dados => {
                    let html = '<option value="" selected disabled>Selecione o Aparelho...</option>';
                    dados.forEach(a => html += `<option value="${a.idAparelho}">${a.nomeMarca} ${a.nomeModelo}</option>`);
                    const aparelhoSelect = document.getElementById('aparelho');
                    if (aparelhoSelect) aparelhoSelect.innerHTML = html;
                });
            }
        });
    }

    // ITEM 3 e 4: Monitora input de peças e busca valor automático do estoque
    function vincularEventosPeca(elemento) {
        if (!elemento) return;
        const inputPeca = elemento.querySelector('.input-peca');
        const inputValor = elemento.querySelector('.input-valor-peca');

        if (inputPeca) {
            inputPeca.addEventListener('input', function() {
                if(this.value.length > 0) {
                    fetch(`php/buscar_dados.php?acao=pecas&busca=${this.value}`)
                    .then(res => res.json())
                    .then(dados => {
                        let html = '';
                        dados.forEach(p => html += `<option value="${p.peca}" data-preco="${p.valor}">`);
                        const listaPecas = document.getElementById('lista-pecas');
                        if (listaPecas) listaPecas.innerHTML = html;
                    });
                }
            });

            inputPeca.addEventListener('change', function() {
                const opcao = document.querySelector(`#lista-pecas option[value="${this.value}"]`);
                if(opcao && inputValor) {
                    inputValor.value = opcao.getAttribute('data-preco');
                    atualizarSomaTotal();
                }
            });
        }
    }

    // Vincula a primeira linha existente
    const primeiraLinhaPeca = document.querySelector('.peca-row');
    if (primeiraLinhaPeca) {
        vincularEventosPeca(primeiraLinhaPeca);
    }

    // ITEM 5: Clonagem inteligente da linha de peças
    const btnAddPeca = document.getElementById('btn-add-peca');
    if (btnAddPeca) {
        btnAddPeca.addEventListener('click', function() {
            const linhaOriginal = document.querySelector('.peca-row');
            const containerPecas = document.getElementById('container-pecas');
            
            if (linhaOriginal && containerPecas) {
                const novaLinha = linhaOriginal.cloneNode(true);
                
                novaLinha.querySelector('.input-peca').value = '';
                novaLinha.querySelector('.input-valor-peca').value = '';
                novaLinha.querySelector('.input-qtd-peca').value = '1';
                
                containerPecas.appendChild(novaLinha);
                vincularEventosPeca(novaLinha);
            }
        });
    }

    // Lógica de cálculo dinâmico na tela
    function atualizarSomaTotal() {
        let total = 0;
        const valores = document.querySelectorAll('.input-valor-peca');
        const quantidades = document.querySelectorAll('.input-qtd-peca');
        const maoObraInput = document.getElementById('mao_obra');
        const maoObra = maoObraInput ? (parseFloat(maoObraInput.value) || 0) : 0;

        valores.forEach((v, i) => {
            let preco = parseFloat(v.value) || 0;
            let qtd = quantidades[i] ? (parseInt(quantidades[i].value) || 1) : 1;
            total += (preco * qtd);
        });

        total += maoObra;
        const labelTotal = document.getElementById('label-total');
        if (labelTotal) {
            labelTotal.innerText = `Total: R$ ${total.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
        }
    }

    document.addEventListener('input', function(e) {
        if(e.target.classList.contains('input-valor-peca') || e.target.classList.contains('input-qtd-peca') || e.target.id === 'mao_obra') {
            atualizarSomaTotal();
        }
    });

    // ITEM 7: Mecanismo do botão de busca
    const btnBusca = document.getElementById('btn-busca');
    if (btnBusca) {
        btnBusca.addEventListener('click', function() {
            const inputBusca = document.getElementById('input-busca');
            const termo = inputBusca ? inputBusca.value : '';
            
            fetch(`php/buscar_dados.php?acao=filtrar_orcamentos&termo=${termo}`)
            .then(res => res.text())
            .then(html => {
                const corpoTabela = document.getElementById('corpo-tabela');
                if (corpoTabela) corpoTabela.innerHTML = html;
            });
        });
    }

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
});