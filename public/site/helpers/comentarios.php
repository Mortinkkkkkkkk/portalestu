<?php
include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
include_once($_SERVER['DOCUMENT_ROOT']."/helpers/redirect.php");
session_start();
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
                                <div class="div-input">
                                    <input class="input-ui" placeholder="Digite seu comentario" type="text"  name="resposta" id="txt-resposta<?=$id_comentario?>">
                                    <span class="input-border"></span>
                                </div>     
                                    <input type="hidden" name="id_user" value="<?= $iduser;?>">
                                    <input type="hidden" name="id_comentario" value="<?= $id_comentario;?>">
                                    <input type="hidden" name="id_post" value="<?= $idpost;?>">
                                    <input type="submit" value="responder" id="btn-enviar<?=$id_comentario?>">
                                </form>
                                <script>
                                    for (let teste in listform) {
                                        let btn_responder = "#btn-responder"+listform[teste];
                                        let form_resposta = "#form-resposta"+listform[teste];
                                        // enviar o form pelo ajax
                                        $(form_resposta).submit(
                                        function(test) {
                                            // preventDefault = Previne a alteracao do usuario após enviar 
                                            test.preventDefault();

                                            let form = $(form_resposta);
                                            let Urlform = form.attr('action');

                                            // serialize() = pega os conteudos dos inputs do form e separa ele 
                                            $.ajax({
                                                type:"POST",
                                                url: Urlform,
                                                data: form.serialize(),
                                                success: function(data){
                                                    $('#comentarios<?= $idpost?>').append(data);
                                                }
                                            });
                                        }

                                    );
                                
                                }
                            
                    </script>
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
                        <div class="div-input">
                            <input class="input-ui" placeholder="teste" type="text" name="comentario">
                            <span class="input-border"></span>
                        </div>
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

?>