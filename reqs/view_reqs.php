<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
    // Captura o termo de busca e a página atual
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;
    // Modifica a consulta para incluir o termo de busca e a paginação
    if ($searchTerm) {
        $stmt = $pdo->prepare("SELECT * FROM requisicoes WHERE numero LIKE :search OR entregador LIKE :search ORDER BY data_hora DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmt = $pdo->prepare("SELECT * FROM requisicoes ORDER BY data_hora DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    }
    $requisicoes = $stmt->fetchAll();
    // Conta o total de registros para a paginação
    if ($searchTerm) {
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM requisicoes WHERE numero LIKE :search OR entregador LIKE :search");
        $countStmt->execute(['search' => '%' . $searchTerm . '%']);
    } else {
        $countStmt = $pdo->query("SELECT COUNT(*) FROM requisicoes");
    }
    $totalItems = $countStmt->fetchColumn();
    $totalPages = ceil($totalItems / $limit);
    include '../includes/header.php';
    include '../includes/navbar.php';
?>
<div class="d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container mt-4">
            <h2 class="text-center mb-4" style="font-weight: bold; color: #333;">Requisições Registradas</h2>
            <!-- Campo de busca -->
            <form method="GET" action="" class="mb-4 d-flex justify-content-center">
                <input type="text" name="search" class="form-control w-50 rounded-pill px-4" placeholder="Buscar por número ou entregador" value="<?= htmlspecialchars($searchTerm) ?>">
                <button type="submit" class="btn ms-2" style="background-color: #52b1a9; color: white; border-radius: 50px;">Buscar</button>
            </form>
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered custom-table" style="border-radius: 8px; overflow: hidden; background-color: #f8f9fa;">
                    <!-- Cabeçalho para desktop -->
                    <thead class="desktop-header">
                        <tr>
                            <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Requisição</th>
                            <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Foto</th>
                            <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Data e Hora</th>
                            <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Entregador</th>
                        </tr>
                    </thead>
                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php if (count($requisicoes) > 0): ?>
                            <?php foreach ($requisicoes as $req): ?>
                                <tr class="card-row">
                                    <td data-label="Requisição"><?= htmlspecialchars($req['numero']) ?></td>
                                    <td data-label="Foto">
                                        <?php if ($req['foto']): ?>
                                            <img src="../uploads/<?= htmlspecialchars($req['foto']) ?>" alt="Foto da Requisição" style="width: 100px; height: auto; cursor: pointer;" onclick="openModal('<?= htmlspecialchars($req['foto']) ?>')">
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
                                <td colspan="4" class="text-center">Nenhuma requisição encontrada.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Paginação -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= htmlspecialchars($searchTerm) ?>" style="color: #52b1a9;">Anterior</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= htmlspecialchars($searchTerm) ?>" style="<?= $i === $page ? 'background-color: #52b1a9; color: white;' : 'color: #52b1a9;' ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($searchTerm) ?>" style="color: #52b1a9;">Próximo</a>
                    </li>
                </ul>
            </nav>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</div>
<div id="imageModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
</div>
<script>
    function openModal(imagePath) {
        const modal = document.getElementById("imageModal");
        const modalImage = document.getElementById("modalImage");
        modal.style.display = "block";
        modalImage.src = `../uploads/${imagePath}`;
    }

    function closeModal() {
        document.getElementById("imageModal").style.display = "none";
    }

    window.onclick = function(event) {
        const modal = document.getElementById("imageModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
</script>
<style>
    /* Cabeçalho para desktop */
    .desktop-header {
        display: table-header-group;
    }
    /* Cabeçalho escondido em mobile */
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
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
    }
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        border-radius: 10px;
    }
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }
    .table-hover tbody tr:hover {
        background-color: #e3f2fd;
    }
    .custom-table td, .custom-table th {
        text-align: center;
        vertical-align: middle;
    }
</style>