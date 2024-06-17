<?php
include 'functions.php';
session_start();

$conn = bdconnect(); // Função dbconnect - functions.php

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editora = $_POST['editora'];
    $dataPubli = !empty($_POST['dataPubli']) ? $_POST['dataPubli'] : null;;
    $ISBN = !empty($_POST['ISBN']) ? $_POST['ISBN']: null ;
    $capa = null;
    $arquivoURL = null;


    // Verifica se um arquivo foi enviado
    if (isset($_FILES['arquivocapa']) && $_FILES['arquivocapa']['error'] == 0) {
        $arquivocapa = $_FILES['arquivocapa'];
        $nomeArquivoCapa = basename($arquivocapa['name']);
        $diretorioDestinoCapa = 'capas/'; // Pasta onde o arquivo será salvo
        $caminhoArquivoCapa = $diretorioDestinoCapa . $nomeArquivoCapa;

        // Verifica se a pasta existe, se não, cria a pasta
        if (!is_dir($diretorioDestinoCapa)) {
            mkdir($diretorioDestinoCapa, 0777, true);
        }

        // Move o arquivo para o diretório de destino
        if (move_uploaded_file($arquivocapa['tmp_name'], $caminhoArquivoCapa)) {
            // Sucesso no upload
            $capa = $caminhoArquivoCapa;
        } else {
            // Erro ao mover o arquivo
            echo "Erro ao mover o arquivo de capa.";
            exit;
        }
    }


    
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        $arquivo = $_FILES['arquivo'];
        $nomeArquivo = basename($arquivo['name']);
        $diretorioDestino = 'arquivos/'; // Pasta onde o arquivo será salvo
        $caminhoArquivo = $diretorioDestino . $nomeArquivo;

        // Verifica se a pasta existe, se não, cria a pasta
        if (!is_dir($diretorioDestino)) {
            mkdir($diretorioDestino, 0777, true);
        }

        // Move o arquivo para o diretório de destino
        if (move_uploaded_file($arquivo['tmp_name'], $caminhoArquivo)) {
            // Sucesso no upload
            $arquivo = $caminhoArquivo;
        } else {
            // Erro ao mover o arquivo
            echo "Erro ao mover o arquivo.";
            exit;
        }
    }

    
    if (!$capa == null && !$arquivo == null) {
    // Atualiza os dados do livro no banco de dados
        $sql = "INSERT INTO Livro 
        (titulo, autor, editora, dataPubli, ISBN, capa, arquivo) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssss', $titulo, $autor, $editora, $dataPubli, $ISBN, $capa, $arquivo);
    
        if ($stmt->execute()) {
            echo "Livro atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar o livro: " . $conn->error;
        }
    }
        
    $stmt->close();
    $conn->close();
    
} else {
    echo "Método de requisição inválido.";
}
header('Location: gerenciar_livro.php')
?>
