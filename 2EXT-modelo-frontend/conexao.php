<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "loja_estetica";

$conexao = mysqli_connect($host, $usuario, $senha, $banco);

if (!$conexao) {
    die("Erro ao conectar ao banco: " . mysqli_connect_error());
}

// echo "Conectado ao banco!";
?>