<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
    // Define o nome do arquivo CSV
    $nomeArquivo = "relatorio_requisicoes_" . date("Y-m-d_H-i-s") . ".csv";
    // Configura os cabeçalhos para download do arquivo CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $nomeArquivo);
    // Abre a saída padrão como arquivo para escrita do CSV
    $output = fopen('php://output', 'w');
    // Escreve a linha de cabeçalho no arquivo CSV
    fputcsv($output, ['ID', 'Número', 'Data e Hora', 'Entregador']);
    // Consulta todas as requisições no banco de dados
    $stmt = $pdo->query("SELECT id, numero, data_hora, entregador FROM requisicoes ORDER BY data_hora DESC");
    $requisicoes = $stmt->fetchAll();
    // Escreve cada linha de requisição no CSV
    foreach ($requisicoes as $req) {
        fputcsv($output, [$req['id'], $req['numero'], $req['data_hora'], $req['entregador']]);
    }
    // Fecha o recurso de saída
    fclose($output);
    exit;