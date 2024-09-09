<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
    $case = $_REQUEST['case'];
    $conexao = conectarDB();
    switch ($case) {
        case 'post': 
            $id_post = $_REQUEST['id_post'];
            $comentario = $_REQUEST['comentario'];
            $sql = "INSERT INTO tb_comentario (id_post,comentario) VALUES (?, ?)";
            $stmt = mysqli_prepare($conexao,$sql);
            mysqli_stmt_bind_param($stmt, "is", $id_post, $comentario);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("location: ../index.php");
            exit();
            break;
            
        case 'comentario':
            $id_post = $_REQUEST['id_post'];
            $id_comentario = $_REQUEST['id_comentario'];
            $comentario = $_REQUEST['resposta'];

            $sql = "INSERT INTO tb_comentario (id_post,resposta_id ,comentario) VALUES (?, ?,?)";
            $stmt = mysqli_prepare($conexao,$sql);
            mysqli_stmt_bind_param($stmt, "iis", $id_post,$id_comentario,$comentario);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("location: ../index.php");
            exit();            
            break;

    }

?>