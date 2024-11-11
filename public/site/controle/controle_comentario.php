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
            
            redirect('comentario','');
            
            break;
            
        case 'comentario_resposta':
            $iduser = $_REQUEST['id_user'];
            $id_post = $_REQUEST['id_post'];
            $id_comentario = $_REQUEST['id_comentario'];
            $comentario = $_REQUEST['resposta'];

            $sql = "INSERT INTO tb_comentario (id_post,id_usuario,resposta_id ,comentario) VALUES (?, ?, ?, ?)";
            executaSql($sql,'iiis',[$id_post,$iduser,$id_comentario,$comentario]);
            
            redirect('comentario','');
                    
                

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
            redirect('comentario','');
            break;
        case 'carregar':
            $idpost = $_REQUEST['id_post'];

            $iduser = $_SESSION['id_usuario'];
            $sql_coment = "SELECT comentario,id_usuario, id_comentario, resposta_id FROM tb_comentario WHERE id_post = ? ORDER BY id_comentario, resposta_id";
            $resultcoment = executaSql($sql_coment,'i',[$idpost]);
                if (sizeof($resultcoment[1]) > 0) {
                    foreach ($resultcoment[1] as $listcoment){
                        $comentario = $listcoment['comentario'];
                        $iduser_coment = $listcoment['id_usuario'];
                        $id_comentario = $listcoment['id_comentario'];
                        $sql_comt_name_user = "SELECT nome_usuario FROM tb_usuario WHERE id_usuario = ?";
                                $resultnomeusuer = executaSql($sql_comt_name_user,'i',[$iduser_coment]);
                                $nome_user_coment = $resultnomeusuer[1][0];
                                $list_form_id[] = $id_comentario; 
                                if ($iduser_coment == '1') {
                                    $user_coment = "Anonimo";
                                }
                                else {
                                    $user_coment = $nome_user_coment['nome_usuario'];
                                }
                                $resposta = $listcoment['resposta_id'];
                                if ($resposta != null) {
                                    ?><div class="comentario resposta">
                                        <p class="txt-resposta"><?php
                                    // Pega o id do usuario do comentario de origem da resposta
                                    $sql_cmnt_org = "SELECT id_usuario FROM tb_comentario WHERE id_comentario = ?";
                                    $rslt_cmnt_org = executaSql($sql_cmnt_org,'i',[$resposta]);
                                    $row_cmt_org = $rslt_cmnt_org[1][0];
                                    $id_us_cmnt_org = $row_cmt_org['id_usuario'];
                                    // Pega o nome do usario do comentario de origem
                                    $sql_nm_us_org = "SELECT nome_usuario FROM tb_usuario WHERE id_usuario = ?";
                                    $rslt_nm_us_org = executaSql($sql_nm_us_org,'i',[$id_us_cmnt_org]);
                                    $row_nm_us_org = $rslt_nm_us_org[1][0];
                                    $nm_us_org = $row_nm_us_org['nome_usuario'];
                                    // comentario:
                                    echo $user_coment ." Respondeu " .$nm_us_org . ": " . $comentario ;?></p><?php

                                } else {
                                    ?><div class="comentario" id="comentario<?=$id_comentario?>" ><p class="txt-coment"><?php
                                    echo $user_coment . ": " . $comentario ;?></p><?php
                                }
                                ?>
                                <div id="form-resposta<?=$id_comentario?>">
                                <form action="/controle/controle_comentario.php?case=comentario_resposta" method="post">
                                    <input type="text"  name="resposta" id="txt-resposta<?=$id_comentario?>">
                                    <input type="hidden" name="id_user" value="<?= $iduser;?>">
                                    <input type="hidden" name="id_comentario" value="<?= $id_comentario;?>">
                                    <input type="hidden" name="id_post" value="<?= $idpost;?>">
                                    <input type="submit" value="responder" id="btn-enviar<?=$id_comentario?>">
                                </form>
                                </div>
                                <p id="btn-responder<?= $id_comentario?>">Responder</p>
                                <?php
                                if (isset($_SESSION) && isset($tipologado)) {
                                    if (!isset($iduser)){
                                        $iduser = 1;
                                    }
                                    if ($iduser == $iduser_coment && $iduser != 1 ||  $tipologado == "X") {
                                        ?>
                                            <p><a href="/controle/controle_comentario.php?case=deletar&id=<?=$id_comentario?>">DELETAR</a> COMENTARIO</p></div>
                                            <?php
                                    }
                                }
                                ?>
                                      </div>
                                <?
                            };
                        } else {
                           ?>
                            <div class="comentario">
                                <p class="txt-coment">Esse Post não tem comentario</p>
                            </div>
                           <?php
                        };
                    ?>
                            </div>
                        </div>
                    <form action="/controle/controle_comentario.php?case=comentario_post" method="post">
                        <label for="comentario">Comente:</label>
                        <input type="text" name="comentario">
                        <input type="hidden" name="id_post" value="<?echo $idpost?>">
                        <input type="hidden" name="id_user" value="<?= $iduser;?>">
                        <input type="submit" value="enviar">
                    </form>
                    <?php 
                        // $iduser = id do usuario logado
                        // $iduser_post = id do usaurio que postou
                        if (isset($iduser)  && isset($tipologado)) {
                            if ($iduser_post == $iduser || $tipologado == "X") {
                            ?>
                            <p>Editar post: <a href="/controle/controle_post.php?case=delete&id=<?=$idpost?>">Deletar</a> <a href="form_post.php?case=update&id=<?=$idpost?>">Atualizar</a></p>
                            <?php
                        }
                    }                  
}  
?>