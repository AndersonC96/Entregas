<?php
    // Inicializa a sessão para controle de login e autenticação
    session_start();
    // Inclui a configuração do banco de dados e funções auxiliares
    require_once './config/db.php';
    require_once './src/helpers/AuthHelper.php';
    // Obtém a rota da URL, ou define como 'home' se nenhuma rota for passada
    $rota = $_GET['rota'] ?? 'home';
    // Definição das rotas e os respectivos arquivos que elas carregam
    $rotas = [
        'login' => './src/controllers/LoginController.php',                // Tela de login
        'cadastro-usuario' => './src/controllers/CadastroUsuarioController.php',  // Cadastro de usuário
        'cadastro-entrega' => './src/controllers/CadastroEntregaController.php',  // Cadastro de entrega
        'relatorio' => './src/controllers/RelatorioController.php',        // Relatório de entregas
        'home' => './src/views/dashboard.php'                                  // Página inicial/dashboard
    ];
    // Verifica se a rota existe no array de rotas
    if (array_key_exists($rota, $rotas)) {
        // Verifica permissões para rotas restritas (exemplo: cadastro de usuário)
        if ($rota === 'cadastro-usuario' || $rota === 'remocao-usuario') {
            // Verifica se o usuário é um administrador (exemplo de validação)
            if (!AuthHelper::isAdmin()) {
                http_response_code(403); // Código de status de proibição
                echo "Acesso negado. Você não tem permissão para acessar esta página.";
                exit;
            }
        }
        // Carrega o arquivo correspondente à rota
        require $rotas[$rota];
    } else {
        // Exibe uma mensagem de erro 404 se a rota não for encontrada
        http_response_code(404);
        echo "Página não encontrada.";
    }