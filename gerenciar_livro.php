<?php

include 'functions.php';

session_start();
$userId  = $_SESSION['userId'] ;
$userName = $_SESSION['userName'] ; #define a sessao para o usuario
$name = $_SESSION['Nome'];
$funcao = $_SESSION['funcao'];

$conn = bdconnect(); //funcao dbconnect - functions.php

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!--<link rel="shortcut icon" href="imagens/logo1.ico" type="image/x-icon">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    

    <title>Gerenciador de Livros</title>
    
</head>
<body>
    <header>
        <nav>
            <ul>
                <li> <img id="logo" src="logonav.png" alt="Logo"> </li>
                <li><a href="livros.php">Meus Livros</a></li>
                <li><a href="catalogo.php">Catálogo</a></li>
                <li class="nav-item dropdown">
                    <button class="btn dropdown-toggle" type="button" id="perfilDropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="perfilDropdown" style="right: 0;">
                        <li><a class="dropdown-item" href="<?php echo (!$userName == '') ? 'livros.php' : 'login.php'; ?>">
                            <?php echo (!$userName == '') ? "Olá, $userName !" : "Faça seu login"; ?></li>
                        <?php if ($funcao == 'adm') { ?>
                        <li><a class="dropdown-item" href="gerenciar_livro.php">Gerenciar Livros</a></li>
                        <?php } ?>
                        <?php if (!$userName == '') { ?>
                        <li><a class="dropdown-item" href="logout.php">Sair</a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </nav>
        <h1>Gerenciador de Livros</h1>
    </header>

    <main>
    <div id="div-single-center" >
        <button onclick="mostrarFormulario('adicionar')">Adicionar Livro</button>
    </div>
    <div id="form-adicionar" style="display: none;">
        <hr>
        <form class="item-livro" action="adicionar_livro.php" method="POST" enctype="multipart/form-data">
            <div class="detalhes" style="display: flex; flex-direction: column;">
                <div class="detalhes" style="display: flex; flex-direction: row; align-items: center;">
                    <div class="info-block">
                        <label for="titulo">Título:</label>
                        <input type="text" name="titulo" id="titulo" required>
                    </div>
                    <div class="info-block">
                        <label for="autor">Autor:</label>
                        <input type="text" name="autor" id="autor" required>
                    </div>
                    <div class="info-block">
                        <label for="editora">Editora:</label>
                        <input type="text" name="editor" id="editor" required>
                    </div>
                    <div class="info-block">
                        <label for="date">Data public.:</label>
                        <input type="date" name="dataPubli" id="dataPubli">
                    </div>
                    <div class="info-block">
                        <label for="ISBN">ISBN:</label>
                        <input type="text" name="ISBN" id="ISBN">
                    </div>
                    <div class="info-block">
                        <label for="capa">Arq. capa:</label>
                        <input type="file" name="arquivocapa" id="arquivocapa" required>
                    </div>
                    <div class="info-block">
                        <label for="arquivo">Arquivo Livro:</label>
                        <input type="file" name="arquivo" id="arquivo" required>
    
                    </div>
                    <div class="info-block">
                        <input type="submit" value="Adicionar Livro" style="font-size: 16px;">
                    </div>
                </div>
            </div>
        </form>
        <hr>
    </div>
    <div id="livros-container" class="lista-livros">
        
        <?php 
        $sql = "SELECT * FROM Livro";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { 
                ?>
                <form class="item-livro" action="atualizar_livro.php" method="POST" enctype="multipart/form-data">
                    <div class="detalhes" style="display: flex; flex-direction: column;">
                        <div class="detalhes" style="display: flex; flex-direction: row; align-items: center;">
                            <div class="capa">
                            <img src="<?php echo $row['capa']; ?>" alt="<?php echo $row['titulo']; ?>">
                            </div>
                            <div class="info-block">
                                <label for="titulo">Título:</label>
                                <input type="text" name="titulo" value="<?php echo $row['titulo']; ?>">
                            </div>
                            <div class="info-block">
                                <label for="autor">Autor:</label>
                                <input type="text" name="autor" value="<?php echo $row['autor']; ?>">
                            </div>
                            <div class="info-block">
                                 <label for="editora">Editora:</label>
                                <input type="text" name="editora" value="<?php echo $row['editora']; ?>">
                            </div>
                            <div class="info-block">
                                <label for="date">Data public.:</label>
                                <input type="date" name="dataPubli" value="<?php echo $row['dataPubli']; ?>">
                            </div>
                            <div class="info-block">
                                <label for="ISBN">ISBN:</label>
                                <input type="text" name="ISBN" value="<?php echo $row['ISBN']; ?>">
                            </div>
                            <div class="info-block">
                                <label for="capa">Arq. capa:</label>
                                <input type="text" name="capa" value="<?php echo $row['capa']; ?>">
                                <div style="margin-bottom: 5px;"></div>
                                <input type="file" name="arquivocapa" id="arquivocapa">
                            </div>
                            <div class="info-block">
                                <label for="arquivo">Arquivo Livro:</label>
                                <input type="text" name="arquivo_name" value="<?php echo $row['arquivo']; ?>">
                                <div style="margin-bottom: 5px;"></div>
                                <input type="file" name="arquivo" id="arquivo">
                            </div>
                            <div class="info-block">
                                <input type="hidden" name="livro_id" value="<?php echo $row['bookId']; ?>">
                                <label for="submit">         </label>
                                <input type="submit" value="Atualizar" style="font-size: 16px;">
                            </div>
                        </div>
                    </div>
                </form>
                <?php 
            }
        } else {
            echo "0 results";
        } 
        ?>
    </div>
    <script>
        function mostrarFormulario(formulario) {
            var form = document.getElementById('form-adicionar');
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
    </main>

</body>

