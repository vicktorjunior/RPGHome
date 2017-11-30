<?php
session_start();
    require 'db/DB.class.php';
    //inicia a conexão

$db = new DB('02080123',                    //usuario
    '3Ka7ktok',                           //senha
    '02080123',                   //banco
    'webacademico.canoas.ifrs.edu.br'//servidor
);


    $usuario = htmlspecialchars($_POST["user"]);
    $senha = htmlspecialchars($_POST["pass"]);

    $result = $db->query("SELECT * from usuarios where usuario = '$usuario' and senha = '$senha'");
    $contar = $result->fetchAll(PDO::FETCH_ASSOC);
    $db->Count = count($contar);
    //echo $db->Count;
    if ($db->Count>0) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['senha'] = $senha;
      // echo "login ok";
        echo "<script>location.href='prod.php';</script>";
        //header('location')
    } else {
        unset ($_SESSION['usuario']);
        unset ($_SESSION['senha']);
        echo "<script> alert('Nome de usuário não cadastrado!'); location.href='home.php';</script>";
    }

   // if (isset($usuario)){
     //   extract($_POST);
     //   $data = array($usuario,$senha);
     //   $login = $db pg_query("SELECT * from usuario where usuario = ? AND senha = ?",$data);
     //   if($login){
     //       echo "login ok";
     //   } else {
    //        echo "NÃO OK";
    //    }
    //}



