<?php
require_once 'conexao.php';

$erro = '';
$nome = '';
$categoria = '';
$faixa_etaria = '';
$preco = '';
$quantidade = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $faixa_etaria = trim($_POST['faixa_etaria'] ?? '');
    $preco = str_replace(',', '.', trim($_POST['preco'] ?? ''));
    $quantidade = trim($_POST['quantidade'] ?? '');

    if ($nome === '' || $categoria === '' || $faixa_etaria === '') {
        $erro = 'Preencha todos os campos de texto.';
    } elseif (!is_numeric($preco) || (float) $preco < 0) {
        $erro = 'Informe um preço válido.';
    } elseif (filter_var($quantidade, FILTER_VALIDATE_INT) === false || (int) $quantidade < 0) {
        $erro = 'Informe uma quantidade válida.';
    } else {
        $preco = (float) $preco;
        $quantidade = (int) $quantidade;

        $stmt = $conn->prepare('INSERT INTO brinquedos (nome, categoria, faixa_etaria, preco, quantidade) VALUES (?, ?, ?, ?, ?)');

        if ($stmt) {
            $stmt->bind_param('sssdi', $nome, $categoria, $faixa_etaria, $preco, $quantidade);

            if ($stmt->execute()) {
                $stmt->close();
                header('Location: index.php?sucesso=' . urlencode('Brinquedo cadastrado com sucesso.'));
                exit;
            }

            $erro = 'Erro ao cadastrar o brinquedo.';
            $stmt->close();
        } else {
            $erro = 'Erro ao preparar o cadastro.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Brinquedo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="container pequeno">
        <h1>Cadastrar Brinquedo</h1>

        <?php if ($erro): ?>
            <div class="mensagem erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="post">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" maxlength="100" value="<?= htmlspecialchars($nome) ?>" required>

            <label for="categoria">Categoria</label>
            <input type="text" id="categoria" name="categoria" maxlength="60" value="<?= htmlspecialchars($categoria) ?>" required>

            <label for="faixa_etaria">Faixa etária</label>
            <input type="text" id="faixa_etaria" name="faixa_etaria" maxlength="40" placeholder="Ex.: 6 a 10 anos" value="<?= htmlspecialchars($faixa_etaria) ?>" required>

            <label for="preco">Preço</label>
            <input type="number" id="preco" name="preco" min="0" step="0.01" value="<?= htmlspecialchars($preco) ?>" required>

            <label for="quantidade">Quantidade em estoque</label>
            <input type="number" id="quantidade" name="quantidade" min="0" step="1" value="<?= htmlspecialchars($quantidade) ?>" required>

            <div class="botoes">
                <button class="botao" type="submit">Cadastrar</button>
                <a class="botao secundario" href="index.php">Voltar</a>
            </div>
        </form>
    </main>
</body>
</html>
