<?php

include("../conexao.php");

// Recebe os dados do formulário
$nome = $_POST["nome"];
$valor = $_POST["valor"];
$imagem = $_POST["imagem"];

// Comando SQL
$sql = "INSERT INTO produtos (nome, valor, imagem)
VALUES ('$nome', '$valor', '$imagem')";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro de Produto</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#fcc5d8;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.caixa{
    background:white;
    padding:40px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.2);
    text-align:center;
    width:400px;
}

h2{
    color:orange;
}

p{
    font-size:18px;
}

a{
    display:inline-block;
    margin-top:20px;
    padding:12px 25px;
    background:orange;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
}

a:hover{
    background:#ff9800;
}

</style>

</head>

<body>

<div class="caixa">

<?php

if(mysqli_query($conexao, $sql))
{
    echo "<h2>✅ Produto cadastrado com sucesso!</h2>";
    echo "<a href='listarProdutos.php'>Ver Produtos</a>";
}
else
{
    echo "<h2>❌ Erro ao cadastrar</h2>";
    echo "<p>" . mysqli_error($conexao) . "</p>";
    echo "<a href='cadastrarProduto.php'>Voltar</a>";
}

?>

</div>

</body>
</html>