<?php
session_start();
include("../conexao.php");

if (isset($_GET["sair"])) {
    unset($_SESSION["id_adm"]);
    unset($_SESSION["nome_adm"]);
    header("Location: index.php");
    exit;
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_SESSION["id_adm"])) {
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if ($email === "" || $senha === "") {
        $erro = "Preencha e-mail e senha para acessar.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Informe um e-mail válido.";
    } else {
        $stmt = mysqli_prepare($conexao, "SELECT id_adm, nome, senha FROM administrador WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if ($adm = mysqli_fetch_assoc($res)) {
            if (password_verify($senha, $adm["senha"])) {
                $_SESSION["id_adm"] = $adm["id_adm"];
                $_SESSION["nome_adm"] = $adm["nome"];
                header("Location: index.php");
                exit;
            }
        }
        $erro = "E-mail ou senha de administrador incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Administrativa</title>
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
        text-align: center;
        box-sizing: border-box;
    }
    h1 {
        color: orange;
        margin-bottom: 20px;
    }
    label {
        display: block;
        text-align: left;
        color: orange;
        font-weight: bold;
        margin-top: 12px;
    }
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: none;
        border-radius: 8px;
        background: #ffe6ef;
        box-sizing: border-box;
    }
    button {
        width: 100%;
        padding: 12px;
        margin-top: 20px;
        background: orange;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        font-size: 15px;
    }
    button:hover {
        background: #ff9800;
    }
    a {
        display: block;
        padding: 12px;
        margin-top: 15px;
        background: orange;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
    }
    a:hover {
        background: #ff9800;
    }
    .btn-sair {
        background: #d9534f;
    }
    .btn-sair:hover {
        background: #c9302c;
    }
    .alerta-erro {
        background: #ffe0e0;
        color: #b00020;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 14px;
    }
    hr {
        margin-bottom: 20px;
    }
    </style>
</head>
<body>

<div class="container">
    <h1>Área Administrativa</h1>
    <hr>

    <?php if (!isset($_SESSION["id_adm"])): ?>
        <?php if ($erro !== ""): ?>
            <div class="alerta-erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <label>E-mail do Administrador:</label>
            <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <button type="submit">Entrar no Painel</button>
        </form>

        <a href="../loja.php">Voltar para a Loja</a>
    <?php else: ?>
        <p style="color:#555; font-weight:bold;">Bem-vinda, <?= htmlspecialchars($_SESSION["nome_adm"]) ?>!</p>

        <a href="cadastrarProdutos.php">Cadastrar Produto</a>
        <a href="listarProdutos.php">Listar Produtos</a>
        <a href="../loja.php">Voltar para a Loja</a>
        <a href="index.php?sair=1" class="btn-sair">Sair</a>
    <?php endif; ?>
</div>

</body>
</html>
