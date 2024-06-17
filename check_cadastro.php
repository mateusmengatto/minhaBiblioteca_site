<?php
include 'functions.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar ao banco de dados
    
    if (isset($_POST['nome']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['senha'])) {
    
        $conn = bdconnect();
    
        // Verificar conexão com banco de dados
        $conn->begin_transaction();
    
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $senha = mysqli_real_escape_string($conn, $_POST['senha']);
    
        // Segurança de senha hash
        $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

        // Armazena os valores na sessão para preservá-los em caso de erro
        $_SESSION['form_data'] = [
            'nome' => $nome,
            'username' => $username,
            'email' => $email
        ];

        if (isEmailExists($conn, 'Usuario', $email)) {
            echo '<script>alert("O email já existe. Tente novamente.");</script>';
            header("Location: cadastro.php");
            exit();
        } elseif (isUserExists($conn, 'Usuario', $username)) {
            echo '<script>alert("O nome de Usuário já existe. Tente novamente.");</script>';
            header("Location: cadastro.php");
            exit();
        } elseif (!isPasswordPattern($senha)) {
            echo '<script>alert("A senha deve conter pelo menos 8 caracteres incluindo Maiúsculas, Números e caracteres especiais.");</script>';
            header("Location: cadastro.php");
            exit();
        } else {
            $sql = "INSERT INTO Usuario (userName, email, senha, nome) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssss", $username, $email, $senha_hashed, $nome);
    
                if ($stmt->execute()) {
                    $conn->commit();
                    // Limpa os dados do formulário da sessão após o sucesso
                    unset($_SESSION['form_data']);
                    // Redireciona para a página de login e encerra o script
                    header("Location: login.php");
                    session_destroy();
                    exit();
                } else {
                    echo "<script>alert('Ocorreu algum erro, cadastro não realizado. Tente novamente mais tarde.');</script>";
                    $conn->rollback();
                }
                $stmt->close();
            } else {
                echo "Erro na preparação do statement: " . $conn->error;
            }
        }
    
        $conn->close();
    }
    else {
        echo '<script>alert("Todos os campos são obrigatórios.");</script>';
    }
}
?>
