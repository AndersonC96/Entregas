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
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Nome de usuário ou senha inválidos.";
        }
    }
    include 'includes/header.php'; // Inclui o cabeçalho
?>
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-container">
        <img src="https://static.wixstatic.com/media/6e2603_a1df562998b54aa79d9bedb9add87265~mv2.png/v1/crop/x_0,y_4,w_123,h_73/fill/w_120,h_71,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/logo.png" alt="Sistema de Entrega">
        <form method="POST" action="">
            <br>
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