<?php
session_start();
if (!isset($_SESSION["id_adm"])) {
    header("Location: index.php");
    exit;
}

include("../conexao.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cadastrarProdutos.php");
    exit;
}

$nome = trim($_POST["nome"] ?? "");
$valor = str_replace(",", ".", trim($_POST["valor"] ?? ""));
$imagem = trim($_POST["imagem"] ?? "");

if ($nome === "" || !is_numeric($valor) || (float)$valor <= 0 || $imagem === "") {
    header("Location: cadastrarProdutos.php?erro=1");
    exit;
}

$valor_float = (float) $valor;
$stmt = mysqli_prepare($conexao, "INSERT INTO produtos (nome, valor, imagem) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sds", $nome, $valor_float, $imagem);
$sucesso = mysqli_stmt_execute($stmt);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastro de Produto</title>
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #fcc5d8;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.caixa {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,.2);
    text-align: center;
    width: 400px;
    max-width: 90%;
    box-sizing: border-box;
}
h2 {
    color: orange;
}
p {
    font-size: 16px;
}
a {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 25px;
    background: orange;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
}
a:hover {
    background: #ff9800;
}
</style>
</head>
<body>

<div class="caixa">
    <?php if ($sucesso): ?>
        <h2>✅ Produto cadastrado com sucesso!</h2>
        <a href="listarProdutos.php">Ver Produtos</a>
    <?php else: ?>
        <h2>❌ Erro ao cadastrar</h2>
        <p>Não foi possível salvar o produto no banco de dados.</p>
        <a href="cadastrarProdutos.php">Voltar</a>
    <?php endif; ?>
</div>

</body>
</html>
</body>
</html>
