<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área Administrativa</title>

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
        text-align: center;
    }

    h1{
        color: orange;
        margin-bottom: 20px;
    }

    a{
        display: block;
        padding: 12px;
        margin-top: 15px;
        background: orange;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
    }

    a:hover{
        background: #ff9800;
    }

    hr{
        margin-bottom: 20px;
    }

    </style>

</head>

<body>

<div class="container">

    <h1>Área Administrativa</h1>

    <hr>

    <a href="cadastrarProduto.php">
        Cadastrar Produto
    </a>

    <a href="listarProdutos.php">
        Listar Produtos
    </a>

    <a href="../index.php">
        Voltar para a Loja
    </a>

</div>

</body>
</html>