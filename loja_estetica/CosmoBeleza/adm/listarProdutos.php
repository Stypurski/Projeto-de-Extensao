<?php
session_start();
if (!isset($_SESSION["id_adm"])) {
    header("Location: index.php");
    exit;
}

include("../conexao.php");

$sql = "SELECT * FROM produtos ORDER BY id_produto DESC";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Produtos Cadastrados</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #fcc5d8;
    margin: 0;
    padding: 20px;
}
.container {
    width: 90%;
    max-width: 1100px;
    margin: 40px auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    box-sizing: border-box;
    overflow-x: auto;
}
h1 {
    text-align: center;
    color: orange;
    margin-bottom: 25px;
}
table {
    border-collapse: collapse;
    width: 100%;
}
th {
    background: orange;
    color: white;
    padding: 12px;
}
td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}
tr:nth-child(even) {
    background: #fff5f8;
}
img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}
.botao {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    color: white;
    font-weight: bold;
}
.editar {
    background: #ff9800;
}
.excluir {
    background: #e53935;
}
.menu {
    margin-top: 25px;
    text-align: center;
}
.menu a {
    display: inline-block;
    margin: 5px;
    padding: 12px 18px;
    background: orange;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
}
.menu a:hover,
.botao:hover {
    opacity: 0.9;
}
.alerta-sucesso {
    background: #e0f7e9;
    color: #1b5e20;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    text-align: center;
    font-size: 14px;
}
.alerta-erro {
    background: #ffe0e0;
    color: #b00020;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    text-align: center;
    font-size: 14px;
}
</style>
</head>
<body>

<div class="container">
    <h1>Produtos Cadastrados</h1>

    <?php if (isset($_GET["cadastrado"])): ?>
        <div class="alerta-sucesso">Produto cadastrado com sucesso!</div>
    <?php elseif (isset($_GET["atualizado"])): ?>
        <div class="alerta-sucesso">Produto atualizado com sucesso!</div>
    <?php elseif (isset($_GET["excluido"])): ?>
        <div class="alerta-sucesso">Produto excluído com sucesso!</div>
    <?php elseif (isset($_GET["erro"]) && $_GET["erro"] === "vinculado"): ?>
        <div class="alerta-erro">Não é possível excluir este produto porque ele já faz parte de pedidos registrados.</div>
    <?php elseif (isset($_GET["erro"]) && $_GET["erro"] === "dados"): ?>
        <div class="alerta-erro">Dados inválidos ao tentar atualizar o produto.</div>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Imagem</th>
            <th>Editar</th>
            <th>Excluir</th>
        </tr>

        <?php while ($produto = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?= (int) $produto["id_produto"] ?></td>
                <td><?= htmlspecialchars($produto["nome"]) ?></td>
                <td>R$ <?= number_format($produto["valor"], 2, ",", ".") ?></td>
                <td>
                    <img src="<?= htmlspecialchars($produto["imagem"]) ?>" alt="<?= htmlspecialchars($produto["nome"]) ?>">
                </td>
                <td>
                    <a class="botao editar" href="editarProduto.php?id=<?= (int) $produto["id_produto"] ?>">Editar</a>
                </td>
                <td>
                    <a class="botao excluir" href="excluirProduto.php?id=<?= (int) $produto["id_produto"] ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="menu">
        <a href="cadastrarProdutos.php">Cadastrar Novo Produto</a>
        <a href="index.php">Voltar ao Painel</a>
    </div>
</div>

</body>
</html>
