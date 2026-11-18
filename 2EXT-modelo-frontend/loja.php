<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>CosmoBeleza</title>

<style>
body{
    margin:0;font-family:Arial;font-style:italic;
}
header{
    background:#fcc5d8;
    padding:20px;
    position:fixed;
    width:100%;
    top:0;
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:1;
}
header h1{
    color:orange;
    font-size:40px;
    margin:0;
}
.icons{
    position:absolute;
    right:80px;
    font-size:24px;
}
.icons span{
    margin-left:15px;
    cursor:pointer;
    color:orange;
}
nav{
    width:200px;
    height:100vh;
    background:orange;
    position:fixed;
    top:0;
    left:0;
    z-index:2;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
}
nav h2{
    color:white;
    font-weight:bold;
    text-transform:uppercase;
    margin-bottom:30px;
    font-size:24px;
}
nav button{
    border:none;
    background:none;
    color:white;
    padding:10px;
    cursor:pointer;
    font-size:20px;
    text-transform:uppercase;
}
nav button:hover{
    color:#ffe6f0;
}
main{
    margin-left:200px;
    padding:120px 20px;
}
.section{
    display:none;
}
.active{
    display:block;
}
.grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);gap:20px;
}
.card{
    background:white;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    overflow:hidden;
}
.card img{
    width:100%;
    height:200px;
    object-fit:cover;
}
.card h3{
    margin:10px;
}
.card p{
    margin:0 10px 10px;
    color:orange;
    font-weight:bold;
}
.card button{
    margin:10px;
    padding:10px;
    width:calc(100% - 20px);
    background:orange;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-style:normal;
}
.section.form-page{
    background:#fcc5d8;
    min-height:100vh;
    justify-content:center;
    align-items:center;
}
.section.form-page.active{
    display:flex;
}
.form-container{
    background:white;
    padding:30px;
    border-radius:15px;
    width:320px;
    box-shadow:0 4px 15px rgba(0,0,0,0.2);
    text-align:center;
}
.form-container h2{
    color:orange;
}
.form-container label{
    display:block;
    text-align:left;
    color:orange;
    margin-top:10px;
}
.form-container input{
    width:100%;
    padding:10px;
    margin-top:5px;
    border:none;
    border-radius:8px;
    background:#fcc5d8;
    box-sizing:border-box;
}
.form-container button{
    width:100%;
    margin-top:15px;
    padding:10px;
    background:orange;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-style:normal;
}
#listaCarrinho li{
    margin-bottom:10px;
}
button{
    font-style:normal;
}
</style>
</head>

<body>

<header>
<h1>COSMOBELEZA</h1>
<div class="icons">
<span onclick="trocar('carrinho')">🛒</span>
<span onclick="trocar('login')">👤</span>
</div>
</header>

<nav>
<h2>MENU</h2>
<button onclick="trocar('produtos')">PRODUTOS</button>
<button onclick="trocar('carrinho')">CARRINHO</button>
<button onclick="trocar('login')">LOGIN</button>
<button onclick="trocar('cadastro')">CADASTRO</button>
<button onclick="window.location.href='adm/index.php'">ÁREA ADMINISTRATIVA</button>
</nav>

<main>

<div id="produtos" class="section active">
<div class="grid">

<?php
include("conexao.php");

$sql = "SELECT * FROM produtos";
$resultado = mysqli_query($conexao, $sql);

while($produto = mysqli_fetch_assoc($resultado))
{
?>

<div class="card">
<img src="<?= $produto["imagem"] ?>">
<h3><?= $produto["nome"] ?></h3>
<p>R$ <?= number_format($produto["valor"],2,",",".") ?></p>
<button onclick="add('<?= $produto["nome"] ?>',<?= $produto["valor"] ?>,'<?= $produto["imagem"] ?>')">
Comprar
</button>
</div>

<?php
}
?>

</div>
</div>

<div id="carrinho" class="section form-page">
<div class="form-container">
<h2>🛒 CARRINHO</h2>
<ul id="listaCarrinho" style="list-style:none;padding:0;"></ul>

<label>Cupom de desconto</label>
<input type="text" id="cupom" placeholder="Ex: COSMO10">
<button type="button" onclick="aplicarCupom()">Aplicar cupom</button>
<p id="msgCupom" style="font-size:13px; margin-top:8px; font-weight:bold;"></p>

<p style="margin-top:15px;font-weight:bold;">Total: R$ <span id="total">0.00</span></p>
<button onclick="trocar('pagamento')">Ir para pagamento</button>
</div>
</div>

<div id="login" class="section form-page">
<div class="form-container">
<h2>👤 LOGIN</h2>
<label>Email</label>
<input type="email" id="loginEmail">
<label>Senha</label>
<input type="password" id="loginSenha">
<button onclick="login()">Entrar</button>
<button onclick="trocar('cadastro')">Criar conta</button>
</div>
</div>

<div id="cadastro" class="section form-page">
<div class="form-container">
<h2>👤 CADASTRO</h2>
<label>Nome</label>
<input type="text" id="nome">
<label>Email</label>
<input type="email" id="email">
<label>Senha</label>
<input type="password" id="senha">
<label>Endereço</label>
<input type="text" id="endereco">
<button onclick="cadastrar()">Cadastrar</button>
<button onclick="trocar('login')">Voltar para login</button>
</div>
</div>

