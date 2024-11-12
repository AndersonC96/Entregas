<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
    // Captura o termo de busca, se existir
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
    // Modifica a consulta para incluir o termo de busca
    if ($searchTerm) {
        $stmt = $pdo->prepare("SELECT * FROM requisicoes WHERE numero LIKE :search OR entregador LIKE :search ORDER BY data_hora DESC");
        $stmt->execute(['search' => '%' . $searchTerm . '%']);
    } else {
        $stmt = $pdo->query("SELECT * FROM requisicoes ORDER BY data_hora DESC");
    }
    $requisicoes = $stmt->fetchAll();
    include '../includes/header.php';
    include '../includes/navbar.php';
?>
<div class="container mt-4">
    <h2 class="text-center mb-4" style="font-weight: bold; color: #333;">Requisições Registradas</h2>
    <!-- Campo de busca -->
    <form method="GET" action="" class="mb-4 d-flex justify-content-center">
        <input type="text" name="search" class="form-control w-50" placeholder="Buscar por número ou entregador" value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit" class="btn btn-primary ms-2">Buscar</button>
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle table-bordered custom-table" style="border-radius: 8px; overflow: hidden; background-color: #f8f9fa;">
            <thead class="desktop-header">
                <tr>
                    <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">ID</th>
                    <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Requisição</th>
                    <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Foto</th>
                    <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Data e Hora</th>
                    <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Entregador</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($requisicoes) > 0): ?>
                    <?php foreach ($requisicoes as $req): ?>
                        <tr class="card-row">
                            <td data-label="ID"><?= htmlspecialchars($req['id']) ?></td>
                            <td data-label="Requisição"><?= htmlspecialchars($req['numero']) ?></td>
                            <td data-label="Foto">
                                <?php if ($req['foto']): ?>
                                    <img src="../uploads/<?= htmlspecialchars($req['foto']) ?>" alt="Foto da Requisição" style="width: 100px; height: auto;">
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td data-label="Data e Hora">
                                <?php
                                $dataHora = new DateTime($req['data_hora']);
                                echo htmlspecialchars($dataHora->format("d/m/Y H:i"));
                                ?>
                            </td>
                            <td data-label="Entregador"><?= htmlspecialchars($req['entregador']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma requisição encontrada.</td>
                    </tr>
                <?php endif; ?>
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
        .desktop-header {
            display: none;
        }
        .custom-table tbody tr.card-row {
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd;
            background-color: #fff;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .custom-table tbody tr.card-row td {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }
        .custom-table tbody tr.card-row td:last-child {
            border-bottom: none;
        }
        .custom-table tbody tr.card-row td:before {
            content: attr(data-label);
            font-weight: bold;
            color: #52b1a9;
            margin-right: 10px;
        }
    }
</style>
<?php include '../includes/footer.php'; ?>