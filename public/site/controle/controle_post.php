<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/helpers/redirect.php");
    session_start();
    $case = $_REQUEST['case'];
    switch ($case) {
        case 'cadastro':
            $iduser = $_SESSION['id_usuario'];
            $conexao = conectarDB();
            $legenda = $_REQUEST['legenda'];
            $data_postagem = date("y-m-d h:i:s");
            $filtro = $_REQUEST["filtro"];
            $sql_cad_post = "INSERT INTO tb_post VALUES (null, ?, ?, ?, ?, 0);";
            $resultado = executaSql($sql_cad_post,'isss',[$iduser ,$legenda,$data_postagem,$filtro]);
            //select do post
            if ($resultado) {
                $sql_slct_post = "SELECT id_post FROM tb_post WHERE data_postagem = ? ";
                $select = executaSql($sql_slct_post,'s',[$data_postagem]);
                if (sizeof($select[1]) > 0) {
                    foreach ($select[1] as $row) {
                        $idpost = $row["id_post"];
                    }
                }               
            $count = $_REQUEST['count'];
            for ($ximgs = 0;$ximgs <= $count;$ximgs++){    
                if (pathinfo($_FILES['img_post'.$ximgs]['name'], PATHINFO_EXTENSION) != null) {
                    $pasta_banco = "/public/assets/img/";
                    $pasta_servidor = $_SERVER['DOCUMENT_ROOT'] . "/public/assets/img/"; 
                    $ext_img = "." . pathinfo($_FILES['img_post'.$ximgs]['name'], PATHINFO_EXTENSION);
                    $nome_img = time() . md5(uniqid()) . rand(1,100);
                    $arq_img_bd = $pasta_banco . $nome_img . $ext_img;
                    $arq_img_server = $pasta_servidor . $nome_img . $ext_img;
                    move_uploaded_file($_FILES['img_post'.$ximgs]['tmp_name'], $arq_img_server);
                    
                    $sql_cad_img = "INSERT INTO tb_midia (midia, id_post) VALUES (?, ?) ";
                    $result_img = executaSql($sql_cad_img,'si',[$arq_img_bd,$idpost]);
                } else {
                    // contiuna o loop
                    continue;
                }

            }
            
                   if (!$result_img){
                   redirect('pagina_incial','Erro no cadastro Img');
                }
                redirect('pagina_inicial','Deu certo');
            } else {
                redirect('pagina_inicial','Erro no cadastro Post');
            }
            break;
            case 'update':
                $iduser = $_SESSION['id_usuario'];
                $idpost = $_REQUEST['id'];
                $data_postagem = date("y-m-d h:i:s");
                $legenda = $_REQUEST['legenda'];
                $filtro = $_REQUEST['filtro'];
                $sql_upd_post = "UPDATE tb_post SET id_post = ?, id_usuario = ?, legenda = ?, data_postagem = ?, filtro = ?
                WHERE id_post = ?;";
                $result_upd_post = executaSql($sql_upd_post,'iisssi',[$idpost, $iduser, $legenda, $data_postagem, $filtro, $idpost]);
                if ($result_upd_post){
                    redirect('pagina_inicial', 'Atualizado!'); 
                } else {
                    redirect('pagina_inicial', 'Deu algo de errado');
                }
                break;
            case 'pin':
                $idpost = $_REQUEST['id'];
                $func = $_REQUEST['func'];
                if ($func == "Fixar") {
                    $sql_upd_pin =" UPDATE tb_post SET 
                        fixado = 1
                    WHERE id_post = ?";
                    $pin = "Fixado";
                } else if ($func == "Desfixar") {
                    $sql_upd_pin =" UPDATE tb_post SET 
                        fixado = 0
                    WHERE id_post = ?";
                    $pin = "Desfixado";
                }
                $rslt_upd_pin = executaSql($sql_upd_pin,'i',[$idpost]);
                if ($rslt_upd_pin) {
                    redirect('pin','');
                } else {
                    redirect('pin','');
                }
                break;
            case 'delete':
                $idpost = $_REQUEST['id'];
                $sql_del = "DELETE FROM tb_post WHERE id_post = ?;";
                $result_del = executaSql($sql_del,'i',[$idpost]);
                if ($result_del) {
                    redirect('pagina_inicial', 'Deletado!');
                } else {
                    redirect('pagina_inicial', 'Deu algo de errado');
                }
                break; 

            

    }
?>