<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
    $case = $_REQUEST['case'];
    switch ($case) {
        case 'cadastro':
            $conexao = conectarDB();
            $img = $_REQUEST['imagem'];
            $legenda = $_REQUEST['legenda'];
            $data_postagem = $_REQUEST['datapostagem'];
            $filtro = $_REQUEST["filtro"];
            // cadastro no post
            $sql_cad_post = "INSERT INTO `tb_post` (`legenda`, `data_postagem`, `filtro`)
            VALUES (?, ?, ?);";
            $stmt_cad_post = mysqli_prepare($conexao,$sql_cad_post);
            mysqli_stmt_bind_param($stmt_cad_post,"sss",$legenda,$data_postagem,$filtro);
            mysqli_stmt_execute($stmt_cad_post);
            mysqli_stmt_close($stmt_cad_post);
            //select do post
            
            

    }
?>