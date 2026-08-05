"""
TESTE AUTOMATIZADO - CADASTRO DE CLIENTE (DADOS DINÂMICOS & VARIADOS)
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

# Tenta importar a biblioteca Faker para dados ultras variados; se não houver, usa gerador interno
try:
    from faker import Faker
    fake = Faker('pt_BR')
    USA_FAKER = True
except ImportError:
    USA_FAKER = False

class TesteAutomatizadoCliente:
    def __init__(self, url_base="http://localhost:8080/TechOs/"):
        self.url_base = url_base
        self.url_login = url_base + "index.php"
        self.url_cliente = url_base + "cliente.php"
        self.diretorio_teste = "TesteCadastroCliente"
        
        if not os.path.exists(self.diretorio_teste):
            os.makedirs(self.diretorio_teste)
            
        self.resultados_testes = []

        chrome_options = Options()
        chrome_options.add_argument("--start-maximized")
        
        self.driver = webdriver.Chrome(options=chrome_options)
        self.wait = WebDriverWait(self.driver, 10)
        
        print("✓ Ambiente preparado e pasta 'TesteCadastroCliente' verificada!")

    def realizar_login(self, usuario="nicolly.pereira", senha="123"):
        """Realiza o login para garantir acesso à área restrita."""
        print("🔐 Efetuando login...")
        self.driver.get(self.url_login)
        
        form_login = self.wait.until(EC.presence_of_element_located((By.XPATH, "//form[contains(@action, 'login_funcionario.php')]")))
        
        campo_usuario = form_login.find_element(By.NAME, "nLogin")
        campo_senha = form_login.find_element(By.NAME, "nSenha")
        
        campo_usuario.clear()
        campo_usuario.send_keys(usuario)
        
        campo_senha.clear()
        campo_senha.send_keys(senha)
        
        form_login.submit()
        time.sleep(2)
        self.tratar_alerta_se_existir()

    def gerar_dados_aleatorios(self):
        # Lista de CEPs válidos para evitar travamento da API ViaCEP
        ceps_validos = ["89201-000", "89218-000", "80010-000", "01001-000", "88010-000", "13010-000"]
        
        if USA_FAKER:
            nome = fake.name()
            cpf = fake.cpf()
            telefone = f"479{random.randint(8000, 9999)}{random.randint(1000, 9999)}"
            rua = fake.street_name()
            bairro = fake.bairro()
            cidade = fake.city()
            uf = fake.state_abbr()
        else:
            # Fallback robusto com combinatória expandida
            primeiros_nomes = ["Ana", "Carlos", "Mariana", "Roberto", "Fernanda", "Lucas", "Patricia", "Gabriel", "Beatriz", "Thiago", "Camila", "Rodrigo", "Juliana", "Felipe"]
            sobrenomes = ["Souza", "Eduardo", "Oliveira", "Santos", "Lima", "Mendes", "Rocha", "Costa", "Almeida", "Ferreira", "Ribeiro", "Carvalho", "Gomes", "Martins"]
            
            nome = f"{random.choice(primeiros_nomes)} {random.choice(sobrenomes)} {random.choice(sobrenomes)}"
            cpf = f"{random.randint(100, 999)}.{random.randint(100, 999)}.{random.randint(100, 999)}-{random.randint(10, 99)}"
            telefone = f"479{random.randint(8000, 9999)}{random.randint(1000, 9999)}"
            rua = f"Rua {random.choice(['das Flores', 'Brasil', 'Amazonas', 'São Paulo', 'XV de Novembro', 'Sete de Setembro'])}"
            bairro = random.choice(["Centro", "America", "Anita Garibaldi", "Costa e Silva", "Saguaçu", "Floresta"])
            cidade = "Joinville"
            uf = "SC"

        return {
            "nome": nome,
            "cpf": cpf,
            "telefone": telefone,
            "cep": random.choice(ceps_validos),
            "endereco": rua,
            "numero": str(random.randint(1, 2000)),
            "complemento": f"Apto {random.randint(101, 902)}" if random.choice([True, False]) else "",
            "bairro": bairro,
            "cidade": cidade,
            "estado": uf
        }

    def tratar_alerta_se_existir(self):
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
        self.tratar_alerta_se_existir()
        caminho = os.path.join(self.diretorio_teste, nome_arquivo)
        self.driver.save_screenshot(caminho)
        return caminho

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
                            <th>CPF</th>
                            <th>Status</th>
                            <th>Evidência</th>
                        </tr>
                    </thead>
                    <tbody>
        """
        
        for r in self.resultados_testes:
            cor_status = "status-sucesso" if r['status'] == 'Sucesso' else "status-falha"
            nome_print_apenas = os.path.basename(r['screenshot'])
            html_content += f"""
                <tr>
                    <td>{r['id']}</td>
                    <td>{r['nome']}</td>
                    <td>{r['cpf']}</td>
                    <td class="{cor_status}">{r['status']}</td>
                    <td><a class="img-link" href="{nome_print_apenas}" target="_blank">Visualizar Screenshot</a></td>
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
        self.realizar_login()

        for i in range(quantidade):
            dados = self.gerar_dados_aleatorios()
            print(f"\n🚀 Cadastrando cliente {i+1} de {quantidade}: {dados['nome']} | CPF: {dados['cpf']}")
            status = "Falha"
            
            try:
                self.driver.get(self.url_cliente)
                
                # Clica em Novo Cliente via JS para evitar interrupções de layout
                btn_novo = self.wait.until(EC.presence_of_element_located((By.ID, "botaoAbrir")))
                self.driver.execute_script("arguments[0].click();", btn_novo)
                
                modal_form = self.wait.until(EC.visibility_of_element_located((By.CSS_SELECTOR, "#meuModal form")))
                
                modal_form.find_element(By.NAME, "nNome").clear()
                modal_form.find_element(By.NAME, "nNome").send_keys(dados["nome"])
                
                modal_form.find_element(By.NAME, "nCpf").clear()
                modal_form.find_element(By.NAME, "nCpf").send_keys(dados["cpf"])
                
                modal_form.find_element(By.NAME, "nTelefone").clear()
                modal_form.find_element(By.NAME, "nTelefone").send_keys(dados["telefone"])
                
                campo_cep = modal_form.find_element(By.NAME, "nCep")
                campo_cep.clear()
                campo_cep.send_keys(dados["cep"])
                
                # Dispara evento para o script da página preencher o endereço
                self.driver.execute_script("arguments[0].dispatchEvent(new Event('blur'));", campo_cep)
                time.sleep(1) 
                self.tratar_alerta_se_existir()

                modal_form.find_element(By.NAME, "nEndereco").clear()
                modal_form.find_element(By.NAME, "nEndereco").send_keys(dados["endereco"])
                
                modal_form.find_element(By.NAME, "nNumero").clear()
                modal_form.find_element(By.NAME, "nNumero").send_keys(dados["numero"])
                
                modal_form.find_element(By.NAME, "nComplemento").clear()
                modal_form.find_element(By.NAME, "nComplemento").send_keys(dados["complemento"])
                
                modal_form.find_element(By.NAME, "nBairro").clear()
                modal_form.find_element(By.NAME, "nBairro").send_keys(dados["bairro"])
                
                modal_form.find_element(By.NAME, "nCidade").clear()
                modal_form.find_element(By.NAME, "nCidade").send_keys(dados["cidade"])
                
                modal_form.find_element(By.NAME, "nEstado").clear()
                modal_form.find_element(By.NAME, "nEstado").send_keys(dados["estado"])
                
                btn_salvar = modal_form.find_element(By.ID, "botaoSalvar")
                self.driver.execute_script("arguments[0].click();", btn_salvar)
                
                time.sleep(2)
                self.tratar_alerta_se_existir()

                if "cliente" in self.driver.current_url.lower():
                    status = "Sucesso"
                
            except Exception as e:
                print(f"✗ Erro no processo: {e}")
            
            nome_print = self.tirar_screenshot(f"cadastro_cliente_{i+1}.png")
            self.resultados_testes.append({
                "id": i+1,
                "nome": dados["nome"],
                "cpf": dados["cpf"],
                "status": status,
                "screenshot": nome_print
            })

        caminho_report = self.gerar_relatorio_html()
        self.driver.quit()
        
        print(f"\n✅ Testes finalizados! Relatório gerado em: {caminho_report}")
        webbrowser.open('file://' + os.path.realpath(caminho_report))

if __name__ == "__main__":
    print("--- SISTEMA DE AUTOMAÇÃO TECHOS (CLIENTES) ---")
    try:
        qtd = int(input("Quantos clientes você deseja cadastrar hoje? "))
        if qtd > 0:
            URL_LOCAL = "http://localhost:8080/TechOs/"
            teste = TesteAutomatizadoCliente(url_base=URL_LOCAL)
            teste.executar_teste_completo(qtd)
        else:
            print("Quantidade inválida.")
    except ValueError:
        print("Por favor, digite apenas números inteiros.")