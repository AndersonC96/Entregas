<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
    // Define o fuso horário para garantir que a hora seja a correta
    date_default_timezone_set('America/Sao_Paulo');
    // Captura os dados do formulário
    $numero = $_POST['numero'];
    $entregador = $_SESSION['user']['nome'];
    $dataHora = date("Y-m-d H:i:s"); // Hora atual correta
    $foto = $_FILES['foto'];
    // Processo de upload da foto
    $fotoNome = null;
    if ($foto && $foto['tmp_name']) {
        // Formata a data e hora para o nome do arquivo
        $dataHoraFormatada = date("d-m-Y_H-i-s");
        $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
        // Nome do arquivo: Número da requisição + data/hora
        $fotoNome = $numero . '_' . $dataHoraFormatada . '.' . $ext;
        move_uploaded_file($foto['tmp_name'], "../uploads/" . $fotoNome);
    }
    // Insere a requisição no banco de dados
    $stmt = $pdo->prepare("INSERT INTO requisicoes (numero, data_hora, entregador, foto) VALUES (?, ?, ?, ?)");
    $stmt->execute([$numero, $dataHora, $entregador, $fotoNome]);
    // Redireciona para a página de visualização de requisições
    header('Location: view_reqs.php');
    exit;