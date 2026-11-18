<?php

include("../conexao.php");

$sql = "SELECT * FROM produtos";
$resultado = mysqli_query($conexao, $sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<title>Produtos Cadastrados</title>

<style>

body{
    font-family: Arial, sans-serif;
    background: #fcc5d8;
    margin: 0;
    padding: 20px;
}

.container{
    width: 90%;
    max-width: 1100px;
    margin: 40px auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

h1{
    text-align: center;
    color: orange;
    margin-bottom: 25px;
}

table{
    border-collapse: collapse;
    width: 100%;
}

th{
    background: orange;
    color: white;
    padding: 12px;
}

td{
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

tr:nth-child(even){
    background: #fff5f8;
}

img{
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.botao{
    display: inline-block;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    color: white;
    font-weight: bold;
}

.editar{
    background: #ff9800;
}

.excluir{
    background: #e53935;
}

.menu{
    margin-top: 25px;
    text-align: center;
}

.menu a{
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
.botao:hover{
    opacity: 0.9;
}

</style>

</head>

<body>

<div class="container">

<h1>Produtos Cadastrados</h1>

<table>

<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Preço</th>
    <th>Imagem</th>
    <th>Editar</th>
    <th>Excluir</th>
</tr>

<?php while($produto = mysqli_fetch_assoc($resultado)) { ?>

<tr>

    <td><?= $produto["id_produto"] ?></td>

    <td><?= $produto["nome"] ?></td>

    <td>R$ <?= number_format($produto["valor"],2,",",".") ?></td>

    <td>
        <img src="<?= $produto["imagem"] ?>">
    </td>

    <td>
        <a class="botao editar"
           href="editarProduto.php?id=<?= $produto["id_produto"] ?>">
           Editar
        </a>
    </td>

    <td>
        <a class="botao excluir"
           href="excluirProduto.php?id=<?= $produto["id_produto"] ?>">
           Excluir
        </a>
    </td>

</tr>

<?php } ?>

</table>

<div class="menu">

<a href="cadastrarProduto.php">
    Cadastrar Novo Produto
</a>

<a href="index.php">
    Voltar ao Painel
</a>

</div>

</div>

</body>

</html>