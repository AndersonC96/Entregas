<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado e é administrador
    if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
        header('Location: ../index.php');
        exit;
    }
    // Processa o formulário de criação de usuário
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = trim($_POST['nome']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        // Verifica se o nome de usuário já existe
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Nome de usuário já existe.";
        } else {
            // Cria o novo usuário
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, username, password, is_admin) VALUES (?, ?, ?, 0)");
            if ($stmt->execute([$nome, $username, md5($password)])) {
                $success = "Usuário criado com sucesso!";
            } else {
                $error = "Erro ao criar o usuário.";
            }
        }
    }
    include '../includes/header.php';
    include '../includes/navbar.php';
?>
<div class="container mt-5">
    <div class="col-md-6 mx-auto">
        <div class="card p-4" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <h3 class="text-center mb-4" style="font-weight: bold; color: #333;">Criar Novo Usuário</h3>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert"><?= $error ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="alert alert-success" role="alert"><?= $success ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required style="background-color: #f5f5f5; border: none; color: #333;">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Nome de Usuário</label>
                    <input type="text" class="form-control" id="username" name="username" required style="background-color: #f5f5f5; border: none; color: #333;">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" required style="background-color: #f5f5f5; border: none; color: #333;">
                </div>
                <button type="submit" class="btn w-100" style="background-color: #52b1a9; color: white; border-radius: 8px;">Criar Usuário</button>
            </form>
        </div>
    </div>
</div>
<style>
    /* Estilo do campo de formulário */
    .form-control {
        border-radius: 8px;
        padding: 10px;
    }
    /* Botão de submissão */
    .btn {
        font-weight: bold;
    }
    /* Estilo do card */
    .card {
        background-color: #ffffff;
        border: none;
    }
</style>
<?php include '../includes/footer.php'; ?>