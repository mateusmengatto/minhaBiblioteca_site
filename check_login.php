<?php
include 'functions.php';

session_start();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar ao banco de dados
    $conn = bdconnect();

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM Usuario WHERE userName = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        
        
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['senha'])) {
            $_SESSION['userId'] = $row['userId'];
            $_SESSION['userName'] = $row['userName']; #define a sessao para o usuario
            $_SESSION['Nome'] = $row['nome'];
            
            if ($row['funcao'] == "1"){
                $_SESSION['funcao'] = "adm"; #define se a sessao e de um usuario admin
            } else {
                $_SESSION['funcao'] = "user";
            }
            echo json_encode(['status' => 'success', 'redirect' => 'catalogo.php']);
            exit();
        }
    }
    
    echo json_encode(['status' => 'error', 'message' => 'Usuário e/ou senha incorretos.']);
    exit();
}
?>
