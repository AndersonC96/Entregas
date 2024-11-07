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
    include 'includes/header.php';
?>
<h2>Login</h2>
<form method="POST" action="">
    <div class="mb-3">
        <label for="username" class="form-label">Nome de usuário</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Entrar</button>
    <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
</form>
<?php include 'includes/footer.php'; ?>