"""
TESTE AUTOMATIZADO - CADASTRO DE APARELHOS COM LOGIN AUTOMÁTICO (FIX CLICK & DADOS DINÂMICOS)
Sistema: TechOS
Ferramenta: Selenium WebDriver com Python
"""

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select, WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options
import time
import random
import os
import webbrowser

class TesteAutomatizadoAparelho:
    def __init__(self, url_base="http://localhost:8080/techos/"):
        self.url_base = url_base
        self.url_login = url_base + "index.php"
        self.url_aparelhos = url_base + "cadastroAparelho.php"
        
        self.diretorio_teste = "TesteCadastroAparelho"
        
        if not os.path.exists(self.diretorio_teste):
            os.makedirs(self.diretorio_teste)
            
        self.resultados_testes = []

        chrome_options = Options()
        chrome_options.add_argument("--start-maximized")
        
        self.driver = webdriver.Chrome(options=chrome_options)
        self.wait = WebDriverWait(self.driver, 10)
        
        print("✓ Ambiente preparado e pasta 'TesteCadastroAparelho' verificada!")

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
        # Aumentei a variedade de modelos
        modelos = ["Galaxy S23", "iPhone 14", "Redmi Note 12", "Moto G84", "ZFlip 5", "Poco X5", "Galaxy A54", "iPhone 11", "Moto Edge 40"]
        imei = "".join([str(random.randint(0, 9)) for _ in range(15)])
        
        return {
            "modelo": f"{random.choice(modelos)} {random.randint(10, 99)}",
            "imei": imei
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
            <title>Dashboard de Testes - TechOS (Aparelhos)</title>
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
                <h1>Relatório de Cadastro de Aparelhos - TechOS</h1>
                <div class="summary">
                    <div class="card"><h3>Total</h3><h2>{len(self.resultados_testes)}</h2></div>
                    <div class="card"><h3 class="status-sucesso">Sucessos</h3><h2>{sucessos}</h2></div>
                    <div class="card"><h3 class="status-falha">Falhas</h3><h2>{falhas}</h2></div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Modelo</th>
                            <th>IMEI</th>
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
                    <td>{r['modelo']}</td>
                    <td>{r['imei']}</td>
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
            print(f"\n🚀 Iniciando cadastro de aparelho {i+1} de {quantidade}...")
            dados = self.gerar_dados_aleatorios()
            status = "Falha"
            texto_alerta = None
            
            try:
                # 2. Navega até a página de aparelhos
                self.driver.get(self.url_aparelhos)
                time.sleep(1)
                
                # 3. Localiza e clica no botão "Novo" via JavaScript para evitar bloqueios de layout
                btn_novo = self.wait.until(EC.presence_of_element_located((By.ID, "btnAbrirNovo")))
                self.driver.execute_script("arguments[0].click();", btn_novo)
                
                # 4. Aguarda o Modal ficar visível
                modal = self.wait.until(EC.visibility_of_element_located((By.ID, "modalAparelho")))
                form_modal = modal.find_element(By.TAG_NAME, "form")
                
                # Preenche Cliente de forma ALEATÓRIA
                select_cliente = Select(form_modal.find_element(By.NAME, "nCliente"))
                qtd_clientes = len(select_cliente.options)
                if qtd_clientes > 1:
                    # Escolhe um índice entre 1 e a última opção (ignorando o 0 que costuma ser "Selecione")
                    index_cliente = random.randint(1, qtd_clientes - 1)
                    select_cliente.select_by_index(index_cliente)
                
                # Preenche Marca de forma ALEATÓRIA
                select_marca = Select(form_modal.find_element(By.NAME, "nMarca"))
                qtd_marcas = len(select_marca.options)
                if qtd_marcas > 1:
                    # Escolhe um índice entre 1 e a última opção
                    index_marca = random.randint(1, qtd_marcas - 1)
                    select_marca.select_by_index(index_marca)

                # Preenche Modelo e IMEI gerados aleatoriamente
                form_modal.find_element(By.NAME, "nModelo").send_keys(dados["modelo"])
                form_modal.find_element(By.NAME, "nImei").send_keys(dados["imei"])
                
                # 5. Clica no botão Cadastrar enviando o formulário
                form_modal.submit()
                
                time.sleep(2)
                
                # Armazena o texto do alerta (se houver) para validação
                texto_alerta = self.tratar_alerta_se_existir()

                # 6. Validação real do cadastro
                if texto_alerta and "sucesso" in texto_alerta.lower():
                    status = "Sucesso"
                elif dados["imei"] in self.driver.page_source:
                    status = "Sucesso"
                else:
                    status = f"Falha (Alerta capturado: {texto_alerta})"
                
            except Exception as e:
                print(f"✗ Erro no processo: {e}")
            
            nome_print = self.tirar_screenshot(f"cadastro_aparelho_{i+1}.png")
            self.resultados_testes.append({
                "id": i+1,
                "modelo": dados["modelo"],
                "imei": dados["imei"],
                "status": status,
                "screenshot": nome_print
            })

        caminho_report = self.gerar_relatorio_html()
        self.driver.quit()
        
        print(f"\n✅ Testes finalizados! Relatório gerado em: {caminho_report}")
        webbrowser.open('file://' + os.path.realpath(caminho_report))

if __name__ == "__main__":
    print("--- SISTEMA DE AUTOMAÇÃO TECHOS (APARELHOS) ---")
    try:
        qtd = int(input("Quantos aparelhos você deseja cadastrar hoje? "))
        if qtd > 0:
            URL_BASE = "http://localhost:8080/techos/"
            teste = TesteAutomatizadoAparelho(url_base=URL_BASE)
            teste.executar_teste_completo(qtd)
        else:
            print("Quantidade inválida.")
    except ValueError:
        print("Por favor, digite apenas números inteiros.")