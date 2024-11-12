<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Captura os dados do formulário
        $numero = $_POST['numero'];
        $entregador = $_SESSION['user']['nome']; // Pega o nome do usuário logado
        $dataHora = date('Y-m-d H:i:s'); // Data e hora atuais
        // Processa o upload da foto, se fornecida
        $foto = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $nomeArquivo = uniqid() . '.' . $extensao;
            $destino = "../uploads/$nomeArquivo";
            // Move o arquivo para a pasta de uploads
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                $foto = $nomeArquivo;
            } else {
                $_SESSION['error'] = 'Erro ao fazer upload da foto.';
                header('Location: add_req.php');
                exit;
            }
        }
        // Insere a nova requisição no banco de dados
        $stmt = $pdo->prepare("INSERT INTO requisicoes (numero, foto, data_hora, entregador) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$numero, $foto, $dataHora, $entregador])) {
            $_SESSION['success'] = 'Requisição adicionada com sucesso!';
        } else {
            $_SESSION['error'] = 'Erro ao adicionar a requisição.';
        }
    }
    // Redireciona de volta para a página de adição de requisição ou outra página de sua escolha
    header('Location: view_reqs.php');
    exit;