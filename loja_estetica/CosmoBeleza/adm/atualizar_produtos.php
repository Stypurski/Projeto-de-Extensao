<?php
session_start();
if (!isset($_SESSION["id_adm"])) {
    header("Location: index.php");
    exit;
}

include("../conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int) ($_POST["id_produto"] ?? 0);
    $nome = trim($_POST["nome"] ?? "");
    $valor = str_replace(",", ".", trim($_POST["valor"] ?? ""));
    $imagem = trim($_POST["imagem"] ?? "");

    if ($id <= 0 || $nome === "" || !is_numeric($valor) || (float)$valor <= 0) {
        header("Location: listarProdutos.php?erro=dados");
        exit;
    }

    $valor_float = (float) $valor;
    $stmt = mysqli_prepare($conexao, "UPDATE produtos SET nome = ?, valor = ?, imagem = ? WHERE id_produto = ?");
    mysqli_stmt_bind_param($stmt, "sdsi", $nome, $valor_float, $imagem, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: listarProdutos.php?atualizado=1");
        exit;
    } else {
        echo "Erro ao atualizar produto.";
    }
} else {
    header("Location: listarProdutos.php");
    exit;
}
?>ro ao atualizar produto.";
}
?>
