<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Cadastro de Usuario</title>
    <link rel="stylesheet" href="form-style.css" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>
<body>
    <?php
    session_start();
    
    // Recupera os dados do formulário da sessão, se existirem
    $nome = isset($_SESSION['form_data']['nome']) ? $_SESSION['form_data']['nome'] : '';
    $username = isset($_SESSION['form_data']['username']) ? $_SESSION['form_data']['username'] : '';
    $email = isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : '';
    ?>
    
    <header>
        <nav>
            <ul>
                <li><img id="logo" src="logonav.png" alt="Logo" /></li>
                <li><a href="livros.php">Meus Livros</a></li>
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a id="perfil" href="login.php"><i class="bi bi-person-circle"></i></a></li>
            </ul>
        </nav>
    </header>

    <main>
      <h1>Cadastro</h1>
      <p>
        Já possui uma conta?
        <a href="login.php" class="signInLink">Login</a>
      </p>

      <form action="check_cadastro.php" method="POST" class="form" id="form">
        <div class="nome">
          <label for="nome">NOME</label> <br />
          <input name="nome" id="nome" type="text" placeholder="Digite o seu nome" value="<?php echo htmlspecialchars($nome); ?>" required />
        </div>
          
        <div class="username">
          <label for="username">NOME DE USUÁRIO</label> <br />
          <input name="username" id="username" type="text" placeholder="Digite o seu nome de usuário" value="<?php echo htmlspecialchars($username); ?>" required />
          <span class="error" id="usernameError" style="display: none; color: red;">Usuário já existe.</span>
        </div>

        <div class="email">
          <label for="email">EMAIL</label> <br />
          <input name="email" id="email" type="email" placeholder="Digite o seu email" value="<?php echo htmlspecialchars($email); ?>" required />
          <span class="error" id="emailError" style="display: none; color: red;">Email já existe.</span>
        </div>

        <div class="senha">
          <label for="senha">SENHA</label> <br />
          <input name="senha" id="senha" type="password" placeholder="Digite a sua senha" required />
          <span class="error" id="minPasswordCharacters" style="display: none;">Sua senha é muito curta.</span>
        </div>

        <div class="confirmPassword">
          <label for="confirmPassword">CONFIRMAR SENHA</label> <br />
          <input name="confirmPassword" id="confirmPassword" type="password" placeholder="Digite a sua senha" required />
          <span class="error" id="passMismatch" style="display: none;">As senhas não coincidem.</span>
        </div>
        <br>
        <input type="submit" value="Cadastrar" />
      </form>
    </main>
    <script type="text/javascript" src="signup-script.js"></script>
</body>
</html>
