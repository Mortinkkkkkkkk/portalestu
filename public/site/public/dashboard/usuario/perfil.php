<?php 
    include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/helpers/session.php");
    session_start();
    if (isset($_REQUEST['iduser'])) {
        $idusuario = $_REQUEST['iduser'];
    } else if (isset($_SESSION['id_usario'])) {
        $idusuario = $_SESSION['id_usario'];
    } else {
        sessionPermit('aluno');
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>