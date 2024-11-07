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
        $nome = $_POST['nome'];
        $username = $_POST['username'];
        $password = $_POST['password'];
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
?>
<h2>Criar Novo Usuário</h2>
<form method="POST" action="">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
    </div>
    <div class="mb-3">
        <label for="username" class="form-label">Nome de Usuário</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Criar Usuário</button>
    <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p class='text-success'>$success</p>"; ?>
</form>
<?php include '../includes/footer.php'; ?>