<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
    // Processa o formulário de alteração de senha
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userId = $_SESSION['user']['id'];
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        // Verifica se a nova senha e a confirmação coincidem
        if ($newPassword !== $confirmPassword) {
            $error = "A nova senha e a confirmação de senha não coincidem.";
        } else {
            // Verifica se a senha atual está correta
            $stmt = $pdo->prepare("SELECT password FROM usuarios WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
            if (!$user || md5($currentPassword) !== $user['password']) {
                $error = "A senha atual está incorreta.";
            } else {
                // Atualiza a senha para a nova senha
                $stmt = $pdo->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
                if ($stmt->execute([md5($newPassword), $userId])) {
                    $success = "Senha alterada com sucesso!";
                } else {
                    $error = "Erro ao atualizar a senha. Tente novamente.";
                }
            }
        }
    }
    include '../includes/header.php';
    include '../includes/navbar.php';
?>
<div class="container mt-5">
    <div class="col-md-6 mx-auto">
        <div class="card p-4" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <h3 class="text-center mb-4" style="font-weight: bold; color: #333;">Alterar Senha</h3>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert"><?= $error ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="alert alert-success" role="alert"><?= $success ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="current_password" class="form-label">Senha Atual</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Nova Senha</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmar Nova Senha</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" style="background-color: #52b1a9; border: none;">Alterar Senha</button>
            </form>
        </div>
    </div>
</div>
<style>
    /* Estilo do card */
    .card {
        background-color: #ffffff;
        border: none;
    }

    /* Estilo do botão */
    .btn-primary {
        background-color: #52b1a9;
        color: white;
        border-radius: 5px;
    }

    .btn-primary:hover {
        background-color: #3d8e84;
        color: white;
    }
</style>

<?php include '../includes/footer.php'; ?>