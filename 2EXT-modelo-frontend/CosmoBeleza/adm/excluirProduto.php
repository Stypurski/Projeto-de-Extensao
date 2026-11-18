<?php

include("../conexao.php");

$id = $_GET["id"];

$sql = "DELETE FROM produtos
WHERE id_produto = $id";

if(mysqli_query($conexao,$sql))
{
    header("Location: listarProdutos.php");
}
else
{
    echo "Erro ao excluir.";
}

?>