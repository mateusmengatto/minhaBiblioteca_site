<?php
include 'functions.php';

session_start();

function possui_favorito($bookId, $userId) {
    
        $query = "SELECT * FROM Favoritos  WHERE FK_bookId = ? AND FK_userId = ?";    
        $response = run_query($query, [$bookId, $userId], 'ii');
        return boolval($response->num_rows);
    
}

function insere_favorito($bookId, $userId) {
    
    $query = "INSERT INTO Favoritos (FK_bookId, FK_userId) values (?,?)";
    execute_sql($query, [$bookId, $userId], 'ii');
    
}

function apaga_favorito($bookId, $userId) {
    $query = "DELETE FROM Favoritos WHERE FK_bookId = ? AND FK_userId = ?";
    execute_sql($query, [$bookId, $userId], 'ii');
}


$userId = $_SESSION['userId'];


if (!is_int($userId)) {
    print_r('{status:false, message: "Usuário inválido."}');
}

$bookId = $_POST['bookId'];

if (!is_int(intval($bookId))) {
    print_r($_POST);
    print_r($bookId);
    print_r('{status:false, message: "Livro inválido."}');
}

if (possui_favorito($bookId, $userId)) {
    apaga_favorito($bookId, $userId);
} else {
    insere_favorito($bookId, $userId);
}

print_r('{status:true}');