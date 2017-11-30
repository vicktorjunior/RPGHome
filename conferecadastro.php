<?php
require 'db/DB.class.php';
//inicia a conexão
$db = new DB('02080123',                    //usuario
    '3Ka7ktok',                           //senha
    '02080123',                   //banco
    'webacademico.canoas.ifrs.edu.br'//servidor
);
extract($_POST);
if(isset($user)) {
    $dados = array($pass,$user,$email);
    $db->execute("INSERT INTO usuarios (senha,usuario,email) VALUES (?,?,?)", $dados);
    $situacao = 1;
}

//$db->execute("",$db);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>RPG-BD</title>
</head>
<body>
<div class="container-fluid">
    <header class="row">
        <div class="col-md-12">
            <h1>Medieval RPG - CADASTRO</h1>
        </div>
    </header>
    <div class="row">
        <div class="col-md-12">
            <?php if ($situacao == 1) {
                echo "<div role='main'><h4>CADASTRO REALIZADO COM SUCESSO</h4>";
                echo "<button class=\"btn-default\" onclick=\"window.location.href='home.php';\">Home</button></div>";
            } else {
                echo "<div role='main'><h4>ACONTECEU ALGUM PROBLEMA! Volte e repita a operação.</h4>";
                echo "<button class=\"btn-default\" onclick=\"window.location.href='cadastro.php';\">Voltar</button></div>";
            }
            ?>
        </div>

    </div>

    <footer class="row">
        <h6>RN Dev &copy; Todos os direitos reservados</h6>
    </footer>
</div>

<script href="js/bootstrap.min.js"></script>