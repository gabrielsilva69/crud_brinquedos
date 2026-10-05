<?php
require_once 'conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    die('ID inválido.');
}

$stmt = $conn->prepare('DELETE FROM brinquedos WHERE id = ?');

if (!$stmt) {
    die('Erro ao preparar a exclusão.');
}

$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    $stmt->close();
    header('Location: index.php?sucesso=' . urlencode('Brinquedo excluído com sucesso.'));
    exit;
}

$stmt->close();
die('Erro ao excluir o brinquedo.');
?>
