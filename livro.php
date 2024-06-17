<?php 

include 'functions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$response = run_query('SELECT arquivo, titulo from Livro where bookId = ?', [$_GET['bookId']], 'i');

$livro = $response->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title><?php echo $livro['titulo']; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
  <div style="height:100vh">
    <iframe height="100%" width=100% src='lib/web/viewer.html?file=/<?php echo $livro['arquivo'];?>'></iframe>
  </div>
</body>

</html>