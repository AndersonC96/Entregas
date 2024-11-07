<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../dashboard.php">Sistema de Entregas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="view_reqs.php">Visualizar Requisições</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_req.php">Cadastrar Requisição</a>
                </li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/create_user.php">Gerenciar Usuários</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>