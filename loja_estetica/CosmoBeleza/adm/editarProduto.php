<?php

include("../conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM produtos WHERE id_produto = $id";

$resultado = mysqli_query($conexao, $sql);

$produto = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<title>Editar Produto</title>

<style>

body{
    font-family: Arial, sans-serif;
    background: #fcc5d8;
    margin: 0;
    padding: 0;
}

.container{
    width: 500px;
    margin: 80px auto;
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

label{
    display: block;
    color: orange;
    font-weight: bold;
    margin-top: 10px;
}

input[type="text"],
input[type="number"]{
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: none;
    border-radius: 8px;
    background: #ffe6ef;
    box-sizing: border-box;
}

input[type="submit"]{
    width: 100%;
    padding: 12px;
    margin-top: 20px;
    background: orange;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}

input[type="submit"]:hover{
    background: #ff9800;
}

a{
    display: block;
    text-align: center;
    margin-top: 20px;
    background: orange;
    color: white;
    text-decoration: none;
    padding: 12px;
    border-radius: 8px;
    font-weight: bold;
}

a:hover{
    background: #ff9800;
}

</style>

</head>

<body>

<div class="container">

<h1>Editar Produto</h1>

<form action="atualizarProdutos.php" method="POST">

<input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">

<label>Nome:</label>
<input type="text" name="nome" value="<?= $produto['nome'] ?>" required>

<label>Preço:</label>
<input type="number" step="0.01" name="valor" value="<?= $produto['valor'] ?>" required>

<label>Imagem (URL):</label>
<input type="text" name="imagem" value="<?= $produto['imagem'] ?>" required>

<input type="submit" value="Salvar Alterações">

</form>

<a href="listarProdutos.php">Voltar para a Lista</a>

</div>

</body>

</html>