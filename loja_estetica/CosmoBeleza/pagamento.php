<?php
session_start();
include("conexao.php");

if (!isset($_SESSION["id_cliente"])) {
    header("Location: login.php?aviso=login");
    exit;
}

$aprovado = false;
$erro = "";

if (empty($_SESSION["carrinho"]) && !isset($_GET["aprovado"])) {
    header("Location: carrinho.php");
    exit;
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
        $subtotal += $prod["valor"] * $qtd;
        $itens[] = [
            "id_produto" => $id,
            "valor" => $prod["valor"],
            "quantidade" => $qtd
        ];
    }
}

$desconto = $_SESSION["desconto"] ?? 0;
$cupom_usado = !empty($_SESSION["cupom"]) ? $_SESSION["cupom"] : null;
$total = $subtotal - ($subtotal * $desconto);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $forma = ($_POST["forma_pagamento"] ?? "PIX") === "Cartão" ? "Cartão" : "PIX";
    $nome_cartao = null;
    $numero_mascarado = null;
    $validade = null;
    $cvv = null;

    if ($forma === "Cartão") {
        $num = preg_replace("/\D/", "", $_POST["numero_cartao"] ?? "");
        $nome_cartao = trim($_POST["nome_cartao"] ?? "");
        $validade = trim($_POST["validade"] ?? "");
        $cvv = preg_replace("/\D/", "", $_POST["cvv"] ?? "");

        if (strlen($num) < 13 || strlen($num) > 16 || $nome_cartao === "" || !preg_match("/^\d{2}\/\d{2}$/", $validade) || strlen($cvv) !== 3) {
            $erro = "Preencha corretamente todos os dados do cartão (número, titular, validade MM/AA e CVV com 3 dígitos).";
        } else {
            $numero_mascarado = "**** **** **** " . substr($num, -4);
        }
    }

    if ($erro === "") {
        mysqli_begin_transaction($conexao);
        try {
            $data_hoje = date("Y-m-d");
            $id_cliente = (int) $_SESSION["id_cliente"];

            $stmt_ped = mysqli_prepare($conexao, "INSERT INTO pedido (data, valor_total, cupom_usado, id_cliente) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt_ped, "sdsi", $data_hoje, $total, $cupom_usado, $id_cliente);
            mysqli_stmt_execute($stmt_ped);
            $id_pedido = mysqli_insert_id($conexao);

            $stmt_item = mysqli_prepare($conexao, "INSERT INTO pedido_produto (id_pedido, id_produto, quantidade, valor_unitario) VALUES (?, ?, ?, ?)");
            foreach ($itens as $item) {
                mysqli_stmt_bind_param($stmt_item, "iiid", $id_pedido, $item["id_produto"], $item["quantidade"], $item["valor"]);
                mysqli_stmt_execute($stmt_item);
            }

            $stmt_pag = mysqli_prepare($conexao, "INSERT INTO pagamento (forma_pagamento, nome_cartao, numero_cartao, validade, cvv, id_pedido) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt_pag, "sssssi", $forma, $nome_cartao, $numero_mascarado, $validade, $cvv, $id_pedido);
            mysqli_stmt_execute($stmt_pag);

            mysqli_commit($conexao);

            unset($_SESSION["carrinho"]);
            unset($_SESSION["desconto"]);
            unset($_SESSION["cupom"]);

            header("Location: pagamento.php?aprovado=1");
            exit;
        } catch (Exception $e) {
            mysqli_rollback($conexao);
            $erro = "Erro ao registrar o pedido no banco de dados.";
        }
    }
}

if (isset($_GET["aprovado"])) {
    $aprovado = true;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosmoBeleza - Pagamento</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<?php include("topo.php"); ?>

<main>
    <div class="form-page">
        <div class="form-container" style="width:420px;">
            <?php if ($aprovado): ?>
                <h2 style="font-weight:bold;">PAGAMENTO APROVADO!</h2>
                <p style="font-style:normal;">Seu pedido foi registrado com sucesso no sistema.</p>
                <a href="meus_pedidos.php" class="btn-link">Ver meus pedidos</a>
                <a href="loja.php" class="btn-link btn-secundario">Voltar para página principal</a>
            <?php else: ?>
                <h2>💳 PAGAMENTO</h2>
                <p style="font-style:normal; font-weight:bold;">Total a pagar: R$ <?= number_format($total, 2, ",", ".") ?></p>

                <?php if ($erro !== ""): ?>
                    <div class="alerta-erro"><?= htmlspecialchars($erro) ?></div>
                <?php endif; ?>

                <div style="display:flex; gap:8px; margin-bottom:15px;">
                    <button type="button" onclick="mudarPagamento('PIX')" style="margin-top:0;">PIX (Principal)</button>
                    <button type="button" onclick="mudarPagamento('Cartão')" class="btn-secundario" style="margin-top:0;">Cartão</button>
                </div>

                <form method="POST" action="pagamento.php">
                    <input type="hidden" name="forma_pagamento" id="formaPagamento" value="PIX">

                    <div id="areaPix">
                        <p style="color:orange; font-weight:bold; margin:5px 0;">Pagamento instantâneo via PIX</p>
                        <div style="background:#fff5f8; border:2px dashed orange; padding:12px; border-radius:10px; margin-bottom:10px;">
                            <p style="font-size:12px; margin:0 0 6px 0; font-style:normal;">Chave PIX (CNPJ Cosmobeleza):</p>
                            <input type="text" id="chavePix" value="12.345.678/0001-90" readonly style="text-align:center; font-weight:bold; margin-top:0;">
                            <button type="button" onclick="copiarPix()" style="margin-top:8px; padding:8px; font-size:13px;">Copiar chave PIX</button>
                        </div>
                    </div>

                    <div id="areaCartao" style="display:none;">
                        <label>Número do Cartão</label>
                        <input type="text" name="numero_cartao" id="numCartao" maxlength="19" placeholder="0000 0000 0000 0000">

                        <label>Nome do Titular</label>
                        <input type="text" name="nome_cartao" id="nomeCartao">

                        <label>Validade (MM/AA)</label>
                        <input type="text" name="validade" id="validadeCartao" maxlength="5" placeholder="12/30">

                        <label>CVV</label>
                        <input type="text" name="cvv" id="cvvCartao" maxlength="3" placeholder="123">
                    </div>

                    <button type="submit">Confirmar Pagamento</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
function mudarPagamento(tipo) {
    document.getElementById("formaPagamento").value = tipo;
    if (tipo === "PIX") {
        document.getElementById("areaPix").style.display = "block";
        document.getElementById("areaCartao").style.display = "none";
    } else {
        document.getElementById("areaPix").style.display = "none";
        document.getElementById("areaCartao").style.display = "block";
    }
}

function copiarPix() {
    let chave = document.getElementById("chavePix").value;
    navigator.clipboard.writeText(chave);
    alert("Chave PIX copiada!");
}
</script>

</body>
</html>
