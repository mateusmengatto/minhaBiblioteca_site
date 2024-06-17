<?php

require 'db_credentials.php';

function bdconnect(){
    global $servername, $username, $password, $dbname;
    // Conectar ao banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    
    return($conn);
}

function isEmailExists($db, $tableName, $email)
{
        // SQL Statement
        $sql = "SELECT * FROM ".$tableName." WHERE email='".$email."'";

        // Process the query
        $results = $db->query($sql);

        // Fetch Associative array
        $row = $results->fetch_assoc();

        // Check if there is a result and response to  1 if email is existing
        return (is_array($row) && count($row)>0);
}

function isUserExists($db, $tableName, $userName){
        // SQL Statement
        $sql = "SELECT * FROM ".$tableName." WHERE userName='".$userName."'";

        // Process the query
        $results = $db->query($sql);

        // Fetch Associative array
        $row = $results->fetch_assoc();

        // Check if there is a result and response to  1 if email is existing
        return (is_array($row) && count($row)>0);
}


function isPasswordUser($db, $tableName, $userName, $password){
    $sql = "SELECT * FROM ".$tableName." WHERE userName='".$userName."'";
    
    $results = $db->query($sql);
    
    if($results->num_rows > 0){
        $row = $results->fetch_assoc();
        return password_verify($password, $row['senha']);
    } else {
        return false;
    }
}

function isPasswordPattern($password) {
    // Define o padrão para a senha
    $passwordPattern = '/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};:\\|,.<>\/?]).{8,}$/';

    // Verifica se a senha atende aos critérios
    return preg_match($passwordPattern, $password);
}


function run_query($query, $params, $paramTypes) {
        $conn = bdconnect();
    
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param($paramTypes, ...$params);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
            }
            $stmt->close();
        }
        $conn->close();
        return $result;
}

function execute_sql($query, $params, $paramTypes) {
        $conn = bdconnect();
        $conn->begin_transaction();
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param($paramTypes, ...$params);

            if ($stmt->execute()) {
                $conn->commit();
            } else {
                $conn->rollback();
            }
            $stmt->close();
        }
        $conn->close();
}
?>