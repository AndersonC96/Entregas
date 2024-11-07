<?php
    session_start();
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
        exit;
    }
    include 'includes/header.php';
?>
<div class="container mt-5">
    <h1>Bem-vindo ao Dashboard, <?= htmlspecialchars($_SESSION['user']['nome']); ?>!</h1>
    <p class="lead">Aqui você pode acessar todas as funcionalidades do sistema.</p>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Visualizar Requisições</h5>
                    <p class="card-text">Acesse todas as requisições registradas.</p>
                    <a href="reqs/view_reqs.php" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cadastrar Nova Requisição</h5>
                    <p class="card-text">Registre uma nova requisição no sistema.</p>
                    <a href="reqs/add_req.php" class="btn btn-primary">Cadastrar</a>
                </div>
            </div>
        </div>
        <?php if ($_SESSION['user']['is_admin']): ?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gerenciar Usuários</h5>
                        <p class="card-text">Adicione ou remova usuários do sistema.</p>
                        <a href="admin/create_user.php" class="btn btn-primary">Gerenciar</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>