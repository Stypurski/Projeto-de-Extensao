<?php
session_start();
if (!isset($_SESSION["id_adm"])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastrar Produto</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #fcc5d8;
    margin: 0;
    padding: 0;
}
.container {
    width: 500px;
    max-width: 90%;
    margin: 80px auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    box-sizing: border-box;
}
h1 {
    text-align: center;
    color: orange;
    margin-bottom: 25px;
}
label {
    display: block;
    color: orange;
    font-weight: bold;
    margin-top: 10px;
}
input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: none;
    border-radius: 8px;
    background: #ffe6ef;
    box-sizing: border-box;
}
input[type="submit"] {
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
input[type="submit"]:hover {
    background: #ff9800;
}
a {
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
a:hover {
    background: #ff9800;
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
    <h1>Cadastrar Produto</h1>

    <?php if (isset($_GET["erro"])): ?>
        <div class="alerta-erro">Preencha todos os campos corretamente (preço deve ser maior que zero).</div>
    <?php endif; ?>

    <form action="salvarProduto.php" method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" required minlength="2">

        <label>Preço:</label>
        <input type="number" step="0.01" min="0.01" name="valor" required>

        <label>Imagem (URL):</label>
        <input type="text" name="imagem" required>

        <input type="submit" value="Cadastrar Produto">
    </form>

    <a href="index.php">Voltar</a>
</div>

</body>
</html>
