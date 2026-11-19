<?php
session_start();
include("conexao.php");

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if ($email === "" || $senha === "") {
        $erro = "Preencha e-mail e senha para entrar.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Formato de e-mail inválido.";
    } else {
        $stmt = mysqli_prepare($conexao, "SELECT id_cliente, nome_completo, senha FROM cliente WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if ($cliente = mysqli_fetch_assoc($res)) {
            if (password_verify($senha, $cliente["senha"])) {
                $_SESSION["id_cliente"] = $cliente["id_cliente"];
                $_SESSION["nome_cliente"] = $cliente["nome_completo"];
                header("Location: loja.php");
                exit;
            }
        }
        $erro = "E-mail ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosmoBeleza - Login</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<?php include("topo.php"); ?>

<main>
    <div class="form-page">
        <div class="form-container">
            <h2>👤 LOGIN</h2>

            <?php if (isset($_GET["cadastrado"])): ?>
                <div class="alerta-sucesso">Cadastro realizado com sucesso! Faça seu login.</div>
            <?php endif; ?>

            <?php if (isset($_GET["aviso"]) && $_GET["aviso"] === "login"): ?>
                <div class="alerta-erro">Faça login para adicionar produtos ao carrinho.</div>
            <?php endif; ?>

            <?php if ($erro !== ""): ?>
                <div class="alerta-erro"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <label>Email</label>
                <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

                <label>Senha</label>
                <input type="password" name="senha" required>

                <button type="submit">Entrar</button>
            </form>

            <a href="cadastro.php" class="btn-link btn-secundario">Criar conta</a>
        </div>
    </div>
</main>

</body>
</html>
