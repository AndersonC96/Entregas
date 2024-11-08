<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
    $stmt = $pdo->query("SELECT * FROM requisicoes ORDER BY data_hora DESC");
    $requisicoes = $stmt->fetchAll();
    include '../includes/header.php';
    include '../includes/navbar.php';
?>
<div class="container mt-4">
    <h2 class="text-center mb-4" style="font-weight: bold; color: #333;">Requisições Registradas</h2>
    <div class="table-responsive">
        <table class="table table-hover align-middle table-bordered custom-table" style="border-radius: 8px; overflow: hidden; background-color: #f8f9fa;">
            <thead>
                <tr>
                    <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">ID</th>
                    <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Requisição</th>
                    <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Foto</th>
                    <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Data e Hora</th>
                    <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Entregador</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requisicoes as $req): ?>
                    <tr>
                        <td><?= htmlspecialchars($req['id']) ?></td>
                        <td><?= htmlspecialchars($req['numero']) ?></td>
                        <td>
                            <?php if ($req['foto']): ?>
                                <img src="../uploads/<?= htmlspecialchars($req['foto']) ?>" alt="Foto da Requisição" style="width: 100px; height: auto;">
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            $dataHora = new DateTime($req['data_hora']);
                            echo htmlspecialchars($dataHora->format("d/m/Y H:i"));
                            ?>
                        </td>
                        <td><?= htmlspecialchars($req['entregador']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<style>
    /* Bordas arredondadas */
    .custom-table {
        border-radius: 8px;
        overflow: hidden;
    }
    /* Linha de hover */
    .table-hover tbody tr:hover {
        background-color: #e3f2fd;
    }
    /* Centralização das Células */
    .custom-table td,
    .custom-table th {
        padding: 16px;
        vertical-align: middle;
        text-align: center;
    }
    /* Ajuste da Imagem */
    .custom-table img {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 2px;
    }
    /* Estilo para a exibição mobile */
    @media (max-width: 768px) {
        .custom-table thead {
            display: none;
        }
        .custom-table tbody tr {
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 8px;
        }
        .custom-table tbody tr td {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .custom-table tbody tr td:last-child {
            border-bottom: none;
        }
        .custom-table tbody tr td:before {
            content: attr(data-label);
            font-weight: bold;
            color: #52b1a9;
            flex: 1;
        }
    }
</style>
<?php include '../includes/footer.php'; ?>