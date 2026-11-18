<?php

include("../conexao.php");

$id = $_POST['id_produto'];
$nome = $_POST['nome'];
$valor = $_POST['valor'];
$imagem = $_POST['imagem'];

$sql = "UPDATE produtos
SET
    nome = '$nome',
    valor = '$valor',
    imagem = '$imagem'
WHERE id_produto = $id";

if(mysqli_query($conexao, $sql))
{
    header("Location: listarProdutos.php");
}
else
{
    echo "Erro ao atualizar produto.";
}
?>