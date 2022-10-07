<?php
    
    require_once "functions/functions.php";
    
    // URL base do sistema.
    $base = "http://localhost/crud";
    
    // Configurações do Banco de Dados.
    $db_name = "crud";
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    
    // Inicialização do objeto PDO para servir as classes de DAO do sistema.
    $pdo = new PDO("mysql:dbname=" . $db_name . ";host=" . $db_host, $db_user, $db_pass);