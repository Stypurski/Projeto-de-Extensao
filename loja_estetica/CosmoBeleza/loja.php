<?php
session_start();
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_produto"])) {
    if (!isset($_SESSION["id_cliente"])) {
        header("Location: login.php?aviso=login");
        exit;
    }

    $id_produto = (int) $_POST["id_produto"];
    if ($id_produto > 0) {
        if (!isset($_SESSION["carrinho"])) {
            $_SESSION["carrinho"] = [];
        }
        if (isset($_SESSION["carrinho"][$id_produto])) {
            $_SESSION["carrinho"][$id_produto]++;
        } else {
            $_SESSION["carrinho"][$id_produto] = 1;
        }
        header("Location: loja.php?adicionado=1");
        exit;
    }
}

$sql = "SELECT * FROM produtos ORDER BY id_produto DESC";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosmoBeleza - Produtos</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<?php include("topo.php"); ?>

<main>
    <div class="vitrine-container">
        <?php if (isset($_GET["adicionado"])): ?>
            <div class="alerta-sucesso">Produto adicionado ao carrinho! <a href="carrinho.php" style="color:orange; font-weight:bold;">Ver carrinho</a></div>
        <?php endif; ?>

        <div class="grid">
            <?php while ($produto = mysqli_fetch_assoc($resultado)): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($produto["imagem"]) ?>" alt="<?= htmlspecialchars($produto["nome"]) ?>">
                    <h3><?= htmlspecialchars($produto["nome"]) ?></h3>
                    <p>R$ <?= number_format($produto["valor"], 2, ",", ".") ?></p>
                    <form method="POST" action="loja.php">
                        <input type="hidden" name="id_produto" value="<?= (int) $produto["id_produto"] ?>">
                        <button type="submit">Comprar</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</main>

</body>
</html>
