<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$total_itens = 0;
if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $qtd) {
        $total_itens += $qtd;
    }
}
?>
<header>
    <h1>COSMOBELEZA</h1>
    <div class="icons">
        <a href="carrinho.php">🛒 (<?= $total_itens ?>)</a>
        <?php if (isset($_SESSION['id_cliente'])): ?>
            <a href="meus_pedidos.php">👤 <?= htmlspecialchars(explode(' ', $_SESSION['nome_cliente'])[0]) ?></a>
        <?php else: ?>
            <a href="login.php">👤 Entrar</a>
        <?php endif; ?>
    </div>
</header>

<nav>
    <h2>MENU</h2>
    <a href="loja.php">PRODUTOS</a>
    <a href="carrinho.php">CARRINHO</a>
    <?php if (isset($_SESSION['id_cliente'])): ?>
        <a href="meus_pedidos.php">MEUS PEDIDOS</a>
        <a href="logout.php">SAIR</a>
    <?php else: ?>
        <a href="login.php">LOGIN</a>
        <a href="cadastro.php">CADASTRO</a>
    <?php endif; ?>
    <a href="adm/index.php">ÁREA ADMINISTRATIVA</a>
</nav>
