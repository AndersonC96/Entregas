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
                        <td class="text-center"><?= htmlspecialchars($req['id']) ?></td>
                        <td class="text-center"><?= htmlspecialchars($req['numero']) ?></td>
                        <td class="text-center">
                            <?php if ($req['foto']): ?>
                                <img src="../uploads/<?= htmlspecialchars($req['foto']) ?>" alt="Foto da Requisição" style="width: 100px; height: auto;">
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php
                            $dataHora = new DateTime($req['data_hora']);
                            echo htmlspecialchars($dataHora->format("d/m/Y H:i"));
                            ?>
                        </td>
                        <td class="text-center"><?= htmlspecialchars($req['entregador']) ?></td>
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
        /* Cor de fundo ao passar o mouse */
    }
    /* Centralização das Células */
    .custom-table td,
    .custom-table th {
        padding: 16px;
        vertical-align: middle;
        text-align: center;
        /* Centraliza o conteúdo */
    }
    /* Ajuste da Imagem */
    .custom-table img {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 2px;
    }
</style>
<?php include '../includes/footer.php'; ?>