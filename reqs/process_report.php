<?php
session_start();
include '../includes/db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}

// Inclui a biblioteca PhpSpreadsheet
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Se o formulário foi enviado, processa os filtros
$dataInicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$dataFim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';
$entregador = isset($_GET['entregador']) ? $_GET['entregador'] : '';

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

// Cria uma nova planilha
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Define o cabeçalho da planilha
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Número');
$sheet->setCellValue('C1', 'Data e Hora');
$sheet->setCellValue('D1', 'Entregador');

// Personalização do cabeçalho
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['argb' => Color::COLOR_WHITE],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FF52B1A9'], // Cor de fundo
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => Color::COLOR_BLACK],
        ],
    ],
];

// Aplica o estilo ao cabeçalho
$sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

// Define a largura automática para cada coluna
foreach (range('A', 'D') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Preenche os dados das requisições na planilha
$row = 2;
foreach ($requisicoes as $req) {
    $sheet->setCellValue('A' . $row, $req['id']);
    $sheet->setCellValue('B' . $row, $req['numero']);
    $sheet->setCellValue('C' . $row, $req['data_hora']);
    $sheet->setCellValue('D' . $row, $req['entregador']);

    // Personalização das células de dados
    $sheet->getStyle("A$row:D$row")->applyFromArray([
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => Color::COLOR_BLACK],
            ],
        ],
    ]);
    $row++;
}

// Define o nome do arquivo Excel
$nomeArquivo = "relatorio_requisicoes_" . date("Y-m-d_H-i-s") . ".xlsx";

// Define os cabeçalhos para download do arquivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $nomeArquivo . '"');
header('Cache-Control: max-age=0');

// Gera o arquivo Excel e envia para download
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
