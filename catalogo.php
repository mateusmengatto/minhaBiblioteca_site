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
    

    <title>Catálogo</title>
    
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
        <h1>Catálogo</h1>
    </header>

    <main>
        <section>
        <?php // Execute a consulta SQL para obter o caminho do arquivo PDF
$result = [];
$sql = "SELECT * FROM Livro l left join Favoritos f on l.bookId = f.FK_bookId and f.FK_userId = ?
order by l.titulo";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param('i', $userId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
    }
}

if ($result->num_rows > 0) {
  // Saída dos dados de cada linha
  while($row = $result->fetch_assoc()) { 
  ?>
      
      <div class="pai_do_quadrado">
            <div class="quadrado" id="livros">
                <a href="livro.php?bookId=<?php echo $row['bookId']; ?>"><img class="livro" src="<?php echo $row['capa']; ?>" alt="<?php echo $row['titulo']; ?>"></a>
                <p class="legenda"><?php echo $row['titulo']; ?></p>
            </div>
            <button class="acao" onclick="toggleLivro(<?php echo $row['bookId']; ?>, this);"><?php if ($row['FK_bookId'] != null) { echo 'Remover'; } else { echo 'Adicionar'; } ?></button>
        </div>
      
  <?php
  
  }
  
} else {
  echo "0 results";
}
?>
        
    </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script> //script para abrir e fechar o menu dropdown
        document.addEventListener("DOMContentLoaded", function() {
            var dropdownToggle = document.getElementById("perfilDropdown");
            var dropdownMenu = document.querySelector(".dropdown-menu");
            
            dropdownToggle.addEventListener("click", function() {
                if (dropdownMenu.classList.contains("show")) {
                    dropdownMenu.classList.remove("show");
                } else {
                    dropdownMenu.classList.add("show");
                }
            });
        });
    </script>
    <script>
        function toggleLivro(bookId, botao) {
            botao.disabled = true;
            $.post({
                url: "toggleLivro.php",
                data: {
                    bookId: bookId
                },
                success: function( result ) {
                    if (botao.innerHTML == "Adicionar") {
                        botao.innerHTML = "Remover";
                    } else {
                        botao.innerHTML = "Adicionar";
                    }
                    botao.disabled = false;
                },
                error: function(result) {
                    botao.disabled = false;
                }
            });
            
        }
    </script>
</body>
</html>


<?php
$conn->close();

?>
