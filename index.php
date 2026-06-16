<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>

  <link rel="stylesheet" href="css/estilo_login.css">
</head>
<body>

   <div class="d-flex justify-content-center align-items-center min-vh-100 p-3">
      <div class= "login-card">
          <h2 class = "fw-bold text-center mb-4">Login</h2>

          <form method="POST" action="php/login_funcionario.php">
              
              <div class="input-group mb-3">
              <span class = "input-group-text"><i class="bi bi-person-fill"></i></span>
              <input type="text" class="form-control" name = "nLogin" placeholder="Usuário">
              </div>
            
              <div class="input-group mb-3">
              <span class = "input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" class="form-control" name = "nSenha" placeholder="Senha">
              </div>

              
              <button class="btn btn-light w-100 text-dark fw-semibold"> Entrar </button>
          </form>
 
      </div> 
  </div>   
</body>
</html>