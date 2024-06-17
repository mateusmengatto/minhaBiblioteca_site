<?php
session_start();

// Finaliza a sessão
session_destroy();

// Redireciona para a página de login ou outra página desejada após o logout
header("Location: login.php");
exit;
?>
