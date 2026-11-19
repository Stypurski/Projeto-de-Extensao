<?php
session_start();
include("conexao.php");

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $endereco = trim($_POST["endereco"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if ($nome === "" || $email === "" || $telefone === "" || $endereco === "" || $senha === "") {
        $erro = "Preencha todos os campos obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Informe um endereço de e-mail válido.";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter no mínimo 6 caracteres.";
    } else {
        $stmt = mysqli_prepare($conexao, "SELECT id_cliente FROM cliente WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $erro = "Este e-mail já está cadastrado.";
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $insert = mysqli_prepare($conexao, "INSERT INTO cliente (nome_completo, email, endereco, telefone, senha) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($insert, "sssss", $nome, $email, $endereco, $telefone, $senha_hash);

            if (mysqli_stmt_execute($insert)) {
                header("Location: login.php?cadastrado=1");
                exit;
            } else {
                $erro = "Erro ao concluir o cadastro. Tente novamente.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosmoBeleza - Cadastro</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<?php include("topo.php"); ?>

<main>
    <div class="form-page">
        <div class="form-container">
            <h2>👤 CADASTRO</h2>

            <?php if ($erro !== ""): ?>
                <div class="alerta-erro"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <form method="POST" action="cadastro.php">
                <label>Nome completo</label>
                <input type="text" name="nome" required minlength="3" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>">

                <label>Email</label>
                <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

                <label>Telefone</label>
                <input type="text" name="telefone" required placeholder="(21) 99999-9999" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>">

                <label>Endereço completo</label>
                <input type="text" name="endereco" required value="<?= htmlspecialchars($_POST['endereco'] ?? '') ?>">

                <label>Senha (mínimo 6 caracteres)</label>
                <input type="password" name="senha" required minlength="6">

                <button type="submit">Cadastrar</button>
            </form>

            <a href="login.php" class="btn-link btn-secundario">Voltar para login</a>
        </div>
    </div>
</main>

</body>
</html>
