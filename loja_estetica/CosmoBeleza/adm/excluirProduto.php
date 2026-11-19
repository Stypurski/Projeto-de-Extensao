<?php
session_start();
if (!isset($_SESSION["id_adm"])) {
    header("Location: index.php");
    exit;
}

include("../conexao.php");

$id = (int) ($_GET["id"] ?? 0);
if ($id <= 0) {
    header("Location: listarProdutos.php");
    exit;
}

try {
    $stmt = mysqli_prepare($conexao, "DELETE FROM produtos WHERE id_produto = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    header("Location: listarProdutos.php?excluido=1");
    exit;
} catch (mysqli_sql_exception $e) {
    header("Location: listarProdutos.php?erro=vinculado");
    exit;
}
?>
