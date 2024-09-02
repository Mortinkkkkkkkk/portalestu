<?php 
        $servidor = "db";
        $nome = "root";
        $senha = "123";
        $banco = "bd_estudatil";
        $conexao = mysqli_connect($servidor,$nome,$senha,$banco);
    function bdcompleto($conexao,$sql){

        $result = mysqli_query($conexao,$sql);
        return $result;

    
    }

?>