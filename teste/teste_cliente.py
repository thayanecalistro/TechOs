"""
TESTE AUTOMATIZADO - CADASTRO DE CLIENTE (VERSÃO DASHBOARD)
Sistema: TechOS
Ferramenta: Selenium WebDriver com Python
"""

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options
import time
import random
import os
import webbrowser

class TesteAutomatizadoCliente:
    def __init__(self, url_base="http://localhost:8080/techos/cliente.php"):
        self.url_base = url_base
        self.diretorio_teste = "TesteCadastroCliente"
        
        if not os.path.exists(self.diretorio_teste):
            os.makedirs(self.diretorio_teste)
            
        self.resultados_testes = []

        chrome_options = Options()
        chrome_options.add_argument("--start-maximized")
        
        self.driver = webdriver.Chrome(options=chrome_options)
        self.wait = WebDriverWait(self.driver, 10)
        
        print("✓ Ambiente preparado e pasta 'TesteCadastroCliente' verificada!")

    def gerar_dados_aleatorios(self):
        nomes = ["Ana Souza", "Carlos Eduardo", "Mariana Oliveira", "Roberto Santos", 
                 "Fernanda Lima", "Lucas Mendes", "Patricia Rocha", "Gabriel Costa"]
        
        # CEPs reais para a consulta de ViaCEP do script não falhar
        ceps_validos = [
            "89201-000", "89218-000", "80010-000", "01001-000", "88010-000"
        ]
        
        nome = random.choice(nomes)
        cpf = f"{random.randint(100, 999)}.{random.randint(100, 999)}.{random.randint(100, 999)}-{random.randint(10, 99)}"
        telefone = f"4799{random.randint(1000, 9999)}1234"
        
        return {
            "nome": nome,
            "cpf": cpf,
            "telefone": telefone,
            "cep": random.choice(ceps_validos),
            "endereco": f"Rua das Flores, {random.randint(10, 500)}",
            "numero": str(random.randint(1, 1000)),
            "complemento": f"Apto {random.randint(101, 502)}",
            "bairro": "Centro",
            "cidade": "Joinville",
            "estado": "SC"
        }

    def tratar_alerta_se_existir(self):
        """Fecha qualquer alert do navegador caso apareça."""
        try:
            WebDriverWait(self.driver, 2).until(EC.alert_is_present())
            alerta = self.driver.switch_to.alert
            texto = alerta.text
            alerta.accept()
            print(f"⚠️ Alerta capturado e fechado: '{texto}'")
            return texto
        except Exception:
            return None

    def tirar_screenshot(self, nome_arquivo):
        # Trata pop-ups antes de tirar a print
        self.tratar_alerta_se_existir()
        
        caminho = os.path.join(self.diretorio_teste, nome_arquivo)
        self.driver.save_screenshot(caminho)
        return nome_arquivo

    def gerar_relatorio_html(self):
        caminho_html = os.path.join(self.diretorio_teste, "dashboard.html")
        
        sucessos = sum(1 for r in self.resultados_testes if r['status'] == 'Sucesso')
        falhas = len(self.resultados_testes) - sucessos

        html_content = f"""
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <title>Dashboard de Testes - TechOS</title>
            <style>
                body {{ font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 20px; }}
                .container {{ max-width: 1000px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }}
                h1 {{ color: #004a80; text-align: center; }}
                .summary {{ display: flex; justify-content: space-around; margin-bottom: 30px; padding: 15px; background: #e9ecef; border-radius: 5px; }}
                .card {{ text-align: center; }}
                .card h2 {{ margin: 0; font-size: 2em; }}
                .status-sucesso {{ color: #28a745; }}
                .status-falha {{ color: #dc3545; }}
                table {{ width: 100%; border-collapse: collapse; margin-top: 20px; }}
                th, td {{ padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }}
                th {{ background-color: #004a80; color: white; }}
                .img-link {{ color: #007bff; text-decoration: none; font-weight: bold; }}
                tr:hover {{ background-color: #f1f1f1; }}
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Relatório de Cadastros - TechOS</h1>
                <div class="summary">
                    <div class="card"><h3>Total</h3><h2>{len(self.resultados_testes)}</h2></div>
                    <div class="card"><h3 class="status-sucesso">Sucessos</h3><h2>{sucessos}</h2></div>
                    <div class="card"><h3 class="status-falha">Falhas</h3><h2>{falhas}</h2></div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Evidência</th>
                        </tr>
                    </thead>
                    <tbody>
        """
        
        for r in self.resultados_testes:
            cor_status = "status-sucesso" if r['status'] == 'Sucesso' else "status-falha"
            html_content += f"""
                <tr>
                    <td>{r['id']}</td>
                    <td>{r['nome']}</td>
                    <td class="{cor_status}">{r['status']}</td>
                    <td><a class="img-link" href="{r['screenshot']}" target="_blank">Visualizar Screenshot</a></td>
                </tr>
            """

        html_content += """
                    </tbody>
                </table>
            </div>
        </body>
        </html>
        """

        with open(caminho_html, "w", encoding="utf-8") as f:
            f.write(html_content)
        
        return caminho_html

    def executar_teste_completo(self, quantidade):
        for i in range(quantidade):
            print(f"\n🚀 Iniciando cadastro {i+1} de {quantidade}...")
            dados = self.gerar_dados_aleatorios()
            status = "Falha"
            
            try:
                self.driver.get(self.url_base)
                
                # Clica em Novo Cliente
                btn_novo = self.wait.until(EC.element_to_be_clickable((By.ID, "botaoAbrir")))
                btn_novo.click()
                
                # Localiza formulário do modal
                modal_form = self.wait.until(EC.visibility_of_element_located((By.CSS_SELECTOR, "#meuModal form")))
                
                modal_form.find_element(By.NAME, "nNome").send_keys(dados["nome"])
                modal_form.find_element(By.NAME, "nCpf").send_keys(dados["cpf"])
                modal_form.find_element(By.NAME, "nTelefone").send_keys(dados["telefone"])
                
                # Insere o CEP
                campo_cep = modal_form.find_element(By.NAME, "nCep")
                campo_cep.send_keys(dados["cep"])
                
                # Simula mudança de foco para o JavaScript acionar a busca de CEP, caso haja evento blur/change
                modal_form.find_element(By.NAME, "nEndereco").click()
                time.sleep(1) 
                
                # Fecha algum alerta de CEP se tiver aparecido
                self.tratar_alerta_se_existir()

                modal_form.find_element(By.NAME, "nEndereco").clear()
                modal_form.find_element(By.NAME, "nEndereco").send_keys(dados["endereco"])
                
                modal_form.find_element(By.NAME, "nNumero").send_keys(dados["numero"])
                modal_form.find_element(By.NAME, "nComplemento").send_keys(dados["complemento"])
                
                modal_form.find_element(By.NAME, "nBairro").clear()
                modal_form.find_element(By.NAME, "nBairro").send_keys(dados["bairro"])
                
                modal_form.find_element(By.NAME, "nCidade").clear()
                modal_form.find_element(By.NAME, "nCidade").send_keys(dados["cidade"])
                
                modal_form.find_element(By.NAME, "nEstado").clear()
                modal_form.find_element(By.NAME, "nEstado").send_keys(dados["estado"])
                
                # Salva
                modal_form.find_element(By.ID, "botaoSalvar").click()
                
                time.sleep(2)
                
                # Trata alerta caso salvar exiba alguma mensagem pop-up
                self.tratar_alerta_se_existir()

                if "cliente" in self.driver.current_url.lower():
                    status = "Sucesso"
                
            except Exception as e:
                print(f"✗ Erro no processo: {e}")
            
            nome_print = self.tirar_screenshot(f"cadastro_cliente_{i+1}.png")
            self.resultados_testes.append({
                "id": i+1,
                "nome": dados["nome"],
                "status": status,
                "screenshot": nome_print
            })

        caminho_report = self.gerar_relatorio_html()
        self.driver.quit()
        
        print(f"\n✅ Testes finalizados! Relatório gerado em: {caminho_report}")
        webbrowser.open('file://' + os.path.realpath(caminho_report))

if __name__ == "__main__":
    print("--- SISTEMA DE AUTOMAÇÃO TECHOS ---")
    try:
        qtd = int(input("Quantos clientes você deseja cadastrar hoje? "))
        if qtd > 0:
            URL_LOCAL = "http://localhost:8080/techos/cliente.php"
            teste = TesteAutomatizadoCliente(url_base=URL_LOCAL)
            teste.executar_teste_completo(qtd)
        else:
            print("Quantidade inválida.")
    except ValueError:
        print("Por favor, digite apenas números inteiros.")