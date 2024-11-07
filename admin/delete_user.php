<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado e é administrador
    if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
        header('Location: ../index.php');
        exit;
    }
    // Verifica se o ID do usuário foi fornecido via GET
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];
        // Previne que o administrador remova a si próprio
        if ($userId == $_SESSION['user']['id']) {
            $error = "Você não pode remover sua própria conta.";
        } else {
            // Exclui o usuário do banco de dados
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
            if ($stmt->execute([$userId])) {
                $success = "Usuário removido com sucesso!";
            } else {
                $error = "Erro ao remover o usuário.";
            }
        }
    }
    // Obtém a lista de usuários para exibição
    $stmt = $pdo->query("SELECT id, nome, username FROM usuarios WHERE is_admin = 0");
    $users = $stmt->fetchAll();
    include '../includes/header.php';
?>
<h2>Remover Usuário</h2>
<?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
<?php if (isset($success)) echo "<p class='text-success'>$success</p>"; ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Nome de Usuário</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['nome']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td>
                    <a href="delete_user.php?id=<?= htmlspecialchars($user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>