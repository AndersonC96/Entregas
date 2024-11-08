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
    <h1 class="text-center">Bem-vindo, <span style="color: #52b1a9;"><?= htmlspecialchars($_SESSION['user']['nome']); ?></span>!</h1>
    <p class="lead text-center">Aqui você pode acessar todas as funcionalidades do sistema.</p>
    <!-- Estilo de Hover para os Cards e Botões Customizados -->
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .btn-custom-card {
            background-color: #52b1a9;
            border-color: #52b1a9;
            color: white;
        }
        .btn-custom-card:hover {
            background-color: #3d8e84;
            border-color: #3d8e84;
        }
    </style>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Cadastrar Requisição</h5>
                    <p class="card-text">Registre uma nova requisição no sistema.</p>
                    <a href="reqs/add_req.php" class="btn btn-custom-card">Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Visualizar Requisições</h5>
                    <p class="card-text">Acesse todas as requisições registradas.</p>
                    <a href="reqs/view_reqs.php" class="btn btn-custom-card">Acessar</a>
                </div>
            </div>
        </div>
        <?php if ($_SESSION['user']['is_admin']): ?>
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Cadastrar Usuários</h5>
                    <p class="card-text">Adicionar usuários do sistema.</p>
                    <a href="admin/create_user.php" class="btn btn-custom-card">Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Visualizar Usuários</h5>
                    <p class="card-text">Visualizar todos usuários do sistema.</p>
                    <a href="admin/view_users.php" class="btn btn-custom-card">Acessar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Remover Usuários</h5>
                    <p class="card-text">Remover usuários do sistema.</p>
                    <a href="admin/delete_user.php" class="btn btn-custom-card">Acessar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Relatórios</h5>
                    <p class="card-text">Gerar relatório.</p>
                    <a href="reqs/report.php" class="btn btn-custom-card">Acessar</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>