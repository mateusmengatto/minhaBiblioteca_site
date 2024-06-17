<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="form-style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
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
        <img src="icon.png" alt="login img" />
        <h1>Login</h1>
        <p>
            Não tem uma conta?
            <a href="./cadastro.php" class="signUpLink">Cadastro</a>
        </p>

        <form action="login.php" method="POST" class="form" id="loginForm">
            <div class="username">
                <label for="username">NOME DE USUÁRIO</label> <br />
                <input name="username" id="username" type="text" placeholder="Digite o seu nome de usuário" required />
            </div>

            <div class="senha">
                <label for="senha">SENHA</label> <br />
                <input name="senha" id="senha" type="password" placeholder="Digite a sua senha" required />
                <br />
                <!--<a href="forgotPassword.html" class="forgottenPass">Esqueceu sua senha? Não implementado não funcionou serviço de email</a>-->
            </div>

            <input type="submit" value="Entrar" />
            <br /><span class="error" id="passwordError">Usuário e/ou senha incorretos.</span>
        </form>
    </main>

    <script>
        $(document).ready(function(){
            $('#loginForm').submit(function(event){
                event.preventDefault();  // Impede o envio do formulário inicialmente

                var username = $('#username').val();
                var password = $('#senha').val();

                $.post('check_login.php', {username: username, password: password}, function(data){
                    if(data.status === 'success'){
                        $('#passwordError').hide();
                        window.location.href = data.redirect;  // Redireciona para a página apropriada
                    } else {
                        $('#passwordError').show();
                    }
                }, 'json');
            });
        });
    </script>
</body>
</html>
