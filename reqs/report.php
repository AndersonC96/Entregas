<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
    include '../includes/header.php';
    include '../includes/navbar.php';
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Gerar Relatório de Requisições</h2>
    <form action="process_report.php" method="GET" class="p-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="mb-3">
            <label for="data_inicio" class="form-label">Data Início</label>
            <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="">
        </div>
        <div class="mb-3">
            <label for="data_fim" class="form-label">Data Fim</label>
            <input type="date" class="form-control" id="data_fim" name="data_fim" value="">
        </div>
        <div class="mb-3">
            <label for="entregador" class="form-label">Entregador</label>
            <input type="text" class="form-control" id="entregador" name="entregador" placeholder="Nome do Entregador" value="">
        </div>
        <button type="submit" class="btn btn-primary w-100" style="background-color: #52b1a9; border: none;">Gerar Relatório</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>