<div id="pagamento" class="section form-page">
<div class="form-container">
<h2>💳 PAGAMENTO</h2>

<div style="display:flex; gap:8px; margin-bottom:15px;">
<button type="button" onclick="mudarPagamento('pix')" style="margin-top:0;">PIX (Principal)</button>
<button type="button" onclick="mudarPagamento('cartao')" style="margin-top:0; background:#f39c12;">Cartão</button>
</div>

<div id="areaPix">
<p style="color:orange; font-weight:bold; margin:5px 0;">Pagamento instantâneo via PIX</p>
<div style="background:#fff5f8; border:2px dashed orange; padding:12px; border-radius:10px; margin-bottom:10px;">
<p style="font-size:12px; margin:0 0 6px 0;">Chave PIX (CNPJ Cosmobeleza):</p>
<input type="text" id="chavePix" value="12.345.678/0001-90" readonly style="text-align:center; font-weight:bold; margin-top:0;">
<button type="button" onclick="copiarPix()" style="margin-top:8px; padding:8px; font-size:13px;">Copiar chave PIX</button>
</div>
</div>

<div id="areaCartao" style="display:none;">
<label>Cartão</label>
<input type="text" id="numCartao">
<label>Nome</label>
<input type="text" id="nomeCartao">
<label>CVV</label>
<input type="text" id="cvvCartao">
</div>

<button onclick="finalizar()">Pagar</button>
</div>
</div>

<div id="confirmacao" class="section form-page">
<div class="form-container">
<h2 style="font-weight:bold;">PAGAMENTO APROVADO!</h2>
<button onclick="trocar('produtos')">Voltar para página principal</button>
</div>
</div>

</main>

<script>
let usuario=null;
let carrinho=[];
let desconto=0;
let metodoPagamento="pix";

function trocar(sec){
    document.querySelectorAll(".section").forEach(function(s){
        s.classList.remove("active");
    });
    document.getElementById(sec).classList.add("active");
}

function cadastrar(){
    let nome=document.getElementById("nome").value;
    let email=document.getElementById("email").value;
    let senha=document.getElementById("senha").value;
    let endereco=document.getElementById("endereco").value;
    if(nome==""||email==""||senha==""||endereco==""){alert("Preencha todos os campos!");return;}
    usuario={nome,email,senha,endereco};
    alert("Cadastro realizado!");
    trocar('login');
}

function login(){
    let email=document.getElementById("loginEmail").value;
    let senha=document.getElementById("loginSenha").value;
    if(!usuario||usuario.email!==email||usuario.senha!==senha){alert("Login inválido!");return;}
    alert("Login realizado!");
    trocar('produtos');
}

function add(nome,preco,img){
    if(!usuario){alert("Faça login!");trocar('login');return;}
    carrinho.push({nome,preco,img});
    atualizar();
    alert("Produto adicionado ao carrinho!");
}

function aplicarCupom(){
    let codigo=document.getElementById("cupom").value.toUpperCase().trim();
    let msg=document.getElementById("msgCupom");

    if(codigo=="COSMO10"){
        desconto=0.10;
        msg.innerText="Cupom COSMO10 aplicado (10% de desconto)!";
        msg.style.color="green";
    }else{
        desconto=0;
        msg.innerText="Cupom inválido! Tente COSMO10.";
        msg.style.color="red";
    }
    atualizar();
}

function atualizar(){
    let lista=document.getElementById("listaCarrinho");
    let totalSpan=document.getElementById("total");
    lista.innerHTML="";
    let total=0;
    carrinho.forEach((item,i)=>{
        total+=item.preco;
        lista.innerHTML+=`
        <li style="display:flex;align-items:center;">
        <img src="${item.img}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;margin-right:10px;">
        <div style="flex:1;">
        ${item.nome}<br>
        <strong>R$ ${item.preco.toFixed(2)}</strong>
        </div>
        <button onclick="remover(${i})" style="width:auto;margin-top:0;padding:5px 10px;">X</button>
        </li>`;
    });
    let totalComDesconto = total - (total * desconto);
    totalSpan.innerText = totalComDesconto.toFixed(2);
}

function remover(i){
    carrinho.splice(i,1);
    atualizar();
}

function mudarPagamento(tipo){
    metodoPagamento=tipo;
    if(tipo=="pix"){
        document.getElementById("areaPix").style.display="block";
        document.getElementById("areaCartao").style.display="none";
    }else{
        document.getElementById("areaPix").style.display="none";
        document.getElementById("areaCartao").style.display="block";
    }
}

function copiarPix(){
    let chave=document.getElementById("chavePix").value;
    navigator.clipboard.writeText(chave);
    alert("Chave PIX copiada!");
}

function finalizar(){
    if(carrinho.length==0){alert("Carrinho vazio!");return;}
    if(metodoPagamento=="cartao"){
        let num=document.getElementById("numCartao").value;
        let nome=document.getElementById("nomeCartao").value;
        let cvv=document.getElementById("cvvCartao").value;
        if(num==""||nome==""||cvv==""){alert("Preencha os dados do cartão!");return;}
    }
    carrinho=[];
    desconto=0;
    document.getElementById("cupom").value="";
    document.getElementById("msgCupom").innerText="";
    atualizar();
    trocar('confirmacao');
}
</script>

</body>
</html>