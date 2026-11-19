<?php
session_start();
include("conexao.php");

if (!isset($_SESSION["id_cliente"])) {
    header("Location: login.php?aviso=login");
    exit;
}

$msg_cupom = "";
$cor_cupom = "";

if (isset($_GET["remover"])) {
    $id_rem = (int) $_GET["remover"];
    unset($_SESSION["carrinho"][$id_rem]);
    header("Location: carrinho.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["aplicar_cupom"])) {
    $codigo = strtoupper(trim($_POST["cupom"] ?? ""));
    if ($codigo === "COSMO10") {
        $_SESSION["desconto"] = 0.10;
        $_SESSION["cupom"] = "COSMO10";
        $msg_cupom = "Cupom COSMO10 aplicado (10% de desconto)!";
        $cor_cupom = "green";
    } else {
        $_SESSION["desconto"] = 0;
        $_SESSION["cupom"] = "";
        $msg_cupom = "Cupom inválido! Tente COSMO10.";
        $cor_cupom = "red";
    }
}

$itens = [];
$subtotal = 0;

if (!empty($_SESSION["carrinho"])) {
    $ids = array_map("intval", array_keys($_SESSION["carrinho"]));
    $lista_ids = implode(",", $ids);
    $res = mysqli_query($conexao, "SELECT * FROM produtos WHERE id_produto IN ($lista_ids)");

    while ($prod = mysqli_fetch_assoc($res)) {
        $id = $prod["id_produto"];
        $qtd = $_SESSION["carrinho"][$id];
        $sub = $prod["valor"] * $qtd;
        $subtotal += $sub;
        $itens[] = [
            "id_produto" => $id,
            "nome" => $prod["nome"],
            "valor" => $prod["valor"],
            "imagem" => $prod["imagem"],
            "quantidade" => $qtd,
            "subtotal" => $sub
        ];
    }
}

$desconto = $_SESSION["desconto"] ?? 0;
$total = $subtotal - ($subtotal * $desconto);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosmoBeleza - Carrinho</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<?php include("topo.php"); ?>

<main>
    <div class="form-page">
        <div class="form-container" style="width:450px;">
            <h2>🛒 CARRINHO</h2>

            <?php if (empty($itens)): ?>
                <p style="font-style:normal;">Seu carrinho está vazio.</p>
                <a href="loja.php" class="btn-link">Ver produtos</a>
            <?php else: ?>
                <div>
                    <?php foreach ($itens as $item): ?>
                        <div class="item-carrinho">
                            <img src="<?= htmlspecialchars($item["imagem"]) ?>" alt="">
                            <div style="flex:1;">
                                <strong><?= htmlspecialchars($item["nome"]) ?></strong><br>
                                Qtd: <?= $item["quantidade"] ?> x R$ <?= number_format($item["valor"], 2, ",", ".") ?>
                            </div>
                            <a href="carrinho.php?remover=<?= $item["id_produto"] ?>" style="background:orange; color:white; padding:5px 10px; border-radius:5px; text-decoration:none; font-weight:bold;">X</a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <form method="POST" action="carrinho.php">
                    <label>Cupom de desconto</label>
                    <input type="text" name="cupom" placeholder="Ex: COSMO10" value="<?= htmlspecialchars($_SESSION["cupom"] ?? "") ?>">
                    <button type="submit" name="aplicar_cupom">Aplicar cupom</button>
                </form>

                <?php if ($msg_cupom !== ""): ?>
                    <p style="font-size:13px; margin-top:8px; font-weight:bold; font-style:normal; color:<?= $cor_cupom ?>;">
                        <?= htmlspecialchars($msg_cupom) ?>
                    </p>
                <?php elseif (!empty($_SESSION["cupom"])): ?>
                    <p style="font-size:13px; margin-top:8px; font-weight:bold; font-style:normal; color:green;">
                        Cupom <?= htmlspecialchars($_SESSION["cupom"]) ?> ativo (10% de desconto)!
                    </p>
                <?php endif; ?>

                <p style="margin-top:15px; font-weight:bold; font-style:normal; font-size:18px;">
                    Total: R$ <?= number_format($total, 2, ",", ".") ?>
                </p>

                <a href="pagamento.php" class="btn-link">Ir para pagamento</a>
            <?php endif; ?>
        </div>
    </div>
</main>

</body>
</html>
