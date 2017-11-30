<?php
/**
 * Created by IntelliJ IDEA.
 * User: VictorJr
 * Date: 04/05/2016
 * Time: 16:31
 */
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
        <div role="main">
            <form method="post" action="conferecadastro.php">
                <div class="row"><div class="col-md-12">Usuário: <input type="text" required name="user"></div></div>
                <div class="row"><div class="col-md-12">E-mail: <input type="email" required name="email"></div></div>
                <div class="row"><div class="col-md-12">Senha: <input type="password" required name="pass"></div></div>
                <div class="row"><button class="btn-default">Cadastrar</button></div>
            </form>
            <button class='btn-default' onclick='window.history.back()'>Voltar</button>
        </div>
        <footer class="row">
            <h6>RN Dev &copy; Todos os direitos reservados</h6>
        </footer>
    </div>

    <script href="js/bootstrap.min.js"></script>
</body>
