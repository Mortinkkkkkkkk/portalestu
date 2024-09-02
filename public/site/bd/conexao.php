<?php 
    function bdcompleto($sql){
        $servidor = "db";
        $nome = "root";
        $senha = "123";
        $banco = "bd_estudantil";
        $conexao = mysqli_connect($servidor,$nome,$senha,$banco);
    }

?>