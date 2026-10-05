<?php
require_once 'conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$erro = '';

if (!$id || $id < 1) {
    die('ID inválido.');
}

$stmt = $conn->prepare('SELECT nome, categoria, faixa_etaria, preco, quantidade FROM brinquedos WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$resultado = $stmt->get_result();
$brinquedo = $resultado->fetch_assoc();
$stmt->close();

if (!$brinquedo) {
    die('Brinquedo não encontrado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $faixa_etaria = trim($_POST['faixa_etaria'] ?? '');
    $preco = str_replace(',', '.', trim($_POST['preco'] ?? ''));
    $quantidade = trim($_POST['quantidade'] ?? '');

    $brinquedo['nome'] = $nome;
    $brinquedo['categoria'] = $categoria;
    $brinquedo['faixa_etaria'] = $faixa_etaria;
    $brinquedo['preco'] = $preco;
    $brinquedo['quantidade'] = $quantidade;

    if ($nome === '' || $categoria === '' || $faixa_etaria === '') {
        $erro = 'Preencha todos os campos de texto.';
    } elseif (!is_numeric($preco) || (float) $preco < 0) {
        $erro = 'Informe um preço válido.';
    } elseif (filter_var($quantidade, FILTER_VALIDATE_INT) === false || (int) $quantidade < 0) {
        $erro = 'Informe uma quantidade válida.';
    } else {
        $preco = (float) $preco;
        $quantidade = (int) $quantidade;

        $stmt = $conn->prepare('UPDATE brinquedos SET nome = ?, categoria = ?, faixa_etaria = ?, preco = ?, quantidade = ? WHERE id = ?');

        if ($stmt) {
            $stmt->bind_param('sssdii', $nome, $categoria, $faixa_etaria, $preco, $quantidade, $id);

            if ($stmt->execute()) {
                $stmt->close();
                header('Location: index.php?sucesso=' . urlencode('Brinquedo atualizado com sucesso.'));
                exit;
            }

            $erro = 'Erro ao atualizar o brinquedo.';
            $stmt->close();
        } else {
            $erro = 'Erro ao preparar a atualização.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Brinquedo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="container pequeno">
        <h1>Editar Brinquedo</h1>

        <?php if ($erro): ?>
            <div class="mensagem erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="post">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" maxlength="100" value="<?= htmlspecialchars($brinquedo['nome']) ?>" required>

            <label for="categoria">Categoria</label>
            <input type="text" id="categoria" name="categoria" maxlength="60" value="<?= htmlspecialchars($brinquedo['categoria']) ?>" required>

            <label for="faixa_etaria">Faixa etária</label>
            <input type="text" id="faixa_etaria" name="faixa_etaria" maxlength="40" value="<?= htmlspecialchars($brinquedo['faixa_etaria']) ?>" required>

            <label for="preco">Preço</label>
            <input type="number" id="preco" name="preco" min="0" step="0.01" value="<?= htmlspecialchars($brinquedo['preco']) ?>" required>

            <label for="quantidade">Quantidade em estoque</label>
            <input type="number" id="quantidade" name="quantidade" min="0" step="1" value="<?= htmlspecialchars($brinquedo['quantidade']) ?>" required>

            <div class="botoes">
                <button class="botao" type="submit">Salvar alterações</button>
                <a class="botao secundario" href="index.php">Voltar</a>
            </div>
        </form>
    </main>
</body>
</html>
