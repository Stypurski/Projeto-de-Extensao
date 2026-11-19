<?php
session_start();
include("conexao.php");

if (!isset($_SESSION["id_cliente"])) {
    header("Location: login.php?aviso=login");
    exit;
}

$id_cliente = (int) $_SESSION["id_cliente"];
$stmt = mysqli_prepare($conexao, "SELECT p.id_pedido, p.data, p.valor_total, p.cupom_usado, pg.forma_pagamento 
                                  FROM pedido p 
                                  LEFT JOIN pagamento pg ON pg.id_pedido = p.id_pedido 
                                  WHERE p.id_cliente = ? 
                                  ORDER BY p.id_pedido DESC");
mysqli_stmt_bind_param($stmt, "i", $id_cliente);
mysqli_stmt_execute($stmt);
$pedidos = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosmoBeleza - Meus Pedidos</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<?php include("topo.php"); ?>

<main>
    <div class="form-page">
        <div class="form-container" style="width:520px;">
            <h2>📦 MEUS PEDIDOS</h2>

            <?php if (mysqli_num_rows($pedidos) === 0): ?>
                <p style="font-style:normal;">Você ainda não realizou nenhum pedido.</p>
                <a href="loja.php" class="btn-link">Ir às compras</a>
            <?php else: ?>
                <?php while ($ped = mysqli_fetch_assoc($pedidos)): ?>
                    <div class="pedido-card">
                        <strong>Pedido #<?= $ped["id_pedido"] ?></strong> — <?= date("d/m/Y", strtotime($ped["data"])) ?><br>
                        Forma de pagamento: <strong><?= htmlspecialchars($ped["forma_pagamento"] ?? "PIX") ?></strong><br>
                        <?php if (!empty($ped["cupom_usado"])): ?>
                            Cupom aplicado: <strong><?= htmlspecialchars($ped["cupom_usado"]) ?></strong><br>
                        <?php endif; ?>
                        Total pago: <strong style="color:orange;">R$ <?= number_format($ped["valor_total"], 2, ",", ".") ?></strong>
                        <ul style="margin:8px 0 0 18px; padding:0;">
                            <?php
                            $id_ped = (int) $ped["id_pedido"];
                            $res_itens = mysqli_query($conexao, "SELECT pr.nome, pp.quantidade, pp.valor_unitario 
                                                                 FROM pedido_produto pp 
                                                                 JOIN produtos pr ON pr.id_produto = pp.id_produto 
                                                                 WHERE pp.id_pedido = $id_ped");
                            while ($it = mysqli_fetch_assoc($res_itens)):
                            ?>
                                <li><?= $it["quantidade"] ?>x <?= htmlspecialchars($it["nome"]) ?> (R$ <?= number_format($it["valor_unitario"], 2, ",", ".") ?>)</li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

</body>
</html>
