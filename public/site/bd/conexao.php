<?php 
    function conectarDB(){
        $servidor = "db";
        $nome = "root";
        $senha = "123";
        $banco = "bd_estudatil";
        $conexao = mysqli_connect($servidor,$nome,$senha,$banco);
        return $conexao;
    }
    function executaSql($sql,$tipos,$dados){
        $conexao = conectarDB();

        $stmt = mysqli_prepare($conexao,$sql);
        $result = mysqli_stmt_bind_param($stmt, $tipos, ...$dados);

        mysqli_stmt_execute($stmt);

        //select
        if ($sql[0] == 'S') {
           $resultados = mysqli_stmt_get_result($stmt);
           if ($resultados) {
                $resultados = mysqli_fetch_all($resultados, MYSQLI_ASSOC);
           }
           return [$result, $resultados];
        }

        mysqli_stmt_close($stmt);
        
        return $result;
    }   

    function SelectallSql($sql){
        $conexao = conectarDB();

        $stmt = mysqli_prepare($conexao,$sql);

        $result = mysqli_stmt_execute($stmt);
        $resultados = mysqli_stmt_get_result($stmt);
        if ($resultados) {
                $resultados = mysqli_fetch_all($resultados, MYSQLI_ASSOC);
           }
           return [$result, $resultados];

        mysqli_stmt_close($stmt);
        
    }   


?>