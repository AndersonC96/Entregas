<?php
    session_start();
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
    include '../includes/header.php';
    include '../includes/navbar.php';
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Cadastro de Requisição</h2>
    <form action="process_add_req.php" method="POST" enctype="multipart/form-data" class="p-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="mb-3">
            <label for="numero" class="form-label"><b>Número da Requisição</b></label>
            <input type="text" class="form-control" id="numero" name="numero" required style="background-color: #f5f5f5; border: none; color: #333;">
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label"><b>Foto da Requisição</b></label>
            <input type="file" class="form-control" id="foto" name="foto" style="background-color: #f5f5f5; border: none; color: #333;">
        </div>
        <button type="submit" class="btn btn-custom w-100"><b>Cadastrar Requisição</b></button>
    </form>
</div>
<style>
    /* Estilo para o botão personalizado */
    .btn-custom {
        background-color: #52b1a9;
        border-color: #52b1a9;
        color: white;
    }
    .btn-custom:hover {
        background-color: #3d8e84;
        border-color: #3d8e84;
    }
</style>
<?php include '../includes/footer.php'; ?>