<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
    // Processa o formulário de cadastro de requisição
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $numero = $_POST['numero'];
        $entregador = $_SESSION['user']['nome']; // Pega o nome do usuário logado
        // Processa a foto
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $fotoNome = uniqid() . '_' . $_FILES['foto']['name'];
            $fotoCaminho = '../uploads/' . $fotoNome;
            // Move a foto para a pasta de uploads
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $fotoCaminho)) {
                // Insere a requisição no banco de dados
                $stmt = $pdo->prepare("INSERT INTO requisicoes (numero, foto, data_hora, entregador) VALUES (?, ?, NOW(), ?)");
                if ($stmt->execute([$numero, $fotoNome, $entregador])) {
                    $success = "Requisição cadastrada com sucesso!";
                } else {
                    $error = "Erro ao cadastrar a requisição.";
                }
            } else {
                $error = "Erro ao fazer upload da foto.";
            }
        } else {
            $error = "Por favor, envie uma foto válida.";
        }
    }
    include '../includes/header.php';
?>
<h2>Cadastro de Requisição</h2>
<?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
<?php if (isset($success)) echo "<p class='text-success'>$success</p>"; ?>
<form method="POST" action="" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="numero" class="form-label">Número da Requisição</label>
        <input type="text" class="form-control" id="numero" name="numero" required>
    </div>
    <div class="mb-3">
        <label for="foto" class="form-label">Foto da Requisição</label>
        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-primary">Cadastrar Requisição</button>
</form>
<?php include '../includes/footer.php'; ?>