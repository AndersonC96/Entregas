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
        <table class="table table-hover align-middle table-bordered" style="border-radius: 8px; overflow: hidden; background-color: #f8f9fa;">
            <thead style="background-color: #52b1a9; color: white;">
                <tr>
                    <th>ID</th>
                    <th>Req.</th>
                    <th>Foto</th>
                    <th>Data e Hora</th>
                    <th>Entregador</th>
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
<!-- Estilos de CSS para Melhorar a Aparência da Tabela -->
<style>
    /* Cabeçalho da Tabela */
    .table thead {
        background-color: #52b1a9;
        /* Fundo do cabeçalho */
        color: white;
        /* Cor do texto do cabeçalho */
        font-weight: bold;
    }
    /* Bordas arredondadas */
    .table {
        border-radius: 8px;
        overflow: hidden;
    }
    /* Linha de hover */
    .table-hover tbody tr:hover {
        background-color: #e3f2fd;
        /* Cor de fundo ao passar o mouse */
    }
    /* Estilos para as Células */
    .table td,
    .table th {
        padding: 16px;
        /* Aumenta o espaçamento das células */
        vertical-align: middle;
    }
    /* Ajuste da Imagem */
    .table img {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 2px;
    }
</style>

<?php include '../includes/footer.php'; ?>