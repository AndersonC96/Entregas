<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
    // Se o formulário foi enviado, processa os filtros
    $dataInicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
    $dataFim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';
    $entregador = isset($_GET['entregador']) ? $_GET['entregador'] : '';
    // Define o nome do arquivo CSV
    $nomeArquivo = "relatorio_requisicoes_" . date("Y-m-d_H-i-s") . ".csv";
    // Configura os cabeçalhos para download do arquivo CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $nomeArquivo);
    // Abre a saída padrão como arquivo para escrita do CSV
    $output = fopen('php://output', 'w');
    // Escreve a linha de cabeçalho no arquivo CSV
    fputcsv($output, ['ID', 'Número', 'Data e Hora', 'Entregador']);
    // Constrói a consulta SQL com filtros, se fornecidos
    $sql = "SELECT id, numero, data_hora, entregador FROM requisicoes WHERE 1=1";
    $params = [];
    if ($dataInicio) {
        $sql .= " AND data_hora >= :dataInicio";
        $params[':dataInicio'] = $dataInicio . ' 00:00:00';
    }
    if ($dataFim) {
        $sql .= " AND data_hora <= :dataFim";
        $params[':dataFim'] = $dataFim . ' 23:59:59';
    }
    if ($entregador) {
        $sql .= " AND entregador LIKE :entregador";
        $params[':entregador'] = '%' . $entregador . '%';
    }
    $sql .= " ORDER BY data_hora DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $requisicoes = $stmt->fetchAll();
    // Escreve cada linha de requisição no CSV
    foreach ($requisicoes as $req) {
        fputcsv($output, [$req['id'], $req['numero'], $req['data_hora'], $req['entregador']]);
    }
    // Fecha o recurso de saída
    fclose($output);
    exit;
?>