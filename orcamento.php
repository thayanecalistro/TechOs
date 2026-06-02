<!DOCTYPE html>

<html>
    <head>
        <title>Orcamento</title>
        <meta charsed="UTF-8">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
        <style>
            body { 
                background-color: #2c3e50; 
                color: white; 
                font-family: sans-serif;
            } 
            .sidebar { 
                background-color: #34495e; 
                min-height: 100vh; 
                padding: 20px; 
            }
            .main-card { 
                border: 1px solid #3498db; 
                padding: 20px; 
                border-radius: 5px; 
                margin-top: 20px; 
                background-color: rgba(0,0,0,0.1);
            }
            .form-label { 
                margin-bottom: 2px; 
                font-size: 0.9rem; 
            }
            .form-control, .form-select {
                background-color: #34495e;
                border: 1px solid #5d6d7e;
                color: white;
            }
            .form-control:focus { 
                background-color: #3e5871; 
                color: white; 
                border-color: #3498db; 
            }
            .total-label { 
                font-size: 1.2rem; 
                font-weight: bold; 
                margin-top: 15px; 
                display: block; 
            }
            legend { 
                width: auto; 
                padding: 0 10px; 
                font-size: 1.1rem; 
                color: #3498db; 
                border: none; 
            }
            fieldset { 
                border: 1px solid #3498db !important; 
                padding: 15px !important; 
                border-radius: 8px; 
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 p-4">
                    <fieldset>
                        <legend>Novo Orçamento</legend>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Cliente:</label>
                                <input type="text" list="lista-clientes" id="cliente" class="form-control" 
                                    placeholder="Carregando clientes...">
                                <datalist id="lista-clientes">
                                    <!--código JS-->
                                </datalist>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Aparelho:</label>
                                <input type="text" list="lista-aparelhos" id="aparelho" class="form-control"
                                    placeholder="Carregando clientes...">
                                <datalist id="lista-aparelhos">
                                    <!--código JS-->
                                </datalist>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Diagnóstico:</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Peça necessária:</label>
                                <select class="form-select" id="peca">
                                    <option selected>Selecione...</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Valor Peça (R$):</label>
                                <input type="number" class="form-control" placeholder="0.00">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Qtd:</label>
                                <input type="number" class="form-control" value="1">
                            </div>
        
                            <div class="col-12">
                                <button type="button" class="btn btn-primary btn-sm">+ Peça</button>
                            </div>
        
                            <div class="col-md-4">
                                <label class="form-label">Mão de Obra (R$):</label>
                                <input type="number" class="form-control" placeholder="0.00">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status:</label>
                                <select class="form-select" id="status">
                                    <option value="aberto" selected>Aberto</option>
                                    <option value="aprovado">Aprovado</option>
                                    <option value="recusado">Recusado</option>
                                </select>
                            </div>

                        </div>
                        <div class="mt-4">
                            <button type="button" class="btn btn-success">Salvar</button>
                            <button type="button" class="btn btn-warning">Editar</button>
                            <button type="button" class="btn btn-danger">Excluir</button>
                        </div>
                        <label class="total-label">Total: R$ 0.00<!--código PHP--></label>
                    </fieldset>

                    <div class="mt-5">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Pesquisar...">
                                    <button class="btn btn-primary">Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-dark table-hover table-sm border-secondary">
                            <thead>
                              <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Aparelho</th>
                                <th scope="col">Peça</th>
                                <th scope="col">Valor Unitário</th>
                                <th scope="col">Mão de Obra</th>
                                <th scope="col">Total(R$)</th>
                                <th scope="col">Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Iphone</td>
                                <td>Tela</td>
                                <td>25,50</td>
                                <td>50,00</td>
                                <td>75,50</td>
                                <td>Aberto</td>
                              </tr>
                              <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Xiaomi</td>
                                <td>Bateria</td>
                                <td>69,99</td>
                                <td>50,00</td>
                                <td>119,99</td>
                                <td>Aberto</td>
                              </tr>
                              <tr>
                                <th scope="row">3</th>
                                <td>Otto</td>
                                <td>Samsung</td>
                                <td>Tela</td>
                                <td>20,99</td>
                                <td>50,00</td>
                                <td>70,99</td>
                                <td>Aprovado</td>
                              </tr>
                          <!--EXEMPLO DE UMA LINHA SÓ---------------------
                              <tr class="table-success text-dark">
                                <td>8</td>
                                <td>Luana</td>
                                <td>Apple 15</td>
                                <td>tela Iphone 15</td>
                                <td>R$ 350.00</td>
                                <td>R$ 80.00</td>
                                <td>R$ 430.00</td>
                                <td>APROVADO</td>
                              </tr>-->
                            </tbody>
                        </table>
                </div>
            </div>
        </div>

    </body>
</html>