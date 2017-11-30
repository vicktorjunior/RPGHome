<?php include_once "sessao.php";?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
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
      <h1>Medieval RPG</h1>
    </div>
  </header>
  <div role="main">
    <?php
    echo"<div class='row'><h3>Bem vindo(a) $logado</h3></div>";
    ?>
      <div class="row"><button class="btn-default" onclick="location.href='cadastropersonagem.php'">CADASTRO PERSONAGEM</button></div>
      <div class="row"><button class="btn-default" onclick="location.href='monstros.php'">MONSTROS</button></div>
      <div class="row"><button class="btn-default" onclick="location.href='classes.php'">CLASSES</button></div>
      <div class="row"><button class="btn-default" onclick="location.href='mapas.php'">MAPAS</button></div>
      <div class="row"><button class="btn-default" onclick="location.href='partidas.php'">PARTIDAS</button></div>
      <div class="row"><button class="btn-default" onclick="location.href='missoes.php'">MISSOES</button></div>
      <div class="row"><button class="btn-default" onclick="location.href='crudpersonagem.php'">CRUD PERSONAGEM</button></div>
      <div class="row"><button class="btn-default" onclick="location.href='crudusuario.php'">CRUD USUARIO</button></div>
    <div class="row"><button class="btn-default" onclick="location.href='crudpersusu.php'">CRUD USUARIO + PERSONAGEM</button></div>
      <div class="row"><button class="btn-default" onclick="location.href='deslogar.php'">LOGOUT</button></div>
  </div>
  <footer class="row">
    <h6>RN Dev &copy; Todos os direitos reservados</h6>
  </footer>
</div>

<script href="js/bootstrap.min.js"></script>
</body>
</html>