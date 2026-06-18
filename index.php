<!DOCTYPE html>
<html lang="pt-br">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>

  <link rel="stylesheet" href="css/styleLogin.css">
</head>
<body>

  <div class="main-container">
    <div class="animacao-circulo"></div>

        <div class= "login-card">
          <h2 >Login</h2>
   <div class="d-flex justify-content-center align-items-center min-vh-100 p-3">
      <div class= "login-card">
        
          <h2 class="fw-bold text-center mb-4 borda-titulo">Login</h2>

          <form method="POST" action="php/login_funcionario.php">
              
              <div class="input-grupo">
              <input type="text" class="formulario" name = "nLogin" placeholder="Usuário">
              </div>
            
              <div class="input-grupo">
              <input type="password" class="formulario" name = "nSenha" placeholder="Senha">
              </div>

              <input type="submit" value="Entrar" class="btn-entrar">
          </form>       
    </div> 
  </div>   
</body>
</html>