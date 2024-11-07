<?php
    session_start();
    include 'includes/db.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ? AND password = ?");
        $stmt->execute([$username, md5($password)]);
        $user = $stmt->fetch();
        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: reqs/view_reqs.php');
            exit;
        } else {
            $error = "Nome de usuário ou senha inválidos.";
        }
    }
    include 'includes/header.php'; // Inclui o cabeçalho
?>
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-container">
        <h3 style="font-family: Arial, sans-serif; color: #009688;">SIMPLE PHARMA</h3>
        <p style="font-size: 12px; color: #6c757d;">MANIPULAÇÃO</p>
        <form method="POST" action="">
            <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Usuário" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
            </div>
            <button type="submit" class="btn btn-custom">Entrar</button>
            <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; // Inclui o rodapé?>