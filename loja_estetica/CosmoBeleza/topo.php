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
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    font-style: italic;
    background: #fff;
}
header {
    background: #fcc5d8;
    padding: 20px;
    position: fixed;
    width: 100%;
    top: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1;
    box-sizing: border-box;
}
header h1 {
    color: orange;
    font-size: 40px;
    margin: 0;
}
.icons {
    position: absolute;
    right: 40px;
    font-size: 22px;
    display: flex;
    align-items: center;
    gap: 15px;
}
.icons a {
    text-decoration: none;
    color: orange;
    font-style: normal;
    font-weight: bold;
    font-size: 16px;
}
nav {
    width: 200px;
    height: 100vh;
    background: orange;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}
nav h2 {
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 30px;
    font-size: 24px;
}
nav a {
    text-decoration: none;
    color: white;
    padding: 10px 15px;
    font-size: 18px;
    text-transform: uppercase;
    display: block;
}
nav a:hover {
    color: #ffe6f0;
}
main {
    margin-left: 200px;
    padding-top: 86px;
}
.vitrine-container {
    padding: 30px 20px;
}
.grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
.card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}
.card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
.card h3 {
    margin: 10px;
}
.card p {
    margin: 0 10px 10px;
    color: orange;
    font-weight: bold;
}
.card button, .btn-acao {
    margin: 10px;
    padding: 10px;
    width: calc(100% - 20px);
    background: orange;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-style: normal;
    font-size: 15px;
    display: inline-block;
    text-align: center;
    text-decoration: none;
    box-sizing: border-box;
}
.form-page {
    background: #fcc5d8;
    min-height: calc(100vh - 86px);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px 15px;
    box-sizing: border-box;
}
.form-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    width: 380px;
    max-width: 100%;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    text-align: center;
    box-sizing: border-box;
}
.form-container h2 {
    color: orange;
    margin-top: 0;
}
.form-container label {
    display: block;
    text-align: left;
    color: orange;
    margin-top: 10px;
    font-weight: bold;
}
.form-container input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: none;
    border-radius: 8px;
    background: #fcc5d8;
    box-sizing: border-box;
    font-style: normal;
}
.form-container button, .form-container .btn-link {
    width: 100%;
    margin-top: 12px;
    padding: 10px;
    background: orange;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-style: normal;
    font-size: 15px;
    display: block;
    text-decoration: none;
    box-sizing: border-box;
}
.btn-secundario {
    background: #f39c12 !important;
}
.alerta-erro {
    background: #ffe0e0;
    color: #b00020;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 12px;
    font-style: normal;
    font-size: 14px;
}
.alerta-sucesso {
    background: #e0f7e9;
    color: #1b5e20;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-style: normal;
    font-size: 14px;
    text-align: center;
}
.item-carrinho {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #f2f2f2;
    padding: 10px 0;
    text-align: left;
    font-style: normal;
}
.item-carrinho img {
    width: 55px;
    height: 55px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 10px;
}
.pedido-card {
    background: #fff5f8;
    border: 1px solid #fcc5d8;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
    text-align: left;
    font-style: normal;
}
@media (max-width: 900px) {
    .grid {
        grid-template-columns: 1fr;
    }
    nav {
        width: 100%;
        height: auto;
        position: relative;
        flex-direction: row;
        flex-wrap: wrap;
        padding: 10px 0;
    }
    nav h2 {
        display: none;
    }
    header {
        position: relative;
    }
    main {
        margin-left: 0;
        padding-top: 0;
    }
}
</style>

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
