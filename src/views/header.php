<?php
    require_once '../src/helpers/AuthHelper.php';
    AuthHelper::requireLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title ?? 'Sistema de Entregas'; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <!-- Barra de navegação -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Sistema de Entregas</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?rota=dashboard">Dashboard</a>
                    </li>
                    <?php if (AuthHelper::isAdmin()) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?rota=cadastro-usuario">Cadastrar Usuário</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?rota=cadastro-entrega">Cadastrar Entrega</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?rota=relatorio">Relatórios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/index.php?rota=logout">Sair</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container mt-5">