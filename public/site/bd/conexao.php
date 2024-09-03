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

        return $result;
        mysqli_stmt_close($stmt);
    }   
    function selectSql($sql,$tipos,$dados){
        $conexao = conectarDB();
        $stmt = mysqli_prepare($conexao,$sql);
        if ($tipos === '') {
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, ...$dados);
            mysqli_stmt_store_result($stmt);
            $result = [];
            if (mysqli_stmt_num_rows($stmt) > 0){
                while (mysqli_stmt_fetch($stmt)){
                    $result = [...$dados];
                }
            }
            mysqli_stmt_close($stmt);
            return $result;
        } else {
            $stmt = mysqli_prepare($conexao,$sql);
            mysqli_stmt_bind_param($stmt,$tipos,...$dados);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, ...$dados);
            if (mysqli_stmt_fetch($stmt)){
                return $dados;
            }
            mysqli_stmt_close($stmt);
        }


    }
?>