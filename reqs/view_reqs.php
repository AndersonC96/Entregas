<?php
    session_start();
    include '../includes/db.php';
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
    // Consulta todas as requisições no banco de dados
    $stmt = $pdo->query("SELECT * FROM requisicoes ORDER BY data_hora DESC");
    $requisicoes = $stmt->fetchAll();
    include '../includes/header.php';
?>
<h2>Requisições Registradas</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Número</th>
            <th>Foto</th>
            <th>Data e Hora</th>
            <th>Entregador</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($requisicoes as $req): ?>
            <tr>
                <td><?= htmlspecialchars($req['id']) ?></td>
                <td><?= htmlspecialchars($req['numero']) ?></td>
                <td>
                    <?php if ($req['foto']): ?>
                        <img src="../uploads/<?= htmlspecialchars($req['foto']) ?>" alt="Foto da Requisição" style="width: 100px; height: auto;">
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($req['data_hora']) ?></td>
                <td><?= htmlspecialchars($req['entregador']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>