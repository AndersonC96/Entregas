<?php
    // Configuração do banco de dados
    $host = 'localhost';
    $dbname = 'sistema_entregas';
    $username = 'root';
    $password = '';
    // DSN para conexão com o MySQL
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    try {
        // Criação da conexão usando PDO
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Em caso de erro, exibe a mensagem de erro e encerra o script
        die("Erro ao conectar com o banco de dados: " . $e->getMessage());
    }