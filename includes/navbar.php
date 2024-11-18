<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<nav class="navbar navbar-expand-lg" style="background-color: #cfd6df; padding: 10px;">
    <div class="container-fluid">
        <a class="navbar-brand" href="../dashboard.php" style="color: #52b1a9; font-weight: bold;">
            <!--<i class="fas fa-truck"></i> Sistema de Entregas-->
            <img src="https://static.wixstatic.com/media/6e2603_a1df562998b54aa79d9bedb9add87265~mv2.png/v1/crop/x_0,y_4,w_123,h_73/fill/w_120,h_71,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/logo.png" alt="Sistema de Entrega" width="60" height="35">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../dashboard.php" style="color: #52b1a9;">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="visualizarReqsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #52b1a9;">
                        <i class="fas fa-eye"></i> Requisições
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="visualizarReqsDropdown">
                        <li><a class="dropdown-item" href="../reqs/add_req.php"><i class="fas fa-check-circle"></i> Adicionar Req.</a></li>
                        <li><a class="dropdown-item" href="../reqs/view_reqs.php"><i class="fas fa-list"></i> Ver Todas</a></li>
                    </ul>
                </li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../reqs/report.php" style="color: #52b1a9;">
                            <i class="fas fa-file-alt"></i> Relatório
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="gerenciarUsuariosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #52b1a9;">
                            <i class="fas fa-users-cog"></i> Gerenciar Usuários
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="gerenciarUsuariosDropdown">
                            <li><a class="dropdown-item" href="../admin/create_user.php"><i class="fas fa-user-plus"></i> Adicionar Usuário</a></li>
                            <li><a class="dropdown-item" href="../admin/delete_user.php"><i class="fas fa-user-minus"></i> Remover Usuário</a></li>
                            <li><a class="dropdown-item" href="../admin/view_users.php"><i class="fas fa-users"></i> Visualizar Usuários</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle no-caret" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://e7.pngegg.com/pngimages/753/432/png-clipart-user-profile-2018-in-sight-user-conference-expo-business-default-business-angle-service-thumbnail.png" alt="perfil" class="rounded-circle me-2" width="40" height="40">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <!--<li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i>Conta</a></li>-->
                    <!--<li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configurações</a></li>-->
                    <li><a class="dropdown-item" href="../admin/pass_change.php"><i class="fas fa-cog me-2"></i>Alterar senha</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<style>
    .navbar .nav-link {
        color: #52b1a9 !important;
        /* Cor dos links de navegação */
    }
    .navbar .nav-link:hover {
        color: #3d8e84 !important;
        /* Cor ao passar o mouse sobre os links */
    }
    .dropdown-menu a {
        color: #333;
        /* Cor dos itens do dropdown */
    }
    .dropdown-menu a:hover {
        background-color: #52b1a9;
        color: white;
    }
    /* Remover a seta do dropdown */
    .no-caret::after {
        display: none !important;
    }
</style>