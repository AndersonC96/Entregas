<?php
    $title = "Dashboard";
    require_once './src/views/header.php';
?>
<h1>Bem-vindo, <?php echo $_SESSION['usuario']['nome']; ?>!</h1>
<p>Seu nível de acesso: <?php echo $_SESSION['usuario']['nivel']; ?></p>
<div class="row mt-4">
    <?php if (AuthHelper::isAdmin()) : ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gestão de Usuários</h5>
                    <p class="card-text">Cadastrar, remover e editar usuários do sistema.</p>
                    <a href="/index.php?rota=cadastro-usuario" class="btn btn-primary">Gerenciar Usuários</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Gestão de Entregas</h5>
                <p class="card-text">Gerenciar entregas e acompanhar o status.</p>
                <a href="/index.php?rota=cadastro-entrega" class="btn btn-primary">Cadastrar Entrega</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Relatórios</h5>
                <p class="card-text">Visualizar relatórios de entregas.</p>
                <a href="/index.php?rota=relatorio" class="btn btn-primary">Ver Relatórios</a>
            </div>
        </div>
    </div>
</div>
<?php require_once './src/views/footer.php'; ?>