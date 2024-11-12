<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/helpers/redirect.php");
    session_start();
    $case = $_REQUEST['case'];
    $conexao = conectarDB();
    switch ($case) {
        case 'comentario_post':
            $id_post = $_REQUEST['id_post'];
            $id_user = $_REQUEST['id_user']; 
            $comentario = $_REQUEST['comentario'];
            $sql = "INSERT INTO tb_comentario (id_post,id_usuario,comentario) VALUES (?, ?, ?)";
            executaSql($sql,'iis',[$id_post, $id_user, $comentario]);
            
            redirect('comentario','carregar');
            
            break;
            
        case 'comentario_resposta':
            $iduser = $_REQUEST['id_user'];
            $id_post = $_REQUEST['id_post'];
            $id_comentario = $_REQUEST['id_comentario'];
            $comentario = $_REQUEST['resposta'];

            $sql = "INSERT INTO tb_comentario (id_post,id_usuario,resposta_id ,comentario) VALUES (?, ?, ?, ?)";
            executaSql($sql,'iiis',[$id_post,$iduser,$id_comentario,$comentario]);
            
            redirect('comentario','carregar');
                    
                

            break;
        case 'deletar':
            $id_comentario = $_REQUEST['id'];
            $sql_resposta = "SELECT id_comentario FROM tb_comentario WHERE resposta_id = ?";
            $sql_delete = "DELETE FROM tb_comentario WHERE id_comentario = ?";
            $rslt_resposta = executaSql($sql_resposta,'i',[$id_comentario]);
            if (sizeof($rslt_resposta[1]) > 0){
                foreach ($rslt_resposta[1] as $id_resposta) {
                    executaSql($sql_delete,'i',[$id_resposta["id_comentario"]]);
                }
            }
            executaSql($sql_delete,'i',[$id_comentario]);
            redirect('comentario','carregar');
            break;
        }