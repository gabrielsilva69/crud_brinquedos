<?php
require_once 'conexao.php';

$erro = '';
$brinquedos = [];

$sql = "SELECT id, nome, categoria, faixa_etaria, preco, quantidade FROM brinquedos ORDER BY id DESC";
$resultado = $conn->query($sql);

if ($resultado) {
    while ($linha = $resultado->fetch_assoc()) {
        $brinquedos[] = $linha;
    }
} else {
    $erro = 'Não foi possível carregar os brinquedos.';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Brinquedos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="container">
        <div class="topo">
            <div>
                <h1>Gestão de Brinquedos</h1>
                <p>Cadastro e controle de brinquedos da loja.</p>
            </div>
            <a class="botao" href="cadastrar.php">Cadastrar brinquedo</a>
        </div>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="mensagem sucesso"><?= htmlspecialchars($_GET['sucesso']) ?></div>
        <?php endif; ?>

        <?php if ($erro): ?>
            <div class="mensagem erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <div class="tabela-area">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Faixa etária</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($brinquedos) === 0): ?>
                        <tr>
                            <td colspan="7" class="vazio">Nenhum brinquedo cadastrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($brinquedos as $brinquedo): ?>
                            <tr>
                                <td><?= (int) $brinquedo['id'] ?></td>
                                <td><?= htmlspecialchars($brinquedo['nome']) ?></td>
                                <td><?= htmlspecialchars($brinquedo['categoria']) ?></td>
                                <td><?= htmlspecialchars($brinquedo['faixa_etaria']) ?></td>
                                <td>R$ <?= number_format((float) $brinquedo['preco'], 2, ',', '.') ?></td>
                                <td><?= (int) $brinquedo['quantidade'] ?></td>
                                <td class="acoes">
                                    <a class="editar" href="editar.php?id=<?= (int) $brinquedo['id'] ?>">Editar</a>
                                    <a class="excluir" href="excluir.php?id=<?= (int) $brinquedo['id'] ?>" onclick="return confirm('Deseja realmente excluir este brinquedo?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
