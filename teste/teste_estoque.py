"""
TESTE AUTOMATIZADO - CONTROLE DE ESTOQUE (VERSÃO DASHBOARD)
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

class TesteAutomatizadoEstoque:
    def __init__(self, url_base="http://localhost:8080/techos/"):
        self.url_base = url_base
        self.url_login = url_base + "index.php"
        self.url_estoque = url_base + "estoque.php"
        
        self.diretorio_teste = "TesteEstoque"
        
        if not os.path.exists(self.diretorio_teste):
            os.makedirs(self.diretorio_teste)
            
        self.resultados_testes = []

        chrome_options = Options()
        chrome_options.add_argument("--start-maximized")
        
        self.driver = webdriver.Chrome(options=chrome_options)
        self.wait = WebDriverWait(self.driver, 10)
        
        print("✓ Ambiente preparado e pasta 'TesteEstoque' verificada!")

    def realizar_login(self, usuario="nicolly.pereira", senha="123"):
        """Realiza o login no sistema para liberar a sessão de usuário."""
        print("🔐 Efetuando login para liberar acesso à página...")
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
        fornecedores = ["Distribuidora Tech", "Eletrônicos Express", "Global Peças", "Fast Parts"]
        pecas = ["Tela Display OLED", "Bateria Li-Ion", "Conector de Carga", "Câmera Traseira", "Tampa Traseira"]
        
        fornecedor = random.choice(fornecedores)
        peca = f"{random.choice(pecas)} {random.randint(100, 999)}"
        valor = round(random.uniform(25.0, 350.0), 2)
        quantidade = random.randint(1, 50)
        
        return {
            "fornecedor": fornecedor,
            "peca": peca,
            "valor": str(valor),
            "quantidade": str(quantidade)
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
            <title>Dashboard de Testes - TechOS (Estoque)</title>
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
                <h1>Relatório de Cadastro de Estoque - TechOS</h1>
                <div class="summary">
                    <div class="card"><h3>Total</h3><h2>{len(self.resultados_testes)}</h2></div>
                    <div class="card"><h3 class="status-sucesso">Sucessos</h3><h2>{sucessos}</h2></div>
                    <div class="card"><h3 class="status-falha">Falhas</h3><h2>{falhas}</h2></div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fornecedor</th>
                            <th>Peça</th>
                            <th>Qtd</th>
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
                    <td>{r['fornecedor']}</td>
                    <td>{r['peca']}</td>
                    <td>{r['quantidade']}</td>
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
        # 1. Realiza login inicial
        self.realizar_login()

        for i in range(quantidade):
            print(f"\n🚀 Iniciando cadastro de item de estoque {i+1} de {quantidade}...")
            dados = self.gerar_dados_aleatorios()
            status = "Falha"
            
            try:
                # 2. Navega até a página de estoque
                self.driver.get(self.url_estoque)
                time.sleep(1)
                
                # 3. Clica no botão "Novo" via JavaScript (aciona a função abrirModalEstoque)
                btn_novo = self.wait.until(EC.presence_of_element_located((By.XPATH, "//button[contains(@onclick, 'abrirModalEstoque')]")))
                self.driver.execute_script("arguments[0].click();", btn_novo)
                
                # 4. Aguarda o Modal de Estoque abrir
                modal = self.wait.until(EC.visibility_of_element_located((By.ID, "modalEstoque")))
                
                # 5. Preenche os campos do formulário
                modal.find_element(By.ID, "NomeFornecedor").send_keys(dados["fornecedor"])
                modal.find_element(By.ID, "peca").send_keys(dados["peca"])
                modal.find_element(By.ID, "valor").send_keys(dados["valor"])
                modal.find_element(By.ID, "qtd").send_keys(dados["quantidade"])
                
                # 6. Envia o formulário
                btn_salvar = modal.find_element(By.ID, "botaoSalvar")
                self.driver.execute_script("arguments[0].click();", btn_salvar)
                
                time.sleep(2)
                self.tratar_alerta_se_existir()

                # 7. Validação
                if "estoque.php" in self.driver.current_url.lower():
                    status = "Sucesso"
                
            except Exception as e:
                print(f"✗ Erro no processo: {e}")
            
            nome_print = self.tirar_screenshot(f"cadastro_estoque_{i+1}.png")
            self.resultados_testes.append({
                "id": i+1,
                "fornecedor": dados["fornecedor"],
                "peca": dados["peca"],
                "quantidade": dados["quantidade"],
                "status": status,
                "screenshot": nome_print
            })

        caminho_report = self.gerar_relatorio_html()
        self.driver.quit()
        
        print(f"\n✅ Testes finalizados! Relatório gerado em: {caminho_report}")
        webbrowser.open('file://' + os.path.realpath(caminho_report))

if __name__ == "__main__":
    print("--- SISTEMA DE AUTOMAÇÃO TECHOS (ESTOQUE) ---")
    try:
        qtd = int(input("Quantos itens de estoque você deseja cadastrar hoje? "))
        if qtd > 0:
            URL_BASE = "http://localhost:8080/techos/"
            teste = TesteAutomatizadoEstoque(url_base=URL_BASE)
            teste.executar_teste_completo(qtd)
        else:
            print("Quantidade inválida.")
    except ValueError:
        print("Por favor, digite apenas números inteiros.")