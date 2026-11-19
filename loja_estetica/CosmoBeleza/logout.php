<?php
session_start();
unset($_SESSION["id_cliente"]);
unset($_SESSION["nome_cliente"]);
unset($_SESSION["carrinho"]);
unset($_SESSION["desconto"]);
unset($_SESSION["cupom"]);
header("Location: login.php");
exit;
?>
