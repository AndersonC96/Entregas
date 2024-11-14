<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado e é administrador
    if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
        header('Location: ../index.php');
        exit;
    }
    // Verifica se há um termo de busca
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
    // Executa a consulta para obter a lista de usuários, filtrando pelo termo de busca, se fornecido
    if ($searchTerm) {
        //$stmt = $pdo->prepare("SELECT id, nome, username FROM usuarios WHERE is_admin = 0 AND nome LIKE ?");
        $stmt = $pdo->prepare("SELECT id, nome, username FROM usuarios WHERE nome LIKE ?");
        $stmt->execute(['%' . $searchTerm . '%']);
    } else {
        //$stmt = $pdo->query("SELECT id, nome, username FROM usuarios WHERE is_admin = 0");
        $stmt = $pdo->query("SELECT id, nome, username FROM usuarios");
    }
    $users = $stmt->fetchAll();
    include '../includes/header.php';
    include '../includes/navbar.php';
?>
<div class="container mt-5">
    <div class="col-md-10 mx-auto">
        <h3 class="text-center mb-4" style="font-weight: bold; color: #333;">Remover Usuário</h3>
        <!-- Campo de busca -->
        <form method="GET" action="" class="mb-4 d-flex justify-content-center">
            <input type="text" name="search" class="form-control w-50 rounded-pill px-4" placeholder="Buscar por nome" value="<?= htmlspecialchars($searchTerm) ?>" style="background-color: #333; color: white;">
            <button type="submit" class="btn ms-2" style="background-color: #52b1a9; color: white; border-radius: 50px;">Buscar</button>
        </form>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success" role="alert"><?= $success ?></div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered custom-table" style="border-radius: 8px; overflow: hidden; background-color: #f8f9fa;">
                <thead style="background-color: #52b1a9; color: white;">
                    <tr>
                        <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">ID</th>
                        <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Nome</th>
                        <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Nome de Usuário</th>
                        <th style="background-color: #52b1a9 !important; color: white !important; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($user['id']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($user['nome']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($user['username']) ?></td>
                                <td class="text-center">
                                    <a href="delete_user.php?id=<?= htmlspecialchars($user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhum usuário encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    /* Estilo da tabela */
    .table {
        border-radius: 8px;
        overflow: hidden;
    }
    .table thead {
        background-color: #52b1a9;
        color: white;
    }
    /* Estilo do botão */
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
        border-radius: 4px;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    /* Estilo do card */
    .card {
        background-color: #ffffff;
        border: none;
    }
    /* Estilos para o campo de busca */
    .form-control.rounded-pill {
        border: none;
        padding-left: 20px;
        background-color: #333;
        color: white;
    }
    /* Estilos para o botão de busca */
    .btn.ms-2 {
        background-color: #52b1a9;
        color: white;
        border-radius: 50px;
    }
    .btn.ms-2:hover {
        background-color: #3d8e84;
        color: white;
    }
</style>
<?php include '../includes/footer.php'; ?>